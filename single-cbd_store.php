<?php
/**
 * Single Store Template
 * 
 * Template para exibir detalhes de uma loja CBD individual
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

while ( have_posts() ) : the_post();
	
	$store_id = get_the_ID();
	
	// Get all store meta data
	$store_type = get_post_meta( $store_id, '_cbd_store_type', true );
	$address = get_post_meta( $store_id, '_cbd_store_address', true );
	$city = get_post_meta( $store_id, '_cbd_store_city', true );
	$postal_code = get_post_meta( $store_id, '_cbd_store_postal_code', true );
	$country = get_post_meta( $store_id, '_cbd_store_country', true );
	$latitude = get_post_meta( $store_id, '_cbd_store_latitude', true );
	$longitude = get_post_meta( $store_id, '_cbd_store_longitude', true );
	$phone = get_post_meta( $store_id, '_cbd_store_phone', true );
	$email = get_post_meta( $store_id, '_cbd_store_email', true );
	$website = get_post_meta( $store_id, '_cbd_store_website', true );
	$rating = get_post_meta( $store_id, '_cbd_store_google_rating', true );
	$review_count = get_post_meta( $store_id, '_cbd_store_google_review_count', true );
	$maps_url = get_post_meta( $store_id, '_cbd_store_google_maps_url', true );
	$opening_hours = get_post_meta( $store_id, '_cbd_store_opening_hours', true );
	$products = get_post_meta( $store_id, '_cbd_store_products', true );
	$certifications = get_post_meta( $store_id, '_cbd_store_certifications', true );
	$payment_methods = get_post_meta( $store_id, '_cbd_store_payment_methods', true );
	$delivery_available = get_post_meta( $store_id, '_cbd_store_delivery_available', true );
	
	// Get taxonomies
	$store_types = get_the_terms( $store_id, 'store_type' );
	$locations = get_the_terms( $store_id, 'store_location' );
	$categories = get_the_terms( $store_id, 'store_category' );
	
	// Build full address
	$full_address_parts = array_filter( array( $address, $city, $postal_code, $country ) );
	$full_address = implode( ', ', $full_address_parts );
?>

<div class="content-area">
	<div class="container mx-auto px-4 py-8">
		<div class="max-w-6xl mx-auto">
			
			<!-- Breadcrumbs -->
			<nav class="mb-6" aria-label="Breadcrumb">
				<?php
				$breadcrumbs = array(
					array(
						'name' => 'Início',
						'url' => home_url( '/' ),
					),
					array(
						'name' => 'Lojas CBD',
						'url' => get_post_type_archive_link( 'cbd_store' ),
					),
					array(
						'name' => get_the_title(),
						'url' => get_permalink(),
					),
				);
				?>
				<ol class="flex flex-wrap items-center gap-2 text-sm" style="color: var(--mui-gray-600);">
					<?php foreach ( $breadcrumbs as $index => $crumb ) : ?>
						<li class="flex items-center">
							<?php if ( $index > 0 ) : ?>
								<span class="mx-2">/</span>
							<?php endif; ?>
							<?php if ( $index < count( $breadcrumbs ) - 1 ) : ?>
								<a href="<?php echo esc_url( $crumb['url'] ); ?>" class="hover:text-blue-600 transition-colors">
									<?php echo esc_html( $crumb['name'] ); ?>
								</a>
							<?php else : ?>
								<span><?php echo esc_html( $crumb['name'] ); ?></span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ol>
			</nav>
			
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
				
				<!-- Main Content -->
				<div class="lg:col-span-2">
					
					<!-- Store Header -->
					<header class="mb-8">
						
						<!-- Store Type Badges -->
						<?php if ( $store_types && ! is_wp_error( $store_types ) ) : ?>
							<div class="mb-4">
								<?php foreach ( $store_types as $type ) : ?>
									<span class="mui-chip mui-chip-success">
										<?php echo esc_html( $type->name ); ?>
									</span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						
						<!-- Title -->
						<h1 class="mui-typography-h1 mb-4">
							<?php the_title(); ?>
						</h1>
						
						<!-- Rating -->
						<?php if ( $rating ) : ?>
							<div class="flex items-center gap-3 mb-4">
								<div class="flex items-center">
									<?php
									$full_stars = floor( $rating );
									$half_star = ( $rating - $full_stars ) >= 0.5;
									for ( $i = 0; $i < 5; $i++ ) {
										if ( $i < $full_stars ) {
											echo '<span style="color: #fbbf24; font-size: 1.5rem;">★</span>';
										} elseif ( $i === $full_stars && $half_star ) {
											echo '<span style="color: #fbbf24; font-size: 1.5rem;">½</span>';
										} else {
											echo '<span style="color: #d1d5db; font-size: 1.5rem;">★</span>';
										}
									}
									?>
								</div>
								<div>
									<span class="text-xl font-bold"><?php echo esc_html( number_format( $rating, 1 ) ); ?></span>
									<?php if ( $review_count ) : ?>
										<span class="text-base" style="color: var(--mui-gray-600);">
											(<?php echo esc_html( number_format_i18n( $review_count ) ); ?> avaliações)
										</span>
									<?php endif; ?>
									<?php if ( $maps_url ) : ?>
										<span class="text-sm">
											<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">
												Ver no Google Maps
											</a>
										</span>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Featured Image -->
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="mb-6 rounded-lg overflow-hidden">
								<?php the_post_thumbnail( 'large', array(
									'class' => 'w-full h-auto',
									'loading' => 'eager',
								) ); ?>
							</div>
						<?php endif; ?>
						
					</header>
					
					<!-- Store Description -->
					<?php if ( get_the_content() ) : ?>
						<div class="mui-card mui-card-elevated p-6 mb-8">
							<h2 class="mui-typography-h5 mb-4">Sobre a Loja</h2>
							<div class="mui-typography-body1" style="color: var(--mui-gray-700);">
								<?php the_content(); ?>
							</div>
						</div>
					<?php endif; ?>
					
					<!-- Products -->
					<?php if ( $products ) : ?>
						<div class="mui-card mui-card-elevated p-6 mb-8">
							<h2 class="mui-typography-h5 mb-4">Produtos</h2>
							<div class="mui-typography-body1" style="color: var(--mui-gray-700);">
								<?php
								$products_list = explode( "\n", $products );
								$products_list = array_filter( array_map( 'trim', $products_list ) );
								if ( ! empty( $products_list ) ) :
								?>
									<ul class="list-disc list-inside space-y-2">
										<?php foreach ( $products_list as $product ) : ?>
											<li><?php echo esc_html( $product ); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php else : ?>
									<p><?php echo esc_html( $products ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					
					<!-- Categories -->
					<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
						<div class="mui-card mui-card-elevated p-6 mb-8">
							<h2 class="mui-typography-h5 mb-4">Categorias de Produtos</h2>
							<div class="flex flex-wrap gap-2">
								<?php foreach ( $categories as $category ) : ?>
									<span class="mui-chip mui-chip-success">
										<?php echo esc_html( $category->name ); ?>
									</span>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
					
					<!-- Certifications -->
					<?php if ( $certifications ) : ?>
						<div class="mui-card mui-card-elevated p-6 mb-8">
							<h2 class="mui-typography-h5 mb-4">Certificações e Licenças</h2>
							<div class="mui-typography-body1" style="color: var(--mui-gray-700);">
								<?php
								$certs_list = explode( "\n", $certifications );
								$certs_list = array_filter( array_map( 'trim', $certs_list ) );
								if ( ! empty( $certs_list ) ) :
								?>
									<ul class="list-disc list-inside space-y-2">
										<?php foreach ( $certs_list as $cert ) : ?>
											<li><?php echo esc_html( $cert ); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php else : ?>
									<p><?php echo esc_html( $certifications ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					
				</div>
				
				<!-- Sidebar -->
				<aside class="lg:col-span-1">
					
					<!-- Contact Information -->
					<div class="mui-card mui-card-elevated p-6 mb-6">
						<h2 class="mui-typography-h6 mb-4">Informações de Contacto</h2>
						
						<div class="space-y-4">
							
							<!-- Address -->
							<?php if ( $full_address ) : ?>
								<div>
									<strong class="block mb-1">📍 Endereço</strong>
									<p class="text-sm" style="color: var(--mui-gray-700);">
										<?php echo esc_html( $full_address ); ?>
									</p>
								</div>
							<?php endif; ?>
							
							<!-- Phone -->
							<?php if ( $phone ) : ?>
								<div>
									<strong class="block mb-1">📞 Telefone</strong>
									<p class="text-sm" style="color: var(--mui-gray-700);">
										<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="text-blue-600 hover:underline">
											<?php echo esc_html( $phone ); ?>
										</a>
									</p>
								</div>
							<?php endif; ?>
							
							<!-- Email -->
							<?php if ( $email ) : ?>
								<div>
									<strong class="block mb-1">✉️ Email</strong>
									<p class="text-sm" style="color: var(--mui-gray-700);">
										<a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-blue-600 hover:underline">
											<?php echo esc_html( $email ); ?>
										</a>
									</p>
								</div>
							<?php endif; ?>
							
							<!-- Website -->
							<?php if ( $website ) : ?>
								<div>
									<strong class="block mb-1">🌐 Website</strong>
									<p class="text-sm" style="color: var(--mui-gray-700);">
										<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">
											<?php echo esc_html( parse_url( $website, PHP_URL_HOST ) ); ?>
										</a>
									</p>
								</div>
							<?php endif; ?>
							
							<!-- Action Buttons -->
							<div class="pt-4 border-t" style="border-color: var(--mui-gray-200);">
								<?php if ( $website ) : ?>
									<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer" class="mui-button mui-button-contained w-full mb-2">
										Visitar Website
									</a>
								<?php endif; ?>
								<?php if ( $maps_url ) : ?>
									<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="mui-button mui-button-outlined w-full">
										Ver no Google Maps
									</a>
								<?php endif; ?>
							</div>
							
						</div>
					</div>
					
					<!-- Opening Hours -->
					<?php if ( $opening_hours ) : ?>
						<div class="mui-card mui-card-elevated p-6 mb-6">
							<h2 class="mui-typography-h6 mb-4">Horários de Funcionamento</h2>
							<div class="text-sm" style="color: var(--mui-gray-700);">
								<?php
								$hours_lines = explode( "\n", $opening_hours );
								$hours_lines = array_filter( array_map( 'trim', $hours_lines ) );
								?>
								<?php if ( ! empty( $hours_lines ) ) : ?>
									<ul class="space-y-2">
										<?php foreach ( $hours_lines as $line ) : ?>
											<li><?php echo esc_html( $line ); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php else : ?>
									<p><?php echo esc_html( $opening_hours ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					
					<!-- Additional Info -->
					<div class="mui-card mui-card-elevated p-6 mb-6">
						<h2 class="mui-typography-h6 mb-4">Informações Adicionais</h2>
						
						<div class="space-y-3 text-sm">
							
							<!-- Payment Methods -->
							<?php if ( $payment_methods ) : ?>
								<div>
									<strong class="block mb-1">💳 Métodos de Pagamento</strong>
									<p style="color: var(--mui-gray-700);">
										<?php echo esc_html( $payment_methods ); ?>
									</p>
								</div>
							<?php endif; ?>
							
							<!-- Delivery -->
							<?php if ( $delivery_available === '1' ) : ?>
								<div>
									<strong class="block mb-1">🚚 Entrega</strong>
									<p style="color: var(--mui-gray-700);">
										Entrega disponível
									</p>
								</div>
							<?php endif; ?>
							
							<!-- Locations -->
							<?php if ( $locations && ! is_wp_error( $locations ) ) : ?>
								<div>
									<strong class="block mb-1">📍 Localização</strong>
									<div class="flex flex-wrap gap-2">
										<?php foreach ( $locations as $location ) : ?>
											<span class="mui-chip" style="background-color: #e0f2fe; color: #0369a1; font-size: 0.75rem;">
												<?php echo esc_html( $location->name ); ?>
											</span>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
							
						</div>
					</div>
					
					<!-- Google Maps Embed -->
					<?php if ( $latitude && $longitude ) : ?>
						<div class="mui-card mui-card-elevated p-6 mb-6">
							<h2 class="mui-typography-h6 mb-4">Localização</h2>
							<div class="rounded-lg overflow-hidden" style="height: 300px;">
								<iframe
									width="100%"
									height="100%"
									style="border:0"
									loading="lazy"
									allowfullscreen
									src="https://www.google.com/maps?q=<?php echo esc_attr( $latitude ); ?>,<?php echo esc_attr( $longitude ); ?>&hl=pt&z=15&output=embed"
								>
								</iframe>
							</div>
							<?php if ( $maps_url ) : ?>
								<div class="mt-3">
									<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-sm text-blue-600 hover:underline">
										Ver no Google Maps →
									</a>
								</div>
							<?php elseif ( $full_address ) : ?>
								<div class="mt-3">
									<a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode( $full_address ); ?>" target="_blank" rel="noopener noreferrer" class="text-sm text-blue-600 hover:underline">
										Ver no Google Maps →
									</a>
								</div>
							<?php endif; ?>
						</div>
					<?php elseif ( $full_address ) : ?>
						<div class="mui-card mui-card-elevated p-6 mb-6">
							<h2 class="mui-typography-h6 mb-4">Localização</h2>
							<p class="text-sm" style="color: var(--mui-gray-700); margin-bottom: 1rem;">
								<?php echo esc_html( $full_address ); ?>
							</p>
							<?php if ( $maps_url ) : ?>
								<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="mui-button mui-button-outlined">
									Ver no Google Maps
								</a>
							<?php else : ?>
								<a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode( $full_address ); ?>" target="_blank" rel="noopener noreferrer" class="mui-button mui-button-outlined">
									Ver no Google Maps
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					
				</aside>
				
			</div>
			
		</div>
	</div>
</div>

<?php
endwhile;

get_footer();
?>

