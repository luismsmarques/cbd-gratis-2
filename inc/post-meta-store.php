<?php
/**
 * Store Post Meta Fields
 * 
 * Adds custom meta fields for CBD stores (physical and online)
 * Includes Google Places integration for ratings and data
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Store meta boxes
 */
function cbd_ai_register_store_meta_boxes() {
	add_meta_box(
		'cbd_ai_store_basic_info',
		'Informações Básicas da Loja',
		'cbd_ai_store_basic_info_meta_box_callback',
		'cbd_store',
		'normal',
		'high'
	);
	
	add_meta_box(
		'cbd_ai_store_google_places',
		'Integração Google Places',
		'cbd_ai_store_google_places_meta_box_callback',
		'cbd_store',
		'normal',
		'high'
	);
	
	add_meta_box(
		'cbd_ai_store_additional_info',
		'Informações Adicionais',
		'cbd_ai_store_additional_info_meta_box_callback',
		'cbd_store',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'cbd_ai_register_store_meta_boxes' );

/**
 * Basic Info meta box callback
 */
function cbd_ai_store_basic_info_meta_box_callback( $post ) {
	wp_nonce_field( 'cbd_ai_store_meta_box', 'cbd_ai_store_meta_box_nonce' );
	
	// Get existing values
	$store_type = get_post_meta( $post->ID, '_cbd_store_type', true );
	$address = get_post_meta( $post->ID, '_cbd_store_address', true );
	$city = get_post_meta( $post->ID, '_cbd_store_city', true );
	$postal_code = get_post_meta( $post->ID, '_cbd_store_postal_code', true );
	$country = get_post_meta( $post->ID, '_cbd_store_country', true );
	$latitude = get_post_meta( $post->ID, '_cbd_store_latitude', true );
	$longitude = get_post_meta( $post->ID, '_cbd_store_longitude', true );
	$phone = get_post_meta( $post->ID, '_cbd_store_phone', true );
	$email = get_post_meta( $post->ID, '_cbd_store_email', true );
	$website = get_post_meta( $post->ID, '_cbd_store_website', true );
	
	// Default country
	if ( empty( $country ) ) {
		$country = 'Portugal';
	}
	
	?>
	<div class="cbd-ai-meta-box" style="padding: 20px;">
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="cbd_store_type">Tipo de Loja</label>
				</th>
				<td>
					<select id="cbd_store_type" name="cbd_store_type" class="regular-text">
						<option value="">Selecione...</option>
						<option value="física" <?php selected( $store_type, 'física' ); ?>>Física</option>
						<option value="online" <?php selected( $store_type, 'online' ); ?>>Online</option>
						<option value="híbrida" <?php selected( $store_type, 'híbrida' ); ?>>Híbrida (Física + Online)</option>
					</select>
					<p class="description">Selecione o tipo de loja.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_address">Endereço Completo</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_store_address" 
						name="cbd_store_address" 
						value="<?php echo esc_attr( $address ); ?>" 
						class="regular-text"
						placeholder="Ex: Rua das Flores, 123"
					>
					<p class="description">Endereço completo da loja (obrigatório para lojas físicas).</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_city">Cidade</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_store_city" 
						name="cbd_store_city" 
						value="<?php echo esc_attr( $city ); ?>" 
						class="regular-text"
						placeholder="Ex: Lisboa"
					>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_postal_code">Código Postal</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_store_postal_code" 
						name="cbd_store_postal_code" 
						value="<?php echo esc_attr( $postal_code ); ?>" 
						class="regular-text"
						placeholder="Ex: 1000-001"
					>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_country">País</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_store_country" 
						name="cbd_store_country" 
						value="<?php echo esc_attr( $country ); ?>" 
						class="regular-text"
						placeholder="Ex: Portugal"
					>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_latitude">Latitude</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_store_latitude" 
						name="cbd_store_latitude" 
						value="<?php echo esc_attr( $latitude ); ?>" 
						class="regular-text"
						placeholder="Ex: 38.7223"
					>
					<p class="description">Coordenada de latitude para mapas (opcional, mas recomendado para lojas físicas).</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_longitude">Longitude</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_store_longitude" 
						name="cbd_store_longitude" 
						value="<?php echo esc_attr( $longitude ); ?>" 
						class="regular-text"
						placeholder="Ex: -9.1393"
					>
					<p class="description">Coordenada de longitude para mapas (opcional, mas recomendado para lojas físicas).</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_phone">Telefone</label>
				</th>
				<td>
					<input 
						type="tel" 
						id="cbd_store_phone" 
						name="cbd_store_phone" 
						value="<?php echo esc_attr( $phone ); ?>" 
						class="regular-text"
						placeholder="Ex: +351 21 123 4567"
					>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_email">Email</label>
				</th>
				<td>
					<input 
						type="email" 
						id="cbd_store_email" 
						name="cbd_store_email" 
						value="<?php echo esc_attr( $email ); ?>" 
						class="regular-text"
						placeholder="Ex: contacto@loja.com"
					>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_website">Website</label>
				</th>
				<td>
					<input 
						type="url" 
						id="cbd_store_website" 
						name="cbd_store_website" 
						value="<?php echo esc_attr( $website ); ?>" 
						class="regular-text"
						placeholder="Ex: https://www.loja.com"
					>
					<p class="description">URL completa do website da loja (inclua http:// ou https://).</p>
				</td>
			</tr>
		</table>
	</div>
	<?php
}

/**
 * Google Places meta box callback
 */
function cbd_ai_store_google_places_meta_box_callback( $post ) {
	// Get existing values
	$place_id = get_post_meta( $post->ID, '_cbd_store_google_place_id', true );
	$rating = get_post_meta( $post->ID, '_cbd_store_google_rating', true );
	$review_count = get_post_meta( $post->ID, '_cbd_store_google_review_count', true );
	$maps_url = get_post_meta( $post->ID, '_cbd_store_google_maps_url', true );
	$last_sync = get_post_meta( $post->ID, '_cbd_store_google_last_sync', true );
	
	?>
	<div class="cbd-ai-meta-box" style="padding: 20px;">
		<p style="color: #666; font-size: 13px; margin-bottom: 15px;">
			<strong>Importação Manual do Google Places:</strong> Cole os dados do Google Places abaixo. 
			Você pode encontrar essas informações na página do Google Maps da loja.
		</p>
		
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="cbd_store_google_place_id">Google Place ID</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_store_google_place_id" 
						name="cbd_store_google_place_id" 
						value="<?php echo esc_attr( $place_id ); ?>" 
						class="regular-text"
						placeholder="Ex: ChIJN1t_tDeuEmsRUsoyG83frY4"
					>
					<p class="description">ID único do lugar no Google Places (opcional).</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_google_rating">Rating (Estrelas)</label>
				</th>
				<td>
					<input 
						type="number" 
						id="cbd_store_google_rating" 
						name="cbd_store_google_rating" 
						value="<?php echo esc_attr( $rating ); ?>" 
						class="small-text"
						min="0"
						max="5"
						step="0.1"
						placeholder="Ex: 4.5"
					>
					<p class="description">Avaliação média do Google (0 a 5 estrelas).</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_google_review_count">Número de Reviews</label>
				</th>
				<td>
					<input 
						type="number" 
						id="cbd_store_google_review_count" 
						name="cbd_store_google_review_count" 
						value="<?php echo esc_attr( $review_count ); ?>" 
						class="small-text"
						min="0"
						placeholder="Ex: 127"
					>
					<p class="description">Número total de avaliações no Google.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_google_maps_url">Link Google Maps</label>
				</th>
				<td>
					<input 
						type="url" 
						id="cbd_store_google_maps_url" 
						name="cbd_store_google_maps_url" 
						value="<?php echo esc_attr( $maps_url ); ?>" 
						class="regular-text"
						placeholder="Ex: https://maps.google.com/..."
					>
					<p class="description">URL completa do Google Maps da loja.</p>
				</td>
			</tr>
			<?php if ( $last_sync ) : ?>
			<tr>
				<th scope="row">Última Sincronização</th>
				<td>
					<p class="description"><?php echo esc_html( date_i18n( 'd/m/Y H:i', strtotime( $last_sync ) ) ); ?></p>
				</td>
			</tr>
			<?php endif; ?>
		</table>
	</div>
	<?php
}

/**
 * Additional Info meta box callback
 */
function cbd_ai_store_additional_info_meta_box_callback( $post ) {
	// Get existing values
	$opening_hours = get_post_meta( $post->ID, '_cbd_store_opening_hours', true );
	$products = get_post_meta( $post->ID, '_cbd_store_products', true );
	$certifications = get_post_meta( $post->ID, '_cbd_store_certifications', true );
	$payment_methods = get_post_meta( $post->ID, '_cbd_store_payment_methods', true );
	$delivery_available = get_post_meta( $post->ID, '_cbd_store_delivery_available', true );
	
	// Default opening hours structure
	if ( empty( $opening_hours ) ) {
		$opening_hours = "Segunda-feira: 09:00 - 18:00\nTerça-feira: 09:00 - 18:00\nQuarta-feira: 09:00 - 18:00\nQuinta-feira: 09:00 - 18:00\nSexta-feira: 09:00 - 18:00\nSábado: 10:00 - 13:00\nDomingo: Fechado";
	}
	
	?>
	<div class="cbd-ai-meta-box" style="padding: 20px;">
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="cbd_store_opening_hours">Horários de Funcionamento</label>
				</th>
				<td>
					<textarea 
						id="cbd_store_opening_hours" 
						name="cbd_store_opening_hours" 
						rows="7" 
						class="large-text"
						placeholder="Ex:&#10;Segunda-feira: 09:00 - 18:00&#10;Terça-feira: 09:00 - 18:00&#10;..."
					><?php echo esc_textarea( $opening_hours ); ?></textarea>
					<p class="description">
						Horários de funcionamento da loja. Uma linha por dia da semana.<br>
						Formato: <strong>Dia da semana: Horário</strong> ou <strong>Dia da semana: Fechado</strong>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_products">Produtos que Vende</label>
				</th>
				<td>
					<textarea 
						id="cbd_store_products" 
						name="cbd_store_products" 
						rows="4" 
						class="large-text"
						placeholder="Ex:&#10;Óleos de CBD&#10;Cremes tópicos&#10;Cápsulas&#10;..."
					><?php echo esc_textarea( $products ); ?></textarea>
					<p class="description">Lista de produtos que a loja vende. Uma linha por produto.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_certifications">Certificações/Licenças</label>
				</th>
				<td>
					<textarea 
						id="cbd_store_certifications" 
						name="cbd_store_certifications" 
						rows="3" 
						class="large-text"
						placeholder="Ex:&#10;Licença Infarmed&#10;Certificação ISO 9001&#10;..."
					><?php echo esc_textarea( $certifications ); ?></textarea>
					<p class="description">Certificações, licenças ou credenciais da loja. Uma linha por certificação.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_payment_methods">Métodos de Pagamento</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_store_payment_methods" 
						name="cbd_store_payment_methods" 
						value="<?php echo esc_attr( $payment_methods ); ?>" 
						class="regular-text"
						placeholder="Ex: Cartão, MB Way, Transferência Bancária"
					>
					<p class="description">Métodos de pagamento aceites pela loja.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_store_delivery_available">Entrega Disponível</label>
				</th>
				<td>
					<label>
						<input 
							type="checkbox" 
							id="cbd_store_delivery_available" 
							name="cbd_store_delivery_available" 
							value="1"
							<?php checked( $delivery_available, '1' ); ?>
						>
						Marque se a loja oferece serviço de entrega
					</label>
				</td>
			</tr>
		</table>
	</div>
	<?php
}

/**
 * Save Store meta box data
 */
function cbd_ai_save_store_meta_box( $post_id ) {
	// Check nonce
	if ( ! isset( $_POST['cbd_ai_store_meta_box_nonce'] ) ) {
		return;
	}
	
	if ( ! wp_verify_nonce( $_POST['cbd_ai_store_meta_box_nonce'], 'cbd_ai_store_meta_box' ) ) {
		return;
	}
	
	// Check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	// Check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	// Check post type
	if ( get_post_type( $post_id ) !== 'cbd_store' ) {
		return;
	}
	
	// Save basic info
	$fields = array(
		'cbd_store_type' => 'sanitize_text_field',
		'cbd_store_address' => 'sanitize_text_field',
		'cbd_store_city' => 'sanitize_text_field',
		'cbd_store_postal_code' => 'sanitize_text_field',
		'cbd_store_country' => 'sanitize_text_field',
		'cbd_store_latitude' => 'sanitize_text_field',
		'cbd_store_longitude' => 'sanitize_text_field',
		'cbd_store_phone' => 'sanitize_text_field',
		'cbd_store_email' => 'sanitize_email',
		'cbd_store_website' => 'esc_url_raw',
	);
	
	foreach ( $fields as $field => $sanitize_callback ) {
		if ( isset( $_POST[ $field ] ) ) {
			$value = call_user_func( $sanitize_callback, $_POST[ $field ] );
			update_post_meta( $post_id, '_' . $field, $value );
		} else {
			delete_post_meta( $post_id, '_' . $field );
		}
	}
	
	// Validate and save coordinates
	if ( isset( $_POST['cbd_store_latitude'] ) && isset( $_POST['cbd_store_longitude'] ) ) {
		$lat = floatval( $_POST['cbd_store_latitude'] );
		$lng = floatval( $_POST['cbd_store_longitude'] );
		
		if ( $lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180 ) {
			update_post_meta( $post_id, '_cbd_store_latitude', $lat );
			update_post_meta( $post_id, '_cbd_store_longitude', $lng );
		}
	}
	
	// Save Google Places data
	$google_fields = array(
		'cbd_store_google_place_id' => 'sanitize_text_field',
		'cbd_store_google_rating' => function( $value ) {
			$rating = floatval( $value );
			return ( $rating >= 0 && $rating <= 5 ) ? $rating : '';
		},
		'cbd_store_google_review_count' => 'absint',
		'cbd_store_google_maps_url' => 'esc_url_raw',
	);
	
	foreach ( $google_fields as $field => $sanitize_callback ) {
		if ( isset( $_POST[ $field ] ) ) {
			$value = call_user_func( $sanitize_callback, $_POST[ $field ] );
			update_post_meta( $post_id, '_' . $field, $value );
		} else {
			delete_post_meta( $post_id, '_' . $field );
		}
	}
	
	// Update last sync date if Google data was updated
	if ( isset( $_POST['cbd_store_google_rating'] ) || isset( $_POST['cbd_store_google_review_count'] ) ) {
		update_post_meta( $post_id, '_cbd_store_google_last_sync', current_time( 'mysql' ) );
	}
	
	// Save additional info
	$additional_fields = array(
		'cbd_store_opening_hours' => 'sanitize_textarea_field',
		'cbd_store_products' => 'sanitize_textarea_field',
		'cbd_store_certifications' => 'sanitize_textarea_field',
		'cbd_store_payment_methods' => 'sanitize_text_field',
	);
	
	foreach ( $additional_fields as $field => $sanitize_callback ) {
		if ( isset( $_POST[ $field ] ) ) {
			$value = call_user_func( $sanitize_callback, $_POST[ $field ] );
			update_post_meta( $post_id, '_' . $field, $value );
		} else {
			delete_post_meta( $post_id, '_' . $field );
		}
	}
	
	// Save delivery available (checkbox)
	$delivery_available = isset( $_POST['cbd_store_delivery_available'] ) ? '1' : '0';
	update_post_meta( $post_id, '_cbd_store_delivery_available', $delivery_available );
}
add_action( 'save_post', 'cbd_ai_save_store_meta_box' );

