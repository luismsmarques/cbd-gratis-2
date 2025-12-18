<?php
/**
 * Single Template: Legislation Alert
 * 
 * Template focado em leitura para alertas legislativos
 * Design MUI sem sidebar, seguindo DESIGN-SYSTEM-GUIDE.md
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

// Check if alert is new (within last week)
$is_new = $alert_date && strtotime( $alert_date ) > ( time() - WEEK_IN_SECONDS );

// Get monitor page URL
$monitor_page = get_page_by_path( 'monitor-legislacao' );
if ( ! $monitor_page ) {
	$monitor_page = get_page_by_path( 'monitor-de-legislacao' );
}
$monitor_url = $monitor_page ? get_permalink( $monitor_page->ID ) : home_url( '/monitor-legislacao/' );
?>

<main class="main-content min-h-screen py-8 md:py-12" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.03), var(--mui-gray-50));">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
			
			<?php while ( have_posts() ) : the_post(); ?>
				
				<!-- Alert Badge -->
				<div class="mb-6">
					<?php if ( $is_new ) : ?>
						<div class="mui-chip mui-chip-success" style="display: inline-flex;">
							<svg class="mui-chip-icon" style="width: 16px; height: 16px; margin-right: 6px;" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
							</svg>
							<span>Novo Alerta</span>
						</div>
					<?php endif; ?>
					
					<?php if ( $legislation_type ) : ?>
						<div class="mui-chip mui-chip-primary" style="display: inline-flex; margin-left: 8px;">
							<svg class="mui-chip-icon" style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
							</svg>
							<span><?php echo esc_html( $legislation_type ); ?></span>
						</div>
					<?php endif; ?>
				</div>
				
				<!-- Article Card -->
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'mui-card mui-card-elevated' ); ?> itemscope itemtype="https://schema.org/Article">
					
					<!-- Card Header -->
					<div class="mui-card-content" style="padding-bottom: 0;">
						
						<!-- Title -->
						<header class="entry-header mb-6">
							<h1 class="mui-typography-h1 mb-4" itemprop="headline">
								<?php the_title(); ?>
							</h1>
							
							<!-- Meta Information -->
							<div class="flex flex-wrap items-center gap-4 mb-6" style="color: var(--mui-gray-600);">
								<div class="flex items-center gap-2">
									<svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
									</svg>
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="mui-typography-body2" itemprop="datePublished">
										<?php echo esc_html( get_the_date( 'd/m/Y H:i' ) ); ?>
									</time>
								</div>
								
								<?php if ( $source ) : ?>
									<div class="flex items-center gap-2">
										<svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
										</svg>
										<span class="mui-typography-body2" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
											<span itemprop="name"><?php echo esc_html( ucfirst( $source ) ); ?></span>
										</span>
									</div>
								<?php endif; ?>
							</div>
						</header>
						
						<!-- Featured Image -->
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="post-thumbnail mb-6 overflow-hidden" style="border-radius: var(--mui-radius-md);">
								<?php the_post_thumbnail( 'large', array( 
									'class' => 'w-full h-auto max-h-[500px] object-cover',
									'loading' => 'lazy',
									'itemprop' => 'image'
								) ); ?>
							</div>
						<?php endif; ?>
						
					</div>
					
					<!-- Card Content -->
					<div class="mui-card-content">
						
						<!-- Source Alert (if source URL exists) -->
						<?php if ( $source_url ) : ?>
							<div class="mui-alert mui-alert-info mb-6">
								<div class="mui-alert-icon">ℹ</div>
								<div class="mui-alert-message">
									<h3 class="mui-typography-subtitle1" style="margin: 0 0 4px 0; font-weight: 600;">
										Fonte Oficial
									</h3>
									<p class="mui-typography-body2" style="margin: 0 0 8px 0;">
										Este alerta foi gerado automaticamente a partir de uma fonte oficial monitorizada.
									</p>
									<a 
										href="<?php echo esc_url( $source_url ); ?>" 
										target="_blank" 
										rel="noopener noreferrer"
										class="mui-button mui-button-text mui-button-small"
										style="padding: 4px 8px; margin-top: 4px;"
										itemprop="url"
									>
										Ver fonte original
										<svg style="width: 14px; height: 14px; margin-left: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
										</svg>
									</a>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Main Content -->
						<div class="entry-content mui-typography-body1" style="color: var(--mui-gray-800); line-height: 1.7;" itemprop="articleBody">
							<?php the_content(); ?>
						</div>
						
						<!-- Excerpt (if different from content) -->
						<?php if ( has_excerpt() && get_the_excerpt() !== get_the_content() ) : ?>
							<div class="mt-6 pt-6 border-t" style="border-color: var(--mui-gray-200);">
								<p class="mui-typography-body2" style="color: var(--mui-gray-600); font-style: italic;" itemprop="description">
									<?php echo esc_html( get_the_excerpt() ); ?>
								</p>
							</div>
						<?php endif; ?>
						
					</div>
					
					<!-- Card Footer -->
					<div class="mui-card-actions" style="border-top: 1px solid var(--mui-gray-200); padding: 16px;">
						<div class="flex flex-wrap items-center justify-between gap-4 w-full">
							
							<!-- Back to Monitor Link -->
							<a 
								href="<?php echo esc_url( $monitor_url ); ?>" 
								class="mui-button mui-button-outlined"
							>
								<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
								</svg>
								Voltar ao Monitor de Legislação
							</a>
							
							<!-- Share Buttons -->
							<div class="flex items-center gap-2">
								<span class="mui-typography-caption" style="margin-right: 8px;">Partilhar:</span>
								<a 
									href="https://twitter.com/intent/tweet?text=<?php echo urlencode( get_the_title() ); ?>&url=<?php echo urlencode( get_permalink() ); ?>" 
									target="_blank" 
									rel="noopener noreferrer"
									class="mui-button mui-button-text mui-button-small"
									aria-label="Partilhar no Twitter"
								>
									<svg style="width: 18px; height: 18px;" fill="currentColor" viewBox="0 0 24 24">
										<path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
									</svg>
								</a>
								<a 
									href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" 
									target="_blank" 
									rel="noopener noreferrer"
									class="mui-button mui-button-text mui-button-small"
									aria-label="Partilhar no Facebook"
								>
									<svg style="width: 18px; height: 18px;" fill="currentColor" viewBox="0 0 24 24">
										<path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
									</svg>
								</a>
							</div>
							
						</div>
					</div>
					
				</article>
				
				<!-- Related Alerts -->
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
					<section class="mt-12">
						<h2 class="mui-typography-h3 mb-6">Alertas Legislativos Relacionados</h2>
						<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
							<?php while ( $related_alerts->have_posts() ) : $related_alerts->the_post(); 
								$related_source = get_post_meta( get_the_ID(), '_cbd_source', true );
								$related_date = get_post_meta( get_the_ID(), '_cbd_alert_date', true );
								$related_is_new = $related_date && strtotime( $related_date ) > ( time() - WEEK_IN_SECONDS );
							?>
								<article class="mui-card mui-card-elevated">
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>" class="block overflow-hidden" style="border-radius: var(--mui-radius-md) var(--mui-radius-md) 0 0;">
											<?php the_post_thumbnail( 'medium', array( 
												'class' => 'w-full h-48 object-cover transition-transform duration-300 hover:scale-105',
												'loading' => 'lazy'
											) ); ?>
										</a>
									<?php endif; ?>
									
									<div class="mui-card-content">
										<?php if ( $related_is_new ) : ?>
											<div class="mb-3">
												<span class="mui-chip mui-chip-success" style="display: inline-flex; font-size: 0.75rem; padding: 2px 8px;">
													Novo
												</span>
											</div>
										<?php endif; ?>
										
										<h3 class="mui-typography-h6 mb-2">
											<a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
												<?php the_title(); ?>
											</a>
										</h3>
										
										<p class="mui-typography-body2 mb-4" style="color: var(--mui-gray-600);">
											<?php echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 20 ) ); ?>
										</p>
										
										<div class="flex items-center justify-between">
											<span class="mui-typography-caption" style="color: var(--mui-gray-500);">
												<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
											</span>
											<?php if ( $related_source ) : ?>
												<span class="mui-typography-caption" style="color: var(--mui-gray-500);">
													<?php echo esc_html( ucfirst( $related_source ) ); ?>
												</span>
											<?php endif; ?>
										</div>
									</div>
								</article>
							<?php endwhile; ?>
						</div>
					</section>
				<?php
					wp_reset_postdata();
				endif;
				?>
				
			<?php endwhile; ?>
			
		</div>
	</div>
</main>

<?php
get_footer();

