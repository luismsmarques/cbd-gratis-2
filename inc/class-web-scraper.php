<?php
/**
 * Web Scraper for Legislation Sources
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Web_Scraper {
	
	/**
	 * Default timeout for requests
	 */
	private $timeout = 30;
	
	/**
	 * Maximum content size to process (in bytes)
	 */
	private $max_content_size = 500000; // 500KB
	
	/**
	 * Scrape URL and extract content
	 *
	 * @param string $url URL to scrape
	 * @param array  $keywords Keywords to search for
	 * @return array|WP_Error Scraped content or error
	 */
	public function scrape_url( $url, $keywords = array() ) {
		// Validate URL
		if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return new WP_Error( 'invalid_url', 'URL inválida fornecida.' );
		}
		
		// Make request
		$response = wp_remote_get( $url, array(
			'timeout' => $this->timeout,
			'user-agent' => 'CBD AI Theme Monitor/1.0',
			'headers' => array(
				'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
				'Accept-Language' => 'pt-PT,pt;q=0.9,en;q=0.8',
			),
		) );
		
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( $response_code !== 200 ) {
			return new WP_Error( 'http_error', sprintf( 'Erro HTTP %d ao acessar URL.', $response_code ) );
		}
		
		$body = wp_remote_retrieve_body( $response );
		
		// Check content size
		if ( strlen( $body ) > $this->max_content_size ) {
			$body = substr( $body, 0, $this->max_content_size );
		}
		
		// Extract relevant content
		$relevant_content = $this->extract_relevant_content( $body, $keywords );
		
		return array(
			'url' => $url,
			'raw_content' => $body,
			'relevant_content' => $relevant_content,
			'content_hash' => $this->generate_hash( $relevant_content ),
			'scraped_at' => current_time( 'mysql' ),
		);
	}
	
	/**
	 * Extract relevant content based on keywords
	 *
	 * @param string $html HTML content
	 * @param array  $keywords Keywords to search for
	 * @return string Extracted relevant content
	 */
	public function extract_relevant_content( $html, $keywords = array() ) {
		// Default keywords if none provided
		if ( empty( $keywords ) ) {
			$keywords = array( 'canabidiol', 'CBD', 'cannabis', 'cânhamo', 'maconha medicinal' );
		}
		
		// Remove scripts and styles
		$html = preg_replace( '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html );
		$html = preg_replace( '/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/mi', '', $html );
		
		// Convert HTML entities
		$html = html_entity_decode( $html, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		
		// Strip HTML tags but keep structure
		$text = wp_strip_all_tags( $html );
		
		// Split into paragraphs
		$paragraphs = preg_split( '/\n\s*\n/', $text );
		
		$relevant_sections = array();
		
		foreach ( $paragraphs as $paragraph ) {
			$paragraph = trim( $paragraph );
			
			// Skip very short paragraphs
			if ( strlen( $paragraph ) < 100 ) {
				continue;
			}
			
			// Check if paragraph contains any keyword
			foreach ( $keywords as $keyword ) {
				if ( stripos( $paragraph, $keyword ) !== false ) {
					$relevant_sections[] = $paragraph;
					break;
				}
			}
		}
		
		// Limit to 10 most relevant sections
		$relevant_sections = array_slice( $relevant_sections, 0, 10 );
		
		return implode( "\n\n", $relevant_sections );
	}
	
	/**
	 * Check for changes by comparing content hash
	 *
	 * @param int    $source_id Source post ID
	 * @param string $new_content New content to compare
	 * @return array Comparison result
	 */
	public function check_for_changes( $source_id, $new_content ) {
		$new_hash = $this->generate_hash( $new_content );
		$last_hash = get_post_meta( $source_id, '_cbd_content_hash', true );
		
		$has_changes = ( $new_hash !== $last_hash && ! empty( $new_hash ) );
		
		return array(
			'has_changes' => $has_changes,
			'new_hash' => $new_hash,
			'last_hash' => $last_hash,
			'content' => $new_content,
		);
	}
	
	/**
	 * Generate hash for content
	 *
	 * @param string $content Content to hash
	 * @return string MD5 hash
	 */
	public function generate_hash( $content ) {
		if ( empty( $content ) ) {
			return '';
		}
		
		// Normalize content before hashing
		$normalized = trim( strtolower( $content ) );
		$normalized = preg_replace( '/\s+/', ' ', $normalized );
		
		return md5( $normalized );
	}
	
	/**
	 * Set timeout
	 *
	 * @param int $timeout Timeout in seconds
	 */
	public function set_timeout( $timeout ) {
		$this->timeout = absint( $timeout );
	}
	
	/**
	 * Set max content size
	 *
	 * @param int $size Size in bytes
	 */
	public function set_max_content_size( $size ) {
		$this->max_content_size = absint( $size );
	}
}

