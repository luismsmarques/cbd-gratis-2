<?php
/**
 * Featured Image Generator using Gemini API
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Featured_Image_Generator {
	
	/**
	 * Gemini API instance
	 */
	private $gemini;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_cbd_generate_featured_image', array( $this, 'ajax_generate_image' ) );
	}
	
	/**
	 * Add meta box to post editor
	 */
	public function add_meta_box() {
		$post_types = get_post_types( array( 'public' => true ), 'names' );
		foreach ( $post_types as $post_type ) {
			add_meta_box(
				'cbd-featured-image-generator',
				'🎨 Gerar Imagem de Destaque com IA',
				array( $this, 'render_meta_box' ),
				$post_type,
				'side',
				'high'
			);
		}
	}
	
	/**
	 * Render meta box content
	 */
	public function render_meta_box( $post ) {
		$has_featured_image = has_post_thumbnail( $post->ID );
		$api_key = get_option( 'cbd_gemini_api_key', '' );
		$has_api_key = ! empty( $api_key );
		
		wp_nonce_field( 'cbd_generate_featured_image', 'cbd_featured_image_nonce' );
		?>
		<div id="cbd-featured-image-generator">
			<?php if ( ! $has_api_key ) : ?>
				<div class="notice notice-error inline">
					<p><strong>⚠️ API Key não configurada.</strong></p>
					<p>Configure a API Key do Gemini em <a href="<?php echo esc_url( admin_url( 'admin.php?page=cbd-ai-settings' ) ); ?>">CBD AI > Configurações</a>.</p>
				</div>
			<?php else : ?>
				<div class="cbd-image-generator-controls">
					<p class="description">
						Use a IA para gerar uma descrição da imagem baseada no conteúdo do post e buscar uma imagem relevante.
					</p>
					
					<?php if ( $has_featured_image ) : ?>
						<div class="cbd-current-image" style="margin-bottom: 15px;">
							<strong>Imagem atual:</strong>
							<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
						</div>
					<?php endif; ?>
					
					<label for="cbd-custom-prompt" style="display: block; margin-bottom: 8px; font-weight: 600;">
						Prompt Personalizado (opcional):
					</label>
					<textarea 
						id="cbd-custom-prompt" 
						name="cbd_custom_prompt"
						rows="3"
						placeholder="Ex: cannabis plant, green leaves, natural medicine"
						style="width: 100%; padding: 8px; margin-bottom: 10px; font-size: 13px;"
					></textarea>
					<p class="description" style="margin-top: -5px; margin-bottom: 10px;">
						Deixe em branco para gerar automaticamente com base no conteúdo do post. Use termos em inglês para melhores resultados.
					</p>
					
					<button 
						type="button" 
						id="cbd-generate-image-btn" 
						class="button button-primary button-large"
						data-post-id="<?php echo esc_attr( $post->ID ); ?>"
						style="width: 100%; margin-bottom: 10px;"
					>
						<span class="dashicons dashicons-art" style="vertical-align: middle; margin-top: 3px;"></span>
						Gerar Imagem de Destaque
					</button>
					
					<div id="cbd-image-generator-status" style="display: none; margin-top: 10px;"></div>
					<div id="cbd-image-generator-preview" style="display: none; margin-top: 15px;"></div>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
	
	/**
	 * Enqueue admin scripts and styles
	 */
	public function enqueue_scripts( $hook ) {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}
		
		wp_enqueue_script(
			'cbd-featured-image-generator',
			CBD_AI_THEME_URI . '/assets/js/admin-featured-image-generator.js',
			array( 'jquery' ),
			CBD_AI_THEME_VERSION,
			true
		);
		
		wp_localize_script( 'cbd-featured-image-generator', 'cbdImageGenerator', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'cbd_generate_featured_image' ),
			'strings' => array(
				'generating' => 'Gerando descrição da imagem...',
				'searching' => 'Buscando imagem...',
				'setting' => 'Definindo imagem de destaque...',
				'success' => 'Imagem de destaque gerada com sucesso!',
				'error' => 'Erro ao gerar imagem. Tente novamente.',
			),
		) );
		
		wp_enqueue_style(
			'cbd-featured-image-generator',
			CBD_AI_THEME_URI . '/assets/css/admin-featured-image-generator.css',
			array(),
			CBD_AI_THEME_VERSION
		);
	}
	
	/**
	 * AJAX handler to generate featured image
	 */
	public function ajax_generate_image() {
		check_ajax_referer( 'cbd_generate_featured_image', 'nonce' );
		
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( array( 'message' => 'Permissão insuficiente.' ) );
		}
		
		$post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
		
		if ( ! $post_id ) {
			wp_send_json_error( array( 'message' => 'ID do post inválido.' ) );
		}
		
		$post = get_post( $post_id );
		if ( ! $post ) {
			wp_send_json_error( array( 'message' => 'Post não encontrado.' ) );
		}
		
		// Check for custom prompt
		$custom_prompt = isset( $_POST['custom_prompt'] ) ? sanitize_text_field( trim( $_POST['custom_prompt'] ) ) : '';
		
		// If custom prompt is provided, use it directly
		if ( ! empty( $custom_prompt ) ) {
			$image_description = $custom_prompt;
		} else {
			// Initialize Gemini API for automatic generation
			if ( ! class_exists( 'CBD_Gemini_API' ) ) {
				wp_send_json_error( array( 'message' => 'Classe Gemini API não encontrada.' ) );
			}
			
			try {
				$this->gemini = new CBD_Gemini_API();
			} catch ( Exception $e ) {
				wp_send_json_error( array( 'message' => 'Erro ao inicializar Gemini API: ' . $e->getMessage() ) );
			}
			
			// Step 1: Generate image description using Gemini
			$image_description = $this->generate_image_description( $post );
			
			if ( is_wp_error( $image_description ) ) {
				wp_send_json_error( array( 
					'message' => 'Erro ao gerar descrição: ' . $image_description->get_error_message(),
					'step' => 'description'
				) );
			}
		}
		
		// Step 2: Search for image using multiple APIs
		$image_url = $this->search_image( $image_description );
		
		// Step 3: Download and set as featured image (will use fallback if needed)
		$attachment_id = $this->download_and_set_image( $image_url, $post_id, $image_description );
		
		if ( is_wp_error( $attachment_id ) ) {
			wp_send_json_error( array( 
				'message' => 'Erro ao definir imagem: ' . $attachment_id->get_error_message(),
				'step' => 'download',
				'image_url' => is_wp_error( $image_url ) ? 'N/A' : $image_url
			) );
		}
		
		// Get attachment data
		$attachment = wp_get_attachment_image_src( $attachment_id, 'full' );
		
		wp_send_json_success( array(
			'message' => 'Imagem de destaque gerada com sucesso!',
			'attachment_id' => $attachment_id,
			'image_url' => $attachment[0],
			'thumbnail' => wp_get_attachment_image( $attachment_id, 'thumbnail' ),
			'description' => $image_description,
		) );
	}
	
	/**
	 * Generate image description using Gemini
	 *
	 * @param WP_Post $post Post object
	 * @return string|WP_Error Image description or error
	 */
	private function generate_image_description( $post ) {
		$title = $post->post_title;
		$content = wp_strip_all_tags( $post->post_content );
		$excerpt = ! empty( $post->post_excerpt ) ? $post->post_excerpt : wp_trim_words( $content, 30 );
		
		$prompt = sprintf(
			'Com base no seguinte artigo, gere APENAS 2-3 palavras-chave simples em INGLÊS que descrevam uma imagem visual para este conteúdo. Use termos genéricos e comuns que existem em bancos de imagens gratuitos.

Título: %s
Resumo: %s

IMPORTANTE:
- Use apenas 2-3 palavras-chave em INGLÊS
- Use termos genéricos e visuais (ex: "dog", "green plant", "oil drop", "justice scale", "legal document")
- Evite termos muito específicos ou técnicos
- Foque em objetos, animais ou conceitos visuais simples
- NÃO inclua explicações, hífens, dois pontos ou outros símbolos
- APENAS as palavras-chave separadas por espaço

Exemplos de boas respostas:
- "dog oil"
- "hemp plant"
- "justice scale"
- "legal document"
- "oil drop"',
			$title,
			$excerpt
		);
		
		$response = $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.8,
			'max_tokens' => 30,
		) );
		
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		
		// Clean up the response - remove quotes, extra spaces, symbols, etc.
		$description = trim( $response );
		$description = preg_replace( '/^["\':\-]|["\':\-]$/', '', $description ); // Remove quotes, colons, hyphens at start/end
		$description = preg_replace( '/^[:\-]\s*/', '', $description ); // Remove leading colon or hyphen
		$description = preg_replace( '/\s*[:\-]\s*/', ' ', $description ); // Replace colons/hyphens with space
		$description = preg_replace( '/\s+/', ' ', $description ); // Multiple spaces to single
		$description = trim( $description );
		
		// Extract only first 2-3 words
		$words = explode( ' ', $description );
		$words = array_filter( $words, function( $word ) {
			return strlen( trim( $word ) ) > 0 && ! preg_match( '/^[:\-]/', $word );
		} );
		$description = implode( ' ', array_slice( $words, 0, 3 ) );
		
		// If description is empty or too short, use fallback
		if ( empty( $description ) || strlen( $description ) < 2 ) {
			$description = 'cannabis plant';
		}
		
		return $description;
	}
	
	/**
	 * Search for image using multiple APIs with fallbacks
	 *
	 * @param string $query Search query
	 * @return string|WP_Error Image URL or error
	 */
	private function search_image( $query ) {
		// Clean query - remove symbols, hyphens, colons
		$query = preg_replace( '/[:\-]/', ' ', $query );
		$query = trim( $query );
		
		// Clean and simplify query - extract main keywords
		$words = explode( ' ', $query );
		$words = array_filter( $words, function( $word ) {
			return strlen( trim( $word ) ) > 0;
		} );
		
		// Remove common words that don't help search (both PT and EN)
		$stop_words = array( 'da', 'de', 'do', 'das', 'dos', 'o', 'a', 'os', 'as', 'um', 'uma', 'com', 'para', 'em', 'sobre', 'the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with' );
		$clean_words = array_filter( $words, function( $word ) use ( $stop_words ) {
			$word_lower = strtolower( trim( $word ) );
			return ! in_array( $word_lower, $stop_words, true ) && strlen( $word_lower ) > 2;
		} );
		
		if ( ! empty( $clean_words ) ) {
			$search_term = implode( ' ', array_slice( $clean_words, 0, 3 ) );
		} else {
			// If no clean words, use first 2 words
			$search_term = implode( ' ', array_slice( $words, 0, 2 ) );
		}
		
		// If search term is empty or too complex, use fallback
		if ( empty( $search_term ) || strlen( $search_term ) > 30 ) {
			$search_term = 'cannabis plant';
		}
		
		// Clean query for URL
		$clean_query = urlencode( $search_term );
		
		// Try multiple image sources with fallbacks
		$sources = array();
		
		// Method 1: Pixabay API (most reliable, free)
		$pixabay_result = $this->search_pixabay( $search_term );
		if ( ! is_wp_error( $pixabay_result ) ) {
			$sources[] = $pixabay_result;
		}
		
		// Method 2: Try simplified search terms
		$simplified_terms = $this->get_simplified_search_terms( $search_term );
		foreach ( $simplified_terms as $term ) {
			$pixabay_simple = $this->search_pixabay( $term );
			if ( ! is_wp_error( $pixabay_simple ) ) {
				$sources[] = $pixabay_simple;
				break;
			}
		}
		
		// Method 3: Unsplash Source API (fallback)
		$unsplash_result = $this->search_unsplash_source( $clean_query );
		if ( ! is_wp_error( $unsplash_result ) ) {
			$sources[] = $unsplash_result;
		}
		
		// Method 4: Try simplified single-word searches
		$single_words = $this->get_simplified_search_terms( $search_term );
		foreach ( $single_words as $word ) {
			if ( strlen( $word ) > 3 ) {
				$single_result = $this->search_pixabay( $word );
				if ( ! is_wp_error( $single_result ) ) {
					$sources[] = $single_result;
					break;
				}
			}
		}
		
		// Method 5: Try generic CBD-related terms as last resort
		$generic_terms = array( 'cannabis', 'hemp', 'plant', 'nature', 'green', 'leaf', 'oil', 'medicine', 'health', 'wellness' );
		foreach ( $generic_terms as $generic_term ) {
			$generic_result = $this->search_pixabay( $generic_term );
			if ( ! is_wp_error( $generic_result ) ) {
				$sources[] = $generic_result;
				break;
			}
		}
		
		// Method 6: Lorem Picsum (final fallback - random but consistent)
		$sources[] = $this->search_lorempicsum( $search_term );
		
		// Try each source until one works
		foreach ( $sources as $image_url ) {
			if ( ! is_wp_error( $image_url ) && ! empty( $image_url ) ) {
				// For Unsplash Source and Lorem Picsum, we can use them directly without verification
				// as they're reliable services
				if ( strpos( $image_url, 'source.unsplash.com' ) !== false || strpos( $image_url, 'picsum.photos' ) !== false ) {
					return $image_url;
				}
				
				// Verify Pixabay URLs
				$test_response = wp_remote_head( $image_url, array(
					'timeout' => 10,
					'sslverify' => true,
					'redirection' => 2,
				) );
				
				if ( ! is_wp_error( $test_response ) ) {
					$response_code = wp_remote_retrieve_response_code( $test_response );
					if ( $response_code === 200 || $response_code === 302 || $response_code === 301 ) {
						// Get final URL if redirected
						$final_url = wp_remote_retrieve_header( $test_response, 'location' );
						return $final_url ? $final_url : $image_url;
					}
				}
			}
		}
		
		// If all sources fail, use a guaranteed fallback image
		// Use a reliable placeholder service that always works
		$fallback_url = sprintf( 'https://picsum.photos/seed/%s/1200/630', absint( crc32( $search_term . time() ) ) );
		
		// Log the failure for debugging
		error_log( 'CBD Image Generator: All sources failed for query: ' . $search_term . ', using fallback: ' . $fallback_url );
		
		return $fallback_url;
	}
	
	/**
	 * Get simplified search terms from complex query
	 *
	 * @param string $query Original query
	 * @return array Simplified terms
	 */
	private function get_simplified_search_terms( $query ) {
		$words = explode( ' ', strtolower( $query ) );
		$terms = array();
		
		// Extract nouns and important words
		foreach ( $words as $word ) {
			if ( strlen( $word ) > 3 ) {
				$terms[] = $word;
			}
		}
		
		// Return first 2 terms
		return array_slice( $terms, 0, 2 );
	}
	
	/**
	 * Search image using Pexels API
	 *
	 * @param string $query Search query
	 * @return string|WP_Error Image URL or error
	 */
	private function search_pexels( $query ) {
		// Pexels API requires authentication, but we can use their public endpoint
		// For better results, use a generic search that works without API key
		// Using a placeholder approach - Pexels requires API key for v1
		
		// Alternative: Use Lorem Picsum with CBD-related keywords as fallback
		// Or use a direct image URL approach
		
		// For now, return error to try next source
		return new WP_Error( 'pexels_requires_key', 'Pexels requer chave API.' );
	}
	
	/**
	 * Search image using Unsplash Source API
	 *
	 * @param string $query Search query (already URL encoded)
	 * @return string Image URL
	 */
	private function search_unsplash_source( $query ) {
		// Use Unsplash Source API with specific dimensions (1200x630 for featured images)
		return sprintf( 'https://source.unsplash.com/1200x630/?%s', $query );
	}
	
	/**
	 * Search image using Pixabay API
	 *
	 * @param string $query Search query
	 * @return string|WP_Error Image URL or error
	 */
	private function search_pixabay( $query ) {
		// Pixabay API endpoint (free, using demo key - user should get their own)
		// Note: This is a demo key, for production use your own key
		$api_key = '9656065-a4094594c34c9f8a706efe4aa';
		
		// Clean query - remove special characters and limit length
		$clean_query = preg_replace( '/[^a-zA-Z0-9\s]/', '', $query );
		$clean_query = trim( $clean_query );
		
		// If query is empty or too short, use generic term
		if ( empty( $clean_query ) || strlen( $clean_query ) < 2 ) {
			$clean_query = 'nature';
		}
		
		$api_url = sprintf( 
			'https://pixabay.com/api/?key=%s&q=%s&image_type=photo&orientation=horizontal&safesearch=true&per_page=5&min_width=1200',
			$api_key,
			urlencode( $clean_query )
		);
		
		$response = wp_remote_get( $api_url, array(
			'timeout' => 15,
			'sslverify' => true,
			'headers' => array(
				'User-Agent' => 'WordPress/' . get_bloginfo( 'version' ),
			),
		) );
		
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( $response_code !== 200 ) {
			return new WP_Error( 'pixabay_api_error', 'Erro na API Pixabay: HTTP ' . $response_code );
		}
		
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		
		if ( isset( $data['hits'] ) && ! empty( $data['hits'] ) ) {
			// Try to get best quality image
			$hit = $data['hits'][0];
			if ( isset( $hit['largeImageURL'] ) && ! empty( $hit['largeImageURL'] ) ) {
				return $hit['largeImageURL'];
			} elseif ( isset( $hit['webformatURL'] ) && ! empty( $hit['webformatURL'] ) ) {
				return $hit['webformatURL'];
			}
		}
		
		return new WP_Error( 'pixabay_no_results', 'Nenhuma imagem encontrada no Pixabay para: ' . $clean_query );
	}
	
	/**
	 * Search image using Lorem Picsum (fallback)
	 *
	 * @param string $query Search query
	 * @return string Image URL
	 */
	private function search_lorempicsum( $query ) {
		// Lorem Picsum provides random images, use seed based on query for consistency
		$seed = absint( crc32( $query ) );
		return sprintf( 'https://picsum.photos/seed/%s/1200/630', $seed );
	}
	
	/**
	 * Download image and set as featured image
	 *
	 * @param string|WP_Error $image_url Image URL or error
	 * @param int    $post_id Post ID
	 * @param string $description Image description
	 * @return int|WP_Error Attachment ID or error
	 */
	private function download_and_set_image( $image_url, $post_id, $description ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		
		// If image_url is an error, use fallback directly
		if ( is_wp_error( $image_url ) ) {
			error_log( 'CBD Image Generator: Search returned error, using fallback - ' . $image_url->get_error_message() );
			return $this->download_fallback_image( $post_id, $description );
		}
		
		// Validate URL
		if ( ! filter_var( $image_url, FILTER_VALIDATE_URL ) ) {
			error_log( 'CBD Image Generator: Invalid URL, using fallback' );
			return $this->download_fallback_image( $post_id, $description );
		}
		
		// Try to download directly (faster and more reliable)
		$tmp = download_url( $image_url, 60 );
		
		// If download fails, check if it's HTTP 503 or similar
		if ( is_wp_error( $tmp ) ) {
			$error_code = $tmp->get_error_code();
			$error_message = $tmp->get_error_message();
			
			error_log( 'CBD Image Generator: Download error [' . $error_code . '] - ' . $error_message );
			
			// Check if error contains HTTP 503, Service Unavailable, or any HTTP error
			if ( strpos( $error_message, '503' ) !== false || 
			     strpos( $error_message, 'Service Unavailable' ) !== false ||
			     strpos( $error_message, '429' ) !== false ||
			     strpos( $error_message, '500' ) !== false ||
			     strpos( $error_message, '502' ) !== false ||
			     strpos( $error_message, '504' ) !== false ||
			     $error_code === 'http_request_failed' ||
			     strpos( strtolower( $error_message ), 'http' ) !== false ) {
				error_log( 'CBD Image Generator: HTTP error detected, using fallback' );
				return $this->download_fallback_image( $post_id, $description );
			}
			
			// For any other download error, use fallback
			error_log( 'CBD Image Generator: Download failed, using fallback' );
			return $this->download_fallback_image( $post_id, $description );
		}
		
		// Verify file was downloaded
		if ( ! file_exists( $tmp ) || filesize( $tmp ) === 0 ) {
			@unlink( $tmp );
			error_log( 'CBD Image Generator: File empty or not found, using fallback' );
			return $this->download_fallback_image( $post_id, $description );
		}
		
		// Get file extension from URL or detect from file
		$file_extension = 'jpg';
		$parsed_url = parse_url( $image_url );
		if ( isset( $parsed_url['path'] ) ) {
			$path_info = pathinfo( $parsed_url['path'] );
			if ( isset( $path_info['extension'] ) && in_array( strtolower( $path_info['extension'] ), array( 'jpg', 'jpeg', 'png', 'webp', 'gif' ), true ) ) {
				$file_extension = strtolower( $path_info['extension'] );
			}
		}
		
		// Detect MIME type
		$file_type = wp_check_filetype( $tmp );
		if ( isset( $file_type['ext'] ) && ! empty( $file_type['ext'] ) ) {
			$file_extension = $file_type['ext'];
		}
		
		// Prepare file array
		$file_array = array(
			'name' => sanitize_file_name( 'cbd-generated-' . $post_id . '-' . time() . '.' . $file_extension ),
			'tmp_name' => $tmp,
		);
		
		// Upload file
		$attachment_id = media_handle_sideload( $file_array, $post_id, $description );
		
		// Check for upload errors
		if ( is_wp_error( $attachment_id ) ) {
			@unlink( $file_array['tmp_name'] );
			error_log( 'CBD Image Generator: Upload error - ' . $attachment_id->get_error_message() );
			
			// Always try fallback if upload fails
			return $this->download_fallback_image( $post_id, $description );
		}
		
		// Set alt text and description
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', $description );
		wp_update_post( array(
			'ID' => $attachment_id,
			'post_content' => $description,
		) );
		
		// Set as featured image
		set_post_thumbnail( $post_id, $attachment_id );
		
		return $attachment_id;
	}
	
	/**
	 * Download fallback image when main sources fail
	 *
	 * @param int    $post_id Post ID
	 * @param string $description Image description
	 * @return int|WP_Error Attachment ID or error
	 */
	private function download_fallback_image( $post_id, $description ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		
		// Use multiple fallback URLs in order of reliability
		$fallback_urls = array(
			// Method 1: Lorem Picsum with seed (most reliable)
			sprintf( 'https://picsum.photos/seed/%s/1200/630', absint( crc32( $description . $post_id ) ) ),
			
			// Method 2: Lorem Picsum random (always works)
			'https://picsum.photos/1200/630',
			
			// Method 3: Placeholder.com (backup)
			'https://via.placeholder.com/1200x630/4a5568/ffffff?text=CBD',
		);
		
		foreach ( $fallback_urls as $fallback_url ) {
			error_log( 'CBD Image Generator: Trying fallback image: ' . $fallback_url );
			
			// Try to download fallback
			$tmp = download_url( $fallback_url, 60 );
			
			if ( is_wp_error( $tmp ) ) {
				error_log( 'CBD Image Generator: Fallback download failed - ' . $tmp->get_error_message() );
				continue; // Try next fallback URL
			}
			
			// Verify file was downloaded
			if ( ! file_exists( $tmp ) || filesize( $tmp ) === 0 ) {
				@unlink( $tmp );
				continue; // Try next fallback URL
			}
			
			// Prepare file array
			$file_array = array(
				'name' => sanitize_file_name( 'cbd-fallback-' . $post_id . '-' . time() . '.jpg' ),
				'tmp_name' => $tmp,
			);
			
			// Upload file
			$attachment_id = media_handle_sideload( $file_array, $post_id, $description . ' (imagem gerada automaticamente)' );
			
			// Check for upload errors
			if ( is_wp_error( $attachment_id ) ) {
				@unlink( $file_array['tmp_name'] );
				error_log( 'CBD Image Generator: Fallback upload failed - ' . $attachment_id->get_error_message() );
				continue; // Try next fallback URL
			}
			
			// Success! Set metadata
			update_post_meta( $attachment_id, '_wp_attachment_image_alt', $description );
			wp_update_post( array(
				'ID' => $attachment_id,
				'post_content' => $description,
			) );
			
			// Set as featured image
			set_post_thumbnail( $post_id, $attachment_id );
			
			error_log( 'CBD Image Generator: Fallback image successfully set: ' . $attachment_id );
			return $attachment_id;
		}
		
		// If all fallbacks fail, return error
		return new WP_Error( 'all_fallbacks_failed', 'Todos os métodos de fallback falharam. Tente novamente mais tarde.' );
	}
}

// Initialize
new CBD_Featured_Image_Generator();

