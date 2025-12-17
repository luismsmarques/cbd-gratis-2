<?php
/**
 * Admin Interface for Legislation Sources
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add admin menu for legislation sources
 */
function cbd_ai_add_legislation_sources_menu() {
	add_menu_page(
		'Fontes Legislativas',
		'Fontes Legislativas',
		'manage_options',
		'cbd-legislation-sources',
		'cbd_ai_legislation_sources_page',
		'dashicons-admin-links',
		30
	);
}
add_action( 'admin_menu', 'cbd_ai_add_legislation_sources_menu' );

/**
 * Enqueue admin scripts and styles
 */
function cbd_ai_legislation_sources_admin_scripts( $hook ) {
	if ( $hook !== 'toplevel_page_cbd-legislation-sources' ) {
		return;
	}
	
	wp_enqueue_style(
		'cbd-ai-legislation-sources-admin',
		CBD_AI_THEME_URI . '/assets/css/admin-legislation-sources.css',
		array(),
		CBD_AI_THEME_VERSION
	);
	
	wp_enqueue_script(
		'cbd-ai-legislation-sources-admin',
		CBD_AI_THEME_URI . '/assets/js/admin-legislation-sources.js',
		array( 'jquery' ),
		CBD_AI_THEME_VERSION,
		true
	);
	
	wp_localize_script( 'cbd-ai-legislation-sources-admin', 'cbdLegislationSources', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'cbd_legislation_sources_nonce' ),
		'strings' => array(
			'confirmDelete' => 'Tem certeza que deseja deletar esta fonte?',
			'testing' => 'Testando...',
			'testSuccess' => 'Teste realizado com sucesso!',
			'testError' => 'Erro ao testar fonte.',
		),
	) );
}
add_action( 'admin_enqueue_scripts', 'cbd_ai_legislation_sources_admin_scripts' );

/**
 * Main admin page
 */
function cbd_ai_legislation_sources_page() {
	// Handle actions
	$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : 'list';
	$source_id = isset( $_GET['source_id'] ) ? absint( $_GET['source_id'] ) : 0;
	
	// Check permissions
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Você não tem permissão para acessar esta página.' );
	}
	
	// Handle form submissions
	if ( isset( $_POST['cbd_save_source'] ) && check_admin_referer( 'cbd_save_source', 'cbd_source_nonce' ) ) {
		$sources = new CBD_Legislation_Sources();
		
		$data = array(
			'name' => sanitize_text_field( $_POST['source_name'] ?? '' ),
			'url' => esc_url_raw( $_POST['source_url'] ?? '' ),
			'type' => sanitize_text_field( $_POST['source_type'] ?? 'custom' ),
			'verification_method' => sanitize_text_field( $_POST['verification_method'] ?? 'web_scraping' ),
			'check_frequency' => sanitize_text_field( $_POST['check_frequency'] ?? 'daily' ),
			'keywords' => sanitize_textarea_field( $_POST['keywords'] ?? '' ),
			'is_active' => isset( $_POST['is_active'] ),
		);
		
		if ( $source_id > 0 ) {
			$result = $sources->update_source( $source_id, $data );
			if ( ! is_wp_error( $result ) ) {
				echo '<div class="notice notice-success"><p>Fonte atualizada com sucesso!</p></div>';
				$action = 'list';
			} else {
				echo '<div class="notice notice-error"><p>' . esc_html( $result->get_error_message() ) . '</p></div>';
			}
		} else {
			$result = $sources->create_source( $data );
			if ( ! is_wp_error( $result ) ) {
				echo '<div class="notice notice-success"><p>Fonte criada com sucesso!</p></div>';
				$action = 'list';
			} else {
				echo '<div class="notice notice-error"><p>' . esc_html( $result->get_error_message() ) . '</p></div>';
			}
		}
	}
	
	// Handle delete
	if ( isset( $_GET['delete'] ) && check_admin_referer( 'delete_source_' . $source_id ) ) {
		$sources = new CBD_Legislation_Sources();
		$result = $sources->delete_source( $source_id );
		if ( ! is_wp_error( $result ) ) {
			echo '<div class="notice notice-success"><p>Fonte deletada com sucesso!</p></div>';
			$action = 'list';
		} else {
			echo '<div class="notice notice-error"><p>' . esc_html( $result->get_error_message() ) . '</p></div>';
		}
	}
	
	// Handle toggle active
	if ( isset( $_GET['toggle'] ) && check_admin_referer( 'toggle_source_' . $source_id ) ) {
		$sources = new CBD_Legislation_Sources();
		$sources->toggle_active( $source_id );
		$action = 'list';
	}
	
	// Display appropriate page
	if ( $action === 'edit' || $action === 'add' ) {
		cbd_ai_legislation_sources_form( $source_id );
	} else {
		cbd_ai_legislation_sources_list();
	}
}

/**
 * List sources page
 */
