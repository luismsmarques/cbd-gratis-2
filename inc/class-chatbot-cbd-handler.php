<?php
/**
 * Chatbot Handler for CBD General
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Chatbot_CBD_Handler {
	
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
				error_log( 'CBD Chatbot CBD: CBD_Gemini_API class not found' );
				throw new Exception( 'CBD_Gemini_API class not found' );
			}
			$this->gemini = new CBD_Gemini_API();
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot CBD: Error initializing Gemini API - ' . $e->getMessage() );
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
			'animais',
			'humanos',
			'geral',
		);
		
		try {
			// Check if gemini is available
			if ( ! isset( $this->gemini ) || ! is_object( $this->gemini ) ) {
				error_log( 'CBD Chatbot CBD: Gemini API not initialized' );
				return 'geral';
			}
			
			// Pass 'geral' context to classify_text
			$category = $this->gemini->classify_text( $question, $categories, 'geral' );
			
			if ( is_wp_error( $category ) ) {
				error_log( 'CBD Chatbot CBD Classification Error: ' . $category->get_error_message() );
				return 'geral';
			}
			
			// Validate category
			if ( ! is_string( $category ) || ! in_array( $category, $categories, true ) ) {
				error_log( 'CBD Chatbot CBD: Invalid category returned: ' . print_r( $category, true ) );
				return 'geral';
			}
			
			return $category;
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot CBD Classification Exception: ' . $e->getMessage() );
			return 'geral';
		}
	}
	
	/**
	 * Get response for user question
	 *
	 * @param string $question User question
	 * @return array Response data
	 */
	public function get_response( $question ) {
		try {
			// Validate inputs
			if ( empty( $question ) || ! is_string( $question ) ) {
				error_log( 'CBD Chatbot CBD: Invalid question parameter' );
				return array(
					'success' => false,
					'message' => 'Pergunta inválida. Por favor, tente novamente.',
					'category' => 'geral',
				);
			}
			
			// Sanitize inputs
			$question = sanitize_text_field( $question );
			
			// Check if gemini is initialized
			if ( ! isset( $this->gemini ) || ! is_object( $this->gemini ) ) {
				error_log( 'CBD Chatbot CBD: Gemini API not initialized in get_response' );
				return array(
					'success' => false,
					'message' => 'Erro ao inicializar a API. Verifique se a API Key está configurada.',
					'category' => 'geral',
				);
			}
			
			error_log( 'CBD Chatbot CBD: Classifying question...' );
			$category = $this->classify_question( $question );
			error_log( 'CBD Chatbot CBD: Category determined: ' . $category );
			
			// Build context-aware prompt
			$context = $this->build_context( $category );
			
			$prompt = sprintf(
				'Você é um especialista em CBD (canabidiol). Responda à seguinte pergunta de forma clara, precisa e útil. Se a pergunta for sobre animais, enfatize a importância de consultar um veterinário. Se for sobre humanos, enfatize a importância de consultar um médico.\n\n%s\n\nPergunta: %s\n\nResposta:',
				$context,
				$question
			);
			
			error_log( 'CBD Chatbot CBD: Calling Gemini API...' );
			$response = $this->gemini->generate_text( $prompt, array(
				'temperature' => 0.7,
				'max_tokens'  => 1000,
			) );
			
			error_log( 'CBD Chatbot CBD: Gemini API response received, type: ' . gettype( $response ) );
			
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				$error_code = $response->get_error_code();
				
				error_log( 'CBD Chatbot CBD Error [' . $error_code . ']: ' . $error_message );
				
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
				error_log( 'CBD Chatbot CBD: Resposta inválida da API (não é string ou está vazia)' );
				return array(
					'success' => false,
					'message' => 'Resposta inválida da API. Por favor, tente novamente.',
					'category' => $category,
				);
			}
			
			// Get related articles
			$related_articles = array();
			try {
				$related_articles = $this->get_related_articles( $question, $category );
			} catch ( Exception $e ) {
				error_log( 'CBD Chatbot CBD: Error getting related articles - ' . $e->getMessage() );
			}
			
			return array(
				'success' => true,
				'message' => $response,
				'category' => $category,
				'related_articles' => $related_articles,
			);
		} catch ( Exception $e ) {
			error_log( 'CBD Chatbot CBD Exception: ' . $e->getMessage() );
			return array(
				'success' => false,
				'message' => 'Erro ao processar sua pergunta. Por favor, tente novamente.',
				'category' => 'geral',
			);
		}
	}
	
	/**
	 * Build context for prompt based on category
	 *
	 * @param string $category Question category
	 * @return string Context string
	 */
	private function build_context( $category ) {
		$contexts = array(
			'dosagem' => 'Foque em informações sobre dosagem de CBD. Inclua orientações gerais, mas sempre enfatize que a dosagem varia conforme peso, condição e sensibilidade individual. Para animais, mencione que a dosagem é diferente de humanos.',
			'beneficios' => 'Foque nos benefícios potenciais do CBD baseados em estudos científicos. Seja honesto sobre o que está comprovado e o que ainda está em estudo.',
			'seguranca' => 'Foque em segurança do CBD, efeitos colaterais potenciais, contraindicações e interações medicamentosas. Sempre enfatize a importância de consultar profissionais de saúde.',
			'legalidade' => 'Foque na legalidade do CBD em Portugal e na União Europeia. Mencione regulamentações do Infarmed e requisitos legais para comercialização.',
			'animais' => 'Foque em CBD para animais de estimação (cães, gatos). Mencione dosagem específica para animais, diferenças em relação a humanos, e sempre enfatize a importância de consultar um veterinário.',
			'humanos' => 'Foque em CBD para uso humano. Mencione dosagem, formas de administração, e sempre enfatize a importância de consultar um médico.',
			'geral' => 'Forneça informações gerais sobre CBD de forma clara e educativa. Se a pergunta envolver animais ou humanos especificamente, adapte a resposta adequadamente.',
		);
		
		return isset( $contexts[ $category ] ) ? $contexts[ $category ] : $contexts['geral'];
	}
	
	/**
	 * Get related articles based on question
	 *
	 * @param string $question User question
	 * @param string $category Question category
	 * @return array Related articles
	 */
	private function get_related_articles( $question, $category ) {
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'post_status' => 'publish',
			's' => $question,
		);
		
		// Add taxonomy filter if category is animals or humans
		if ( $category === 'animais' ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'animal_type',
					'field' => 'slug',
					'terms' => array( 'cão', 'gato', 'cao' ),
				),
			);
		}
		
		$query = new WP_Query( $args );
		$articles = array();
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$articles[] = array(
					'title' => get_the_title(),
					'url' => get_permalink(),
				);
			}
			wp_reset_postdata();
		}
		
		return $articles;
	}
}

