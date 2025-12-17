<?php
/**
 * Chatbot Handler for CBD Animals
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Chatbot_Handler {
	
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
				error_log( 'CBD Chatbot: CBD_Gemini_API class not found' );
				throw new Exception( 'CBD_Gemini_API class not found' );
			}
			$this->gemini = new CBD_Gemini_API();
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot: Error initializing Gemini API - ' . $e->getMessage() );
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
			'geral',
		);
		
		try {
			$category = $this->gemini->classify_text( $question, $categories );
			
			if ( is_wp_error( $category ) ) {
				error_log( 'CBD Chatbot Classification Error: ' . $category->get_error_message() );
				return 'geral';
			}
			
			return $category;
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot Classification Exception: ' . $e->getMessage() );
			return 'geral';
		}
	}
	
	/**
	 * Get response for user question
	 *
	 * @param string $question User question
	 * @param string $animal_type Type of animal (cão, gato, etc.)
	 * @param float  $weight Animal weight in kg
	 * @return array Response data
	 */
	public function get_response( $question, $animal_type = '', $weight = 0 ) {
		try {
			$category = $this->classify_question( $question );
			
			// Build context-aware prompt
			$context = $this->build_context( $category, $animal_type, $weight );
			
			$prompt = sprintf(
				'Você é um especialista em CBD para animais de estimação. Responda à seguinte pergunta de forma clara, precisa e útil, sempre enfatizando a importância de consultar um veterinário antes de usar CBD.\n\n%s\n\nPergunta: %s\n\nResposta:',
				$context,
				$question
			);
			
			$response = $this->gemini->generate_text( $prompt, array(
				'temperature' => 0.7,
				'max_tokens'  => 1000, // Increased to prevent MAX_TOKENS cutoff
			) );
			
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				$error_code = $response->get_error_code();
				
				// Log error for debugging
				error_log( 'CBD Chatbot Error [' . $error_code . ']: ' . $error_message );
				
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
				error_log( 'CBD Chatbot: Resposta inválida da API (não é string ou está vazia)' );
				return array(
					'success' => false,
					'message' => 'Resposta inválida da API. Por favor, tente novamente.',
					'category' => $category,
				);
			}
			
			// Get related articles (with error handling)
			$related_articles = array();
			try {
				$related_articles = $this->get_related_articles( $category, $animal_type );
				if ( ! is_array( $related_articles ) ) {
					$related_articles = array();
				}
			} catch ( Exception $e ) {
				error_log( 'CBD Chatbot: Error getting related articles - ' . $e->getMessage() );
				$related_articles = array();
			}
			
			// Get dosage info (with error handling)
			$dosage_info = null;
			try {
				$dosage_info = $this->get_dosage_info( $animal_type, $weight );
			} catch ( Exception $e ) {
				error_log( 'CBD Chatbot: Error getting dosage info - ' . $e->getMessage() );
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
			error_log( 'CBD Chatbot Exception: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString() );
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
	 * @param string $animal_type Animal type
	 * @param float  $weight Weight
	 * @return string Context string
	 */
	private function build_context( $category, $animal_type, $weight ) {
		$context = '';
		
		if ( ! empty( $animal_type ) ) {
			$context .= sprintf( 'Animal: %s. ', ucfirst( $animal_type ) );
		}
		
		if ( $weight > 0 ) {
			$context .= sprintf( 'Peso: %.1f kg. ', $weight );
		}
		
		switch ( $category ) {
			case 'dosagem':
				$context .= 'Foque em informações sobre dosagem segura e como calcular a dose adequada.';
				break;
			case 'beneficios':
				$context .= 'Foque nos benefícios potenciais do CBD para animais, mas seja honesto sobre a falta de estudos científicos completos.';
				break;
			case 'seguranca':
				$context .= 'Foque em segurança, efeitos colaterais potenciais e quando NÃO usar CBD.';
				break;
			case 'legalidade':
				$context .= 'Foque na legislação portuguesa sobre CBD e cannabis para animais.';
				break;
			default:
				$context .= 'Forneça informações gerais e úteis sobre CBD para animais.';
		}
		
		return $context;
	}
	
	/**
	 * Get dosage information
	 *
	 * @param string $animal_type Animal type
	 * @param float  $weight Weight in kg
	 * @return array Dosage info
	 */
	public function get_dosage_info( $animal_type = '', $weight = 0 ) {
		try {
			$animal_type = sanitize_text_field( $animal_type );
			$weight = floatval( $weight );
			
			if ( empty( $animal_type ) || $weight <= 0 ) {
				return null;
			}
			
			// General guideline: 0.1-0.5mg per kg of body weight
			$min_dose = round( $weight * 0.1, 2 );
			$max_dose = round( $weight * 0.5, 2 );
			
			return array(
				'min_dose_mg' => $min_dose,
				'max_dose_mg' => $max_dose,
				'recommendation' => sprintf(
					'Para um %s de %.1f kg, a dose recomendada é entre %.2f mg e %.2f mg de CBD por dia, dividida em 2-3 administrações.',
					$animal_type,
					$weight,
					$min_dose,
					$max_dose
				),
			);
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot: Error in get_dosage_info - ' . $e->getMessage() );
			return null;
		}
	}
	
	/**
	 * Get related articles
	 *
	 * @param string $category Category
	 * @param string $animal_type Animal type
	 * @return array Related articles
	 */
	private function get_related_articles( $category, $animal_type = '' ) {
		$articles = array();
		
		try {
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'post_status' => 'publish',
		);
			
			$tax_query = array();
			
			if ( ! empty( $animal_type ) ) {
				$tax_query[] = array(
					'taxonomy' => 'animal_type',
					'field' => 'slug',
					'terms' => sanitize_title( $animal_type ),
				);
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
				if ( ! empty( $category ) ) {
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
			error_log( 'CBD Chatbot: Error in get_related_articles - ' . $e->getMessage() );
			// Return empty array on error
			return array();
		}
		
		return $articles;
	}
}

