<?php
/**
 * Schema.org JSON-LD Markup Generator
 * 
 * Generates structured data for SEO and GEO optimization
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Schema_Markup {
	
	/**
	 * Generate Website Schema with SearchAction
	 */
	public static function generate_website_schema() {
		$schema = array(
			'@context' => 'https://schema.org',
			'@type' => 'WebSite',
			'@id' => home_url( '/' ) . '#website',
			'url' => home_url( '/' ),
			'name' => get_bloginfo( 'name' ),
			'description' => get_bloginfo( 'description' ) ?: 'Portal de Autoridade sobre CBD em Portugal: Legalidade, Guias para Animais e Informação Científica.',
			'potentialAction' => array(
				array(
					'@type' => 'SearchAction',
					'target' => array(
						'@type' => 'EntryPoint',
						'urlTemplate' => home_url( '/?s={search_term_string}' ),
					),
					'query-input' => 'required name=search_term_string',
				),
			),
		);
		
		return $schema;
	}
	
	/**
	 * Generate Organization Schema
	 */
	public static function generate_organization_schema() {
		$schema = array(
			'@context' => 'https://schema.org',
			'@type' => 'Organization',
			'@id' => home_url( '/' ) . '#organization',
			'name' => get_bloginfo( 'name' ) . ' - Autoridade CBD Portugal',
			'url' => home_url( '/' ),
			'description' => 'Portal especializado em CBD em Portugal. Informação atualizada sobre legalidade, dosagem para animais e legislação portuguesa.',
		);
		
		// Add logo if available
		if ( has_custom_logo() ) {
			$logo_id = get_theme_mod( 'custom_logo' );
			$logo = wp_get_attachment_image_src( $logo_id, 'full' );
			if ( $logo ) {
				$schema['logo'] = array(
					'@type' => 'ImageObject',
					'url' => $logo[0],
					'width' => $logo[1],
					'height' => $logo[2],
				);
			}
		}
		
		// Add sameAs (social media links) if available
		$social_links = array();
		// You can add social media URLs here if needed
		// $social_links[] = 'https://facebook.com/...';
		// $social_links[] = 'https://twitter.com/...';
		
		if ( ! empty( $social_links ) ) {
			$schema['sameAs'] = $social_links;
		}
		
		return $schema;
	}
	
	/**
	 * Generate Breadcrumb Schema
	 */
	public static function generate_breadcrumb_schema( $items = array() ) {
		if ( empty( $items ) ) {
			return null;
		}
		
		$breadcrumb_items = array();
		$position = 1;
		
		foreach ( $items as $item ) {
			$breadcrumb_items[] = array(
				'@type' => 'ListItem',
				'position' => $position++,
				'name' => $item['name'],
				'item' => $item['url'],
			);
		}
		
		$schema = array(
			'@context' => 'https://schema.org',
			'@type' => 'BreadcrumbList',
			'itemListElement' => $breadcrumb_items,
		);
		
		return $schema;
	}
	
	/**
	 * Generate Article Schema
	 */
	public static function generate_article_schema( $post_id = null ) {
		if ( ! $post_id ) {
			global $post;
			$post_id = $post->ID;
		}
		
		$post_obj = get_post( $post_id );
		if ( ! $post_obj ) {
			return null;
		}
		
		$schema = array(
			'@context' => 'https://schema.org',
			'@type' => 'Article',
			'headline' => get_the_title( $post_id ),
			'description' => wp_trim_words( get_the_excerpt( $post_id ), 30 ),
			'datePublished' => get_the_date( 'c', $post_id ),
			'dateModified' => get_the_modified_date( 'c', $post_id ),
			'author' => array(
				'@type' => 'Organization',
				'name' => get_bloginfo( 'name' ),
			),
			'publisher' => array(
				'@type' => 'Organization',
				'name' => get_bloginfo( 'name' ),
			),
		);
		
		// Add featured image
		if ( has_post_thumbnail( $post_id ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );
			if ( $image ) {
				$schema['image'] = array(
					'@type' => 'ImageObject',
					'url' => $image[0],
					'width' => $image[1],
					'height' => $image[2],
				);
			}
		}
		
		return $schema;
	}
	
	/**
	 * Output Schema JSON-LD
	 */
	public static function output_schema() {
		$schemas = array();
		
		// Always include Website and Organization on homepage
		if ( is_front_page() ) {
			$schemas[] = self::generate_website_schema();
			$schemas[] = self::generate_organization_schema();
		}
		
		// Add Article schema for single posts
		if ( is_singular() && ! is_front_page() ) {
			$article_schema = self::generate_article_schema();
			if ( $article_schema ) {
				$schemas[] = $article_schema;
			}
			
			// Add Organization schema
			$schemas[] = self::generate_organization_schema();
		}
		
		// Output schemas
		if ( ! empty( $schemas ) ) {
			// If multiple schemas, use @graph format
			if ( count( $schemas ) > 1 ) {
				echo '<script type="application/ld+json">' . "\n";
				echo wp_json_encode( array(
					'@context' => 'https://schema.org',
					'@graph' => $schemas,
				), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "\n";
				echo '</script>' . "\n";
			} else {
				// Single schema
				foreach ( $schemas as $schema ) {
					echo '<script type="application/ld+json">' . "\n";
					echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "\n";
					echo '</script>' . "\n";
				}
			}
		}
	}
}

