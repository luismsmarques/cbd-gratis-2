<?php
/**
 * Template Name: Blog - Listagem de Artigos
 * 
 * Página principal de listagem de artigos do blog com sidebar, comentários e social share
 * Design MUI focado em rigor, segurança e inovação
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// IMPORTANTE: Obter o ID da página do blog ANTES de qualquer query
// Isso garante que não seja afetado pelo loop de posts
// Para page templates, precisamos obter o ID da página que está sendo visualizada
$blog_page_id = null;

if ( is_page() ) {
	// Se estamos em uma página, obter o ID diretamente
	global $wp_query;
	$queried_object = $wp_query->get_queried_object();
	if ( $queried_object && isset( $queried_object->ID ) ) {
		$blog_page_id = $queried_object->ID;
	} else {
		$blog_page_id = get_queried_object_id();
	}
}

// Fallback: se ainda não temos o ID, tentar obter pela query global
if ( ! $blog_page_id ) {
	global $wp_query;
	if ( isset( $wp_query->queried_object->ID ) ) {
		$blog_page_id = $wp_query->queried_object->ID;
	} else {
		$blog_page_id = get_queried_object_id();
	}
}

// Último fallback: usar get_the_ID() (pode não funcionar se já estivermos no loop)
if ( ! $blog_page_id ) {
	$blog_page_id = get_the_ID();
}

// Query para posts do blog
// Detecção da página atual para paginação
// Em page templates: WordPress usa 'page' query var com pretty permalinks
$paged = 1;

// Para page templates com pretty permalinks, WordPress usa 'page' (não 'paged')
if ( is_page() ) {
	$page_num = get_query_var( 'page' );
	if ( $page_num > 0 ) {
		$paged = absint( $page_num );
	}
} else {
	// Para archives ou plain permalinks, usa 'paged'
	$paged_num = get_query_var( 'paged' );
	if ( $paged_num > 0 ) {
		$paged = absint( $paged_num );
	}
}

// Garantir que paged seja pelo menos 1
$paged = max( 1, $paged );

$blog_query = new WP_Query( array(
	'post_type' => 'post',
	'posts_per_page' => 9,
	'paged' => $paged,
	'post_status' => 'publish',
	'orderby' => 'date',
	'order' => 'DESC',
	'ignore_sticky_posts' => true,
) );
?>

<main class="main-content py-8 md:py-12" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.03), var(--mui-gray-50));">
	<div class="mui-container">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-7xl mx-auto">
			
			<!-- Main Content Area -->
			<div class="lg:col-span-8">
				
				<!-- Page Header -->
				<header class="mb-8 md:mb-12 text-center">
					<h1 class="mui-typography-h1 mb-4">
						<?php 
						if ( is_page() ) {
							the_title();
						} else {
							echo 'Blog';
						}
						?>
					</h1>
					<?php if ( get_the_content() ) : ?>
						<div class="mui-typography-body1" style="color: var(--mui-gray-700); max-w-3xl mx-auto">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
				</header>

				<?php if ( $blog_query->have_posts() ) : ?>
					
					<!-- Posts Grid -->
					<div class="blog-posts-grid grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
						<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'mui-card mui-card-elevated group hover:shadow-xl transition-all duration-300' ); ?> itemscope itemtype="https://schema.org/Article">
								
								<!-- Featured Image -->
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-t-lg featured-image-container-blog">
										<?php the_post_thumbnail( 'medium', array(
											'class' => 'featured-image-blog w-full object-cover group-hover:scale-105 transition-transform duration-300',
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
					<?php if ( $blog_query->max_num_pages > 1 ) : ?>
					<div class="pagination mt-8">
						<?php
						/**
						 * Sistema de Paginação Corrigido para Page Templates
						 * 
						 * Funciona corretamente com:
						 * - Pretty permalinks: /blog/page/2/
						 * - Plain permalinks: ?page_id=X&paged=2
						 * 
						 * IMPORTANTE: Usa $blog_page_id obtido ANTES do loop para garantir
						 * que sempre referencia a página do blog, não o último post.
						 */
						
						// Obter o permalink da página do blog (não do último post)
						$page_permalink = get_permalink( $blog_page_id );
						
						// Verificar se estamos usando pretty permalinks
						$permalink_structure = get_option( 'permalink_structure' );
						$using_pretty_permalinks = ! empty( $permalink_structure );
						
						// Construir a base de paginação corretamente
						if ( $using_pretty_permalinks ) {
							// Pretty permalinks: /blog/page/2/
							// Remove qualquer /page/X/ existente da URL base
							$page_permalink = preg_replace( '/\/page\/\d+\/?$/', '', $page_permalink );
							$page_permalink = trailingslashit( $page_permalink );
							$pagination_base = $page_permalink . 'page/%#%/';
						} else {
							// Plain permalinks: ?page_id=X&paged=2
							// Remove qualquer parâmetro paged existente
							$page_permalink = remove_query_arg( 'paged', $page_permalink );
							$pagination_base = add_query_arg( 'paged', '%#%', $page_permalink );
						}
						
						// Configuração dos argumentos de paginação
						$pagination_args = array(
							'base'      => $pagination_base,
							'format'    => '',
							'current'   => $paged,
							'total'     => $blog_query->max_num_pages,
							'prev_text' => '<svg style="width: 16px; height: 16px; margin-right: 4px; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> <span>Anterior</span>',
							'next_text' => '<span>Próxima</span> <svg style="width: 16px; height: 16px; margin-left: 4px; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
							'type'      => 'list',
							'end_size'  => 2,
							'mid_size'  => 1,
							'show_all'  => false,
							'add_args'  => false,
							'before_page_number' => '<span class="sr-only">Página </span>',
						);
						
						// Gerar links de paginação
						$pagination = paginate_links( $pagination_args );
						
						if ( $pagination ) :
						?>
							<nav class="mui-pagination" aria-label="<?php esc_attr_e( 'Navegação de páginas', 'cbd-ai-theme' ); ?>">
								<?php 
								// Aplicar classes MUI aos elementos de paginação
								$pagination = str_replace( 
									'<ul class=\'page-numbers\'>', 
									'<ul class="mui-pagination-list flex flex-wrap justify-center items-center gap-2">', 
									$pagination 
								);
								
								$pagination = str_replace( 
									'<li>', 
									'<li class="mui-pagination-item">', 
									$pagination 
								);
								
								// Links de página (não ativos)
								$pagination = str_replace( 
									'<a class="page-numbers', 
									'<a class="mui-button mui-button-outlined mui-button-small mui-pagination-link', 
									$pagination 
								);
								
								// Página atual
								$pagination = str_replace( 
									'<span class="page-numbers current', 
									'<span class="mui-button mui-button-contained mui-button-primary mui-button-small mui-pagination-current" aria-current="page"', 
									$pagination 
								);
								
								// Dots (reticências)
								$pagination = str_replace( 
									'<span class="page-numbers dots', 
									'<span class="mui-typography-body2 mui-pagination-dots" style="padding: 8px 12px; color: var(--mui-gray-600);"', 
									$pagination 
								);
								
								// Links de navegação (prev/next)
								$pagination = preg_replace( 
									'/<a class="(prev|next) page-numbers/', 
									'<a class="mui-button mui-button-outlined mui-button-small mui-pagination-nav mui-pagination-$1', 
									$pagination 
								);
								
								echo $pagination;
								?>
							</nav>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					
					<?php wp_reset_postdata(); ?>
					
				<?php else : ?>
					
					<!-- No Posts Found -->
					<div class="mui-card mui-card-elevated p-8 md:p-12 text-center">
						<div class="mui-alert mui-alert-info">
							<div class="mui-alert-icon" style="font-size: 3rem;">📝</div>
							<div class="mui-alert-message">
								<h2 class="mui-typography-h4 mb-2">Nenhum artigo encontrado</h2>
								<p class="mui-typography-body1" style="color: var(--mui-gray-700);">
									Ainda não há artigos publicados no blog. Volte em breve!
								</p>
							</div>
						</div>
					</div>
					
				<?php endif; ?>
				
			</div>
			
			<!-- Sidebar -->
			<?php
			cbd_ai_sidebar( array(
				'show_search'     => true,
				'show_categories' => true,
				'show_recent'     => true,
				'show_chatbot'    => true,
				'show_calculator' => false,
				'show_newsletter' => true,
				'show_related'    => false,
				'context'         => 'blog',
			) );
			?>
			
		</div>
	</div>
