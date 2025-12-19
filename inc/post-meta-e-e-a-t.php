<?php
/**
 * E-E-A-T Post Meta Fields
 * 
 * Adds custom meta fields for Expertise, Experience, Authoritativeness, and Trustworthiness
 * Critical for YMYL (Your Money Your Life) content like CBD
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register E-E-A-T meta boxes
 */
function cbd_ai_register_e_e_a_t_meta_boxes() {
	add_meta_box(
		'cbd_ai_e_e_a_t_meta',
		'Dados E-E-A-T (Expertise, Autoridade, Confiança)',
		'cbd_ai_e_e_a_t_meta_box_callback',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cbd_ai_register_e_e_a_t_meta_boxes' );

/**
 * Meta box callback
 */
function cbd_ai_e_e_a_t_meta_box_callback( $post ) {
	wp_nonce_field( 'cbd_ai_e_e_a_t_meta_box', 'cbd_ai_e_e_a_t_meta_box_nonce' );
	
	// Get existing values
	$reviewer_name = get_post_meta( $post->ID, '_cbd_reviewer_name', true );
	$reviewer_title = get_post_meta( $post->ID, '_cbd_reviewer_title', true );
	$reviewer_type = get_post_meta( $post->ID, '_cbd_reviewer_type', true );
	$verified_sources = get_post_meta( $post->ID, '_cbd_verified_sources', true );
	
	// Default reviewer types
	$reviewer_types = array(
		'pharmacist' => 'Farmacêutico(a)',
		'veterinarian' => 'Veterinário(a)',
		'lawyer' => 'Advogado(a)',
		'doctor' => 'Médico(a)',
		'researcher' => 'Investigador(a)',
		'other' => 'Outro',
	);
	
	?>
	<div class="cbd-ai-meta-box" style="padding: 20px;">
		<h3 style="margin-top: 0; color: #00897b;">Revisor Médico/Legal</h3>
		<p style="color: #666; font-size: 13px; margin-bottom: 15px;">
			<strong>CRUCIAL para YMYL:</strong> Indica que o conteúdo foi verificado por um especialista. 
			O Google valoriza a verificação humana em tópicos de saúde.
		</p>
		
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="cbd_reviewer_name">Nome do Revisor</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_reviewer_name" 
						name="cbd_reviewer_name" 
						value="<?php echo esc_attr( $reviewer_name ); ?>" 
						class="regular-text"
						placeholder="Ex: Dra. Ana Gomes"
					>
					<p class="description">Nome completo do especialista que revisou o conteúdo.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_reviewer_title">Título/Especialização</label>
				</th>
				<td>
					<input 
						type="text" 
						id="cbd_reviewer_title" 
						name="cbd_reviewer_title" 
						value="<?php echo esc_attr( $reviewer_title ); ?>" 
						class="regular-text"
						placeholder="Ex: Farmacêutica especializada em produtos naturais"
					>
					<p class="description">Título profissional ou área de especialização.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cbd_reviewer_type">Tipo de Revisor</label>
				</th>
				<td>
					<select id="cbd_reviewer_type" name="cbd_reviewer_type" class="regular-text">
						<option value="">Selecione...</option>
						<?php foreach ( $reviewer_types as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $reviewer_type, $value ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<p class="description">Tipo de especialista que revisou o conteúdo.</p>
				</td>
			</tr>
		</table>
		
		<h3 style="margin-top: 30px; color: #00897b;">Fontes Verificadas (Fato-Checking)</h3>
		<p style="color: #666; font-size: 13px; margin-bottom: 15px;">
			<strong>Importante para Confiança:</strong> Liste as fontes oficiais e verificadas usadas no artigo 
			(Infarmed, OMS, EFSA, Estudos PubMed, etc.).
		</p>
		
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="cbd_verified_sources">Fontes</label>
				</th>
				<td>
					<textarea 
						id="cbd_verified_sources" 
						name="cbd_verified_sources" 
						rows="6" 
						class="large-text"
						placeholder="Ex:&#10;OMS (2020) - Canabidiol: uma revisão científica&#10;Infarmed (2024) - Regulamentação de produtos com CBD&#10;PubMed - Estudo sobre eficácia do CBD em animais"
					><?php echo esc_textarea( $verified_sources ); ?></textarea>
					<p class="description">
						Liste uma fonte por linha. Formato: <strong>Nome da Fonte (Ano) - Descrição</strong><br>
						Exemplos: OMS (2020), Infarmed (2024), PubMed, EFSA, etc.
					</p>
				</td>
			</tr>
		</table>
	</div>
	<?php
}

/**
 * Save E-E-A-T meta box data
 */
function cbd_ai_save_e_e_a_t_meta_box( $post_id ) {
	// Check nonce
	if ( ! isset( $_POST['cbd_ai_e_e_a_t_meta_box_nonce'] ) ) {
		return;
	}
	
	if ( ! wp_verify_nonce( $_POST['cbd_ai_e_e_a_t_meta_box_nonce'], 'cbd_ai_e_e_a_t_meta_box' ) ) {
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
	
	// Save reviewer data
	if ( isset( $_POST['cbd_reviewer_name'] ) ) {
		update_post_meta( $post_id, '_cbd_reviewer_name', sanitize_text_field( $_POST['cbd_reviewer_name'] ) );
	}
	
	if ( isset( $_POST['cbd_reviewer_title'] ) ) {
		update_post_meta( $post_id, '_cbd_reviewer_title', sanitize_text_field( $_POST['cbd_reviewer_title'] ) );
	}
	
	if ( isset( $_POST['cbd_reviewer_type'] ) ) {
		update_post_meta( $post_id, '_cbd_reviewer_type', sanitize_text_field( $_POST['cbd_reviewer_type'] ) );
	}
	
	// Save verified sources
	if ( isset( $_POST['cbd_verified_sources'] ) ) {
		update_post_meta( $post_id, '_cbd_verified_sources', sanitize_textarea_field( $_POST['cbd_verified_sources'] ) );
	}
}
add_action( 'save_post', 'cbd_ai_save_e_e_a_t_meta_box' );

