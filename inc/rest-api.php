<?php
/**
 * REST API Endpoints
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register REST API routes
 */
function cbd_ai_register_rest_routes() {
	// Chatbot endpoint
	register_rest_route( 'cbd-ai/v1', '/chatbot', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_chatbot_handler',
		'permission_callback' => '__return_true',
		'args' => array(
			'question' => array(
				'required' => true,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'animal_type' => array(
				'required' => false,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'weight' => array(
				'required' => false,
				'type' => 'number',
				'sanitize_callback' => function( $value ) {
					return floatval( $value );
				},
			),
		),
	) );
	
	// Content generator endpoint
	register_rest_route( 'cbd-ai/v1', '/generate-content', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_generate_content',
		'permission_callback' => function() {
			return current_user_can( 'edit_posts' );
		},
		'args' => array(
			'type' => array(
				'required' => true,
				'type' => 'string',
				'enum' => array( 'article', 'faq', 'guide' ),
			),
			'topic' => array(
				'required' => true,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'animal_type' => array(
				'required' => false,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'word_count' => array(
				'required' => false,
				'type' => 'integer',
				'default' => 1000,
			),
		),
	) );
	
	// SEO optimizer endpoint
	register_rest_route( 'cbd-ai/v1', '/optimize', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_optimize_content',
		'permission_callback' => function() {
			return current_user_can( 'edit_posts' );
		},
		'args' => array(
			'content' => array(
				'required' => true,
				'type' => 'string',
			),
			'title' => array(
				'required' => false,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
		),
	) );
	
	// Legislation sources endpoints
	register_rest_route( 'cbd-ai/v1', '/legislation-sources', array(
		'methods' => 'GET',
		'callback' => 'cbd_ai_get_legislation_sources',
		'permission_callback' => function() {
			return current_user_can( 'manage_options' );
		},
		'args' => array(
			'active_only' => array(
				'required' => false,
				'type' => 'boolean',
				'default' => false,
			),
		),
	) );
	
	register_rest_route( 'cbd-ai/v1', '/legislation-sources', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_create_legislation_source',
		'permission_callback' => function() {
			return current_user_can( 'manage_options' );
		},
	) );
	
	register_rest_route( 'cbd-ai/v1', '/legislation-sources/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'cbd_ai_get_legislation_source',
		'permission_callback' => function() {
			return current_user_can( 'manage_options' );
		},
		'args' => array(
			'id' => array(
				'required' => true,
				'type' => 'integer',
			),
		),
	) );
	
	register_rest_route( 'cbd-ai/v1', '/legislation-sources/(?P<id>\d+)', array(
		'methods' => 'PUT',
		'callback' => 'cbd_ai_update_legislation_source',
		'permission_callback' => function() {
			return current_user_can( 'manage_options' );
		},
		'args' => array(
			'id' => array(
				'required' => true,
				'type' => 'integer',
			),
		),
	) );
	
	register_rest_route( 'cbd-ai/v1', '/legislation-sources/(?P<id>\d+)', array(
		'methods' => 'DELETE',
		'callback' => 'cbd_ai_delete_legislation_source',
		'permission_callback' => function() {
			return current_user_can( 'manage_options' );
		},
		'args' => array(
			'id' => array(
				'required' => true,
				'type' => 'integer',
			),
		),
	) );
	
	register_rest_route( 'cbd-ai/v1', '/legislation-sources/(?P<id>\d+)/test', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_test_legislation_source',
		'permission_callback' => function() {
			return current_user_can( 'manage_options' );
		},
		'args' => array(
			'id' => array(
				'required' => true,
				'type' => 'integer',
			),
		),
	) );
	
	// Chatbot Humans endpoint
	register_rest_route( 'cbd-ai/v1', '/chatbot-humans', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_chatbot_humans_handler',
		'permission_callback' => '__return_true',
		'args' => array(
			'question' => array(
				'required' => true,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'weight' => array(
				'required' => false,
				'type' => 'number',
				'sanitize_callback' => function( $value ) {
					return floatval( $value );
				},
			),
			'condition' => array(
				'required' => false,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
		),
	) );
	
	// Chatbot CBD (General) endpoint
	register_rest_route( 'cbd-ai/v1', '/chatbot-cbd', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_chatbot_cbd_handler',
		'permission_callback' => '__return_true',
		'args' => array(
			'question' => array(
				'required' => true,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
		),
	) );
	
	// Legislation chatbot endpoint
	register_rest_route( 'cbd-ai/v1', '/legislation-chatbot', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_legislation_chatbot_handler',
		'permission_callback' => '__return_true',
		'args' => array(
			'question' => array(
				'required' => true,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
		),
	) );
	
	// Legislation alerts endpoint
	register_rest_route( 'cbd-ai/v1', '/legislation-alerts', array(
		'methods' => 'GET',
		'callback' => 'cbd_ai_get_legislation_alerts',
		'permission_callback' => '__return_true',
		'args' => array(
			'limit' => array(
				'required' => false,
				'type' => 'integer',
				'default' => 10,
			),
		),
	) );
	
	// Newsletter subscription endpoint
	register_rest_route( 'cbd-ai/v1', '/newsletter/subscribe', array(
		'methods' => 'POST',
		'callback' => 'cbd_ai_newsletter_subscribe',
		'permission_callback' => '__return_true',
		'args' => array(
			'email' => array(
				'required' => true,
				'type' => 'string',
				'validate_callback' => function( $param ) {
					return is_email( $param );
				},
				'sanitize_callback' => 'sanitize_email',
			),
		),
	) );
	
	// Stores endpoints
	register_rest_route( 'cbd-ai/v1', '/stores', array(
		'methods' => 'GET',
		'callback' => 'cbd_ai_get_stores',
		'permission_callback' => '__return_true',
		'args' => array(
			'per_page' => array(
				'required' => false,
				'type' => 'integer',
				'default' => 10,
				'sanitize_callback' => 'absint',
			),
			'page' => array(
				'required' => false,
				'type' => 'integer',
				'default' => 1,
				'sanitize_callback' => 'absint',
			),
			'store_type' => array(
				'required' => false,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'location' => array(
				'required' => false,
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'min_rating' => array(
				'required' => false,
				'type' => 'number',
				'sanitize_callback' => 'floatval',
			),
			'orderby' => array(
				'required' => false,
				'type' => 'string',
				'default' => 'date',
				'enum' => array( 'date', 'title', 'rating' ),
			),
			'order' => array(
				'required' => false,
				'type' => 'string',
				'default' => 'DESC',
				'enum' => array( 'ASC', 'DESC' ),
			),
		),
	) );
	
	register_rest_route( 'cbd-ai/v1', '/stores/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'cbd_ai_get_store',
		'permission_callback' => '__return_true',
		'args' => array(
			'id' => array(
				'required' => true,
				'type' => 'integer',
				'sanitize_callback' => 'absint',
			),
		),
	) );
}
add_action( 'rest_api_init', 'cbd_ai_register_rest_routes' );

/**
 * Handle chatbot request
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_chatbot_handler( $request ) {
	try {
		$question = $request->get_param( 'question' );
		$animal_type = $request->get_param( 'animal_type' );
		$weight = $request->get_param( 'weight' );
		
		if ( empty( $question ) ) {
			return new WP_Error( 'missing_question', 'Pergunta é obrigatória', array( 'status' => 400 ) );
		}
		
		$chatbot = new CBD_Chatbot_Handler();
		$response = $chatbot->get_response( $question, $animal_type, $weight );
		
		// If response is WP_Error, return it properly
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		
		return rest_ensure_response( $response );
	} catch ( Exception $e ) {
		return new WP_Error( 
			'chatbot_error', 
			'Erro ao processar pergunta: ' . $e->getMessage(), 
			array( 'status' => 500 ) 
		);
	}
}

/**
 * Handle content generation request
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_generate_content( $request ) {
	$type = $request->get_param( 'type' );
	$topic = $request->get_param( 'topic' );
	$animal_type = $request->get_param( 'animal_type' );
	$word_count = $request->get_param( 'word_count' );
	
	$generator = new CBD_Content_Generator();
	
	switch ( $type ) {
		case 'article':
			$result = $generator->generate_article( $topic, $animal_type, $word_count );
			break;
		case 'faq':
			$result = $generator->generate_faq( $topic );
			break;
		case 'guide':
			$result = $generator->generate_guide( $animal_type ?: 'cão' );
			break;
		default:
			return new WP_Error( 'invalid_type', 'Tipo inválido', array( 'status' => 400 ) );
	}
	
	if ( is_wp_error( $result ) ) {
		return $result;
	}
	
	return rest_ensure_response( $result );
}

/**
 * Handle SEO optimization request
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_optimize_content( $request ) {
	$content = $request->get_param( 'content' );
	$title = $request->get_param( 'title' );
	
	if ( empty( $content ) ) {
		return new WP_Error( 'missing_content', 'Conteúdo é obrigatório', array( 'status' => 400 ) );
	}
	
	$optimizer = new CBD_SEO_Optimizer();
	
	// Analyze content
	$analysis = $optimizer->analyze_content( $content, $title );
	
	// Get suggestions
	$suggestions = $optimizer->suggest_variations( $content );
	
	// Generate meta description
	$meta_description = $optimizer->generate_meta( $content, $title );
	
	return rest_ensure_response( array(
		'analysis' => $analysis,
		'suggestions' => $suggestions,
		'meta_description' => is_wp_error( $meta_description ) ? '' : $meta_description,
	) );
}

/**
 * Handle chatbot humans request
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_chatbot_humans_handler( $request ) {
	try {
		error_log( 'CBD REST API: chatbot_humans_handler called' );
		
		$question = $request->get_param( 'question' );
		$weight = $request->get_param( 'weight' );
		$condition = $request->get_param( 'condition' );
		
		error_log( 'CBD REST API: Question = ' . substr( $question, 0, 50 ) );
		
		if ( empty( $question ) ) {
			error_log( 'CBD REST API: Missing question parameter' );
			return new WP_Error( 'missing_question', 'Pergunta é obrigatória', array( 'status' => 400 ) );
		}
		
		error_log( 'CBD REST API: Creating CBD_Chatbot_Humans_Handler instance' );
		
		// Check if class exists
		if ( ! class_exists( 'CBD_Chatbot_Humans_Handler' ) ) {
			error_log( 'CBD REST API: CBD_Chatbot_Humans_Handler class not found' );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro: Classe do chatbot não encontrada. Verifique se todos os arquivos estão carregados corretamente.',
			) );
		}
		
		try {
			$chatbot = new CBD_Chatbot_Humans_Handler();
		} catch ( Exception $e ) {
			error_log( 'CBD REST API: Error creating chatbot instance - ' . $e->getMessage() );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro ao inicializar o chatbot. Verifique se a API Key está configurada corretamente.',
			) );
		} catch ( Error $e ) {
			error_log( 'CBD REST API: Fatal error creating chatbot instance - ' . $e->getMessage() );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro fatal ao inicializar o chatbot. Verifique os logs do WordPress.',
			) );
		}
		
		error_log( 'CBD REST API: Calling get_response' );
		
		try {
			$response = $chatbot->get_response( $question, $weight, $condition );
		} catch ( Exception $e ) {
			error_log( 'CBD REST API: Exception in get_response - ' . $e->getMessage() );
			error_log( 'CBD REST API: Stack trace - ' . $e->getTraceAsString() );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro ao processar sua pergunta: ' . $e->getMessage(),
			) );
		} catch ( Error $e ) {
			error_log( 'CBD REST API: Fatal error in get_response - ' . $e->getMessage() );
			error_log( 'CBD REST API: Stack trace - ' . $e->getTraceAsString() );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro fatal ao processar sua pergunta. Verifique os logs do WordPress.',
			) );
		}
		
		error_log( 'CBD REST API: Response received, type = ' . gettype( $response ) );
		
		// If response is WP_Error, return it properly
		if ( is_wp_error( $response ) ) {
			error_log( 'CBD REST API: Response is WP_Error: ' . $response->get_error_message() );
			// Convert WP_Error to array for JSON response
			return rest_ensure_response( array(
				'success' => false,
				'message' => $response->get_error_message(),
				'error_code' => $response->get_error_code(),
			) );
		}
		
		// Validate response structure
		if ( ! is_array( $response ) ) {
			error_log( 'CBD REST API: Response is not an array, converting. Type: ' . gettype( $response ) );
			$response = array(
				'success' => false,
				'message' => 'Resposta inválida do chatbot.',
			);
		}
		
		error_log( 'CBD REST API: Returning response successfully' );
		return rest_ensure_response( $response );
	} catch ( Exception $e ) {
		error_log( 'CBD REST API: Exception caught - ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString() );
		return new WP_Error( 
			'chatbot_error', 
			'Erro ao processar pergunta: ' . $e->getMessage(), 
			array( 'status' => 500 ) 
		);
	} catch ( Error $e ) {
		error_log( 'CBD REST API: Fatal Error caught - ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString() );
		
		// Return JSON error response instead of letting WordPress show HTML error page
		$error_response = new WP_Error( 
			'chatbot_fatal_error', 
			'Erro fatal ao processar pergunta. Verifique os logs do WordPress ou configure a API Key corretamente.', 
			array( 'status' => 500 ) 
		);
		
		// Ensure it's returned as JSON
		return rest_ensure_response( array(
			'success' => false,
			'message' => 'Erro ao processar sua pergunta. Por favor, verifique se a API Key está configurada corretamente em CBD AI > Configurações.',
			'error_code' => 'fatal_error',
		) );
	}
}

/**
 * Chatbot CBD (General) Handler
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_chatbot_cbd_handler( $request ) {
	try {
		error_log( 'CBD REST API: chatbot_cbd_handler called' );
		
		$question = $request->get_param( 'question' );
		
		error_log( 'CBD REST API: Question = ' . substr( $question, 0, 50 ) );
		
		if ( empty( $question ) ) {
			error_log( 'CBD REST API: Missing question parameter' );
			return new WP_Error( 'missing_question', 'Pergunta é obrigatória', array( 'status' => 400 ) );
		}
		
		error_log( 'CBD REST API: Creating CBD_Chatbot_CBD_Handler instance' );
		
		// Check if class exists
		if ( ! class_exists( 'CBD_Chatbot_CBD_Handler' ) ) {
			error_log( 'CBD REST API: CBD_Chatbot_CBD_Handler class not found' );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro: Classe do chatbot não encontrada. Verifique se todos os arquivos estão carregados corretamente.',
			) );
		}
		
		try {
			$chatbot = new CBD_Chatbot_CBD_Handler();
		} catch ( Exception $e ) {
			error_log( 'CBD REST API: Error creating chatbot instance - ' . $e->getMessage() );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro ao inicializar o chatbot. Verifique se a API Key está configurada corretamente.',
			) );
		} catch ( Error $e ) {
			error_log( 'CBD REST API: Fatal error creating chatbot instance - ' . $e->getMessage() );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro fatal ao inicializar o chatbot. Verifique os logs do WordPress.',
			) );
		}
		
		error_log( 'CBD REST API: Calling get_response' );
		
		try {
			$response = $chatbot->get_response( $question );
		} catch ( Exception $e ) {
			error_log( 'CBD REST API: Exception in get_response - ' . $e->getMessage() );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro ao processar sua pergunta. Por favor, tente novamente.',
			) );
		} catch ( Error $e ) {
			error_log( 'CBD REST API: Fatal error in get_response - ' . $e->getMessage() );
			return rest_ensure_response( array(
				'success' => false,
				'message' => 'Erro fatal ao processar sua pergunta. Verifique os logs do WordPress.',
			) );
		}
		
		error_log( 'CBD REST API: Response prepared, success: ' . ( $response['success'] ? 'true' : 'false' ) );
		
		return rest_ensure_response( $response );
	} catch ( Exception $e ) {
		error_log( 'CBD REST API: Outer exception in chatbot_cbd_handler - ' . $e->getMessage() );
		return rest_ensure_response( array(
			'success' => false,
			'message' => 'Erro inesperado. Por favor, tente novamente.',
		) );
	} catch ( Error $e ) {
		error_log( 'CBD REST API: Outer fatal error in chatbot_cbd_handler - ' . $e->getMessage() );
		return rest_ensure_response( array(
			'success' => false,
			'message' => 'Erro fatal. Verifique os logs do WordPress.',
		) );
	}
}

/**
 * Handle legislation chatbot request
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_legislation_chatbot_handler( $request ) {
	$question = $request->get_param( 'question' );
	
	if ( empty( $question ) ) {
		return new WP_Error( 'missing_question', 'Pergunta é obrigatória', array( 'status' => 400 ) );
	}
	
	$chatbot = new CBD_Legislation_Chatbot_Handler();
	$response = $chatbot->get_response( $question );
	
	return rest_ensure_response( $response );
}

/**
 * Get legislation alerts
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response
 */
function cbd_ai_get_legislation_alerts( $request ) {
	$limit = $request->get_param( 'limit' );
	
	$monitor = new CBD_Legislation_Monitor();
	$alerts = $monitor->get_recent_alerts( $limit );
	
	return rest_ensure_response( $alerts );
}

/**
 * Handle newsletter subscription
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_newsletter_subscribe( $request ) {
	$email = $request->get_param( 'email' );
	
	if ( empty( $email ) || ! is_email( $email ) ) {
		return new WP_Error( 'invalid_email', 'Email inválido.', array( 'status' => 400 ) );
	}
	
	// Check if Brevo integration is configured
	$api_key = get_option( 'cbd_brevo_api_key', false );
	$list_id = get_option( 'cbd_brevo_list_id', false );
	
	if ( ! $api_key || ! $list_id ) {
		return new WP_Error( 'not_configured', 'Newsletter não está configurado. Por favor, contacte o administrador.', array( 'status' => 500 ) );
	}
	
	// Initialize Brevo integration
	if ( ! class_exists( 'CBD_Brevo_Integration' ) ) {
		require_once CBD_AI_THEME_PATH . '/inc/class-brevo-integration.php';
	}
	
	$brevo = new CBD_Brevo_Integration();
	
	// Add source attribute
	$attributes = array(
		'SOURCE' => 'Website',
		'SUBSCRIBED_AT' => current_time( 'mysql' ),
	);
	
	$result = $brevo->subscribe( $email, $attributes );
	
	if ( is_wp_error( $result ) ) {
		return $result;
	}
	
	return rest_ensure_response( $result );
}

/**
 * Get all legislation sources
 */
function cbd_ai_get_legislation_sources( $request ) {
	$active_only = $request->get_param( 'active_only' );
	
	$sources = new CBD_Legislation_Sources();
	$all_sources = $sources->get_all_sources( $active_only );
	
	return rest_ensure_response( $all_sources );
}

/**
 * Get single legislation source
 */
function cbd_ai_get_legislation_source( $request ) {
	$source_id = $request->get_param( 'id' );
	
	$sources = new CBD_Legislation_Sources();
	$source = $sources->get_source( $source_id );
	
	if ( ! $source ) {
		return new WP_Error( 'not_found', 'Fonte não encontrada.', array( 'status' => 404 ) );
	}
	
	return rest_ensure_response( $source );
}

/**
 * Create legislation source
 */
function cbd_ai_create_legislation_source( $request ) {
	$data = $request->get_json_params();
	
	$sources = new CBD_Legislation_Sources();
	$result = $sources->create_source( $data );
	
	if ( is_wp_error( $result ) ) {
		return $result;
	}
	
	$source = $sources->get_source( $result );
	return rest_ensure_response( $source );
}

/**
 * Update legislation source
 */
function cbd_ai_update_legislation_source( $request ) {
	$source_id = $request->get_param( 'id' );
	$data = $request->get_json_params();
	
	$sources = new CBD_Legislation_Sources();
	$result = $sources->update_source( $source_id, $data );
	
	if ( is_wp_error( $result ) ) {
		return $result;
	}
	
	$source = $sources->get_source( $source_id );
	return rest_ensure_response( $source );
}

/**
 * Delete legislation source
 */
function cbd_ai_delete_legislation_source( $request ) {
	$source_id = $request->get_param( 'id' );
	
	$sources = new CBD_Legislation_Sources();
	$result = $sources->delete_source( $source_id );
	
	if ( is_wp_error( $result ) ) {
		return $result;
	}
	
	return rest_ensure_response( array( 'success' => true, 'message' => 'Fonte deletada com sucesso.' ) );
}

/**
 * Test legislation source
 */
function cbd_ai_test_legislation_source( $request ) {
	$source_id = $request->get_param( 'id' );
	
	$sources = new CBD_Legislation_Sources();
	$source = $sources->get_source( $source_id );
	
	if ( ! $source ) {
		return new WP_Error( 'not_found', 'Fonte não encontrada.', array( 'status' => 404 ) );
	}
	
	$scraper = new CBD_Web_Scraper();
	$result = $scraper->scrape_url( $source['url'], $source['keywords'] );
	
	if ( is_wp_error( $result ) ) {
		return $result;
	}
	
	$changes = $scraper->check_for_changes( $source_id, $result['relevant_content'] );
	
	return rest_ensure_response( array(
		'success' => true,
		'has_changes' => $changes['has_changes'],
		'content_length' => strlen( $result['relevant_content'] ),
		'hash' => $result['content_hash'],
		'message' => $changes['has_changes'] ? 'Mudanças detectadas!' : 'Nenhuma mudança detectada.',
	) );
}

/**
 * Get stores list
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_get_stores( $request ) {
	$per_page = $request->get_param( 'per_page' );
	$page = $request->get_param( 'page' );
	$store_type = $request->get_param( 'store_type' );
	$location = $request->get_param( 'location' );
	$min_rating = $request->get_param( 'min_rating' );
	$orderby = $request->get_param( 'orderby' );
	$order = $request->get_param( 'order' );
	
	$query_args = array(
		'post_type' => 'cbd_store',
		'posts_per_page' => $per_page,
		'paged' => $page,
		'post_status' => 'publish',
	);
	
	// Add taxonomy filters
	$tax_query = array();
	if ( ! empty( $store_type ) ) {
		$tax_query[] = array(
			'taxonomy' => 'store_type',
			'field' => 'slug',
			'terms' => $store_type,
		);
	}
	if ( ! empty( $location ) ) {
		$tax_query[] = array(
			'taxonomy' => 'store_location',
			'field' => 'slug',
			'terms' => $location,
		);
	}
	if ( ! empty( $tax_query ) ) {
		$query_args['tax_query'] = $tax_query;
	}
	
	// Add rating filter
	if ( $min_rating > 0 ) {
		$query_args['meta_query'] = array(
			array(
				'key' => '_cbd_store_google_rating',
				'value' => $min_rating,
				'compare' => '>=',
				'type' => 'DECIMAL',
			),
		);
	}
	
	// Add ordering
	if ( $orderby === 'rating' ) {
		$query_args['meta_key'] = '_cbd_store_google_rating';
		$query_args['orderby'] = 'meta_value_num';
		$query_args['order'] = $order;
	} elseif ( $orderby === 'title' ) {
		$query_args['orderby'] = 'title';
		$query_args['order'] = $order;
	} else {
		$query_args['orderby'] = 'date';
		$query_args['order'] = $order;
	}
	
	$query = new WP_Query( $query_args );
	
	$stores = array();
	
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$store_id = get_the_ID();
			
			$stores[] = array(
				'id' => $store_id,
				'title' => get_the_title(),
				'slug' => get_post_field( 'post_name', $store_id ),
				'permalink' => get_permalink( $store_id ),
				'excerpt' => get_the_excerpt(),
				'featured_image' => get_the_post_thumbnail_url( $store_id, 'medium' ),
				'address' => get_post_meta( $store_id, '_cbd_store_address', true ),
				'city' => get_post_meta( $store_id, '_cbd_store_city', true ),
				'postal_code' => get_post_meta( $store_id, '_cbd_store_postal_code', true ),
				'country' => get_post_meta( $store_id, '_cbd_store_country', true ),
				'phone' => get_post_meta( $store_id, '_cbd_store_phone', true ),
				'email' => get_post_meta( $store_id, '_cbd_store_email', true ),
				'website' => get_post_meta( $store_id, '_cbd_store_website', true ),
				'latitude' => get_post_meta( $store_id, '_cbd_store_latitude', true ),
				'longitude' => get_post_meta( $store_id, '_cbd_store_longitude', true ),
				'rating' => get_post_meta( $store_id, '_cbd_store_google_rating', true ),
				'review_count' => get_post_meta( $store_id, '_cbd_store_google_review_count', true ),
				'google_maps_url' => get_post_meta( $store_id, '_cbd_store_google_maps_url', true ),
				'store_type' => wp_get_post_terms( $store_id, 'store_type', array( 'fields' => 'names' ) ),
				'location' => wp_get_post_terms( $store_id, 'store_location', array( 'fields' => 'names' ) ),
				'categories' => wp_get_post_terms( $store_id, 'store_category', array( 'fields' => 'names' ) ),
			);
		}
		wp_reset_postdata();
	}
	
	return rest_ensure_response( array(
		'stores' => $stores,
		'total' => $query->found_posts,
		'pages' => $query->max_num_pages,
		'current_page' => $page,
	) );
}

/**
 * Get single store
 *
 * @param WP_REST_Request $request Request object
 * @return WP_REST_Response|WP_Error
 */
function cbd_ai_get_store( $request ) {
	$store_id = $request->get_param( 'id' );
	
	$store = get_post( $store_id );
	
	if ( ! $store || $store->post_type !== 'cbd_store' || $store->post_status !== 'publish' ) {
		return new WP_Error( 'not_found', 'Loja não encontrada.', array( 'status' => 404 ) );
	}
	
	$store_data = array(
		'id' => $store_id,
		'title' => get_the_title( $store_id ),
		'slug' => $store->post_name,
		'permalink' => get_permalink( $store_id ),
		'content' => apply_filters( 'the_content', $store->post_content ),
		'excerpt' => get_the_excerpt( $store_id ),
		'featured_image' => get_the_post_thumbnail_url( $store_id, 'large' ),
		'address' => get_post_meta( $store_id, '_cbd_store_address', true ),
		'city' => get_post_meta( $store_id, '_cbd_store_city', true ),
		'postal_code' => get_post_meta( $store_id, '_cbd_store_postal_code', true ),
		'country' => get_post_meta( $store_id, '_cbd_store_country', true ),
		'phone' => get_post_meta( $store_id, '_cbd_store_phone', true ),
		'email' => get_post_meta( $store_id, '_cbd_store_email', true ),
		'website' => get_post_meta( $store_id, '_cbd_store_website', true ),
		'latitude' => get_post_meta( $store_id, '_cbd_store_latitude', true ),
		'longitude' => get_post_meta( $store_id, '_cbd_store_longitude', true ),
		'rating' => get_post_meta( $store_id, '_cbd_store_google_rating', true ),
		'review_count' => get_post_meta( $store_id, '_cbd_store_google_review_count', true ),
		'google_maps_url' => get_post_meta( $store_id, '_cbd_store_google_maps_url', true ),
		'opening_hours' => get_post_meta( $store_id, '_cbd_store_opening_hours', true ),
		'products' => get_post_meta( $store_id, '_cbd_store_products', true ),
		'certifications' => get_post_meta( $store_id, '_cbd_store_certifications', true ),
		'payment_methods' => get_post_meta( $store_id, '_cbd_store_payment_methods', true ),
		'delivery_available' => get_post_meta( $store_id, '_cbd_store_delivery_available', true ) === '1',
		'store_type' => wp_get_post_terms( $store_id, 'store_type', array( 'fields' => 'all' ) ),
		'location' => wp_get_post_terms( $store_id, 'store_location', array( 'fields' => 'all' ) ),
		'categories' => wp_get_post_terms( $store_id, 'store_category', array( 'fields' => 'all' ) ),
	);
	
	return rest_ensure_response( $store_data );
}

