<?php
/**
 * Gemini API Integration Class
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Gemini_API {
	
	/**
	 * API version (can be changed via option or filter)
	 */
	private $api_version = 'v1';
	
	/**
	 * Model name (can be changed via option or filter)
	 * Available models: gemini-pro, gemini-1.5-pro, gemini-1.5-flash
	 */
	private $model_name = 'gemini-pro';
	
	/**
	 * API key
	 */
	private $api_key;
	
	/**
	 * Cache group
	 */
	private $cache_group = 'cbd_gemini_responses';
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->api_key = get_option( 'cbd_gemini_api_key', '' );
		
		// Get saved model and version from options (set by test function)
		$this->model_name = get_option( 'cbd_gemini_model_name', '' );
		$this->api_version = get_option( 'cbd_gemini_api_version', '' );
		
		// Fallback to defaults if not set
		if ( empty( $this->model_name ) ) {
			$this->model_name = 'gemini-pro';
		}
		if ( empty( $this->api_version ) ) {
			$this->api_version = 'v1';
		}
		
		// Allow model and version to be changed via filter
		$this->model_name = apply_filters( 'cbd_gemini_model_name', $this->model_name );
		$this->api_version = apply_filters( 'cbd_gemini_api_version', $this->api_version );
		
		// Validate model and version
		if ( empty( $this->model_name ) || empty( $this->api_version ) ) {
			error_log( 'CBD Gemini API: Modelo ou versão inválidos. Model: ' . $this->model_name . ', Version: ' . $this->api_version );
		}
	}
	
	/**
	 * Get API endpoint URL
	 *
	 * @return string Endpoint URL
	 */
	private function get_api_endpoint() {
		return sprintf(
			'https://generativelanguage.googleapis.com/%s/models/%s:generateContent',
			$this->api_version,
			$this->model_name
		);
	}
	
	/**
	 * Extract text from API response (handles multiple response structures)
	 *
	 * @param array $data API response data
	 * @return string|null Extracted text or null if not found
	 */
	private function extract_text_from_response( $data ) {
		if ( ! is_array( $data ) ) {
			return null;
		}
		
		// Check if candidates exist
		if ( ! isset( $data['candidates'] ) || ! is_array( $data['candidates'] ) || empty( $data['candidates'] ) ) {
			return null;
		}
		
		$candidate = $data['candidates'][0];
		
		// Check if content exists
		if ( ! isset( $candidate['content'] ) ) {
			// Check finish reason for clues
			$finish_reason = isset( $candidate['finishReason'] ) ? $candidate['finishReason'] : '';
			if ( $finish_reason === 'MAX_TOKENS' ) {
				error_log( 'CBD Gemini API: Response cut off (MAX_TOKENS) and no content found' );
			}
			return null;
		}
		
		$content = $candidate['content'];
		
		// Standard structure: candidates[0].content.parts[0].text
		if ( isset( $content['parts'] ) && is_array( $content['parts'] ) && ! empty( $content['parts'] ) ) {
			// Check first part
			$first_part = $content['parts'][0];
			
			if ( isset( $first_part['text'] ) && is_string( $first_part['text'] ) && ! empty( trim( $first_part['text'] ) ) ) {
				return trim( $first_part['text'] );
			}
			
			// If first part is a string
			if ( is_string( $first_part ) && ! empty( trim( $first_part ) ) ) {
				return trim( $first_part );
			}
			
			// Loop through all parts
			foreach ( $content['parts'] as $part ) {
				if ( isset( $part['text'] ) && is_string( $part['text'] ) && ! empty( trim( $part['text'] ) ) ) {
					return trim( $part['text'] );
				}
				if ( is_string( $part ) && ! empty( trim( $part ) ) ) {
					return trim( $part );
				}
			}
		}
		
		// Alternative: text directly in content
		if ( isset( $content['text'] ) && is_string( $content['text'] ) && ! empty( trim( $content['text'] ) ) ) {
			return trim( $content['text'] );
		}
		
		// Alternative: content is a string
		if ( is_string( $content ) && ! empty( trim( $content ) ) ) {
			return trim( $content );
		}
		
		// Alternative: text directly in candidate
		if ( isset( $candidate['text'] ) && is_string( $candidate['text'] ) && ! empty( trim( $candidate['text'] ) ) ) {
			return trim( $candidate['text'] );
		}
		
		// Alternative: content directly in response
		if ( isset( $data['content'] ) ) {
			if ( is_string( $data['content'] ) && ! empty( trim( $data['content'] ) ) ) {
				return trim( $data['content'] );
			}
			if ( isset( $data['content']['text'] ) && is_string( $data['content']['text'] ) && ! empty( trim( $data['content']['text'] ) ) ) {
				return trim( $data['content']['text'] );
			}
			if ( isset( $data['content']['parts'] ) && is_array( $data['content']['parts'] ) ) {
				foreach ( $data['content']['parts'] as $part ) {
					if ( isset( $part['text'] ) && is_string( $part['text'] ) && ! empty( trim( $part['text'] ) ) ) {
						return trim( $part['text'] );
					}
					if ( is_string( $part ) && ! empty( trim( $part ) ) ) {
						return trim( $part );
					}
				}
			}
		}
		
		// Try to find text anywhere in the structure (recursive search)
		$text = $this->find_text_recursive( $data );
		if ( ! empty( $text ) && is_string( $text ) && ! empty( trim( $text ) ) ) {
			return trim( $text );
		}
		
		return null;
	}
	
	/**
	 * Recursively search for text in response structure
	 *
	 * @param mixed $data Data to search
	 * @param int   $depth Current depth (prevent infinite recursion)
	 * @return string|null Found text or null
	 */
	private function find_text_recursive( $data, $depth = 0 ) {
		if ( $depth > 5 ) {
			return null; // Prevent infinite recursion
		}
		
		if ( is_string( $data ) && strlen( $data ) > 5 ) {
			// If it's a string longer than 5 chars, might be our text
			return $data;
		}
		
		if ( is_array( $data ) ) {
			// Check for common text keys
			$text_keys = array( 'text', 'content', 'message', 'output', 'result' );
			foreach ( $text_keys as $key ) {
				if ( isset( $data[ $key ] ) && is_string( $data[ $key ] ) && strlen( $data[ $key ] ) > 5 ) {
					return $data[ $key ];
				}
			}
			
			// Recursively search in array values
			foreach ( $data as $value ) {
				$found = $this->find_text_recursive( $value, $depth + 1 );
				if ( ! empty( $found ) ) {
					return $found;
				}
			}
		}
		
		return null;
	}
	
	/**
	 * List available models
	 *
	 * @return array|WP_Error List of models or error
	 */
	public function list_models() {
		if ( empty( $this->api_key ) ) {
			return new WP_Error( 'no_api_key', 'API key não configurada' );
		}
		
		$url = add_query_arg( 'key', $this->api_key, 'https://generativelanguage.googleapis.com/v1/models' );
		
		$response = wp_remote_get( $url, array(
			'timeout' => 10,
		) );
		
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		
		if ( isset( $data['error'] ) ) {
			return new WP_Error( 'api_error', $data['error']['message'] );
		}
		
		return $data;
	}
	
	/**
	 * Generate text using Gemini API
	 *
	 * @param string $prompt The prompt to send
	 * @param array  $options Additional options
	 * @return string|WP_Error Generated text or error
	 */
	public function generate_text( $prompt, $options = array() ) {
		if ( empty( $this->api_key ) ) {
			return new WP_Error( 'no_api_key', 'API key não configurada. Configure a API Key em CBD AI > Configurações.' );
		}
		
		// Validate model and version
		if ( empty( $this->model_name ) || empty( $this->api_version ) ) {
			return new WP_Error( 'invalid_config', 'Modelo ou versão da API não configurados. Teste a API Key novamente.' );
		}
		
		// Check cache first (but skip for debug/test prompts)
		$is_test_prompt = ( strlen( $prompt ) < 20 && ( stripos( $prompt, 'teste' ) !== false || stripos( $prompt, 'test' ) !== false ) );
		if ( ! $is_test_prompt ) {
			$cache_key = 'gemini_' . md5( $prompt . serialize( $options ) );
			$cached = wp_cache_get( $cache_key, $this->cache_group );
			
			if ( false !== $cached ) {
				return $cached;
			}
		}
		
		$defaults = array(
			'temperature' => 0.7,
			'max_tokens'  => 2000,
			'top_p'       => 0.95,
			'top_k'       => 40,
		);
		
		$options = wp_parse_args( $options, $defaults );
		
		$body = array(
			'contents' => array(
				array(
					'parts' => array(
						array( 'text' => $prompt )
					)
				)
			),
			'generationConfig' => array(
				'temperature' => $options['temperature'],
				'topP' => $options['top_p'],
				'topK' => $options['top_k'],
				'maxOutputTokens' => $options['max_tokens'],
			),
		);
		
		$endpoint = $this->get_api_endpoint();
		$url = add_query_arg( 'key', $this->api_key, $endpoint );
		
		// Log request for debugging (only in debug mode)
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( 'CBD Gemini API Request: ' . $endpoint );
		}
		
		$response = wp_remote_post( $url, array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'body' => json_encode( $body ),
			'timeout' => 60, // Increased timeout for slower responses
			'sslverify' => true,
		) );
		
		if ( is_wp_error( $response ) ) {
			error_log( 'CBD Gemini API HTTP Error: ' . $response->get_error_message() );
			return new WP_Error( 'http_error', 'Erro de conexão com a API: ' . $response->get_error_message() );
		}
		
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( $response_code !== 200 ) {
			$response_body = wp_remote_retrieve_body( $response );
			$error_data = json_decode( $response_body, true );
			$error_message = isset( $error_data['error']['message'] ) ? $error_data['error']['message'] : 'Erro desconhecido';
			error_log( 'CBD Gemini API HTTP Error [' . $response_code . ']: ' . $error_message );
			error_log( 'CBD Gemini API Full Response: ' . substr( $response_body, 0, 500 ) );
			
			// Handle specific error codes
			if ( $response_code === 503 ) {
				return new WP_Error( 'service_unavailable', 'Serviço temporariamente indisponível. A API Gemini pode estar sobrecarregada. Tente novamente em alguns instantes.' );
			} elseif ( $response_code === 429 ) {
				return new WP_Error( 'rate_limit', 'Limite de requisições excedido. Aguarde alguns instantes antes de tentar novamente.' );
			}
			
			return new WP_Error( 'http_error', 'Erro HTTP ' . $response_code . ' da API: ' . $error_message );
		}
		
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			error_log( 'CBD Gemini API JSON Error: ' . json_last_error_msg() );
			return new WP_Error( 'json_error', 'Erro ao processar resposta da API' );
		}
		
		if ( isset( $data['error'] ) ) {
			$error_message = $data['error']['message'] ?? 'Erro desconhecido da API';
			error_log( 'CBD Gemini API Error: ' . $error_message . ' | Model: ' . $this->model_name . ' | Version: ' . $this->api_version );
			
			// If model not found, clear saved model and suggest testing again
			if ( strpos( $error_message, 'not found' ) !== false || strpos( $error_message, 'not supported' ) !== false ) {
				// Clear invalid model/version
				delete_option( 'cbd_gemini_model_name' );
				delete_option( 'cbd_gemini_api_version' );
				
				return new WP_Error( 
					'api_error', 
					'Modelo não encontrado ou não suportado. Por favor, teste a API Key novamente em CBD AI > Configurações para detectar o modelo correto automaticamente.' 
				);
			}
			
			return new WP_Error( 'api_error', $error_message );
		}
		
		// Check finish reason
		$finish_reason = isset( $data['candidates'][0]['finishReason'] ) ? $data['candidates'][0]['finishReason'] : '';
		
		// Extract text using helper function
		$generated_text = $this->extract_text_from_response( $data );
		
		if ( empty( $generated_text ) || ! is_string( $generated_text ) ) {
			// Check if it's a MAX_TOKENS issue with empty response
			if ( $finish_reason === 'MAX_TOKENS' ) {
				// Check if max_tokens is too low
				$current_max_tokens = isset( $options['max_tokens'] ) ? intval( $options['max_tokens'] ) : 1000;
				if ( $current_max_tokens < 100 ) {
					error_log( 'CBD Gemini API: MAX_TOKENS reached with low limit (' . $current_max_tokens . '), retrying with higher limit' );
					// Retry with higher max_tokens (but prevent infinite loop)
					$options['max_tokens'] = 1000;
					return $this->generate_text( $prompt, $options );
				}
				return new WP_Error( 
					'max_tokens_reached', 
					'A resposta foi cortada devido ao limite de tokens. Tente novamente com uma pergunta mais curta ou aumente o limite de tokens.' 
				);
			}
			
			// Log full response for debugging
			error_log( 'CBD Gemini API Invalid Response Structure. Model: ' . $this->model_name . ' | Version: ' . $this->api_version );
			error_log( 'Finish reason: ' . $finish_reason );
			error_log( 'Response keys: ' . implode( ', ', array_keys( $data ) ) );
			if ( isset( $data['candidates'] ) && is_array( $data['candidates'] ) && ! empty( $data['candidates'] ) ) {
				error_log( 'First candidate keys: ' . implode( ', ', array_keys( $data['candidates'][0] ) ) );
				if ( isset( $data['candidates'][0]['content'] ) ) {
					error_log( 'Content keys: ' . implode( ', ', array_keys( $data['candidates'][0]['content'] ) ) );
					if ( isset( $data['candidates'][0]['content']['parts'] ) ) {
						error_log( 'Parts structure: ' . wp_json_encode( $data['candidates'][0]['content']['parts'] ) );
					} else {
						error_log( 'No parts found in content' );
					}
				} else {
					error_log( 'No content found in candidate' );
				}
			}
			error_log( 'Full response (first 1000 chars): ' . substr( wp_json_encode( $data, JSON_PRETTY_PRINT ), 0, 1000 ) );
			
			// Return user-friendly error with suggestion to check debug
			return new WP_Error( 
				'invalid_response', 
				'Resposta inválida da API. O modelo ' . $this->model_name . ' retornou uma estrutura inesperada. Acesse ?cbd_debug_gemini=1 para ver detalhes ou teste a API Key novamente.' 
			);
		}
		
		// Cache for 1 hour (but skip for test prompts)
		if ( ! $is_test_prompt ) {
			wp_cache_set( $cache_key, $generated_text, $this->cache_group, HOUR_IN_SECONDS );
		}
		
		return $generated_text;
	}
	
	/**
	 * Classify text using Gemini
	 *
	 * @param string $text Text to classify
	 * @param array  $categories Categories to classify into
	 * @return string|WP_Error Category name or error
	 */
	public function classify_text( $text, $categories = array(), $context = 'animais' ) {
		$default_categories = array(
			'dosagem',
			'beneficios',
			'seguranca',
			'legalidade',
			'geral',
		);
		
		$categories = ! empty( $categories ) ? $categories : $default_categories;
		
		// Adjust prompt based on context
		$context_text = ( $context === 'humanos' ) ? 'CBD para uso humano' : 'CBD para animais';
		
		$prompt = sprintf(
			'Classifique a seguinte pergunta sobre %s em uma das categorias: %s. Responda APENAS com o nome da categoria, sem explicações.\n\nPergunta: %s\n\nCategoria:',
			$context_text,
			implode( ', ', $categories ),
			$text
		);
		
		try {
			$result = $this->generate_text( $prompt, array( 'temperature' => 0.3, 'max_tokens' => 50 ) );
			
			if ( is_wp_error( $result ) ) {
				error_log( 'CBD Gemini API classify_text error: ' . $result->get_error_message() );
				return 'geral';
			}
			
			// Clean and validate result
			$result = strtolower( trim( $result ) );
			
			// Remove any extra text after the category
			$lines = explode( "\n", $result );
			$result = trim( $lines[0] );
			
			// Remove punctuation
			$result = trim( $result, '.,;:!?' );
			
			if ( in_array( $result, $categories, true ) ) {
				return $result;
			}
			
			// Try to find partial match
			foreach ( $categories as $cat ) {
				if ( strpos( $result, $cat ) !== false ) {
					return $cat;
				}
			}
			
			return 'geral';
		} catch ( Exception $e ) {
			error_log( 'CBD Gemini API classify_text exception: ' . $e->getMessage() );
			return 'geral';
		} catch ( Error $e ) {
			error_log( 'CBD Gemini API classify_text fatal error: ' . $e->getMessage() );
			return 'geral';
		}
	}
	
	/**
	 * Summarize text using Gemini
	 *
	 * @param string $text Text to summarize
	 * @param int    $max_length Maximum length of summary
	 * @return string|WP_Error Summary or error
	 */
	public function summarize_text( $text, $max_length = 200 ) {
		$prompt = sprintf(
			'Resuma o seguinte texto em português de forma clara e concisa, máximo %d palavras:\n\n%s',
			$max_length,
			$text
		);
		
		return $this->generate_text( $prompt, array( 'temperature' => 0.5 ) );
	}
	
	/**
	 * Extract keywords from text
	 *
	 * @param string $text Text to analyze
	 * @return array|WP_Error Array of keywords or error
	 */
	public function extract_keywords( $text ) {
		$prompt = sprintf(
			'Extraia as palavras-chave principais do seguinte texto sobre CBD. Retorne apenas uma lista separada por vírgulas:\n\n%s',
			$text
		);
		
		$result = $this->generate_text( $prompt, array( 'temperature' => 0.3 ) );
		
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		
		$keywords = array_map( 'trim', explode( ',', $result ) );
		
		return array_filter( $keywords );
	}
}

