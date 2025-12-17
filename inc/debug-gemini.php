<?php
/**
 * Debug Helper for Gemini API
 * 
 * Add ?cbd_debug_gemini=1 to any page to see debug info
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Debug Gemini API (only for admins)
 */
function cbd_ai_debug_gemini() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	if ( ! isset( $_GET['cbd_debug_gemini'] ) || $_GET['cbd_debug_gemini'] !== '1' ) {
		return;
	}
	
	$api_key = get_option( 'cbd_gemini_api_key', '' );
	$model = get_option( 'cbd_gemini_model_name', '' );
	$version = get_option( 'cbd_gemini_api_version', '' );
	
	echo '<pre style="background: #f0f0f0; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
	echo "=== CBD Gemini API Debug ===\n\n";
	echo "API Key: " . ( ! empty( $api_key ) ? substr( $api_key, 0, 10 ) . '...' : 'NÃO CONFIGURADA' ) . "\n";
	echo "Model: " . ( ! empty( $model ) ? $model : 'NÃO CONFIGURADO' ) . "\n";
	echo "Version: " . ( ! empty( $version ) ? $version : 'NÃO CONFIGURADO' ) . "\n\n";
	
	if ( ! empty( $api_key ) ) {
		echo "=== Testing API ===\n";
		$gemini = new CBD_Gemini_API();
		
		// Test with current model
		echo "\nTesting with current model (" . $model . " / " . $version . "):\n";
		$test_result = $gemini->generate_text( 'Teste', array( 'max_tokens' => 100 ) );
		
		if ( is_wp_error( $test_result ) ) {
			echo "ERROR: " . $test_result->get_error_message() . "\n";
			echo "Code: " . $test_result->get_error_code() . "\n";
		} else {
			echo "SUCCESS: " . substr( $test_result, 0, 100 ) . "...\n";
		}
		
		// Test raw API call to see response structure
		echo "\n=== Raw API Response Structure ===\n";
		$endpoint = sprintf(
			'https://generativelanguage.googleapis.com/%s/models/%s:generateContent?key=%s',
			$version,
			$model,
			$api_key
		);
		
		$body = array(
			'contents' => array(
				array(
					'parts' => array(
						array( 'text' => 'Teste' )
					)
				)
			),
			'generationConfig' => array(
				'maxOutputTokens' => 100,
			),
		);
		
		$response = wp_remote_post( $endpoint, array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'body' => json_encode( $body ),
			'timeout' => 10,
		) );
		
		if ( ! is_wp_error( $response ) ) {
			$response_body = wp_remote_retrieve_body( $response );
			$response_data = json_decode( $response_body, true );
			
			echo "Response Code: " . wp_remote_retrieve_response_code( $response ) . "\n";
			echo "Response Keys: " . implode( ', ', array_keys( $response_data ) ) . "\n";
			
			if ( isset( $response_data['candidates'] ) ) {
				echo "Candidates count: " . count( $response_data['candidates'] ) . "\n";
				if ( ! empty( $response_data['candidates'] ) ) {
					echo "First candidate keys: " . implode( ', ', array_keys( $response_data['candidates'][0] ) ) . "\n";
					if ( isset( $response_data['candidates'][0]['content'] ) ) {
						echo "Content keys: " . implode( ', ', array_keys( $response_data['candidates'][0]['content'] ) ) . "\n";
						if ( isset( $response_data['candidates'][0]['content']['parts'] ) ) {
							echo "Parts structure:\n";
							print_r( $response_data['candidates'][0]['content']['parts'] );
						}
					}
				}
			}
			
			if ( isset( $response_data['error'] ) ) {
				echo "API Error: " . wp_json_encode( $response_data['error'] ) . "\n";
			}
			
			echo "\nFull response (first 1000 chars):\n";
			echo substr( wp_json_encode( $response_data, JSON_PRETTY_PRINT ), 0, 1000 ) . "...\n";
		} else {
			echo "HTTP Error: " . $response->get_error_message() . "\n";
		}
	}
	
	echo '</pre>';
	exit;
}
add_action( 'init', 'cbd_ai_debug_gemini' );

