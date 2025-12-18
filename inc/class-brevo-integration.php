<?php
/**
 * Brevo (Sendinblue) API Integration
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class CBD_Brevo_Integration
 */
class CBD_Brevo_Integration {
	
	/**
	 * API endpoint base URL
	 */
	const API_BASE_URL = 'https://api.brevo.com/v3';
	
	/**
	 * Get API key from options
	 *
	 * @return string|false
	 */
	private function get_api_key() {
		return get_option( 'cbd_brevo_api_key', false );
	}
	
	/**
	 * Get list ID from options
	 *
	 * @return int|false
	 */
	private function get_list_id() {
		return get_option( 'cbd_brevo_list_id', false );
	}
	
	/**
	 * Make API request to Brevo
	 *
	 * @param string $endpoint API endpoint
	 * @param string $method HTTP method
	 * @param array  $data Request data
	 * @return array|WP_Error
	 */
	private function api_request( $endpoint, $method = 'GET', $data = array() ) {
		$api_key = $this->get_api_key();
		
		if ( ! $api_key ) {
			return new WP_Error( 'no_api_key', 'API Key do Brevo não configurada.' );
		}
		
		$url = self::API_BASE_URL . $endpoint;
		
		$args = array(
			'method'  => $method,
			'headers' => array(
				'api-key'      => $api_key,
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
			),
			'timeout' => 30,
		);
		
		if ( ! empty( $data ) && in_array( $method, array( 'POST', 'PUT', 'PATCH' ), true ) ) {
			$args['body'] = wp_json_encode( $data );
		}
		
		$response = wp_remote_request( $url, $args );
		
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		
		$status_code = wp_remote_retrieve_response_code( $response );
		$body = wp_remote_retrieve_body( $response );
		$decoded = json_decode( $body, true );
		
		if ( $status_code >= 200 && $status_code < 300 ) {
			return $decoded;
		}
		
		$error_message = 'Erro na API do Brevo';
		if ( isset( $decoded['message'] ) ) {
			$error_message = $decoded['message'];
		} elseif ( isset( $decoded['error'] ) ) {
			$error_message = is_array( $decoded['error'] ) ? $decoded['error']['message'] : $decoded['error'];
		}
		
		return new WP_Error( 'brevo_api_error', $error_message, array( 'status' => $status_code ) );
	}
	
	/**
	 * Subscribe email to Brevo list
	 *
	 * @param string $email Email address
	 * @param array  $attributes Additional attributes (optional)
	 * @return array|WP_Error
	 */
	public function subscribe( $email, $attributes = array() ) {
		$list_id = $this->get_list_id();
		
		if ( ! $list_id ) {
			return new WP_Error( 'no_list_id', 'ID da lista do Brevo não configurado.' );
		}
		
		// Validate email
		if ( ! is_email( $email ) ) {
			return new WP_Error( 'invalid_email', 'Email inválido.' );
		}
		
		// Prepare contact data
		$contact_data = array(
			'email'     => sanitize_email( $email ),
			'listIds'   => array( (int) $list_id ),
			'updateEnabled' => true, // Update if contact already exists
		);
		
		// Add attributes if provided
		if ( ! empty( $attributes ) ) {
			$contact_data['attributes'] = $attributes;
		}
		
		// Make API request
		$result = $this->api_request( '/contacts', 'POST', $contact_data );
		
		if ( is_wp_error( $result ) ) {
			// Check if contact already exists (error code 400 with specific message)
			$error_code = $result->get_error_code();
			$error_message = $result->get_error_message();
			
			// If contact exists, try to update it
			if ( strpos( strtolower( $error_message ), 'already exists' ) !== false || 
				 strpos( strtolower( $error_message ), 'duplicate' ) !== false ) {
				return $this->update_contact( $email, $attributes );
			}
			
			return $result;
		}
		
		return array(
			'success' => true,
			'message' => 'Subscrição realizada com sucesso!',
			'data'    => $result,
		);
	}
	
	/**
	 * Update existing contact
	 *
	 * @param string $email Email address
	 * @param array  $attributes Additional attributes
	 * @return array|WP_Error
	 */
	private function update_contact( $email, $attributes = array() ) {
		$list_id = $this->get_list_id();
		
		$contact_data = array(
			'listIds' => array( (int) $list_id ),
		);
		
		if ( ! empty( $attributes ) ) {
			$contact_data['attributes'] = $attributes;
		}
		
		// Brevo uses PUT to update contacts
		$email_encoded = urlencode( $email );
		$result = $this->api_request( '/contacts/' . $email_encoded, 'PUT', $contact_data );
		
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		
		return array(
			'success' => true,
			'message' => 'Subscrição atualizada com sucesso!',
			'data'    => $result,
		);
	}
	
	/**
	 * Get lists from Brevo
	 *
	 * @return array|WP_Error
	 */
	public function get_lists() {
		$result = $this->api_request( '/contacts/lists?limit=50&offset=0&sort=desc' );
		
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		
		return $result;
	}
	
	/**
	 * Test API connection
	 *
	 * @return array|WP_Error
	 */
	public function test_connection() {
		// Try to get account info
		$result = $this->api_request( '/account' );
		
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		
		return array(
			'success' => true,
			'message' => 'Conexão com Brevo estabelecida com sucesso!',
			'data'    => $result,
		);
	}
}

