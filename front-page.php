<?php
/**
 * Front Page Template - Authority Design
 * 
 * Design profissional tipo revista especializada/portal de saúde
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();
?>

<!-- Hero Section - MUI Design Dashboard de Autoridade -->
<section class="hero-authority py-6 md:py-10" style="background: linear-gradient(to bottom, #ffffff, rgba(0, 137, 123, 0.05), #ffffff);">
	<div class="mui-container">
		<div class="max-w-4xl mx-auto text-center">
			<!-- Trust Badge - MUI Chip Style -->
			<div class="mui-chip mui-chip-success" style="margin-bottom: 24px; display: inline-flex;">
				<svg class="mui-chip-icon" style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
				</svg>
				<span>Autoridade em CBD para Animais em Portugal</span>
			</div>
			
			<h1 class="mui-typography-h1" style="margin-bottom: 24px;">
				<?php echo esc_html( cbd_ai_get_homepage_h1() ); ?>
			</h1>
			
			<!-- SEO-Optimized Definitions for Featured Snippets (GEO Optimization) -->
			<div class="seo-definitions max-w-3xl mx-auto mb-6 space-y-4 text-base text-gray-700 leading-relaxed" itemscope itemtype="https://schema.org/FAQPage">
				<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="mb-4">
					<p class="font-medium" itemprop="name">
						<strong>O que é CBD?</strong>
					</p>
					<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
						<p itemprop="text">
							<?php echo esc_html( cbd_ai_get_cbd_definition() ); ?>
						</p>
					</div>
				</div>
				<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="mb-4">
					<p class="font-medium" itemprop="name">
						<strong>CBD Legal em Portugal:</strong>
					</p>
					<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
						<p itemprop="text">
							<?php echo esc_html( cbd_ai_get_legal_definition() ); ?>
						</p>
					</div>
				</div>
			</div>
			
			<p class="text-sm text-gray-600 mb-8 max-w-xl mx-auto">
				<span class="inline-flex items-center gap-1">
					<svg class="w-4 h-4 text-cbd-green-600" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
					</svg>
					Informação monitorizada por IA para garantir precisão legal e de dosagem
				</span>
			</p>
			
			<!-- Search Bar - MUI Text Field Style -->
			<div class="max-w-2xl mx-auto mb-8" style="padding: 0 16px;">
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: flex; gap: 0;">
					<div class="mui-text-field" style="flex: 1; margin: 0;">
					<input 
						type="search" 
						name="s" 
						placeholder="Pesquise sobre CBD para animais, dosagem, legalidade..."
							class="mui-input mui-input-outlined"
							style="border-radius: 4px 0 0 4px;"
						value="<?php echo get_search_query(); ?>"
					>
					</div>
					<button 
						type="submit" 
						class="mui-button mui-button-contained mui-button-contained-teal"
						style="border-radius: 0 4px 4px 0; min-width: auto; padding: 16.5px 24px;"
						aria-label="Pesquisar"
					>
						<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
						</svg>
					</button>
				</form>
			</div>
			
			<!-- StatusCard Component - Monitor de Legislação -->
			<?php
			$recent_alerts = cbd_ai_get_recent_legal_alerts( 1 );
			$monitor_url = cbd_ai_get_monitor_legislacao_url();
			$has_alert = ! empty( $recent_alerts ) && isset( $recent_alerts[0] );
			?>
			<div id="status-card-app" style="max-width: 800px; margin: 32px auto 0;"></div>
		</div>
	</div>
</section>

<!-- Section A: Recent Legal Alerts Widget (GEO Optimization) - Redesigned -->
<section class="legal-alert-section py-12 md:py-16 bg-gradient-to-b from-blue-50 via-white to-blue-50" id="ultimo-alerta-legal">
	<div class="container mx-auto px-4">
		<div class="max-w-7xl mx-auto">
			<?php
			$recent_alerts = cbd_ai_get_recent_legal_alerts( 3 );
			$monitor_url = cbd_ai_get_monitor_legislacao_url();
			?>
			
			<!-- Section Header -->
			<div class="text-center mb-8 md:mb-12">
				<div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold uppercase tracking-wide mb-4">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
					</svg>
					<span>Monitorização Legislativa</span>
				</div>
				<h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
					Últimos Alertas Legais sobre CBD em Portugal
				</h2>
				<p class="text-lg text-gray-600 max-w-2xl mx-auto">
					Monitorização automática de legislação portuguesa e europeia. Mantenha-se atualizado com as últimas alterações.
				</p>
			</div>
			
			<?php if ( ! empty( $recent_alerts ) ) : ?>
				<!-- Alerts Grid -->
				<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
					<?php foreach ( $recent_alerts as $index => $alert ) : 
						$alert_date = strtotime( $alert['date'] );
						$alert_date_iso = date( 'c', $alert_date );
						$is_new = isset( $alert['is_new'] ) && $alert['is_new'];
						$alert_id = isset( $alert['id'] ) ? $alert['id'] : 0;
						$featured_image = $alert_id ? get_the_post_thumbnail( $alert_id, 'medium_large', array( 'class' => 'w-full h-48 object-cover' ) ) : '';
					?>
						<article 
							class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group"
							itemscope 
							itemtype="https://schema.org/Article"
						>
							
							<!-- Featured Image -->
							<?php if ( $featured_image ) : ?>
								<div class="w-full h-48 overflow-hidden bg-gray-100 group/image">
									<a href="<?php echo esc_url( $alert['url'] ); ?>" aria-label="<?php echo esc_attr( $alert['title'] ); ?>" class="block h-full">
										<?php 
										// Replace class attribute to add hover effect
										$featured_image_with_hover = str_replace( 
											'class="', 
											'class="w-full h-full object-cover transition-transform duration-300 group-hover/image:scale-105 ', 
											$featured_image 
										);
										echo $featured_image_with_hover; 
										?>
									</a>
								</div>
							<?php endif; ?>
							
							<!-- Card Content -->
							<div class="p-6" itemprop="articleBody">
								<h3 class="text-lg font-bold text-gray-900 mb-4 leading-tight line-clamp-2 group-hover:text-blue-700 transition-colors" itemprop="headline">
									<?php echo esc_html( $alert['title'] ); ?>
								</h3>
								
								<p class="text-sm text-gray-600 mb-5 leading-relaxed line-clamp-3" itemprop="description">
									<?php echo esc_html( wp_trim_words( $alert['excerpt'], 25 ) ); ?>
								</p>
								
								<?php if ( ! empty( $alert['source'] ) ) : ?>
									<div class="flex items-center gap-2 text-xs text-gray-500 mb-5 pb-5 border-b border-gray-100">
										<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
										</svg>
										<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
											<span itemprop="name"><?php echo esc_html( $alert['source'] ); ?></span>
										</span>
									</div>
								<?php endif; ?>
								
								<a 
									href="<?php echo esc_url( $alert['url'] ); ?>" 
									class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 group-hover:gap-3 transition-all"
									itemprop="url"
									aria-label="Ler alerta completo: <?php echo esc_attr( $alert['title'] ); ?>"
								>
									<span>Ler mais</span>
									<svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
									</svg>
								</a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				
				<!-- CTA to Monitor Page -->
				<div class="text-center">
					<a 
						href="<?php echo esc_url( $monitor_url ); ?>" 
						class="group/cta inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-green-800 via-green-900 to-green-950 text-white rounded-xl font-bold text-base md:text-lg hover:from-green-900 hover:via-green-950 hover:to-black transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 active:translate-y-0 active:shadow-lg"
						style="background: linear-gradient(to right, #166534, #14532d, #0f2817);"
						aria-label="Ver todos os alertas legislativos no Monitor de Legislação"
					>
						<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
						</svg>
						<span>Ver Todos os Alertas no Monitor de Legislação</span>
						<svg class="w-5 h-5 group-hover/cta:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
						</svg>
					</a>
				</div>
			<?php else : ?>
				<!-- No Alerts State -->
				<div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden max-w-2xl mx-auto">
					<div class="bg-gradient-to-r from-green-500 to-green-600 px-6 md:px-8 py-6">
						<div class="flex items-center gap-4">
							<div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0">
								<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
								</svg>
							</div>
							<div class="flex-1">
								<h3 class="text-xl md:text-2xl font-bold text-white mb-1">Status Legislativo: Estável</h3>
								<p class="text-sm text-green-100">Monitorização automática de legislação portuguesa</p>
							</div>
						</div>
					</div>
					<div class="p-6 md:p-8 text-center">
						<div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-lg mb-4">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
							</svg>
							<span class="font-semibold">Nenhum alerta legislativo significativo encontrado no momento.</span>
						</div>
						<p class="text-sm text-gray-600 mb-6">
							Última verificação: <time datetime="<?php echo esc_attr( date( 'Y-m-d\TH:i:s' ) ); ?>" class="font-medium"><?php echo date_i18n( 'd/m/Y H:i' ); ?></time>
						</p>
						<a 
							href="<?php echo esc_url( $monitor_url ); ?>" 
							class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors"
						>
							<span>Ver Monitor de Legislação</span>
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
							</svg>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Section D: Blog Articles List - Posts with Categories -->
<section class="blog-articles-section py-16 md:py-20" style="background: linear-gradient(to bottom, #fafafa, #ffffff, #fafafa);">
	<div class="mui-container">
		<div class="max-w-7xl mx-auto">
			<!-- Section Header - MUI Typography -->
			<div class="text-center mb-8 md:mb-12">
				<div class="mui-chip mui-chip-info" style="margin-bottom: 16px; display: inline-flex;">
					<svg class="mui-chip-icon" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
					</svg>
					<span>Artigos do Blog</span>
				</div>
				<h2 class="mui-typography-h2" style="margin-bottom: 16px;">
					Últimos Artigos Publicados
				</h2>
				<p class="mui-typography-body1" style="max-width: 768px; margin: 0 auto; color: var(--mui-gray-600);">
					Descubra os nossos artigos mais recentes sobre CBD, organizados por categoria para facilitar a navegação.
				</p>
			</div>
			
			<?php
			// Get recent posts with categories
			$blog_posts = new WP_Query( array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'DESC',
			) );
			
			if ( $blog_posts->have_posts() ) :
			?>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
					<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); 
						$post_categories = get_the_category();
						$primary_category = ! empty( $post_categories ) ? $post_categories[0] : null;
					?>
						<article class="mui-card mui-card-elevated group hover:shadow-xl transition-all duration-300" itemscope itemtype="https://schema.org/Article">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="block overflow-hidden" style="border-radius: var(--mui-radius-md) var(--mui-radius-md) 0 0;">
									<?php the_post_thumbnail( 'medium_large', array( 
										'class' => 'w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105',
										'loading' => 'lazy',
										'itemprop' => 'image'
									) ); ?>
								</a>
							<?php else : ?>
								<!-- Placeholder when no thumbnail -->
								<div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center" style="border-radius: var(--mui-radius-md) var(--mui-radius-md) 0 0;">
									<svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
									</svg>
								</div>
							<?php endif; ?>
							
							<div class="mui-card-content">
								<!-- Categories List (if multiple) -->
								<?php if ( ! empty( $post_categories ) && count( $post_categories ) > 1 ) : ?>
									<div class="flex flex-wrap gap-2 mb-3">
										<?php foreach ( array_slice( $post_categories, 0, 3 ) as $category ) : ?>
											<a 
												href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
												class="mui-chip mui-chip-clickable mui-chip-small"
												style="font-size: 0.75rem; padding: 2px 8px;"
												onclick="event.stopPropagation();"
											>
												<?php echo esc_html( $category->name ); ?>
											</a>
										<?php endforeach; ?>
										<?php if ( count( $post_categories ) > 3 ) : ?>
											<span class="mui-chip mui-chip-small" style="font-size: 0.75rem; padding: 2px 8px; opacity: 0.7;">
												+<?php echo count( $post_categories ) - 3; ?>
											</span>
										<?php endif; ?>
									</div>
								<?php elseif ( $primary_category && ! has_post_thumbnail() ) : ?>
									<!-- Show category if no thumbnail (already shown in placeholder) -->
									<div class="mb-3"></div>
								<?php endif; ?>
								
								<h3 class="mui-typography-h6 mb-2" itemprop="headline">
									<a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
										<?php the_title(); ?>
									</a>
								</h3>
								
								<p class="mui-typography-body2 mb-4" style="color: var(--mui-gray-600);" itemprop="description">
									<?php echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 25 ) ); ?>
								</p>
								
								<div class="flex items-center justify-between pt-4 border-t" style="border-color: var(--mui-gray-200);">
									<div class="flex items-center gap-3">
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="mui-typography-caption" style="color: var(--mui-gray-500);" itemprop="datePublished">
											<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
										</time>
										<?php if ( $primary_category && count( $post_categories ) === 1 ) : ?>
											<span class="mui-typography-caption" style="color: var(--mui-gray-400);">•</span>
											<a 
												href="<?php echo esc_url( get_category_link( $primary_category->term_id ) ); ?>" 
												class="mui-typography-caption hover:text-blue-600 transition-colors"
												style="color: var(--mui-gray-600);"
											>
												<?php echo esc_html( $primary_category->name ); ?>
											</a>
										<?php endif; ?>
									</div>
									<a href="<?php the_permalink(); ?>" class="mui-button mui-button-text mui-button-small" itemprop="url">
										Ler mais
										<svg style="width: 14px; height: 14px; margin-left: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
										</svg>
									</a>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
				
				<!-- Link to Blog Archive -->
				<?php
				$posts_page_id = get_option( 'page_for_posts' );
				$posts_page_url = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
				?>
				<div class="text-center">
					<a 
						href="<?php echo esc_url( $posts_page_url ); ?>" 
						class="mui-button mui-button-contained mui-button-primary mui-button-large"
					>
						Ver Todos os Artigos do Blog
						<svg style="width: 20px; height: 20px; margin-left: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
						</svg>
					</a>
				</div>
			<?php
				wp_reset_postdata();
			else :
			?>
				<div class="text-center py-12">
					<p class="mui-typography-body1" style="color: var(--mui-gray-600);">
						Ainda não há artigos publicados. Volte em breve!
					</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
// Enqueue StatusCard component
wp_enqueue_script(
	'cbd-ai-status-card',
	CBD_AI_THEME_URI . '/assets/js/components/StatusCard.js',
	array( 'vue-prod' ),
	CBD_AI_THEME_VERSION,
	false
);
?>

<script>
(function() {
	function initHomepageComponents() {
		// Check if Vue Helper is available
		if (typeof window.CBDVueHelper === 'undefined') {
			setTimeout(initHomepageComponents, 100);
			return;
		}
		
		// Initialize StatusCard using Vue Helper
		window.CBDVueHelper.initComponent('StatusCard', 'status-card-app', {
			data() {
				return {
					status: '<?php echo $has_alert ? "warning" : "success"; ?>',
					titulo: '<?php echo $has_alert ? "Alerta Legislativo Ativo" : "Status Legislativo: Estável"; ?>',
					mensagem: '<?php echo $has_alert ? esc_js( wp_trim_words( $recent_alerts[0]['title'], 15 ) ) : "Nenhum alerta legislativo significativo encontrado no momento."; ?>',
					dataAtualizacao: '<?php echo date_i18n( 'd/m/Y H:i' ); ?>'
				};
			},
			template: '<StatusCard :status="status" :titulo="titulo" :mensagem="mensagem" :dataAtualizacao="dataAtualizacao" />'
		});
	}
	
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initHomepageComponents, 300);
		});
	} else {
		setTimeout(initHomepageComponents, 300);
	}
})();
</script>

<?php
get_footer();
