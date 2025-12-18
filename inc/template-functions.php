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

/**
 * Display standard sidebar widgets
 * 
 * Uniform sidebar across all templates based on single.php design
 * 
 * @param array $args {
 *     Optional. Array of arguments.
 *     @type bool $show_search       Show search widget. Default true.
 *     @type bool $show_categories   Show categories widget. Default true.
 *     @type bool $show_recent       Show recent posts widget. Default true.
 *     @type bool $show_chatbot      Show chatbot widget. Default true.
 *     @type bool $show_calculator   Show dosage calculator widget. Default false.
 *     @type bool $show_newsletter   Show newsletter widget. Default true.
 *     @type bool $show_related      Show related articles widget. Default false (only for single posts).
 *     @type string $context         Context for customization (e.g., 'single', 'archive', 'search').
 * }
 */
function cbd_ai_sidebar( $args = array() ) {
	$defaults = array(
		'show_search'     => true,
		'show_categories' => true,
		'show_recent'     => true,
		'show_chatbot'    => true,
		'show_calculator' => false,
		'show_newsletter' => true,
		'show_related'    => false,
		'context'         => 'default',
		'wrap_in_aside'   => true,
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	if ( $args['wrap_in_aside'] ) {
		?>
		<aside class="lg:col-span-4">
			<div class="sticky top-24 space-y-6">
		<?php
	} else {
		?>
		<div class="sticky top-24 space-y-6">
		<?php
	}
	
	?>
	
	<?php if ( $args['show_chatbot'] ) : ?>
		<!-- Chatbot Widget - Featured -->
		<div class="chatbot-widget bg-white rounded-lg shadow-lg border-2 border-cbd-green-200 overflow-hidden">
			<div class="bg-gradient-to-r from-cbd-green-600 to-cbd-green-700 p-4 text-white">
				<div class="flex items-center gap-3">
					<div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
						<span class="text-2xl">💬</span>
					</div>
					<div>
						<h3 class="font-bold text-lg">Chatbot Especialista</h3>
						<p class="text-sm opacity-90">Tire suas dúvidas agora</p>
					</div>
				</div>
			</div>
			<div class="p-4">
				<p class="text-gray-700 text-sm mb-4">
					<?php if ( $args['context'] === 'category' ) : ?>
						Faça perguntas sobre CBD relacionadas com <?php echo esc_html( strtolower( single_cat_title( '', false ) ) ); ?>. Nossa IA especializada está pronta para ajudar.
					<?php else : ?>
						Faça perguntas sobre dosagem, segurança ou qualquer dúvida sobre CBD. Nossa IA especializada está pronta para ajudar.
					<?php endif; ?>
				</p>
				<?php
				$chatbot_page = get_page_by_path( 'chatbot-ai-cbd' );
				if ( ! $chatbot_page ) {
					$chatbot_page = get_page_by_path( 'chatbot' );
				}
				$chatbot_url = $chatbot_page ? get_permalink( $chatbot_page->ID ) : home_url( '/chatbot-ai-cbd/' );
				?>
				<a href="<?php echo esc_url( $chatbot_url ); ?>" class="btn-cta bg-cbd-green-600 text-white w-full py-3 rounded-lg font-semibold hover:bg-cbd-green-700 transition-colors inline-flex items-center justify-center gap-2">
					Iniciar Conversa
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
					</svg>
				</a>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if ( $args['show_calculator'] ) : ?>
		<!-- Quick Dosage Calculator -->
		<div class="dosage-calculator bg-white rounded-lg shadow-md border border-gray-200 p-6">
			<h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
				<svg class="w-5 h-5 text-cbd-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
				</svg>
				Calculadora Rápida
			</h3>
			<p class="text-gray-600 text-sm mb-4">
				Calcule a dosagem recomendada baseada no peso do seu animal.
			</p>
			<?php
			$calc_page = get_page_by_path( 'calculadora-de-dosagem-cbd' );
			if ( ! $calc_page ) {
				$calc_page = get_page_by_path( 'calculadora-dosagem' );
			}
			$calc_url = $calc_page ? get_permalink( $calc_page->ID ) : home_url( '/calculadora-de-dosagem-cbd/' );
			?>
			<a href="<?php echo esc_url( $calc_url ); ?>" class="text-cbd-green-600 font-semibold text-sm hover:underline inline-flex items-center gap-1">
				Usar calculadora
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
				</svg>
			</a>
		</div>
	<?php endif; ?>
	
	<?php if ( $args['show_related'] && is_singular() ) : ?>
		<!-- Related Articles Widget -->
		<?php
		$related = new WP_Query( array(
			'post_type' => get_post_type(),
			'posts_per_page' => 3,
			'post__not_in' => array( get_the_ID() ),
			'orderby' => 'rand',
		) );
		
		if ( $related->have_posts() ) :
		?>
			<div class="related-widget bg-white rounded-lg shadow-md border border-gray-200 p-6">
				<h3 class="font-bold text-gray-900 mb-4">Artigos Relacionados</h3>
				<ul class="space-y-4" style="list-style: none; padding-left: 0;">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>" class="flex gap-3 group">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php 
									cbd_ai_the_post_thumbnail_with_dimensions( 
										'thumbnail', 
										array( 
											'class' => 'w-16 h-16 object-cover rounded-lg flex-shrink-0'
										),
										true
									);
									?>
								<?php endif; ?>
								<div class="flex-1 min-w-0">
									<h4 class="font-semibold text-sm text-gray-900 group-hover:text-cbd-green-600 transition-colors line-clamp-2">
										<?php the_title(); ?>
									</h4>
									<p class="text-xs text-gray-600 mt-1">
										<?php echo get_the_date(); ?>
									</p>
								</div>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php
		wp_reset_postdata();
		endif;
		?>
	<?php endif; ?>
	
	<?php if ( $args['show_search'] ) : ?>
		<!-- Search Widget -->
		<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
			<h3 class="font-bold text-gray-900 mb-4">Pesquisar Artigos</h3>
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="mb-4">
					<input
						type="search"
						name="s"
						placeholder="Digite sua pesquisa..."
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cbd-green-500 focus:border-transparent text-sm"
						value="<?php echo esc_attr( get_search_query() ); ?>"
					>
				</div>
				<button type="submit" class="btn-cta bg-cbd-green-600 text-white w-full py-2 rounded-lg font-semibold hover:bg-cbd-green-700 transition-colors text-sm inline-flex items-center justify-center gap-2">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
					</svg>
					Pesquisar
				</button>
			</form>
		</div>
	<?php endif; ?>
	
	<?php if ( $args['show_categories'] ) : ?>
		<!-- Categories Widget -->
		<?php
		$categories = get_categories( array(
			'orderby' => 'count',
			'order' => 'DESC',
			'hide_empty' => true,
			'number' => 10,
		) );
		
		if ( ! empty( $categories ) ) :
		?>
			<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
				<h3 class="font-bold text-gray-900 mb-4">Categorias</h3>
				<ul class="space-y-2" style="list-style: none; padding-left: 0;">
					<?php foreach ( $categories as $category ) : ?>
						<li>
							<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
							   class="flex items-center justify-between text-sm text-gray-700 hover:text-cbd-green-600 transition-colors py-1">
								<span><?php echo esc_html( $category->name ); ?></span>
								<span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
									<?php echo esc_html( $category->count ); ?>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if ( $args['show_recent'] ) : ?>
		<!-- Recent Posts Widget -->
		<?php
		$recent_posts = new WP_Query( array(
			'post_type' => 'post',
			'posts_per_page' => 5,
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC',
		) );
		
		if ( $recent_posts->have_posts() ) :
		?>
			<div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
				<h3 class="font-bold text-gray-900 mb-4">Artigos Recentes</h3>
				<ul class="space-y-4" style="list-style: none; padding-left: 0;">
					<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>" class="flex gap-3 group">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php 
									cbd_ai_the_post_thumbnail_with_dimensions( 
										'thumbnail', 
										array( 
											'class' => 'w-16 h-16 object-cover rounded-lg flex-shrink-0'
										),
										true
									);
									?>
								<?php endif; ?>
								<div class="flex-1 min-w-0">
									<h4 class="font-semibold text-sm text-gray-900 group-hover:text-cbd-green-600 transition-colors line-clamp-2">
										<?php the_title(); ?>
									</h4>
									<p class="text-xs text-gray-600 mt-1">
										<?php echo get_the_date(); ?>
									</p>
								</div>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php
		wp_reset_postdata();
		endif;
		?>
	<?php endif; ?>
	
	<?php if ( $args['show_newsletter'] ) : ?>
		<!-- Newsletter/Subscribe Widget -->
		<div class="newsletter-widget bg-gradient-to-br from-cbd-green-50 to-white rounded-lg border border-cbd-green-200 p-6">
			<h3 class="font-bold text-gray-900 mb-2">Mantenha-se Atualizado</h3>
			<p class="text-gray-700 text-sm mb-4">
				Receba alertas sobre mudanças na legislação e novos guias sobre CBD.
			</p>
			<form class="space-y-3">
				<input 
					type="email" 
					placeholder="Seu email" 
					class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cbd-green-500 focus:border-transparent text-sm"
				>
				<button type="submit" class="btn-cta bg-cbd-green-600 text-white w-full py-2 rounded-lg font-semibold hover:bg-cbd-green-700 transition-colors text-sm">
					Subscrever
				</button>
			</form>
		</div>
	<?php endif; ?>
	
	<!-- Dynamic Sidebar -->
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="dynamic-sidebar">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	<?php endif; ?>
	
	</div>
	<?php
	if ( $args['wrap_in_aside'] ) {
		?>
		</aside>
		<?php
	}
}