function cbd_ai_legislation_sources_list() {
	$sources = new CBD_Legislation_Sources();
	$all_sources = $sources->get_all_sources( false );
	
	// Statistics
	$active_count = count( array_filter( $all_sources, function( $s ) { return $s['is_active']; } ) );
	$total_count = count( $all_sources );
	
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline">Fontes Legislativas</h1>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=cbd-legislation-sources&action=add' ) ); ?>" class="page-title-action">Adicionar Nova</a>
		<hr class="wp-header-end">
		
		<!-- Statistics -->
		<div class="cbd-sources-stats">
			<div class="stat-box">
				<span class="stat-number"><?php echo esc_html( $total_count ); ?></span>
				<span class="stat-label">Total de Fontes</span>
			</div>
			<div class="stat-box">
				<span class="stat-number"><?php echo esc_html( $active_count ); ?></span>
				<span class="stat-label">Fontes Ativas</span>
			</div>
			<div class="stat-box">
				<span class="stat-number"><?php echo esc_html( $total_count - $active_count ); ?></span>
				<span class="stat-label">Fontes Inativas</span>
			</div>
		</div>
		
		<!-- Sources Table -->
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Tipo</th>
					<th>URL</th>
					<th>Frequência</th>
					<th>Última Verificação</th>
					<th>Status</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( empty( $all_sources ) ) : ?>
					<tr>
						<td colspan="7" class="text-center">
							<p>Nenhuma fonte cadastrada. <a href="<?php echo esc_url( admin_url( 'admin.php?page=cbd-legislation-sources&action=add' ) ); ?>">Adicione uma nova fonte</a>.</p>
						</td>
					</tr>
				<?php else : ?>
					<?php foreach ( $all_sources as $source ) : ?>
						<tr>
							<td><strong><?php echo esc_html( $source['name'] ); ?></strong></td>
							<td><?php echo esc_html( ucfirst( $source['type'] ?? 'custom' ) ); ?></td>
							<td><a href="<?php echo esc_url( $source['url'] ); ?>" target="_blank"><?php echo esc_html( $source['url'] ); ?></a></td>
							<td><?php echo esc_html( cbd_ai_get_frequency_label( $source['check_frequency'] ?? 'daily' ) ); ?></td>
							<td>
								<?php if ( $source['last_check'] ) : ?>
									<?php echo esc_html( date_i18n( 'd/m/Y H:i', strtotime( $source['last_check'] ) ) ); ?>
									<br>
									<small class="status-<?php echo esc_attr( $source['last_status'] ?? 'unknown' ); ?>">
										<?php echo esc_html( cbd_ai_get_status_label( $source['last_status'] ?? 'unknown' ) ); ?>
									</small>
								<?php else : ?>
									<span class="text-muted">Nunca</span>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $source['is_active'] ) : ?>
									<span class="status-active">Ativa</span>
								<?php else : ?>
									<span class="status-inactive">Inativa</span>
								<?php endif; ?>
							</td>
							<td>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=cbd-legislation-sources&action=edit&source_id=' . $source['id'] ) ); ?>" class="button button-small">Editar</a>
								<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=cbd-legislation-sources&toggle=1&source_id=' . $source['id'] ), 'toggle_source_' . $source['id'] ) ); ?>" class="button button-small">
									<?php echo $source['is_active'] ? 'Desativar' : 'Ativar'; ?>
								</a>
								<a href="#" class="button button-small test-source" data-source-id="<?php echo esc_attr( $source['id'] ); ?>">Testar</a>
								<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=cbd-legislation-sources&delete=1&source_id=' . $source['id'] ), 'delete_source_' . $source['id'] ) ); ?>" class="button button-small button-link-delete" onclick="return confirm('Tem certeza?');">Deletar</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * Form page (add/edit)
 */
