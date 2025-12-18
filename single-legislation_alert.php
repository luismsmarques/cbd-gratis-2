<?php
/**
 * Single Template: Legislation Alert
 * 
 * Uniformizado com single.php para consistência visual
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get alert metadata
$source = get_post_meta( get_the_ID(), '_cbd_source', true );
$source_url = get_post_meta( get_the_ID(), '_cbd_source_url', true );
$alert_date = get_post_meta( get_the_ID(), '_cbd_alert_date', true );
$source_id = get_post_meta( get_the_ID(), '_cbd_source_id', true );

// Get legislation type taxonomy
$legislation_types = get_the_terms( get_the_ID(), 'legislation_type' );
$legislation_type = ! empty( $legislation_types ) ? $legislation_types[0]->name : '';

// Get monitor page URL
$monitor_page = get_page_by_path( 'monitor-legislacao' );
if ( ! $monitor_page ) {
	$monitor_page = get_page_by_path( 'monitor-de-legislacao' );
}
$monitor_url = $monitor_page ? get_permalink( $monitor_page->ID ) : home_url( '/monitor-legislacao/' );
?>

<div class="content-area">
	<div class="container mx-auto px-4 py-8">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-7xl mx-auto">
			
			<!-- Main Content -->
			<div class="lg:col-span-8">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-lg shadow-md p-6 md:p-8' ); ?>>
						
						<header class="entry-header mb-6">
							<h1 class="entry-title text-3xl md:text-4xl font-bold mb-4 text-gray-900">
								<?php the_title(); ?>
							</h1>
							
							<?php cbd_ai_post_meta(); ?>
						</header>
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="post-thumbnail mb-6 overflow-hidden rounded-lg" style="aspect-ratio: 16/9; max-height: 500px;">
								<?php 
								cbd_ai_the_post_thumbnail_with_dimensions( 
									'large', 
									array( 
										'class' => 'w-full h-full object-cover rounded-lg'
									),
									false // Don't lazy load above-fold featured image
								);
								?>
							</div>
						<?php endif; ?>
						
						<!-- Source Alert (if source URL exists) -->
						<?php if ( $source_url ) : ?>
							<div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-r-lg mb-6">
								<div class="flex items-start gap-3">
									<div class="flex-shrink-0">
										<svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
										</svg>
									</div>
									<div class="flex-1">
										<h3 class="text-sm font-semibold text-gray-900 mb-1">
											Fonte Oficial
										</h3>
										<p class="text-sm text-gray-700 mb-2">
											Este alerta foi gerado automaticamente a partir de uma fonte oficial monitorizada.
										</p>
										<a 
											href="<?php echo esc_url( $source_url ); ?>" 
											target="_blank" 
											rel="noopener noreferrer"
											class="text-blue-600 hover:text-blue-700 font-semibold text-sm inline-flex items-center gap-1"
										>
											Ver fonte original
											<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
											</svg>
										</a>
									</div>
								</div>
							</div>
						<?php endif; ?>
						
						<div class="entry-content prose prose-lg max-w-none text-gray-700">
							<?php the_content(); ?>
						</div>
						
						<?php if ( has_tag() ) : ?>
							<div class="post-tags mt-6 pt-6 border-t border-gray-200">
								<?php the_tags( '<span class="font-medium text-gray-900">Tags: </span>', ', ', '' ); ?>
							</div>
						<?php endif; ?>
						
						<?php cbd_ai_social_share(); ?>
						
						<!-- Back to Monitor CTA -->
						<div class="mt-8 p-6 bg-gradient-to-br from-cbd-green-50 to-white rounded-lg border border-cbd-green-200">
							<h3 class="text-xl font-bold text-gray-900 mb-2">Monitor de Legislação</h3>
							<p class="text-gray-700 text-sm mb-4">
								Mantenha-se atualizado com todas as mudanças na legislação sobre CBD em Portugal.
							</p>
							<a href="<?php echo esc_url( $monitor_url ); ?>" class="btn-cta bg-cbd-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-cbd-green-700 transition-colors inline-flex items-center gap-2 text-sm">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
								</svg>
								Voltar ao Monitor de Legislação
							</a>
						</div>
						
						<?php
						// Comments
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
						?>
					</article>
					
					<!-- Related Legislation Alerts -->
					<?php
					$related_alerts = new WP_Query( array(
						'post_type' => 'legislation_alert',
						'posts_per_page' => 3,
						'post__not_in' => array( get_the_ID() ),
						'orderby' => 'date',
						'order' => 'DESC',
					) );
					
					if ( $related_alerts->have_posts() ) :
					?>
						<div class="related-posts mt-8 pt-8 border-t border-gray-200">
							<h3 class="text-2xl font-bold mb-6 text-gray-900">Alertas Legislativos Relacionados</h3>
							<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
								<?php while ( $related_alerts->have_posts() ) : $related_alerts->the_post(); ?>
									<article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
										<?php if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>" class="block overflow-hidden">
												<div class="w-full" style="height: 200px; overflow: hidden;">
													<?php 
													cbd_ai_the_post_thumbnail_with_dimensions( 
														'medium', 
														array( 
															'class' => 'w-full h-full object-cover'
														),
														true
													);
													?>
												</div>
											</a>
										<?php endif; ?>
										
										<div class="p-4">
											<h4 class="text-lg font-bold mb-2">
												<a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-cbd-green-600 transition-colors">
													<?php the_title(); ?>
												</a>
											</h4>
											
											<p class="text-sm text-gray-600 mb-3 line-clamp-2">
												<?php echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 20 ) ); ?>
											</p>
											
											<div class="text-xs text-gray-500">
												<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
											</div>
										</div>
									</article>
								<?php endwhile; ?>
							</div>
						</div>
					<?php
						wp_reset_postdata();
					endif;
					?>
					
				<?php endwhile; ?>
			</div>
			
			<!-- Sidebar -->
			<?php
			cbd_ai_sidebar( array(
				'show_search'     => false, // Não mostrar search em single post
				'show_categories' => false, // Não mostrar categories em single post
				'show_recent'     => false, // Não mostrar recent em single post
				'show_chatbot'    => true,
				'show_calculator' => true,  // Mostrar calculadora em single post
				'show_newsletter' => true,
				'show_related'    => true,  // Mostrar relacionados em single post
				'context'         => 'single',
			) );
			?>
			
		</div>
	</div>
</div>

<?php
get_footer();
