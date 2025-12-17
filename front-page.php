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
			
			<!-- Strategic Internal Links (SEO) - MUI Chips -->
			<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 8px;">
				<?php
				$strategic_links = cbd_ai_get_strategic_internal_links();
				foreach ( $strategic_links as $link ) :
				?>
					<a 
						href="<?php echo esc_url( $link['url'] ); ?>" 
						class="mui-chip mui-chip-clickable"
						title="<?php echo esc_attr( $link['title'] ); ?>"
						style="text-decoration: none;"
					>
						<?php 
						if ( strpos( $link['anchor'], 'caes' ) !== false ) {
							echo '🐕 CBD para Cães';
						} elseif ( strpos( $link['anchor'], 'legislacao' ) !== false || strpos( $link['anchor'], 'monitor' ) !== false ) {
							echo '⚖️ Legalidade em Portugal';
						} elseif ( strpos( $link['anchor'], 'humanos' ) !== false ) {
							echo '👤 CBD para Humanos';
						} elseif ( strpos( $link['anchor'], 'chatbot' ) !== false ) {
							echo '💬 Chatbot Especialista';
						} else {
							echo esc_html( $link['title'] );
						}
						?>
					</a>
				<?php endforeach; ?>
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

<!-- Section B: Featured Guides - MUI ActionCards -->
<section class="guides-section py-16 md:py-20" style="background: linear-gradient(to bottom, #ffffff, #fafafa, #ffffff);">
	<div class="mui-container">
		<div class="max-w-7xl mx-auto">
			<!-- Section Header - MUI Typography -->
			<div class="text-center mb-12">
				<div class="mui-chip mui-chip-primary" style="margin-bottom: 16px; display: inline-flex;">
					<svg class="mui-chip-icon" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
					</svg>
					<span>Guias Práticos</span>
				</div>
				<h2 class="mui-typography-h2" style="margin-bottom: 16px;">
					Guias Completos de CBD: Dosagem, Segurança e Benefícios
				</h2>
				<p class="mui-typography-body1" style="max-width: 768px; margin: 0 auto; color: var(--mui-gray-600);">
					Explore os nossos guias especializados sobre CBD para pessoas e animais. Informação validada por AI e baseada em evidências científicas.
				</p>
			</div>
			
			<!-- ActionCards Grid - MUI Grid System -->
			<?php
			// Get page URLs
			$pessoas_url = get_permalink( get_page_by_path( 'cbd-para-pessoas' ) ) ?: home_url( '/cbd-para-pessoas/' );
			$animais_url = get_permalink( get_page_by_path( 'cbd-animais' ) ) ?: get_permalink( get_page_by_path( 'cbd-para-animais' ) ) ?: home_url( '/cbd-animais/' );
			$calculadora_url = get_permalink( get_page_by_path( 'calculadora-de-dosagem' ) ) ?: home_url( '/calculadora-de-dosagem/' );
			?>
			
			<div id="action-cards-app" class="mui-grid" style="margin: -12px;">
				<!-- ActionCards serão renderizados via Vue -->
			</div>
		</div>
	</div>
</section>

