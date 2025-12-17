<?php
/**
 * Breadcrumbs Functionality
 * 
 * Generates breadcrumbs with Schema.org markup for SEO
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generate breadcrumbs array
 */
function cbd_ai_get_breadcrumbs() {
	$breadcrumbs = array();
	
	// Home
	$breadcrumbs[] = array(
		'name' => 'Início',
		'url' => home_url( '/' ),
	);
	
	// Single post
	if ( is_singular() && ! is_front_page() ) {
		$post_type = get_post_type();
		$post_type_obj = get_post_type_object( $post_type );
		
		// Add post type archive if exists
		if ( $post_type_obj && $post_type_obj->has_archive ) {
			$breadcrumbs[] = array(
				'name' => $post_type_obj->labels->name,
				'url' => get_post_type_archive_link( $post_type ),
			);
		}
		
		// Add categories/taxonomies
		$taxonomies = get_object_taxonomies( $post_type );
		if ( ! empty( $taxonomies ) ) {
			$terms = wp_get_post_terms( get_the_ID(), $taxonomies[0] );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$term = $terms[0];
				$breadcrumbs[] = array(
					'name' => $term->name,
					'url' => get_term_link( $term ),
				);
			}
		}
		
		// Current post
		$breadcrumbs[] = array(
			'name' => get_the_title(),
			'url' => get_permalink(),
		);
	}
	
	// Category archive
	elseif ( is_category() ) {
		$category = get_queried_object();
		$breadcrumbs[] = array(
			'name' => $category->name,
			'url' => get_category_link( $category->term_id ),
		);
	}
	
	// Tag archive
	elseif ( is_tag() ) {
		$tag = get_queried_object();
		$breadcrumbs[] = array(
			'name' => $tag->name,
			'url' => get_tag_link( $tag->term_id ),
		);
	}
	
	// Taxonomy archive
	elseif ( is_tax() ) {
		$term = get_queried_object();
		$taxonomy = get_taxonomy( $term->taxonomy );
		
		if ( $taxonomy ) {
			$breadcrumbs[] = array(
				'name' => $taxonomy->labels->name,
				'url' => get_post_type_archive_link( $taxonomy->object_type[0] ),
			);
		}
		
		$breadcrumbs[] = array(
			'name' => $term->name,
			'url' => get_term_link( $term ),
		);
	}
	
	// Page
	elseif ( is_page() && ! is_front_page() ) {
		$ancestors = get_post_ancestors( get_the_ID() );
		if ( $ancestors ) {
			$ancestors = array_reverse( $ancestors );
			foreach ( $ancestors as $ancestor_id ) {
				$breadcrumbs[] = array(
					'name' => get_the_title( $ancestor_id ),
					'url' => get_permalink( $ancestor_id ),
				);
			}
		}
		
		$breadcrumbs[] = array(
			'name' => get_the_title(),
			'url' => get_permalink(),
		);
	}
	
	// Search
	elseif ( is_search() ) {
		$breadcrumbs[] = array(
			'name' => 'Pesquisa: ' . get_search_query(),
			'url' => get_search_link(),
		);
	}
	
	// 404
	elseif ( is_404() ) {
		$breadcrumbs[] = array(
			'name' => 'Página não encontrada',
			'url' => '',
		);
	}
	
	return $breadcrumbs;
}

/**
 * Output breadcrumbs HTML with Schema.org markup
 */
function cbd_ai_breadcrumbs() {
	if ( is_front_page() ) {
		return; // Don't show breadcrumbs on homepage
	}
	
	$breadcrumbs = cbd_ai_get_breadcrumbs();
	if ( empty( $breadcrumbs ) ) {
		return;
	}
	
	// Generate Schema.org JSON-LD
	$schema = CBD_Schema_Markup::generate_breadcrumb_schema( $breadcrumbs );
	
	?>
	<nav aria-label="Breadcrumb" class="breadcrumbs mb-6">
		<ol class="flex flex-wrap items-center gap-2 text-sm text-gray-600" itemscope itemtype="https://schema.org/BreadcrumbList">
			<?php
			foreach ( $breadcrumbs as $index => $crumb ) :
				$position = $index + 1;
				$is_last = ( $position === count( $breadcrumbs ) );
			?>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="flex items-center gap-2">
					<?php if ( ! $is_last && ! empty( $crumb['url'] ) ) : ?>
						<a href="<?php echo esc_url( $crumb['url'] ); ?>" itemprop="item" class="hover:text-cbd-green-600 transition-colors">
							<span itemprop="name"><?php echo esc_html( $crumb['name'] ); ?></span>
						</a>
						<meta itemprop="position" content="<?php echo esc_attr( $position ); ?>" />
						<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
						</svg>
					<?php else : ?>
						<span itemprop="name" class="text-gray-900 font-medium"><?php echo esc_html( $crumb['name'] ); ?></span>
						<meta itemprop="position" content="<?php echo esc_attr( $position ); ?>" />
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</nav>
	
	<?php if ( $schema ) : ?>
		<script type="application/ld+json">
		<?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ); ?>
		</script>
	<?php endif; ?>
	<?php
}

