<?php
/**
 * Migration Script for Legacy Legislation Sources
 *
 * Converts hardcoded sources to Custom Post Type entries
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migrate legacy sources to CPT
 */
function cbd_ai_migrate_legacy_sources() {
	// Check if migration already done
	if ( get_option( 'cbd_legislation_sources_migrated', false ) ) {
		return;
	}
	
	$sources = new CBD_Legislation_Sources();
	
	$legacy_sources = array(
		array(
			'name' => 'Infarmed',
			'url' => 'https://www.infarmed.pt',
			'type' => 'infarmed',
			'verification_method' => 'web_scraping',
			'check_frequency' => 'daily',
			'is_active' => true,
		),
		array(
			'name' => 'Diário da República',
			'url' => 'https://dre.pt',
			'type' => 'dre',
			'verification_method' => 'web_scraping',
			'check_frequency' => 'daily',
			'is_active' => true,
		),
		array(
			'name' => 'União Europeia',
			'url' => 'https://eur-lex.europa.eu',
			'type' => 'eu',
			'verification_method' => 'web_scraping',
			'check_frequency' => 'weekly',
			'is_active' => true,
		),
	);
	
	foreach ( $legacy_sources as $source_data ) {
		// Check if source already exists
		$existing = get_posts( array(
			'post_type' => 'legislation_source',
			'post_status' => 'any',
			'meta_query' => array(
				array(
					'key' => '_cbd_source_url',
					'value' => $source_data['url'],
					'compare' => '=',
				),
			),
			'posts_per_page' => 1,
		) );
		
		if ( empty( $existing ) ) {
			$sources->create_source( $source_data );
		}
	}
	
	// Mark migration as done
	update_option( 'cbd_legislation_sources_migrated', true );
}

// Run migration on admin init
add_action( 'admin_init', 'cbd_ai_migrate_legacy_sources' );

