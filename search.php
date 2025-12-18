<?php
/**
 * Search Results Template - MUI Design System
 *
 * Página de resultados de pesquisa seguindo o MUI Design System
 * Design focado em rigor, segurança e inovação
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

global $wp_query;
$search_query = get_search_query();
$found_posts = $wp_query->found_posts;
?>

<main class="main-content py-8 md:py-12" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.03), var(--mui-gray-50));">
	<div class="mui-container">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-7xl mx-auto">
			
			<!-- Main Content Area -->
			<div class="lg:col-span-8">
				
				<!-- Search Header -->
				<header class="mb-8 md:mb-12">
					<h1 class="mui-typography-h1 mb-4">
						Resultados da Pesquisa
					</h1>
					
					<?php if ( ! empty( $search_query ) ) : ?>
						<div class="mui-alert mui-alert-info mb-6">
							<div class="mui-alert-icon">🔍</div>
							<div class="mui-alert-message">
								<p class="mui-typography-body1 mb-2" style="margin: 0;">
									<strong>Pesquisa:</strong> "<span style="font-weight: 600;"><?php echo esc_html( $search_query ); ?></span>"
								</p>
								<?php if ( $found_posts > 0 ) : ?>
									<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-700);">
										<?php printf( 
											_n( 
												'Encontrado %d resultado', 
												'Encontrados %d resultados', 
												$found_posts, 
												'cbd-ai-theme' 
											), 
											$found_posts 
										); ?>
									</p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					
					<!-- Search Form - MUI Style -->
					<div class="mui-card mui-card-elevated p-6 mb-8">
						<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2">
							<div class="mui-text-field" style="flex: 1; margin: 0;">
								<label for="search-input" class="mui-text-field-label mui-text-field-label-shrink">Pesquisar</label>
								<input
									type="search"
									id="search-input"
									name="s"
									placeholder="Digite sua pesquisa..."
									class="mui-input mui-input-outlined"
									value="<?php echo esc_attr( $search_query ); ?>"
									required
								>
							</div>
							<button type="submit" class="mui-button mui-button-contained mui-button-primary" style="min-width: auto; padding: 16.5px 24px;">
								<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
								</svg>
							</button>
						</form>
					</div>
				</header>

				<?php if ( have_posts() ) : ?>
					
					<!-- Search Results List -->
					<div class="search-results space-y-6 mb-8">
						<?php while ( have_posts() ) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'mui-card mui-card-elevated group hover:shadow-xl transition-all duration-300' ); ?> itemscope itemtype="https://schema.org/Article">
								
								<div class="mui-card-content p-6">
									
									<!-- Post Type Badge -->
									<?php 
									$post_type_obj = get_post_type_object( get_post_type() );
									$post_type_label = $post_type_obj ? $post_type_obj->labels->singular_name : get_post_type();
									?>
									<div class="flex flex-wrap items-center gap-2 mb-3">
										<span class="mui-chip mui-chip-info mui-chip-small">
											<?php echo esc_html( ucfirst( $post_type_label ) ); ?>
										</span>
										<?php 
										$categories = get_the_category();
										if ( ! empty( $categories ) ) :
											foreach ( array_slice( $categories, 0, 2 ) as $category ) :
										?>
											<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
											   class="mui-chip mui-chip-info mui-chip-small" 
											   style="text-decoration: none;">
												<?php echo esc_html( $category->name ); ?>
											</a>
										<?php 
											endforeach;
										endif; 
										?>
									</div>
									
									<!-- Title -->
									<h2 class="mui-typography-h5 mb-3" itemprop="headline">
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
									
									<!-- Featured Image (if available) -->
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="mb-4 overflow-hidden rounded-lg featured-image-container">
											<a href="<?php the_permalink(); ?>" class="block">
												<?php the_post_thumbnail( 'medium', array(
													'class' => 'featured-image-search w-full object-cover group-hover:scale-105 transition-transform duration-300',
													'loading' => 'lazy',
													'itemprop' => 'image'
												) ); ?>
											</a>
										</div>
									<?php endif; ?>
									
									<!-- Excerpt with highlighted search terms -->
									<div class="mui-typography-body2 mb-4" style="color: var(--mui-gray-700);" itemprop="description">
										<?php 
										$excerpt = get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 );
										// Highlight search terms
										if ( ! empty( $search_query ) ) {
											$excerpt = preg_replace( 
												'/' . preg_quote( $search_query, '/' ) . '/i', 
												'<mark style="background-color: rgba(255, 235, 59, 0.3); padding: 2px 4px; border-radius: 2px;">$0</mark>', 
												$excerpt 
											);
										}
										echo $excerpt;
										?>
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
					
					<!-- No Results Found -->
					<div class="mui-card mui-card-elevated p-8 md:p-12 text-center">
						<div class="mui-alert mui-alert-warning">
							<div class="mui-alert-icon" style="font-size: 3rem;">🔍</div>
							<div class="mui-alert-message">
								<h2 class="mui-typography-h4 mb-2">Nenhum resultado encontrado</h2>
								<p class="mui-typography-body1 mb-4" style="color: var(--mui-gray-700);">
									Desculpe, não encontramos nenhum conteúdo correspondente à sua pesquisa "<strong><?php echo esc_html( $search_query ); ?></strong>".
								</p>
								<div class="mt-6">
									<p class="mui-typography-body2 mb-4" style="color: var(--mui-gray-600);">
										Tente pesquisar com termos diferentes ou navegue pelas categorias abaixo:
									</p>
									
									<!-- Popular Categories -->
									<?php
									$popular_categories = get_categories( array(
										'orderby' => 'count',
										'order' => 'DESC',
										'hide_empty' => true,
										'number' => 6,
									) );
									
									if ( ! empty( $popular_categories ) ) :
									?>
										<div class="flex flex-wrap justify-center gap-2 mt-4">
											<?php foreach ( $popular_categories as $category ) : ?>
												<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
												   class="mui-chip mui-chip-clickable mui-chip-info">
													<?php echo esc_html( $category->name ); ?>
												</a>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
									
									<!-- Search Form -->
									<div class="mt-6 max-w-md mx-auto">
										<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2">
											<div class="mui-text-field" style="flex: 1; margin: 0;">
												<label for="search-input-empty" class="mui-text-field-label mui-text-field-label-shrink">Pesquisar</label>
												<input
													type="search"
													id="search-input-empty"
													name="s"
													placeholder="Digite sua pesquisa..."
													class="mui-input mui-input-outlined"
													value="<?php echo esc_attr( $search_query ); ?>"
													required
												>
											</div>
											<button type="submit" class="mui-button mui-button-contained mui-button-primary" style="min-width: auto; padding: 16.5px 24px;">
												<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
												</svg>
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					
				<?php endif; ?>
				
			</div>
			
			<!-- Sidebar -->
			<aside class="lg:col-span-4">
				<div class="sticky top-24 space-y-6">
					
					<!-- Search Widget -->
					<div class="mui-card mui-card-elevated p-6">
						<h3 class="mui-typography-h6 mb-4">Nova Pesquisa</h3>
						<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<div class="mui-text-field">
								<label for="sidebar-search-input" class="mui-text-field-label mui-text-field-label-shrink">Pesquisar</label>
								<input
									type="search"
									id="sidebar-search-input"
									name="s"
									placeholder="Digite sua pesquisa..."
									class="mui-input mui-input-outlined"
									value="<?php echo esc_attr( $search_query ); ?>"
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
					
					<!-- Popular Categories Widget -->
					<?php
					$categories = get_categories( array(
						'orderby' => 'count',
						'order' => 'DESC',
						'hide_empty' => true,
						'number' => 10,
					) );
					
					if ( ! empty( $categories ) ) :
					?>
						<div class="mui-card mui-card-elevated p-6">
							<h3 class="mui-typography-h6 mb-4">Categorias Populares</h3>
							<ul class="mui-list">
								<?php foreach ( $categories as $category ) : ?>
									<li class="mui-list-item">
										<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
										   class="mui-list-item-text flex items-center justify-between hover:text-blue-600 transition-colors">
											<span><?php echo esc_html( $category->name ); ?></span>
											<span class="mui-typography-caption" style="color: var(--mui-gray-500);">
												<?php echo esc_html( $category->count ); ?>
											</span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
					
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
								Não encontrou o que procurava? Faça perguntas sobre CBD ao nosso chatbot especializado.
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

/* Search Results Spacing */
.search-results article {
	margin-bottom: 24px;
}

.search-results article:last-child {
	margin-bottom: 0;
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

/* Highlight search terms */
mark {
	background-color: rgba(255, 235, 59, 0.3);
	padding: 2px 4px;
	border-radius: 2px;
	font-weight: 500;
}

/* Featured Image Fix - Ensure fixed height */
.featured-image-container {
	height: 200px;
	width: 100%;
	overflow: hidden;
	position: relative;
}

.featured-image-container a {
	display: block;
	height: 100%;
	width: 100%;
}

.featured-image-search {
	height: 200px !important;
	width: 100% !important;
	object-fit: cover !important;
	object-position: center;
	display: block;
}

/* Fallback for browsers that don't support :has() */
.search-results .mui-card-content .featured-image-container {
	height: 200px;
	max-height: 200px;
}
</style>

<?php
get_footer();
?>
