<?php
/**
 * Archive Template for CBD Stores
 * 
 * Template específico para o arquivo de lojas CBD (/lojas-cbd/)
 * Exibe lojas com rating, endereço e filtros
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get filter parameters
$search_query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
$store_type_filter = isset( $_GET['store_type'] ) ? sanitize_text_field( $_GET['store_type'] ) : '';
$location_filter = isset( $_GET['location'] ) ? sanitize_text_field( $_GET['location'] ) : '';
$rating_filter = isset( $_GET['min_rating'] ) ? floatval( $_GET['min_rating'] ) : 0;
$orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : 'rating';

// Get archive info
$archive_title = get_the_archive_title();
$archive_description = get_the_archive_description();

// Build custom query if filters are applied, otherwise use main query
$has_filters = ! empty( $search_query ) || ! empty( $store_type_filter ) || ! empty( $location_filter ) || $rating_filter > 0 || $orderby !== 'rating';

if ( $has_filters ) {
	// Build query args for filtered results
	$query_args = array(
		'post_type' => 'cbd_store',
		'posts_per_page' => get_option( 'posts_per_page', 12 ),
		'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
		'post_status' => 'publish',
	);
	
	// Add search
	if ( ! empty( $search_query ) ) {
		$query_args['s'] = $search_query;
	}
	
	// Add taxonomy filters
	$tax_query = array();
	if ( ! empty( $store_type_filter ) ) {
		$tax_query[] = array(
			'taxonomy' => 'store_type',
			'field' => 'slug',
			'terms' => $store_type_filter,
		);
	}
	if ( ! empty( $location_filter ) ) {
		$tax_query[] = array(
			'taxonomy' => 'store_location',
			'field' => 'slug',
			'terms' => $location_filter,
		);
	}
	if ( ! empty( $tax_query ) ) {
		$query_args['tax_query'] = $tax_query;
	}
	
	// Add rating filter
	if ( $rating_filter > 0 ) {
		$query_args['meta_query'] = array(
			array(
				'key' => '_cbd_store_google_rating',
				'value' => $rating_filter,
				'compare' => '>=',
				'type' => 'DECIMAL',
			),
		);
	}
	
	// Add ordering
	if ( $orderby === 'rating' ) {
		$query_args['meta_key'] = '_cbd_store_google_rating';
		$query_args['orderby'] = 'meta_value_num';
		$query_args['order'] = 'DESC';
	} elseif ( $orderby === 'name' ) {
		$query_args['orderby'] = 'title';
		$query_args['order'] = 'ASC';
	} else {
		$query_args['orderby'] = 'date';
		$query_args['order'] = 'DESC';
	}
	
	$custom_query = new WP_Query( $query_args );
	$use_custom_query = true;
} else {
	// Use default archive query with rating ordering
	global $wp_query;
	$custom_query = $wp_query;
	$use_custom_query = false;
}

// Get filter options
$store_types = get_terms( array(
	'taxonomy' => 'store_type',
	'hide_empty' => true,
) );

$locations = get_terms( array(
	'taxonomy' => 'store_location',
	'hide_empty' => true,
) );
?>

<div class="content-area">
	<div class="container mx-auto px-4 py-8">
		
		<!-- Archive Header -->
		<header class="mb-8 md:mb-12 text-center">
			<h1 class="mui-typography-h1 mb-4">
				<?php echo wp_kses_post( $archive_title ); ?>
			</h1>
			<?php if ( ! empty( $archive_description ) ) : ?>
				<div class="mui-typography-body1" style="color: var(--mui-gray-700); max-w-3xl mx-auto">
					<?php echo wp_kses_post( $archive_description ); ?>
				</div>
			<?php endif; ?>
		</header>

		<!-- Filters Section -->
		<div class="store-filters mb-8">
			<div class="mui-card mui-card-elevated p-6">
				<form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'cbd_store' ) ); ?>" class="store-filter-form">
					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
						
						<!-- Search -->
						<div>
							<label for="store-search" class="block text-sm font-medium mb-2">Buscar</label>
							<input 
								type="text" 
								id="store-search" 
								name="s" 
								value="<?php echo esc_attr( $search_query ); ?>"
								class="mui-input mui-input-outlined w-full"
								placeholder="Nome da loja..."
							>
						</div>
						
						<!-- Store Type -->
						<div>
							<label for="store-type-filter" class="block text-sm font-medium mb-2">Tipo</label>
							<select 
								id="store-type-filter" 
								name="store_type" 
								class="mui-input mui-input-outlined w-full"
							>
								<option value="">Todos os tipos</option>
								<?php foreach ( $store_types as $type ) : ?>
									<option value="<?php echo esc_attr( $type->slug ); ?>" <?php selected( $store_type_filter, $type->slug ); ?>>
										<?php echo esc_html( $type->name ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<!-- Location -->
						<div>
							<label for="location-filter" class="block text-sm font-medium mb-2">Localização</label>
							<select 
								id="location-filter" 
								name="location" 
								class="mui-input mui-input-outlined w-full"
							>
								<option value="">Todas as localizações</option>
								<?php foreach ( $locations as $location ) : ?>
									<option value="<?php echo esc_attr( $location->slug ); ?>" <?php selected( $location_filter, $location->slug ); ?>>
										<?php echo esc_html( $location->name ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<!-- Rating -->
						<div>
							<label for="rating-filter" class="block text-sm font-medium mb-2">Rating Mínimo</label>
							<select 
								id="rating-filter" 
								name="min_rating" 
								class="mui-input mui-input-outlined w-full"
							>
								<option value="0" <?php selected( $rating_filter, 0 ); ?>>Qualquer rating</option>
								<option value="3" <?php selected( $rating_filter, 3 ); ?>>3+ estrelas</option>
								<option value="4" <?php selected( $rating_filter, 4 ); ?>>4+ estrelas</option>
								<option value="4.5" <?php selected( $rating_filter, 4.5 ); ?>>4.5+ estrelas</option>
							</select>
						</div>
						
					</div>
					
					<div class="flex flex-wrap gap-4 mt-4">
						<button type="submit" class="mui-button mui-button-contained">
							Filtrar
						</button>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'cbd_store' ) ); ?>" class="mui-button mui-button-outlined">
							Limpar Filtros
						</a>
						
						<!-- Order By -->
						<div class="flex items-center gap-2 ml-auto">
							<label for="orderby" class="text-sm">Ordenar por:</label>
							<select 
								id="orderby" 
								name="orderby" 
								class="mui-input mui-input-outlined"
								onchange="this.form.submit()"
							>
								<option value="rating" <?php selected( $orderby, 'rating' ); ?>>Rating</option>
								<option value="name" <?php selected( $orderby, 'name' ); ?>>Nome</option>
								<option value="date" <?php selected( $orderby, 'date' ); ?>>Mais recente</option>
							</select>
						</div>
					</div>
				</form>
			</div>
		</div>

		<?php 
		// Use custom query if filters applied, otherwise use main loop
		if ( $has_filters ) {
			$stores_query = $custom_query;
		} else {
			global $wp_query;
			$stores_query = $wp_query;
		}
		
		if ( $stores_query->have_posts() ) : 
		?>
			
			<!-- Results Count -->
			<div class="mb-6">
				<p class="mui-typography-body2" style="color: var(--mui-gray-600);">
					<?php 
					printf(
						_n(
							'%d loja encontrada',
							'%d lojas encontradas',
							$stores_query->found_posts,
							'cbd-ai-theme'
						),
						$stores_query->found_posts
					);
					?>
				</p>
			</div>
			
			<!-- Stores Grid -->
			<div class="stores-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
				<?php while ( $stores_query->have_posts() ) : $stores_query->the_post(); ?>
					<?php
					$store_id = get_the_ID();
					$rating = get_post_meta( $store_id, '_cbd_store_google_rating', true );
					$review_count = get_post_meta( $store_id, '_cbd_store_google_review_count', true );
					$address = get_post_meta( $store_id, '_cbd_store_address', true );
					$city = get_post_meta( $store_id, '_cbd_store_city', true );
					$phone = get_post_meta( $store_id, '_cbd_store_phone', true );
					$website = get_post_meta( $store_id, '_cbd_store_website', true );
					$store_types = get_the_terms( $store_id, 'store_type' );
					?>
					
					<article class="mui-card mui-card-elevated hover:shadow-xl transition-all duration-300">
						
						<!-- Featured Image -->
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-t-lg">
								<?php the_post_thumbnail( 'medium', array(
									'class' => 'w-full h-48 object-cover hover:scale-105 transition-transform duration-300',
									'loading' => 'lazy',
								) ); ?>
							</a>
						<?php endif; ?>
						
						<div class="mui-card-content p-6">
							
							<!-- Store Type Badge -->
							<?php if ( $store_types && ! is_wp_error( $store_types ) ) : ?>
								<div class="mb-2">
									<?php foreach ( $store_types as $type ) : ?>
										<span class="mui-chip mui-chip-success" style="font-size: 0.75rem;">
											<?php echo esc_html( $type->name ); ?>
										</span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							
							<!-- Title -->
							<h2 class="mui-typography-h6 mb-3">
								<a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
									<?php the_title(); ?>
								</a>
							</h2>
							
							<!-- Rating -->
							<?php if ( $rating ) : ?>
								<div class="flex items-center gap-2 mb-3">
									<div class="flex items-center">
										<?php
										$full_stars = floor( $rating );
										$half_star = ( $rating - $full_stars ) >= 0.5;
										for ( $i = 0; $i < 5; $i++ ) {
											if ( $i < $full_stars ) {
												echo '<span style="color: #fbbf24;">★</span>';
											} elseif ( $i === $full_stars && $half_star ) {
												echo '<span style="color: #fbbf24;">½</span>';
											} else {
												echo '<span style="color: #d1d5db;">★</span>';
											}
										}
										?>
									</div>
									<span class="text-sm font-medium"><?php echo esc_html( number_format( $rating, 1 ) ); ?></span>
									<?php if ( $review_count ) : ?>
										<span class="text-sm" style="color: var(--mui-gray-600);">
											(<?php echo esc_html( number_format_i18n( $review_count ) ); ?>)
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							
							<!-- Address -->
							<?php if ( $address || $city ) : ?>
								<div class="mb-3 text-sm" style="color: var(--mui-gray-700);">
									<strong>📍</strong> 
									<?php 
									$location_parts = array_filter( array( $address, $city ) );
									echo esc_html( implode( ', ', $location_parts ) );
									?>
								</div>
							<?php endif; ?>
							
							<!-- Phone -->
							<?php if ( $phone ) : ?>
								<div class="mb-3 text-sm" style="color: var(--mui-gray-700);">
									<strong>📞</strong> <?php echo esc_html( $phone ); ?>
								</div>
							<?php endif; ?>
							
							<!-- Excerpt -->
							<?php if ( has_excerpt() ) : ?>
								<div class="mui-typography-body2 mb-4" style="color: var(--mui-gray-700);">
									<?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?>
								</div>
							<?php endif; ?>
							
							<!-- Actions -->
							<div class="flex flex-wrap gap-2">
								<a href="<?php the_permalink(); ?>" class="mui-button mui-button-text mui-button-small">
									Ver Detalhes
								</a>
								<?php if ( $website ) : ?>
									<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer" class="mui-button mui-button-outlined mui-button-small">
										Website
									</a>
								<?php endif; ?>
							</div>
							
						</div>
						
					</article>
				<?php endwhile; ?>
			</div>
			
			<?php wp_reset_postdata(); ?>
			
			<!-- Pagination -->
			<?php if ( $stores_query->max_num_pages > 1 ) : ?>
				<div class="pagination mt-8">
					<?php
					$big = 999999999;
					$pagination_base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
					
					// Preserve query vars in pagination
					$query_vars = array();
					if ( ! empty( $search_query ) ) {
						$query_vars['s'] = $search_query;
					}
					if ( ! empty( $store_type_filter ) ) {
						$query_vars['store_type'] = $store_type_filter;
					}
					if ( ! empty( $location_filter ) ) {
						$query_vars['location'] = $location_filter;
					}
					if ( $rating_filter > 0 ) {
						$query_vars['min_rating'] = $rating_filter;
					}
					if ( ! empty( $orderby ) ) {
						$query_vars['orderby'] = $orderby;
					}
					
					$pagination_args = array(
						'base'      => $pagination_base,
						'format'    => '?paged=%#%',
						'current'   => max( 1, get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ),
						'total'     => $stores_query->max_num_pages,
						'prev_text' => '← Anterior',
						'next_text' => 'Próxima →',
						'type'      => 'list',
						'end_size'  => 2,
						'mid_size'  => 1,
						'add_args'  => $query_vars,
					);
					
					$pagination = paginate_links( $pagination_args );
					
					if ( $pagination ) :
					?>
						<nav class="mui-pagination" aria-label="<?php esc_attr_e( 'Navegação de páginas', 'cbd-ai-theme' ); ?>">
							<?php 
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
							$pagination = str_replace( 
								'<a class="page-numbers', 
								'<a class="mui-button mui-button-outlined mui-button-small mui-pagination-link', 
								$pagination 
							);
							$pagination = str_replace( 
								'<span class="page-numbers current', 
								'<span class="mui-button mui-button-contained mui-button-primary mui-button-small mui-pagination-current" aria-current="page"', 
								$pagination 
							);
							echo $pagination;
							?>
						</nav>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			
		<?php else : ?>
			
			<!-- No Stores Found -->
			<div class="mui-card mui-card-elevated p-8 md:p-12 text-center">
				<div class="mui-alert mui-alert-info">
					<div class="mui-alert-icon" style="font-size: 3rem;">🏪</div>
					<div class="mui-alert-message">
						<h2 class="mui-typography-h4 mb-2">Nenhuma loja encontrada</h2>
						<p class="mui-typography-body1" style="color: var(--mui-gray-700);">
							<?php if ( ! empty( $search_query ) || ! empty( $store_type_filter ) || ! empty( $location_filter ) ) : ?>
								Tente ajustar os filtros de busca.
							<?php else : ?>
								Ainda não há lojas cadastradas no diretório.
							<?php endif; ?>
						</p>
					</div>
				</div>
			</div>
			
		<?php endif; ?>
		
	</div>
</div>

<?php
get_footer();
?>

