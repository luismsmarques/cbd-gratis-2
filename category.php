<?php
/**
 * Category Archive Template - MUI Design System
 *
 * Template específico para páginas de arquivo de categorias
 * Design focado em rigor, segurança e inovação
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

$category = get_queried_object();
$category_name = $category->name;
$category_description = category_description();
$post_count = $category->count;
?>

<main class="main-content py-8 md:py-12" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.03), var(--mui-gray-50));">
	<div class="mui-container">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-7xl mx-auto">
			
			<!-- Main Content Area -->
			<div class="lg:col-span-8">
				
				<!-- Category Header -->
				<header class="mb-8 md:mb-12">
					<div class="mui-card mui-card-elevated p-6 md:p-8 mb-6">
						<div class="flex flex-wrap items-center gap-3 mb-4">
							<span class="mui-chip mui-chip-info mui-chip-large">
								<?php echo esc_html( $category_name ); ?>
							</span>
							<?php if ( $post_count > 0 ) : ?>
								<span class="mui-typography-body2" style="color: var(--mui-gray-600);">
									<?php printf( 
										_n( 
											'%d artigo', 
											'%d artigos', 
											$post_count, 
											'cbd-ai-theme' 
										), 
										$post_count 
									); ?>
								</span>
							<?php endif; ?>
						</div>
						
						<h1 class="mui-typography-h1 mb-4">
							<?php echo esc_html( $category_name ); ?>
						</h1>
						
						<?php if ( ! empty( $category_description ) ) : ?>
							<div class="mui-typography-body1" style="color: var(--mui-gray-700);">
								<?php echo wp_kses_post( $category_description ); ?>
							</div>
						<?php endif; ?>
					</div>

				</header>

				<?php if ( have_posts() ) : ?>
					
					<!-- Posts Grid -->
					<div class="category-posts-grid grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
						<?php while ( have_posts() ) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'mui-card mui-card-elevated group hover:shadow-xl transition-all duration-300' ); ?> itemscope itemtype="https://schema.org/Article">
								
								<!-- Featured Image -->
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-t-lg">
										<?php the_post_thumbnail( 'medium', array(
											'class' => 'w-full h-[200px] object-cover group-hover:scale-105 transition-transform duration-300',
											'loading' => 'lazy',
											'itemprop' => 'image',
											'sizes' => '(max-width: 768px) 100vw, 50vw'
										) ); ?>
									</a>
								<?php endif; ?>
								
								<div class="mui-card-content p-6">
									
									
									<!-- Title -->
									<h2 class="mui-typography-h6 mb-3" itemprop="headline">
										<a href="<?php the_permalink(); ?>" 
										   class="hover:text-blue-600 transition-colors"
										   itemprop="url">
											<?php the_title(); ?>
										</a>
									</h2>
									
									<!-- Post Meta -->
									<div class="mui-typography-caption mb-4" style="color: var(--mui-gray-600);">
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
											<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
										</time>
										<?php if ( get_the_author() ) : ?>
											<span class="mx-2">•</span>
											<span itemprop="author" itemscope itemtype="https://schema.org/Person">
												<span itemprop="name"><?php echo esc_html( get_the_author() ); ?></span>
											</span>
										<?php endif; ?>
									</div>
									
									<!-- Excerpt -->
									<div class="mui-typography-body2 mb-4" style="color: var(--mui-gray-700);" itemprop="description">
										<?php echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 20 ) ); ?>
									</div>
									
									<!-- Read More Button -->
									<a href="<?php the_permalink(); ?>" 
									   class="mui-button mui-button-text mui-button-small inline-flex items-center">
										Ler mais
										<svg style="width: 14px; height: 14px; margin-left: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
										</svg>
									</a>
									
								</div>
								
							</article>
						<?php endwhile; ?>
					</div>
					
					<!-- Pagination -->
					<div class="pagination mt-8">
						<?php
						$big = 999999999;
						$pagination_args = array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var( 'paged' ) ),
							'total' => $wp_query->max_num_pages,
							'prev_text' => '<svg style="width: 16px; height: 16px; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Anterior',
							'next_text' => 'Próxima <svg style="width: 16px; height: 16px; margin-left: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
							'type' => 'list',
							'end_size' => 2,
							'mid_size' => 1,
						);
						
						$pagination = paginate_links( $pagination_args );
						
						if ( $pagination ) :
						?>
							<nav class="mui-pagination" aria-label="Navegação de páginas">
								<?php 
								// Style pagination with MUI classes
								$pagination = str_replace( '<ul class=\'page-numbers\'>', '<ul class="mui-pagination-list flex flex-wrap justify-center gap-2">', $pagination );
								$pagination = str_replace( '<li>', '<li class="mui-pagination-item">', $pagination );
								$pagination = str_replace( '<a class="page-numbers', '<a class="mui-button mui-button-outlined mui-button-small', $pagination );
								$pagination = str_replace( '<span class="page-numbers current', '<span class="mui-button mui-button-contained mui-button-primary mui-button-small', $pagination );
								$pagination = str_replace( '<span class="page-numbers dots', '<span class="mui-typography-body2" style="padding: 8px 12px; color: var(--mui-gray-600);"', $pagination );
								echo $pagination;
								?>
							</nav>
						<?php endif; ?>
					</div>
					
				<?php else : ?>
					
					<!-- No Posts Found -->
					<div class="mui-card mui-card-elevated p-8 md:p-12 text-center">
						<div class="mui-alert mui-alert-info">
							<div class="mui-alert-icon" style="font-size: 3rem;">📝</div>
							<div class="mui-alert-message">
								<h2 class="mui-typography-h4 mb-2">Nenhum artigo encontrado</h2>
								<p class="mui-typography-body1 mb-4" style="color: var(--mui-gray-700);">
									Ainda não há artigos publicados na categoria "<strong><?php echo esc_html( $category_name ); ?></strong>".
								</p>
								<div class="mt-6">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mui-button mui-button-contained mui-button-primary">
										<svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 12v10a1 1 0 001 1h3m10-11l2 2m0 0l-7 7-7-7M19 12v10a1 1 0 01-1 1h-3"/>
										</svg>
										Voltar à Página Inicial
									</a>
								</div>
							</div>
						</div>
					</div>
					
				<?php endif; ?>
				
			</div>
			
			<!-- Sidebar -->
			<aside class="lg:col-span-4">
				<div class="sticky top-24 space-y-6">
					
					<!-- Category Info Widget -->
					<div class="mui-card mui-card-elevated p-6">
						<h3 class="mui-typography-h6 mb-4">Sobre esta Categoria</h3>
						<?php if ( ! empty( $category_description ) ) : ?>
							<div class="mui-typography-body2 mb-4" style="color: var(--mui-gray-700);">
								<?php echo wp_kses_post( wp_trim_words( $category_description, 30 ) ); ?>
							</div>
						<?php else : ?>
							<p class="mui-typography-body2" style="color: var(--mui-gray-600);">
								Artigos relacionados com <?php echo esc_html( strtolower( $category_name ) ); ?>.
							</p>
						<?php endif; ?>
						<?php if ( $post_count > 0 ) : ?>
							<div class="mt-4 pt-4 border-t" style="border-color: var(--mui-gray-300);">
								<p class="mui-typography-caption" style="color: var(--mui-gray-600);">
									<strong><?php echo esc_html( $post_count ); ?></strong> 
									<?php echo _n( 'artigo publicado', 'artigos publicados', $post_count, 'cbd-ai-theme' ); ?>
								</p>
							</div>
						<?php endif; ?>
					</div>
					
					<!-- Related Categories Widget -->
					<?php
					$related_categories = get_categories( array(
						'exclude' => array( $category->term_id ),
						'orderby' => 'count',
						'order' => 'DESC',
						'hide_empty' => true,
						'number' => 8,
					) );
					
					if ( ! empty( $related_categories ) ) :
					?>
						<div class="mui-card mui-card-elevated p-6">
							<h3 class="mui-typography-h6 mb-4">Outras Categorias</h3>
							<ul class="mui-list">
								<?php foreach ( $related_categories as $related_cat ) : ?>
									<li class="mui-list-item">
										<a href="<?php echo esc_url( get_category_link( $related_cat->term_id ) ); ?>" 
										   class="mui-list-item-text flex items-center justify-between hover:text-blue-600 transition-colors">
											<span><?php echo esc_html( $related_cat->name ); ?></span>
											<span class="mui-typography-caption" style="color: var(--mui-gray-500);">
												<?php echo esc_html( $related_cat->count ); ?>
											</span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<!-- Search Widget -->
					<div class="mui-card mui-card-elevated p-6">
						<h3 class="mui-typography-h6 mb-4">Pesquisar Artigos</h3>
						<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<div class="mui-text-field">
								<label for="category-search-input" class="mui-text-field-label mui-text-field-label-shrink">Pesquisar</label>
								<input
									type="search"
									id="category-search-input"
									name="s"
									placeholder="Digite sua pesquisa..."
									class="mui-input mui-input-outlined"
								>
							</div>
							<button type="submit" class="mui-button mui-button-contained mui-button-primary mui-button-small mt-4 w-full">
								<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
								</svg>
								Pesquisar
							</button>
						</form>
					</div>
					
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
						<div class="mui-card mui-card-elevated p-6">
							<h3 class="mui-typography-h6 mb-4">Artigos Recentes</h3>
							<ul class="space-y-4" style="list-style: none; padding-left: 0;">
								<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
									<li>
										<a href="<?php the_permalink(); ?>" class="flex gap-3 group">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'thumbnail', array(
													'class' => 'w-16 h-16 object-cover rounded-lg flex-shrink-0',
													'loading' => 'lazy'
												) ); ?>
											<?php endif; ?>
											<div class="flex-1 min-w-0">
												<h4 class="mui-typography-subtitle2 group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
													<?php the_title(); ?>
												</h4>
												<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="mui-typography-caption" style="color: var(--mui-gray-500);">
													<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
												</time>
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
					
					<!-- Chatbot Widget -->
					<div class="mui-card mui-card-elevated overflow-hidden" style="border: 2px solid var(--mui-teal-primary);">
						<div style="background: linear-gradient(to right, var(--mui-teal-primary), var(--mui-teal-dark)); padding: 20px; color: white;">
							<div class="flex items-center gap-3">
								<div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
									<span style="font-size: 1.5rem;">💬</span>
								</div>
								<div>
									<h3 class="mui-typography-h6" style="margin: 0; color: white; font-weight: 600;">Chatbot Especialista</h3>
									<p class="mui-typography-body2" style="margin: 0; opacity: 0.9;">Tire suas dúvidas agora</p>
								</div>
							</div>
						</div>
						<div class="p-6">
							<p class="mui-typography-body2 mb-4" style="color: var(--mui-gray-700);">
								Faça perguntas sobre CBD relacionadas com <?php echo esc_html( strtolower( $category_name ) ); ?>. Nossa IA especializada está pronta para ajudar.
							</p>
							<a href="<?php echo esc_url( home_url( '/chatbot-ai-cbd/' ) ); ?>" class="mui-button mui-button-contained mui-button-contained-teal w-full">
								<svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
								</svg>
								Iniciar Conversa
							</a>
						</div>
					</div>
					
					<!-- Dynamic Sidebar -->
					<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
						<div class="dynamic-sidebar">
							<?php dynamic_sidebar( 'sidebar-1' ); ?>
						</div>
					<?php endif; ?>
					
				</div>
			</aside>
			
		</div>
	</div>
</main>

<style>
/* Pagination Styles */
.mui-pagination-list {
	list-style: none;
	padding: 0;
	margin: 0;
}

.mui-pagination-item {
	display: inline-block;
}

.mui-pagination-item .mui-button {
	min-width: auto;
	padding: 8px 16px;
}

.mui-pagination-item span.mui-button {
	cursor: default;
}

/* Category Posts Grid Responsive */
@media (min-width: 768px) {
	.category-posts-grid {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}
}

@media (min-width: 1024px) {
	.category-posts-grid {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}
}

/* Sidebar Widget Spacing */
.dynamic-sidebar .widget {
	margin-bottom: 24px;
}

.dynamic-sidebar .widget:last-child {
	margin-bottom: 0;
}

.dynamic-sidebar .widget-title {
	font-size: 1.25rem;
	font-weight: 600;
	margin-bottom: 16px;
	color: var(--mui-gray-900);
}
</style>

<?php
get_footer();
?>

