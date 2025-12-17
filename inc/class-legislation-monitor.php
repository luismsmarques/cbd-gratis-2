<?php
/**
 * Legislation Monitor for Portuguese CBD Laws
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Legislation_Monitor {
	
	/**
	 * Gemini API instance
	 */
	private $gemini;
	
	/**
	 * Sources manager instance
	 */
	private $sources_manager;
	
	/**
	 * Web scraper instance
	 */
	private $scraper;
	
	/**
	 * Legacy sources (for backward compatibility)
	 */
	private $legacy_sources = array(
		'infarmed' => 'https://www.infarmed.pt',
		'dre' => 'https://dre.pt',
		'eu' => 'https://eur-lex.europa.eu',
	);
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->gemini = new CBD_Gemini_API();
		$this->sources_manager = new CBD_Legislation_Sources();
		$this->scraper = new CBD_Web_Scraper();
		$this->init_cron();
	}
	
	/**
	 * Initialize cron jobs
	 */
	private function init_cron() {
		// Register cron hooks for different frequencies
		$frequencies = array( 'hourly', 'twice_daily', 'daily', 'weekly' );
		
		foreach ( $frequencies as $frequency ) {
			$hook = "cbd_legislation_monitor_{$frequency}";
			
			if ( ! wp_next_scheduled( $hook ) ) {
				wp_schedule_event( time(), $frequency, $hook );
			}
			
			add_action( $hook, array( $this, 'monitor_sources_by_frequency' ) );
		}
		
		// Legacy daily hook for backward compatibility
		if ( ! wp_next_scheduled( 'cbd_legislation_monitor' ) ) {
			wp_schedule_event( time(), 'daily', 'cbd_legislation_monitor' );
		}
		add_action( 'cbd_legislation_monitor', array( $this, 'monitor_sources' ) );
	}
	
	/**
	 * Monitor sources by frequency
	 *
	 * @param string $frequency Frequency hook name
	 */
	public function monitor_sources_by_frequency( $frequency ) {
		// Extract frequency from hook name
		$freq = str_replace( 'cbd_legislation_monitor_', '', $frequency );
		
		// Get sources with this frequency
		$all_sources = $this->sources_manager->get_all_sources( true );
		$sources_to_check = array_filter( $all_sources, function( $source ) use ( $freq ) {
			return ( $source['check_frequency'] ?? 'daily' ) === $freq;
		} );
		
		foreach ( $sources_to_check as $source ) {
			$this->check_source_from_db( $source );
		}
	}
	
	/**
	 * Monitor sources for changes (legacy method - uses DB sources)
	 *
	 * @return array Results
	 */
	public function monitor_sources() {
		$results = array();
		
		// Use database sources if available
		$db_sources = $this->sources_manager->get_all_sources( true );
		
		if ( ! empty( $db_sources ) ) {
			foreach ( $db_sources as $source ) {
				$result = $this->check_source_from_db( $source );
				if ( ! is_wp_error( $result ) ) {
					$results[ $source['id'] ] = $result;
				}
			}
		} else {
			// Fallback to legacy sources
			foreach ( $this->legacy_sources as $source_name => $source_url ) {
				$result = $this->check_source( $source_name, $source_url );
				if ( ! is_wp_error( $result ) ) {
					$results[ $source_name ] = $result;
				}
			}
		}
		
		return $results;
	}
	
	/**
	 * Check source from database
	 *
	 * @param array $source Source data from database
	 * @return array|WP_Error Results or error
	 */
	private function check_source_from_db( $source ) {
		$source_id = $source['id'];
		$source_url = $source['url'];
		$keywords = ! empty( $source['keywords'] ) ? $source['keywords'] : array();
		$verification_method = $source['verification_method'] ?? 'web_scraping';
		
		// Only support web_scraping for now
		if ( $verification_method !== 'web_scraping' ) {
			$this->sources_manager->update_check_status( $source_id, 'error', 'Método de verificação não suportado: ' . $verification_method );
			return new WP_Error( 'unsupported_method', 'Método de verificação não suportado.' );
		}
		
		// Scrape URL
		$scrape_result = $this->scraper->scrape_url( $source_url, $keywords );
		
		if ( is_wp_error( $scrape_result ) ) {
			$this->sources_manager->update_check_status( $source_id, 'error', $scrape_result->get_error_message() );
			return $scrape_result;
		}
		
		// Check for changes
		$changes = $this->scraper->check_for_changes( $source_id, $scrape_result['relevant_content'] );
		
		if ( ! $changes['has_changes'] ) {
			$this->sources_manager->update_check_status( $source_id, 'no_changes' );
			return array(
				'status' => 'no_changes',
				'source_id' => $source_id,
				'source_name' => $source['name'],
			);
		}
		
		// New content detected - summarize and create alert
		if ( ! empty( $scrape_result['relevant_content'] ) ) {
			$summary = $this->summarize_document( $scrape_result['relevant_content'] );
			
			if ( ! is_wp_error( $summary ) ) {
				$alert_id = $this->create_alert( $source['type'] ?? 'custom', $summary, $source_url, $source_id );
				
				// Update content hash
				$this->sources_manager->update_content_hash( $source_id, $changes['new_hash'] );
				$this->sources_manager->update_check_status( $source_id, 'success' );
				
				return array(
					'status' => 'new_content',
					'source_id' => $source_id,
					'source_name' => $source['name'],
					'summary' => $summary,
					'alert_id' => $alert_id,
				);
			}
		}
		
		$this->sources_manager->update_check_status( $source_id, 'error', 'Erro ao processar conteúdo.' );
		return new WP_Error( 'processing_error', 'Erro ao processar conteúdo.' );
	}
	
	/**
	 * Extract relevant sections from content (legacy method)
	 *
	 * @param string $content Content to analyze
	 * @param array  $keywords Keywords to search for
	 * @return array Relevant sections
	 */
	private function extract_relevant_sections( $content, $keywords ) {
		$sections = array();
		$paragraphs = preg_split( '/\n\s*\n/', $content );
		
		foreach ( $paragraphs as $paragraph ) {
			$paragraph = trim( $paragraph );
			if ( strlen( $paragraph ) < 100 ) {
				continue;
			}
			
			foreach ( $keywords as $keyword ) {
				if ( stripos( $paragraph, $keyword ) !== false ) {
					$sections[] = $paragraph;
					break;
				}
			}
		}
		
		return array_slice( $sections, 0, 5 ); // Limit to 5 sections
	}
	
	/**
	 * Check a specific source (legacy method - for backward compatibility)
	 *
	 * @param string $source_name Source name
	 * @param string $source_url Source URL
	 * @return array|WP_Error Results or error
	 */
	private function check_source( $source_name, $source_url ) {
		// Search for CBD/cannabis related content
		$search_terms = array( 'canabidiol', 'CBD', 'cannabis', 'cânhamo', 'maconha medicinal' );
		
		$found_documents = array();
		
		// Use web scraper
		$scrape_result = $this->scraper->scrape_url( $source_url, $search_terms );
		
		if ( is_wp_error( $scrape_result ) ) {
			return $scrape_result;
		}
		
		// Check if content mentions CBD/cannabis keywords
		if ( empty( $scrape_result['relevant_content'] ) ) {
			return array( 'status' => 'no_changes', 'source' => $source_name );
		}
		
		// Check if we've seen this content before
		$content_hash = $scrape_result['content_hash'];
		$last_hash = get_option( "cbd_legislation_hash_{$source_name}", '' );
		
		if ( $content_hash === $last_hash ) {
			return array( 'status' => 'no_changes', 'source' => $source_name );
		}
		
		// New content detected
		update_option( "cbd_legislation_hash_{$source_name}", $content_hash );
		
		// Summarize the content
		$summary = $this->summarize_document( $scrape_result['relevant_content'] );
		
		if ( is_wp_error( $summary ) ) {
			return $summary;
		}
		
		// Create alert post
		$alert_id = $this->create_alert( $source_name, $summary, $source_url );
		
		return array(
			'status' => 'new_content',
			'source' => $source_name,
			'summary' => $summary,
			'alert_id' => $alert_id,
		);
	}
	
	/**
	 * Summarize legal document
	 *
	 * @param string $document Document content
	 * @return string|WP_Error Summary or error
	 */
	public function summarize_document( $document ) {
		$prompt = sprintf(
			'Resuma o seguinte documento legal sobre CBD/cannabis em português de forma clara e acessível. Destaque as principais mudanças ou informações relevantes:\n\n%s\n\nResumo:',
			$document
		);
		
		return $this->gemini->summarize_text( $prompt, 150 );
	}
	
	/**
	 * Create alert post
	 *
	 * @param string $source Source name/type
	 * @param string $summary Summary text
	 * @param string $source_url Source URL
	 * @param int    $source_id Source post ID (optional)
	 * @return int Post ID
	 */
	private function create_alert( $source, $summary, $source_url, $source_id = 0 ) {
		$source_name = ucfirst( $source );
		
		// Get source name from database if source_id provided
		if ( $source_id > 0 ) {
			$source_data = $this->sources_manager->get_source( $source_id );
			if ( $source_data ) {
				$source_name = $source_data['name'];
				$source = $source_data['type'] ?? $source;
			}
		}
		
		$post_data = array(
			'post_title' => sprintf( 'Alerta Legislativo: %s - %s', $source_name, date_i18n( 'd/m/Y' ) ),
			'post_content' => $summary,
			'post_status' => 'publish',
			'post_type' => 'legislation_alert',
			'meta_input' => array(
				'_cbd_source' => $source,
				'_cbd_source_url' => $source_url,
				'_cbd_alert_date' => current_time( 'mysql' ),
				'_cbd_source_id' => $source_id,
			),
		);
		
		$post_id = wp_insert_post( $post_data );
		
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			// Set taxonomy term
			wp_set_object_terms( $post_id, $source, 'legislation_type' );
		}
		
		return $post_id;
	}
	
	/**
	 * Get recent alerts
	 *
	 * @param int $limit Number of alerts to retrieve
	 * @return array Alerts
	 */
	public function get_recent_alerts( $limit = 10 ) {
		$args = array(
			'post_type' => 'legislation_alert',
			'posts_per_page' => $limit,
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC',
		);
		
		$query = new WP_Query( $args );
		
		$alerts = array();
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				
				$alert_date = get_post_meta( get_the_ID(), '_cbd_alert_date', true );
				$is_new = strtotime( $alert_date ) > ( time() - WEEK_IN_SECONDS );
				
				$alerts[] = array(
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'content' => get_the_content(),
					'excerpt' => wp_trim_words( get_the_content(), 30 ),
					'date' => get_the_date(),
					'source' => get_post_meta( get_the_ID(), '_cbd_source', true ),
					'source_url' => get_post_meta( get_the_ID(), '_cbd_source_url', true ),
					'url' => get_permalink(),
					'is_new' => $is_new,
				);
			}
			wp_reset_postdata();
		}
		
		return $alerts;
	}
}

