<?php
/**
 * Single Post Template
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();
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
						
						<div class="entry-content prose prose-lg max-w-none text-gray-700">
							<?php the_content(); ?>
						</div>
						
						<?php if ( has_tag() ) : ?>
							<div class="post-tags mt-6 pt-6 border-t border-gray-200">
								<?php the_tags( '<span class="font-medium text-gray-900">Tags: </span>', ', ', '' ); ?>
							</div>
						<?php endif; ?>
						
						<?php cbd_ai_social_share(); ?>
						
						<!-- Affiliate CTA - Contextual -->
						<div class="affiliate-cta mt-8 p-6 bg-gradient-to-br from-cbd-green-50 to-white rounded-lg border border-cbd-green-200">
							<h3 class="text-xl font-bold text-gray-900 mb-2">Onde Comprar Produtos Recomendados</h3>
							<p class="text-gray-700 text-sm mb-4">
								Encontre produtos de qualidade testados e aprovados por especialistas. Ao comprar através dos nossos links, você apoia nosso trabalho de pesquisa.
							</p>
							<a href="#produtos-recomendados" class="btn-cta bg-cbd-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-cbd-green-700 transition-colors inline-flex items-center gap-2 text-sm">
								Ver Produtos Recomendados
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
								</svg>
							</a>
						</div>
						
						<?php
						// Comments
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
						?>
					</article>
					
					<?php cbd_ai_related_posts(); ?>
					
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

