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
			<aside class="lg:col-span-4">
				<div class="sticky top-24 space-y-6">
					
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
								Faça perguntas sobre dosagem, segurança ou qualquer dúvida sobre CBD para animais. Nossa IA especializada está pronta para ajudar.
							</p>
							<a href="<?php echo esc_url( home_url( '/chatbot-ai-cbd/' ) ); ?>" class="btn-cta bg-cbd-green-600 text-white w-full py-3 rounded-lg font-semibold hover:bg-cbd-green-700 transition-colors inline-flex items-center justify-center gap-2">
								Iniciar Conversa
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
								</svg>
							</a>
						</div>
					</div>
					
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
						<a href="<?php echo esc_url( home_url( '/calculadora-de-dosagem-cbd/' ) ); ?>" class="text-cbd-green-600 font-semibold text-sm hover:underline inline-flex items-center gap-1">
							Usar calculadora
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
							</svg>
						</a>
					</div>
					
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
					
				</div>
			</aside>
			
		</div>
	</div>
</div>

<?php
get_footer();

