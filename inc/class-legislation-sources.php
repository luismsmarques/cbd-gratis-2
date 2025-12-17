<?php
/**
 * Legislation Sources Management Class
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Legislation_Sources {
	
	/**
	 * Get all active sources
	 *
	 * @return array Array of source objects
	 */
	public function get_all_sources( $active_only = true ) {
		$args = array(
			'post_type' => 'legislation_source',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'orderby' => 'title',
			'order' => 'ASC',
		);
		
		if ( $active_only ) {
			$args['meta_query'] = array(
				array(
					'key' => '_cbd_is_active',
					'value' => '1',
					'compare' => '=',
				),
			);
		}
		
		$query = new WP_Query( $args );
		$sources = array();
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$sources[] = $this->get_source( get_the_ID() );
			}
			wp_reset_postdata();
		}
		
		return $sources;
	}
	
	/**
	 * Get source by ID
	 *
	 * @param int $source_id Source post ID
	 * @return array|false Source data or false if not found
	 */
	public function get_source( $source_id ) {
		$post = get_post( $source_id );
		
		if ( ! $post || $post->post_type !== 'legislation_source' ) {
			return false;
		}
		
		$keywords = get_post_meta( $source_id, '_cbd_keywords', true );
		if ( is_string( $keywords ) ) {
			$keywords = json_decode( $keywords, true );
		}
		if ( ! is_array( $keywords ) ) {
			$keywords = array();
		}
		
		return array(
			'id' => $source_id,
			'name' => $post->post_title,
			'url' => get_post_meta( $source_id, '_cbd_source_url', true ),
			'type' => get_post_meta( $source_id, '_cbd_source_type', true ),
			'verification_method' => get_post_meta( $source_id, '_cbd_verification_method', true ),
			'check_frequency' => get_post_meta( $source_id, '_cbd_check_frequency', true ),
			'keywords' => $keywords,
			'is_active' => (bool) get_post_meta( $source_id, '_cbd_is_active', true ),
			'last_check' => get_post_meta( $source_id, '_cbd_last_check', true ),
			'last_status' => get_post_meta( $source_id, '_cbd_last_status', true ),
			'error_message' => get_post_meta( $source_id, '_cbd_error_message', true ),
			'check_count' => (int) get_post_meta( $source_id, '_cbd_check_count', true ),
			'success_count' => (int) get_post_meta( $source_id, '_cbd_success_count', true ),
			'content_hash' => get_post_meta( $source_id, '_cbd_content_hash', true ),
		);
	}
	
	/**
	 * Create new source
	 *
	 * @param array $data Source data
	 * @return int|WP_Error Post ID or error
	 */
	public function create_source( $data ) {
		// Validate required fields
		if ( empty( $data['name'] ) || empty( $data['url'] ) ) {
			return new WP_Error( 'missing_fields', 'Nome e URL são obrigatórios.' );
		}
		
		// Validate URL
		if ( ! filter_var( $data['url'], FILTER_VALIDATE_URL ) ) {
			return new WP_Error( 'invalid_url', 'URL inválida.' );
		}
		
		// Prepare keywords
		$keywords = array();
		if ( ! empty( $data['keywords'] ) ) {
			if ( is_string( $data['keywords'] ) ) {
				$keywords = array_filter( array_map( 'trim', explode( "\n", $data['keywords'] ) ) );
			} elseif ( is_array( $data['keywords'] ) ) {
				$keywords = array_filter( array_map( 'trim', $data['keywords'] ) );
			}
		}
		
		// Default keywords if none provided
		if ( empty( $keywords ) ) {
			$keywords = array( 'canabidiol', 'CBD', 'cannabis', 'cânhamo', 'maconha medicinal' );
		}
		
		// Create post
		$post_data = array(
			'post_title' => sanitize_text_field( $data['name'] ),
			'post_type' => 'legislation_source',
			'post_status' => 'publish',
		);
		
		$post_id = wp_insert_post( $post_data );
		
		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}
		
		// Save meta fields
		update_post_meta( $post_id, '_cbd_source_url', esc_url_raw( $data['url'] ) );
		update_post_meta( $post_id, '_cbd_source_type', sanitize_text_field( $data['type'] ?? 'custom' ) );
		update_post_meta( $post_id, '_cbd_verification_method', sanitize_text_field( $data['verification_method'] ?? 'web_scraping' ) );
		update_post_meta( $post_id, '_cbd_check_frequency', sanitize_text_field( $data['check_frequency'] ?? 'daily' ) );
		update_post_meta( $post_id, '_cbd_keywords', wp_json_encode( $keywords ) );
		update_post_meta( $post_id, '_cbd_is_active', ! empty( $data['is_active'] ) ? '1' : '0' );
		update_post_meta( $post_id, '_cbd_check_count', 0 );
		update_post_meta( $post_id, '_cbd_success_count', 0 );
		
		// Set taxonomy term
		if ( ! empty( $data['type'] ) ) {
			wp_set_object_terms( $post_id, sanitize_text_field( $data['type'] ), 'source_type' );
		}
		
		return $post_id;
	}
	
	/**
	 * Update source
	 *
	 * @param int   $source_id Source post ID
	 * @param array $data Source data
	 * @return bool|WP_Error Success or error
	 */
	public function update_source( $source_id, $data ) {
		$post = get_post( $source_id );
		
		if ( ! $post || $post->post_type !== 'legislation_source' ) {
			return new WP_Error( 'not_found', 'Fonte não encontrada.' );
		}
		
		// Update post title if provided
		if ( ! empty( $data['name'] ) ) {
			wp_update_post( array(
				'ID' => $source_id,
				'post_title' => sanitize_text_field( $data['name'] ),
			) );
		}
		
		// Update meta fields
		if ( isset( $data['url'] ) ) {
			if ( ! filter_var( $data['url'], FILTER_VALIDATE_URL ) ) {
				return new WP_Error( 'invalid_url', 'URL inválida.' );
			}
			update_post_meta( $source_id, '_cbd_source_url', esc_url_raw( $data['url'] ) );
		}
		
		if ( isset( $data['type'] ) ) {
			update_post_meta( $source_id, '_cbd_source_type', sanitize_text_field( $data['type'] ) );
			wp_set_object_terms( $source_id, sanitize_text_field( $data['type'] ), 'source_type' );
		}
		
		if ( isset( $data['verification_method'] ) ) {
			update_post_meta( $source_id, '_cbd_verification_method', sanitize_text_field( $data['verification_method'] ) );
		}
		
		if ( isset( $data['check_frequency'] ) ) {
			update_post_meta( $source_id, '_cbd_check_frequency', sanitize_text_field( $data['check_frequency'] ) );
		}
		
		if ( isset( $data['keywords'] ) ) {
			$keywords = array();
			if ( is_string( $data['keywords'] ) ) {
				$keywords = array_filter( array_map( 'trim', explode( "\n", $data['keywords'] ) ) );
			} elseif ( is_array( $data['keywords'] ) ) {
				$keywords = array_filter( array_map( 'trim', $data['keywords'] ) );
			}
			update_post_meta( $source_id, '_cbd_keywords', wp_json_encode( $keywords ) );
		}
		
		if ( isset( $data['is_active'] ) ) {
			update_post_meta( $source_id, '_cbd_is_active', $data['is_active'] ? '1' : '0' );
		}
		
		return true;
	}
	
	/**
	 * Delete source
	 *
	 * @param int $source_id Source post ID
	 * @return bool|WP_Error Success or error
	 */
	public function delete_source( $source_id ) {
		$post = get_post( $source_id );
		
		if ( ! $post || $post->post_type !== 'legislation_source' ) {
			return new WP_Error( 'not_found', 'Fonte não encontrada.' );
		}
		
		return wp_delete_post( $source_id, true ) !== false;
	}
	
	/**
	 * Toggle active status
	 *
	 * @param int $source_id Source post ID
	 * @return bool|WP_Error New status or error
	 */
	public function toggle_active( $source_id ) {
		$current_status = get_post_meta( $source_id, '_cbd_is_active', true );
		$new_status = ( $current_status !== '1' ) ? '1' : '0';
		
		update_post_meta( $source_id, '_cbd_is_active', $new_status );
		
		return (bool) $new_status;
	}
	
	/**
	 * Get sources by type
	 *
	 * @param string $type Source type
	 * @return array Array of sources
	 */
	public function get_sources_by_type( $type ) {
		$args = array(
			'post_type' => 'legislation_source',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => '_cbd_source_type',
					'value' => $type,
					'compare' => '=',
				),
				array(
					'key' => '_cbd_is_active',
					'value' => '1',
					'compare' => '=',
				),
			),
		);
		
		$query = new WP_Query( $args );
		$sources = array();
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$sources[] = $this->get_source( get_the_ID() );
			}
			wp_reset_postdata();
		}
		
		return $sources;
	}
	
	/**
	 * Update source check status
	 *
	 * @param int    $source_id Source post ID
	 * @param string $status Status (success, error, no_changes)
	 * @param string $error_message Error message if status is error
	 * @return bool Success
	 */
	public function update_check_status( $source_id, $status, $error_message = '' ) {
		update_post_meta( $source_id, '_cbd_last_check', current_time( 'mysql' ) );
		update_post_meta( $source_id, '_cbd_last_status', $status );
		
		$check_count = (int) get_post_meta( $source_id, '_cbd_check_count', true );
		update_post_meta( $source_id, '_cbd_check_count', $check_count + 1 );
		
		if ( $status === 'success' ) {
			$success_count = (int) get_post_meta( $source_id, '_cbd_success_count', true );
			update_post_meta( $source_id, '_cbd_success_count', $success_count + 1 );
		}
		
		if ( ! empty( $error_message ) ) {
			update_post_meta( $source_id, '_cbd_error_message', sanitize_text_field( $error_message ) );
		} else {
			delete_post_meta( $source_id, '_cbd_error_message' );
		}
		
		return true;
	}
	
	/**
	 * Update content hash
	 *
	 * @param int    $source_id Source post ID
	 * @param string $hash Content hash
	 * @return bool Success
	 */
	public function update_content_hash( $source_id, $hash ) {
		return update_post_meta( $source_id, '_cbd_content_hash', $hash ) !== false;
	}
}