</main>

<style>
/* Pagination Styles - Sistema Completo */
.mui-pagination {
	margin-top: 2rem;
	margin-bottom: 2rem;
}

.mui-pagination-list {
	list-style: none;
	padding: 0;
	margin: 0;
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	align-items: center;
	gap: 0.5rem;
}

.mui-pagination-item {
	display: inline-flex;
	align-items: center;
	justify-content: center;
}

.mui-pagination-item .mui-button {
	min-width: auto;
	padding: 8px 16px;
	text-decoration: none;
	transition: all 0.2s ease;
}

.mui-pagination-item .mui-button:hover {
	transform: translateY(-1px);
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.mui-pagination-item span.mui-button {
	cursor: default;
	pointer-events: none;
}

.mui-pagination-link {
	color: var(--mui-gray-700);
}

.mui-pagination-link:hover {
	color: var(--mui-teal-primary);
	border-color: var(--mui-teal-primary);
}

.mui-pagination-current {
	font-weight: 600;
	cursor: default;
	pointer-events: none;
}

.mui-pagination-nav {
	display: inline-flex;
	align-items: center;
	gap: 0.25rem;
}

.mui-pagination-dots {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	user-select: none;
}

/* Screen reader only */
.sr-only {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0, 0, 0, 0);
	white-space: nowrap;
	border-width: 0;
}

/* Responsive adjustments */
@media (max-width: 640px) {
	.mui-pagination-list {
		gap: 0.375rem;
	}
	
	.mui-pagination-item .mui-button {
		padding: 6px 12px;
		font-size: 0.875rem;
	}
	
	.mui-pagination-nav span {
		display: none;
	}
	
	.mui-pagination-nav svg {
		margin: 0 !important;
	}
}

/* Blog Posts Grid Responsive */
@media (min-width: 768px) {
	.blog-posts-grid {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}
}

@media (min-width: 1024px) {
	.blog-posts-grid {
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

/* Featured Image Fix - Ensure fixed height */
.featured-image-container-blog {
	height: 200px;
	width: 100%;
	overflow: hidden;
	position: relative;
	display: block;
}

.featured-image-blog {
	height: 200px !important;
	width: 100% !important;
	object-fit: cover !important;
	object-position: center;
	display: block;
}

/* Ensure images in blog grid maintain fixed height */
.blog-posts-grid .featured-image-container-blog {
	height: 200px;
	max-height: 200px;
	min-height: 200px;
}
</style>

<?php
get_footer();
?>