function cbd_ai_legislation_sources_form( $source_id = 0 ) {
	$sources = new CBD_Legislation_Sources();
	$source = $source_id > 0 ? $sources->get_source( $source_id ) : false;
	
	$is_edit = $source !== false;
	$title = $is_edit ? 'Editar Fonte' : 'Adicionar Nova Fonte';
	
	// Default values
	$name = $source['name'] ?? '';
	$url = $source['url'] ?? '';
	$type = $source['type'] ?? 'custom';
	$verification_method = $source['verification_method'] ?? 'web_scraping';
	$check_frequency = $source['check_frequency'] ?? 'daily';
	$keywords = is_array( $source['keywords'] ?? null ) ? implode( "\n", $source['keywords'] ) : '';
	$is_active = $source['is_active'] ?? true;
	
	?>
	<div class="wrap">
		<h1><?php echo esc_html( $title ); ?></h1>
		
		<form method="post" action="">
			<?php wp_nonce_field( 'cbd_save_source', 'cbd_source_nonce' ); ?>
			
			<table class="form-table">
				<tr>
					<th><label for="source_name">Nome da Fonte <span class="required">*</span></label></th>
					<td>
						<input type="text" id="source_name" name="source_name" value="<?php echo esc_attr( $name ); ?>" class="regular-text" required>
						<p class="description">Nome descritivo da fonte (ex: Infarmed, Diário da República)</p>
					</td>
				</tr>
				
				<tr>
					<th><label for="source_url">URL <span class="required">*</span></label></th>
					<td>
						<input type="url" id="source_url" name="source_url" value="<?php echo esc_attr( $url ); ?>" class="regular-text" required>
						<p class="description">URL completa da fonte a ser monitorada</p>
					</td>
				</tr>
				
				<tr>
					<th><label for="source_type">Tipo</label></th>
					<td>
						<select id="source_type" name="source_type">
							<option value="infarmed" <?php selected( $type, 'infarmed' ); ?>>Infarmed</option>
							<option value="dre" <?php selected( $type, 'dre' ); ?>>Diário da República</option>
							<option value="eu" <?php selected( $type, 'eu' ); ?>>União Europeia</option>
							<option value="custom" <?php selected( $type, 'custom' ); ?>>Outro</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<th><label for="verification_method">Método de Verificação</label></th>
					<td>
						<select id="verification_method" name="verification_method">
							<option value="web_scraping" <?php selected( $verification_method, 'web_scraping' ); ?>>Web Scraping</option>
							<option value="rss" <?php selected( $verification_method, 'rss' ); ?>>RSS Feed</option>
							<option value="api" <?php selected( $verification_method, 'api' ); ?>>API</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<th><label for="check_frequency">Frequência de Verificação</label></th>
					<td>
						<select id="check_frequency" name="check_frequency">
							<option value="hourly" <?php selected( $check_frequency, 'hourly' ); ?>>A cada hora</option>
							<option value="twice_daily" <?php selected( $check_frequency, 'twice_daily' ); ?>>2x por dia</option>
							<option value="daily" <?php selected( $check_frequency, 'daily' ); ?>>Diário</option>
							<option value="weekly" <?php selected( $check_frequency, 'weekly' ); ?>>Semanal</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<th><label for="keywords">Palavras-chave</label></th>
					<td>
						<textarea id="keywords" name="keywords" rows="5" class="large-text"><?php echo esc_textarea( $keywords ); ?></textarea>
						<p class="description">Uma palavra-chave por linha. Se vazio, serão usadas as palavras-chave padrão (canabidiol, CBD, cannabis, cânhamo, maconha medicinal)</p>
					</td>
				</tr>
				
				<tr>
					<th><label for="is_active">Status</label></th>
					<td>
						<label>
							<input type="checkbox" id="is_active" name="is_active" value="1" <?php checked( $is_active ); ?>>
							Fonte ativa (será verificada automaticamente)
						</label>
					</td>
				</tr>
			</table>
			
			<p class="submit">
				<input type="submit" name="cbd_save_source" class="button button-primary" value="Salvar Fonte">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=cbd-legislation-sources' ) ); ?>" class="button">Cancelar</a>
				<?php if ( $is_edit ) : ?>
					<a href="#" class="button test-source" data-source-id="<?php echo esc_attr( $source_id ); ?>">Testar Fonte</a>
				<?php endif; ?>
			</p>
		</form>
	</div>
	<?php
}

/**
 * Get frequency label
 */
function cbd_ai_get_frequency_label( $frequency ) {
	$labels = array(
		'hourly' => 'A cada hora',
		'twice_daily' => '2x por dia',
		'daily' => 'Diário',
		'weekly' => 'Semanal',
	);
	
	return $labels[ $frequency ] ?? $frequency;
}

/**
 * Get status label
 */
function cbd_ai_get_status_label( $status ) {
	$labels = array(
		'success' => 'Sucesso',
		'error' => 'Erro',
		'no_changes' => 'Sem mudanças',
		'unknown' => 'Não verificado',
	);
	
	return $labels[ $status ] ?? $status;
}

/**
 * AJAX handler for testing source
 */
function cbd_ai_test_source_ajax() {
	check_ajax_referer( 'cbd_legislation_sources_nonce', 'nonce' );
	
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Permissão negada.' ) );
	}
	
	$source_id = isset( $_POST['source_id'] ) ? absint( $_POST['source_id'] ) : 0;
	
	if ( $source_id === 0 ) {
		wp_send_json_error( array( 'message' => 'ID de fonte inválido.' ) );
	}
	
	$sources = new CBD_Legislation_Sources();
	$source = $sources->get_source( $source_id );
	
	if ( ! $source ) {
		wp_send_json_error( array( 'message' => 'Fonte não encontrada.' ) );
	}
	
	$scraper = new CBD_Web_Scraper();
	$result = $scraper->scrape_url( $source['url'], $source['keywords'] );
	
	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}
	
	$changes = $scraper->check_for_changes( $source_id, $result['relevant_content'] );
	
	wp_send_json_success( array(
		'message' => 'Teste realizado com sucesso!',
		'has_changes' => $changes['has_changes'],
		'content_length' => strlen( $result['relevant_content'] ),
		'hash' => $result['content_hash'],
	) );
}
add_action( 'wp_ajax_cbd_test_source', 'cbd_ai_test_source_ajax' );

