<?php
/**
 * Chatbot Handler for CBD Humans
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Chatbot_Humans_Handler {
	
	/**
	 * Gemini API instance
	 */
	private $gemini;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		try {
			if ( ! class_exists( 'CBD_Gemini_API' ) ) {
				error_log( 'CBD Chatbot Humans: CBD_Gemini_API class not found' );
				throw new Exception( 'CBD_Gemini_API class not found' );
			}
			$this->gemini = new CBD_Gemini_API();
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot Humans: Error initializing Gemini API - ' . $e->getMessage() );
			throw $e;
		}
	}
	
	/**
	 * Classify user question
	 *
	 * @param string $question User question
	 * @return string Category
	 */
	public function classify_question( $question ) {
		$categories = array(
			'dosagem',
			'beneficios',
			'seguranca',
			'legalidade',
			'interacoes',
			'condicoes',
			'geral',
		);
		
		try {
			// Check if gemini is available
			if ( ! isset( $this->gemini ) || ! is_object( $this->gemini ) ) {
				error_log( 'CBD Chatbot Humans: Gemini API not initialized' );
				return 'geral';
			}
			
			// Pass 'humanos' context to classify_text
			$category = $this->gemini->classify_text( $question, $categories, 'humanos' );
			
			if ( is_wp_error( $category ) ) {
				error_log( 'CBD Chatbot Humans Classification Error: ' . $category->get_error_message() );
				return 'geral';
			}
			
			// Validate category
			if ( ! is_string( $category ) || ! in_array( $category, $categories, true ) ) {
				error_log( 'CBD Chatbot Humans: Invalid category returned: ' . print_r( $category, true ) );
				return 'geral';
			}
			
			return $category;
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot Humans Classification Exception: ' . $e->getMessage() );
			error_log( 'CBD Chatbot Humans Classification Stack: ' . $e->getTraceAsString() );
			return 'geral';
		} catch ( Error $e ) {
			error_log( 'CBD Chatbot Humans Classification Fatal Error: ' . $e->getMessage() );
			error_log( 'CBD Chatbot Humans Classification Stack: ' . $e->getTraceAsString() );
			return 'geral';
		}
	}
	
	/**
	 * Get response for user question
	 *
	 * @param string $question User question
	 * @param float  $weight User weight in kg (optional)
	 * @param string $condition Medical condition (optional)
	 * @return array Response data
	 */
	public function get_response( $question, $weight = 0, $condition = '' ) {
		try {
			// Validate inputs
			if ( empty( $question ) || ! is_string( $question ) ) {
				error_log( 'CBD Chatbot Humans: Invalid question parameter' );
				return array(
					'success' => false,
					'message' => 'Pergunta inválida. Por favor, tente novamente.',
					'category' => 'geral',
				);
			}
			
			// Sanitize inputs
			$question = sanitize_text_field( $question );
			$weight = floatval( $weight );
			$condition = sanitize_text_field( $condition );
			
			// Check if gemini is initialized
			if ( ! isset( $this->gemini ) || ! is_object( $this->gemini ) ) {
				error_log( 'CBD Chatbot Humans: Gemini API not initialized in get_response' );
				return array(
					'success' => false,
					'message' => 'Erro ao inicializar a API. Verifique se a API Key está configurada.',
					'category' => 'geral',
				);
			}
			
			error_log( 'CBD Chatbot Humans: Classifying question...' );
			$category = $this->classify_question( $question );
			error_log( 'CBD Chatbot Humans: Category determined: ' . $category );
			
			// Build context-aware prompt
			$context = $this->build_context( $category, $weight, $condition );
			
			$prompt = sprintf(
				'Você é um especialista em CBD para uso humano. Responda à seguinte pergunta de forma clara, precisa e útil, sempre enfatizando a importância de consultar um médico antes de usar CBD.\n\n%s\n\nPergunta: %s\n\nResposta:',
				$context,
				$question
			);
			
			error_log( 'CBD Chatbot Humans: Calling Gemini API...' );
			$response = $this->gemini->generate_text( $prompt, array(
				'temperature' => 0.7,
				'max_tokens'  => 1000, // Increased to prevent MAX_TOKENS cutoff
			) );
			
			error_log( 'CBD Chatbot Humans: Gemini API response received, type: ' . gettype( $response ) );
			
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				$error_code = $response->get_error_code();
				
				// Log error for debugging
				error_log( 'CBD Chatbot Humans Error [' . $error_code . ']: ' . $error_message );
				
				// Return user-friendly error
				$user_message = 'Desculpe, ocorreu um erro ao processar sua pergunta.';
				
				if ( strpos( $error_message, 'API key' ) !== false || $error_code === 'no_api_key' ) {
					$user_message = 'API Key não configurada. Por favor, configure a API Key em CBD AI > Configurações.';
				} elseif ( strpos( $error_message, 'not found' ) !== false || strpos( $error_message, 'not supported' ) !== false ) {
					$user_message = 'Modelo da API não encontrado. Por favor, teste a API Key novamente em CBD AI > Configurações.';
				} elseif ( strpos( $error_message, 'conexão' ) !== false || $error_code === 'http_error' ) {
					$user_message = 'Erro de conexão com a API. Verifique sua conexão com a internet e tente novamente.';
				}
				
				return array(
					'success' => false,
					'message' => $user_message,
					'category' => $category,
				);
			}
			
			// Validate response is a string
			if ( ! is_string( $response ) || empty( trim( $response ) ) ) {
				error_log( 'CBD Chatbot Humans: Resposta inválida da API (não é string ou está vazia)' );
				return array(
					'success' => false,
					'message' => 'Resposta inválida da API. Por favor, tente novamente.',
					'category' => $category,
				);
			}
			
			// Get related articles (with error handling)
			$related_articles = array();
			try {
				$related_articles = $this->get_related_articles( $category, $condition );
				if ( ! is_array( $related_articles ) ) {
					$related_articles = array();
				}
			} catch ( Exception $e ) {
				error_log( 'CBD Chatbot Humans: Error getting related articles - ' . $e->getMessage() );
				$related_articles = array();
			}
			
			// Get dosage info (with error handling)
			$dosage_info = null;
			try {
				$dosage_info = $this->get_dosage_info( $weight, $condition );
			} catch ( Exception $e ) {
				error_log( 'CBD Chatbot Humans: Error getting dosage info - ' . $e->getMessage() );
				$dosage_info = null;
			}
			
			return array(
				'success' => true,
				'message' => $response,
				'category' => $category,
				'related_articles' => $related_articles,
				'dosage_info' => $dosage_info,
			);
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot Humans Exception: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString() );
			return array(
				'success' => false,
				'message' => 'Erro inesperado ao processar sua pergunta. Por favor, tente novamente mais tarde.',
				'category' => 'geral',
			);
		}
	}
	
	/**
	 * Build context for prompt
	 *
	 * @param string $category Category
	 * @param float  $weight Weight in kg
	 * @param string $condition Medical condition
	 * @return string Context string
	 */
	private function build_context( $category, $weight, $condition ) {
		$context = '';
		
		if ( $weight > 0 ) {
			$context .= sprintf( 'Peso: %.1f kg. ', $weight );
		}
		
		if ( ! empty( $condition ) ) {
			$context .= sprintf( 'Condição médica mencionada: %s. ', ucfirst( $condition ) );
		}
		
		switch ( $category ) {
			case 'dosagem':
				$context .= 'Foque em informações sobre dosagem segura para humanos e como calcular a dose adequada. Mencione que a dosagem varia muito entre indivíduos.';
				break;
			case 'beneficios':
				$context .= 'Foque nos benefícios potenciais do CBD para humanos, mas seja honesto sobre a necessidade de mais estudos científicos e sempre mencione que não substitui tratamento médico.';
				break;
			case 'seguranca':
				$context .= 'Foque em segurança, efeitos colaterais potenciais, quando NÃO usar CBD e interações com medicamentos.';
				break;
			case 'legalidade':
				$context .= 'Foque na legislação portuguesa sobre CBD e cannabis para uso humano.';
				break;
			case 'interacoes':
				$context .= 'Foque em interações medicamentosas do CBD e a importância de consultar um médico antes de usar CBD com outros medicamentos.';
				break;
			case 'condicoes':
				$context .= 'Foque em como o CBD pode ajudar em condições específicas, mas sempre enfatize que não substitui tratamento médico convencional.';
				break;
			default:
				$context .= 'Forneça informações gerais e úteis sobre CBD para uso humano.';
		}
		
		return $context;
	}
	
	/**
	 * Get dosage information
	 *
	 * @param float  $weight Weight in kg
	 * @param string $condition Medical condition
	 * @return array Dosage info
	 */
	public function get_dosage_info( $weight = 0, $condition = '' ) {
		try {
			$weight = floatval( $weight );
			
			if ( $weight <= 0 ) {
				return null;
			}
			
			// General guideline for humans: 0.25-0.5mg per kg of body weight (starting dose)
			// Can go up to 1-2mg per kg for therapeutic doses
			$start_min = round( $weight * 0.25, 2 );
			$start_max = round( $weight * 0.5, 2 );
			$therapeutic_min = round( $weight * 1, 2 );
			$therapeutic_max = round( $weight * 2, 2 );
			
			$recommendation = sprintf(
				'Para uma pessoa de %.1f kg, a dose inicial recomendada é entre %.2f mg e %.2f mg de CBD por dia, dividida em 2-3 administrações.',
				$weight,
				$start_min,
				$start_max
			);
			
			if ( ! empty( $condition ) ) {
				$condition = sanitize_text_field( $condition );
				$recommendation .= sprintf(
					' Para condições específicas, doses terapêuticas podem variar entre %.2f mg e %.2f mg por dia, mas sempre consulte um médico.',
					$therapeutic_min,
					$therapeutic_max
				);
			} else {
				$recommendation .= ' Doses terapêuticas podem variar entre ' . $therapeutic_min . ' mg e ' . $therapeutic_max . ' mg por dia, mas sempre consulte um médico antes de aumentar a dose.';
			}
			
			return array(
				'start_min_mg' => $start_min,
				'start_max_mg' => $start_max,
				'therapeutic_min_mg' => $therapeutic_min,
				'therapeutic_max_mg' => $therapeutic_max,
				'recommendation' => $recommendation,
			);
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot Humans: Error in get_dosage_info - ' . $e->getMessage() );
			return null;
		}
	}
	
	/**
	 * Get related articles
	 *
	 * @param string $category Category
	 * @param string $condition Medical condition
	 * @return array Related articles
	 */
	private function get_related_articles( $category, $condition = '' ) {
		$articles = array();
		
		try {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'post_status' => 'publish',
			);
			
			$tax_query = array();
			
			// Add condition filter if provided
			if ( ! empty( $condition ) ) {
				$args['s'] = sanitize_text_field( $condition );
			}
			
			if ( ! empty( $category ) && $category !== 'geral' ) {
				$tax_query[] = array(
					'taxonomy' => 'cbd_topic',
					'field' => 'slug',
					'terms' => sanitize_title( $category ),
				);
			}
			
			if ( ! empty( $tax_query ) ) {
				$args['tax_query'] = $tax_query;
			} else {
				// Fallback: search by category in title/content
				if ( empty( $args['s'] ) ) {
					$args['s'] = sanitize_text_field( $category );
				}
			}
			
			$query = new WP_Query( $args );
			
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					
					$title = get_the_title();
					$url = get_permalink();
					$excerpt = get_the_excerpt();
					
					// Validate values before adding
					if ( ! empty( $title ) && ! empty( $url ) ) {
						$articles[] = array(
							'title' => $title,
							'url' => $url,
							'excerpt' => ! empty( $excerpt ) ? wp_trim_words( $excerpt, 20 ) : '',
						);
					}
				}
				wp_reset_postdata();
			}
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot Humans: Error in get_related_articles - ' . $e->getMessage() );
			// Return empty array on error
			return array();
		}
		
		return $articles;
	}
}