<!-- Section C: Categories Overview - Redesigned -->
<section class="categories-section py-16 md:py-20 bg-white">
	<div class="container mx-auto px-4">
		<div class="max-w-7xl mx-auto">
			<div class="text-center mb-12">
				<div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold mb-4">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
					</svg>
					Navegação por Categoria
				</div>
				<h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
					Explore por Categoria
				</h2>
				<p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
					Conteúdo organizado para facilitar sua busca e descoberta
				</p>
			</div>
			
			<?php
			// Get page URLs
			$animais_page = get_page_by_path( 'cbd-animais' );
			$animais_url = $animais_page ? get_permalink( $animais_page->ID ) : home_url( '/cbd-animais/' );
			
			$monitor_page = get_page_by_path( 'monitor-legislacao' );
			$monitor_url = $monitor_page ? get_permalink( $monitor_page->ID ) : home_url( '/monitor-legislacao/' );
			
			// Get chatbot CBD page (try multiple slugs)
			$chatbot_cbd_page = get_page_by_path( 'chatbot-cbd' );
			if ( ! $chatbot_cbd_page ) {
				$chatbot_cbd_page = get_page_by_path( 'chatbot' );
			}
			$chatbot_cbd_url = $chatbot_cbd_page ? get_permalink( $chatbot_cbd_page->ID ) : home_url( '/chatbot-cbd/' );
			
			// Get category archive URL for Cânhamo & Ciência (posts)
			$ciencia_category = get_category_by_slug( 'ciencia' );
			if ( ! $ciencia_category ) {
				$ciencia_category = get_category_by_slug( 'canhamo' );
			}
			$posts_page_id = get_option( 'page_for_posts' );
			$posts_page_url = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
			$ciencia_url = $ciencia_category ? get_category_link( $ciencia_category->term_id ) : $posts_page_url;
			?>
			
			<div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-8">
				<!-- Category 1: CBD para Animais -->
				<a href="<?php echo esc_url( $animais_url ); ?>" class="category-card group relative bg-white rounded-2xl border-2 border-gray-200 p-8 hover:border-cbd-green-500 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
					<div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cbd-green-100 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
					<div class="relative z-10">
						<div class="w-20 h-20 bg-gradient-to-br from-cbd-green-500 to-cbd-green-600 rounded-2xl flex items-center justify-center text-white text-4xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
							🐕
						</div>
						<h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 group-hover:text-cbd-green-600 transition-colors">CBD para Animais</h3>
						<p class="text-gray-700 mb-6 leading-relaxed text-base">
							Guias completos sobre CBD para cães e gatos, incluindo dosagem, benefícios e segurança.
						</p>
						<ul class="space-y-3 mb-8 text-sm text-gray-700">
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-cbd-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Guia de dosagem por peso</span>
							</li>
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-cbd-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Benefícios e casos de uso</span>
							</li>
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-cbd-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>FAQ e dúvidas comuns</span>
							</li>
						</ul>
						<span class="inline-flex items-center gap-2 text-cbd-green-600 font-bold group-hover:gap-3 transition-all group/link">
							Explorar seção
							<svg class="w-5 h-5 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
							</svg>
						</span>
					</div>
				</a>
				
				<!-- Category 2: Monitor Legislação -->
				<a href="<?php echo esc_url( $monitor_url ); ?>" class="category-card group relative bg-white rounded-2xl border-2 border-gray-200 p-8 hover:border-blue-500 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
					<div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
					<div class="relative z-10">
						<div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white text-4xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
							⚖️
						</div>
						<h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">Monitor Legislação</h3>
						<p class="text-gray-700 mb-6 leading-relaxed text-base">
							Monitorização contínua da legislação portuguesa e europeia sobre CBD e cannabis medicinal.
						</p>
						<ul class="space-y-3 mb-8 text-sm text-gray-700">
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Alertas legislativos em tempo real</span>
							</li>
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Legislação atual explicada</span>
							</li>
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Documentos oficiais sumarizados</span>
							</li>
						</ul>
						<span class="inline-flex items-center gap-2 text-blue-600 font-bold group-hover:gap-3 transition-all group/link">
							Ver legislação
							<svg class="w-5 h-5 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
							</svg>
						</span>
					</div>
				</a>
				
				<!-- Category 3: Cânhamo & Ciência -->
				<a href="<?php echo esc_url( $ciencia_url ); ?>" class="category-card group relative bg-white rounded-2xl border-2 border-gray-200 p-8 hover:border-purple-500 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
					<div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-100 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
					<div class="relative z-10">
						<div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-4xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
							🔬
						</div>
						<h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 group-hover:text-purple-600 transition-colors">Cânhamo & Ciência</h3>
						<p class="text-gray-700 mb-6 leading-relaxed text-base">
							Informação científica e educativa sobre cânhamo, cannabis e seus compostos.
						</p>
						<ul class="space-y-3 mb-8 text-sm text-gray-700">
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Diferenças: Cânhamo vs Cannabis</span>
							</li>
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Estudos científicos</span>
							</li>
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Informação educativa</span>
							</li>
						</ul>
						<span class="inline-flex items-center gap-2 text-purple-600 font-bold group-hover:gap-3 transition-all group/link">
							Explorar ciência
							<svg class="w-5 h-5 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
							</svg>
						</span>
					</div>
				</a>
				
				<!-- Category 4: AI CBD Chatbot -->
				<a href="<?php echo esc_url( $chatbot_cbd_url ); ?>" class="category-card group relative bg-white rounded-2xl border-2 border-gray-200 p-8 hover:border-emerald-500 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
					<div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
					<div class="relative z-10">
						<div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white text-4xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
							💊
						</div>
						<h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 group-hover:text-emerald-600 transition-colors">
							AI CBD
						</h3>
						<p class="text-gray-700 mb-6 leading-relaxed text-base">
							Chatbot Especialista em CBD. Faça perguntas sobre CBD. Nossa IA especializada está aqui para ajudar com dosagem, benefícios, segurança, legalidade e muito mais!
						</p>
						<ul class="space-y-3 mb-8 text-sm text-gray-700">
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Dosagem personalizada</span>
							</li>
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Benefícios e segurança</span>
							</li>
							<li class="flex items-start gap-3">
								<svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Legalidade em Portugal</span>
							</li>
						</ul>
						<span class="inline-flex items-center gap-2 text-emerald-600 font-bold group-hover:gap-3 transition-all group/link">
							Falar com IA
							<svg class="w-5 h-5 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
							</svg>
						</span>
					</div>
				</a>
			</div>
		</div>
	</div>
