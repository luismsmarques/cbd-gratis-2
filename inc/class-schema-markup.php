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
	 * Generate LocalBusiness Schema for CBD Stores
	 */
	public static function generate_local_business_schema( $post_id = null ) {
		if ( ! $post_id ) {
			global $post;
			$post_id = $post->ID;
		}
		
		$post_obj = get_post( $post_id );
		if ( ! $post_obj || get_post_type( $post_id ) !== 'cbd_store' ) {
			return null;
		}
		
		// Get store meta data
		$name = get_the_title( $post_id );
		$description = wp_trim_words( get_the_excerpt( $post_id ) ?: get_the_content( $post_id ), 30 );
		$address = get_post_meta( $post_id, '_cbd_store_address', true );
		$city = get_post_meta( $post_id, '_cbd_store_city', true );
		$postal_code = get_post_meta( $post_id, '_cbd_store_postal_code', true );
		$country = get_post_meta( $post_id, '_cbd_store_country', true ) ?: 'Portugal';
		$phone = get_post_meta( $post_id, '_cbd_store_phone', true );
		$email = get_post_meta( $post_id, '_cbd_store_email', true );
		$website = get_post_meta( $post_id, '_cbd_store_website', true );
		$latitude = get_post_meta( $post_id, '_cbd_store_latitude', true );
		$longitude = get_post_meta( $post_id, '_cbd_store_longitude', true );
		$rating = get_post_meta( $post_id, '_cbd_store_google_rating', true );
		$review_count = get_post_meta( $post_id, '_cbd_store_google_review_count', true );
		$maps_url = get_post_meta( $post_id, '_cbd_store_google_maps_url', true );
		$opening_hours = get_post_meta( $post_id, '_cbd_store_opening_hours', true );
		
		$schema = array(
			'@context' => 'https://schema.org',
			'@type' => 'LocalBusiness',
			'name' => $name,
			'description' => $description,
		);
		
		// Add URL
		$schema['url'] = get_permalink( $post_id );
		if ( $website ) {
			$schema['url'] = $website;
		}
		
		// Add address
		if ( $address || $city ) {
			$address_schema = array(
				'@type' => 'PostalAddress',
			);
			
			if ( $address ) {
				$address_schema['streetAddress'] = $address;
			}
			if ( $city ) {
				$address_schema['addressLocality'] = $city;
			}
			if ( $postal_code ) {
				$address_schema['postalCode'] = $postal_code;
			}
			$address_schema['addressCountry'] = $country;
			
			$schema['address'] = $address_schema;
		}
		
		// Add geo coordinates
		if ( $latitude && $longitude ) {
			$schema['geo'] = array(
				'@type' => 'GeoCoordinates',
				'latitude' => floatval( $latitude ),
				'longitude' => floatval( $longitude ),
			);
		}
		
		// Add contact information
		$contact_points = array();
		if ( $phone ) {
			$contact_points[] = array(
				'@type' => 'ContactPoint',
				'telephone' => $phone,
				'contactType' => 'customer service',
			);
		}
		if ( $email ) {
			$contact_points[] = array(
				'@type' => 'ContactPoint',
				'email' => $email,
				'contactType' => 'customer service',
			);
		}
		if ( ! empty( $contact_points ) ) {
			$schema['contactPoint'] = $contact_points;
		}
		
		// Add opening hours
		if ( $opening_hours ) {
			$hours_lines = explode( "\n", $opening_hours );
			$hours_lines = array_filter( array_map( 'trim', $hours_lines ) );
			if ( ! empty( $hours_lines ) ) {
				$opening_hours_spec = array();
				foreach ( $hours_lines as $line ) {
					// Try to parse opening hours (basic format: "Monday: 09:00 - 18:00")
					if ( preg_match( '/([^:]+):\s*([0-9]{2}:[0-9]{2})\s*-\s*([0-9]{2}:[0-9]{2})/i', $line, $matches ) ) {
						$day = trim( $matches[1] );
						$opens = trim( $matches[2] );
						$closes = trim( $matches[3] );
						
						// Map Portuguese day names to English
						$day_map = array(
							'segunda-feira' => 'Monday',
							'terça-feira' => 'Tuesday',
							'quarta-feira' => 'Wednesday',
							'quinta-feira' => 'Thursday',
							'sexta-feira' => 'Friday',
							'sábado' => 'Saturday',
							'domingo' => 'Sunday',
						);
						
						$day_lower = strtolower( $day );
						if ( isset( $day_map[ $day_lower ] ) ) {
							$opening_hours_spec[] = $day_map[ $day_lower ] . ' ' . $opens . '-' . $closes;
						}
					}
				}
				if ( ! empty( $opening_hours_spec ) ) {
					$schema['openingHoursSpecification'] = array();
					foreach ( $opening_hours_spec as $spec ) {
						if ( preg_match( '/(\w+)\s+([0-9]{2}:[0-9]{2})-([0-9]{2}:[0-9]{2})/', $spec, $matches ) ) {
							$schema['openingHoursSpecification'][] = array(
								'@type' => 'OpeningHoursSpecification',
								'dayOfWeek' => $matches[1],
								'opens' => $matches[2],
								'closes' => $matches[3],
							);
						}
					}
				}
			}
		}
		
		// Add aggregate rating
		if ( $rating && $review_count ) {
			$schema['aggregateRating'] = array(
				'@type' => 'AggregateRating',
				'ratingValue' => floatval( $rating ),
				'reviewCount' => intval( $review_count ),
			);
		}
		
		// Add image
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
		
		// Add sameAs (Google Maps link)
		if ( $maps_url ) {
			$schema['sameAs'] = array( $maps_url );
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
		
		// Add LocalBusiness schema for CBD stores
		if ( is_singular( 'cbd_store' ) ) {
			$local_business_schema = self::generate_local_business_schema();
			if ( $local_business_schema ) {
				$schemas[] = $local_business_schema;
			}
			
			// Add Organization schema
			$schemas[] = self::generate_organization_schema();
		}
		
		// Add Article schema for single posts (but not stores)
		if ( is_singular() && ! is_front_page() && ! is_singular( 'cbd_store' ) ) {
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

