<?php
/**
 * Template Functions
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get post excerpt with custom length
 *
 * @param int $length Excerpt length
 * @return string Excerpt
 */
function cbd_ai_get_excerpt( $length = 30 ) {
	$excerpt = get_the_excerpt();
	if ( empty( $excerpt ) ) {
		$excerpt = get_the_content();
	}
	return wp_trim_words( $excerpt, $length );
}

/**
 * Display post meta
 *
 * @param array $args Arguments
 */
function cbd_ai_post_meta( $args = array() ) {
	$defaults = array(
		'author' => true,
		'date' => true,
		'categories' => true,
		'tags' => false,
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	echo '<div class="post-meta flex flex-wrap gap-4 text-sm text-gray-600">';
	
	if ( $args['author'] ) {
		echo '<span class="author">Por ' . esc_html( get_the_author() ) . '</span>';
	}
	
	if ( $args['date'] ) {
		echo '<span class="date">' . esc_html( get_the_date() ) . '</span>';
	}
	
	if ( $args['categories'] && has_category() ) {
		echo '<span class="categories">' . get_the_category_list( ', ' ) . '</span>';
	}
	
	if ( $args['tags'] && has_tag() ) {
		echo '<span class="tags">' . get_the_tag_list( '', ', ' ) . '</span>';
	}
	
	echo '</div>';
}

/**
 * Display related posts
 *
 * @param int $post_id Post ID
 * @param int $limit Number of posts
 */
function cbd_ai_related_posts( $post_id = null, $limit = 3 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	
	$categories = wp_get_post_categories( $post_id );
	$tags = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );
	
	$args = array(
		'post__not_in' => array( $post_id ),
		'posts_per_page' => $limit,
		'post_status' => 'publish',
	);
	
	if ( ! empty( $categories ) ) {
		$args['category__in'] = $categories;
	} elseif ( ! empty( $tags ) ) {
		$args['tag__in'] = $tags;
	}
	
	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) {
		echo '<div class="related-posts mt-8">';
		echo '<h3 class="text-2xl font-bold mb-4">Artigos Relacionados</h3>';
		echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-6">';
		
		while ( $query->have_posts() ) {
			$query->the_post();
			?>
			<article class="card">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" class="block mb-4 overflow-hidden rounded-lg">
						<?php the_post_thumbnail( 'medium', array( 
							'class' => 'w-full h-[200px] object-cover rounded-lg',
							'loading' => 'lazy',
							'sizes' => '(max-width: 768px) 100vw, 33vw'
						) ); ?>
					</a>
				<?php endif; ?>
				
				<h4 class="text-lg font-bold mb-2">
					<a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-cbd-green-600">
						<?php the_title(); ?>
					</a>
				</h4>
				
				<div class="text-sm text-gray-600 mb-3">
					<?php echo get_the_date(); ?>
				</div>
				
				<p class="text-gray-600 text-sm">
					<?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
				</p>
				
				<a href="<?php the_permalink(); ?>" class="text-cbd-green-600 hover:underline text-sm font-medium mt-3 inline-block">
					Ler mais →
				</a>
			</article>
			<?php
		}
		
		echo '</div>';
		echo '</div>';
		
		wp_reset_postdata();
	}
}

/**
 * Get breadcrumbs
 * 
 * NOTE: This function is now defined in inc/breadcrumbs.php with Schema.org markup support.
 * The function has been moved to provide better SEO optimization.
 */

/**
 * Display social share buttons
 */
function cbd_ai_social_share() {
	$url = urlencode( get_permalink() );
	$title = urlencode( get_the_title() );
	$excerpt = urlencode( get_the_excerpt() );
	
	echo '<div class="social-share flex gap-4 mt-6">';
	echo '<span class="text-sm font-medium">Partilhar:</span>';
	
	// Facebook
	echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . esc_url( $url ) . '" target="_blank" rel="noopener" class="text-blue-600 hover:text-blue-700">Facebook</a>';
	
	// Twitter
	echo '<a href="https://twitter.com/intent/tweet?url=' . esc_url( $url ) . '&text=' . esc_attr( $title ) . '" target="_blank" rel="noopener" class="text-blue-400 hover:text-blue-500">Twitter</a>';
	
	// WhatsApp
	echo '<a href="https://wa.me/?text=' . esc_attr( $title . ' ' . $url ) . '" target="_blank" rel="noopener" class="text-green-600 hover:text-green-700">WhatsApp</a>';
	
	echo '</div>';
}