</section>

<?php
// Enqueue StatusCard and ActionCard components
wp_enqueue_script(
	'cbd-ai-status-card',
	CBD_AI_THEME_URI . '/assets/js/components/StatusCard.js',
	array( 'vue-prod' ),
	CBD_AI_THEME_VERSION,
	false
);

wp_enqueue_script(
	'cbd-ai-action-card',
	CBD_AI_THEME_URI . '/assets/js/components/ActionCard.js',
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
		
		// Initialize ActionCards using Vue Helper
		window.CBDVueHelper.initComponent('ActionCard', 'action-cards-app', {
			data() {
				return {
					cards: [
						{
							titulo: 'CBD para Animais',
							descricao: 'Guias completos sobre CBD para cães e gatos, incluindo dosagem, benefícios e segurança.',
							icone: '🐕',
							url: '<?php echo esc_js( $animais_url ); ?>',
							cor: 'teal',
							tamanho: 'medium'
						},
						{
							titulo: 'CBD para Pessoas',
							descricao: 'Guia completo sobre benefícios, dosagem e legalidade do CBD para uso humano em Portugal.',
							icone: '👤',
							url: '<?php echo esc_js( $pessoas_url ); ?>',
							cor: 'primary',
							tamanho: 'medium'
						},
						{
							titulo: 'Calculadora de Dosagem',
							descricao: 'Calcule a dosagem correta de CBD baseada no peso, condição e tipo de produto.',
							icone: '📊',
							url: '<?php echo esc_js( $calculadora_url ); ?>',
							cor: 'info',
							tamanho: 'medium'
						}
					]
				};
			},
			template: `
				<template v-for="(card, index) in cards" :key="index">
					<div class="mui-grid-item mui-grid-md-4 mui-grid-sm-6 mui-grid-xs-12" style="padding: 12px;">
						<ActionCard 
							:titulo="card.titulo"
							:descricao="card.descricao"
							:icone="card.icone"
							:url="card.url"
							:cor="card.cor"
							:tamanho="card.tamanho"
						/>
					</div>
				</template>
			`
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
