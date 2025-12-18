<?php
/**
 * Admin Settings Page
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add admin menu
 */
function cbd_ai_add_admin_menu() {
	// Main menu item
	add_menu_page(
		'CBD AI',
		'CBD AI',
		'manage_options',
		'cbd-ai-settings',
		'cbd_ai_settings_page',
		'dashicons-admin-generic',
		30
	);
	
	// Settings submenu
	add_submenu_page(
		'cbd-ai-settings',
		'Configurações',
		'Configurações',
		'manage_options',
		'cbd-ai-settings',
		'cbd_ai_settings_page'
	);
}
add_action( 'admin_menu', 'cbd_ai_add_admin_menu' );

/**
 * Register settings
 */
function cbd_ai_register_settings() {
	register_setting( 'cbd_ai_settings', 'cbd_gemini_api_key', array(
		'type' => 'string',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	register_setting( 'cbd_ai_settings', 'cbd_legislation_monitor_enabled', array(
		'type' => 'boolean',
		'default' => true,
	) );
	
	register_setting( 'cbd_ai_settings', 'cbd_chatbot_enabled', array(
		'type' => 'boolean',
		'default' => true,
	) );
	
	register_setting( 'cbd_ai_settings', 'cbd_chatbot_humans_enabled', array(
		'type' => 'boolean',
		'default' => true,
	) );
	
	// Brevo (Newsletter) settings
	register_setting( 'cbd_ai_settings', 'cbd_brevo_api_key', array(
		'type' => 'string',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	register_setting( 'cbd_ai_settings', 'cbd_brevo_list_id', array(
		'type' => 'integer',
		'sanitize_callback' => 'absint',
	) );
}
add_action( 'admin_init', 'cbd_ai_register_settings' );

/**
 * List available Gemini models
 *
 * @param string $api_key API key
 * @return array|WP_Error List of models or error
 */
function cbd_ai_list_gemini_models( $api_key ) {
	if ( empty( $api_key ) ) {
		return new WP_Error( 'no_api_key', 'API key não configurada' );
	}
	
	// Try both API versions
	$versions = array( 'v1', 'v1beta' );
	$models = array();
	
	foreach ( $versions as $version ) {
		$url = sprintf(
			'https://generativelanguage.googleapis.com/%s/models?key=%s',
			$version,
			$api_key
		);
		
		$response = wp_remote_get( $url, array(
			'timeout' => 10,
		) );
		
		if ( is_wp_error( $response ) ) {
			continue;
		}
		
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		
		if ( isset( $data['models'] ) && is_array( $data['models'] ) ) {
			foreach ( $data['models'] as $model ) {
				$model_name = $model['name'] ?? '';
				if ( ! empty( $model_name ) ) {
					// Extract model name from full path (e.g., "models/gemini-pro" -> "gemini-pro")
					$model_name = str_replace( 'models/', '', $model_name );
					
					// Check if model supports generateContent
					$supported_methods = $model['supportedGenerationMethods'] ?? array();
					if ( in_array( 'generateContent', $supported_methods ) ) {
						$models[] = array(
							'name' => $model_name,
							'version' => $version,
							'display_name' => $model['displayName'] ?? $model_name,
						);
					}
				}
			}
		}
	}
	
	return $models;
}

/**
 * Test Gemini API key with available models
 *
 * @param string $api_key API key to test
 * @return array Test result
 */
function cbd_ai_test_gemini_api_key( $api_key ) {
	if ( empty( $api_key ) ) {
		return array(
			'success' => false,
			'message' => 'API Key vazia',
		);
	}
	
	// First, try to list available models
	$available_models = cbd_ai_list_gemini_models( $api_key );
	
	if ( is_wp_error( $available_models ) ) {
		// If listing fails, try common models
		$models_to_try = array(
			array( 'version' => 'v1', 'model' => 'gemini-pro' ),
			array( 'version' => 'v1beta', 'model' => 'gemini-pro' ),
		);
	} else {
		// Use the models we found
		$models_to_try = array();
		foreach ( $available_models as $model_info ) {
			$models_to_try[] = array(
				'version' => $model_info['version'],
				'model' => $model_info['name'],
			);
		}
		
		// If no models found, fallback to common ones
		if ( empty( $models_to_try ) ) {
			$models_to_try = array(
				array( 'version' => 'v1', 'model' => 'gemini-pro' ),
			);
		}
	}
	
	$last_error = '';
	
	foreach ( $models_to_try as $config ) {
		$api_endpoint = sprintf(
			'https://generativelanguage.googleapis.com/%s/models/%s:generateContent',
			$config['version'],
			$config['model']
		);
		$url = add_query_arg( 'key', $api_key, $api_endpoint );
		
		$body = array(
			'contents' => array(
				array(
					'parts' => array(
						array( 'text' => 'Teste' )
					)
				)
			),
			'generationConfig' => array(
				'maxOutputTokens' => 10,
			),
		);
		
		$response = wp_remote_post( $url, array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'body' => json_encode( $body ),
			'timeout' => 10,
		) );
		
		if ( is_wp_error( $response ) ) {
			$last_error = 'Erro de conexão: ' . $response->get_error_message();
			continue;
		}
		
		$response_body = wp_remote_retrieve_body( $response );
		$data = json_decode( $response_body, true );
		
		if ( isset( $data['error'] ) ) {
			$last_error = sprintf(
				'Erro com %s/%s: %s',
				$config['version'],
				$config['model'],
				$data['error']['message'] ?? 'Erro desconhecido'
			);
			continue;
		}
		
		// Try multiple response structures
		$text_found = false;
		
		// Standard structure
		if ( isset( $data['candidates'][0]['content']['parts'][0]['text'] ) ) {
			$text_found = true;
		}
		// Alternative structures
		elseif ( isset( $data['candidates'][0]['content']['parts'][0] ) && is_string( $data['candidates'][0]['content']['parts'][0] ) ) {
			$text_found = true;
		}
		elseif ( isset( $data['candidates'][0]['content']['parts'] ) && is_array( $data['candidates'][0]['content']['parts'] ) ) {
			foreach ( $data['candidates'][0]['content']['parts'] as $part ) {
				if ( ( isset( $part['text'] ) && is_string( $part['text'] ) ) || is_string( $part ) ) {
					$text_found = true;
					break;
				}
			}
		}
		
		if ( $text_found ) {
			// Success! Update the default model (only if valid)
			if ( ! empty( $config['model'] ) && ! empty( $config['version'] ) ) {
				update_option( 'cbd_gemini_model_name', sanitize_text_field( $config['model'] ) );
				update_option( 'cbd_gemini_api_version', sanitize_text_field( $config['version'] ) );
			}
			
			return array(
				'success' => true,
				'message' => sprintf(
					'API Key válida! Modelo funcionando: %s (API %s)',
					$config['model'],
					$config['version']
				),
			);
		}
	}
	
	// If we get here, all models failed
	$error_msg = 'Nenhum modelo funcionou. ';
	if ( ! empty( $last_error ) ) {
		$error_msg .= 'Último erro: ' . $last_error;
	} else {
		$error_msg .= 'Não foi possível encontrar modelos disponíveis.';
	}
	
	return array(
		'success' => false,
		'message' => $error_msg,
	);
}

/**
 * Check API key status
 *
 * @param string $api_key API key
 * @return array Status information
 */
function cbd_ai_check_api_key_status( $api_key ) {
	if ( empty( $api_key ) ) {
		return array(
			'valid' => false,
			'message' => 'API Key não configurada',
		);
	}
	
	// Try a simple test request
	$test_result = cbd_ai_test_gemini_api_key( $api_key );
	
	return array(
		'valid' => $test_result['success'],
		'message' => $test_result['message'] ?? '',
	);
}

/**
 * Settings page content
 */
function cbd_ai_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	// Save settings - handle all forms
	if ( isset( $_POST['submit'] ) && check_admin_referer( 'cbd_ai_settings' ) ) {
		// Save Gemini API Key - preserve existing if password field is empty
		if ( isset( $_POST['cbd_gemini_api_key'] ) ) {
			$new_api_key = sanitize_text_field( $_POST['cbd_gemini_api_key'] );
			// If password field is empty, use current value
			if ( empty( $new_api_key ) && isset( $_POST['cbd_gemini_api_key_current'] ) ) {
				$new_api_key = sanitize_text_field( $_POST['cbd_gemini_api_key_current'] );
			}
			update_option( 'cbd_gemini_api_key', $new_api_key );
		}
		
		// Save module settings
		update_option( 'cbd_legislation_monitor_enabled', isset( $_POST['cbd_legislation_monitor_enabled'] ) );
		update_option( 'cbd_chatbot_enabled', isset( $_POST['cbd_chatbot_enabled'] ) );
		update_option( 'cbd_chatbot_humans_enabled', isset( $_POST['cbd_chatbot_humans_enabled'] ) );
		
		// Save Brevo settings - preserve existing if password field is empty
		if ( isset( $_POST['cbd_brevo_api_key'] ) ) {
			$brevo_key = sanitize_text_field( $_POST['cbd_brevo_api_key'] );
			// If password field is empty, use current value
			if ( empty( $brevo_key ) && isset( $_POST['cbd_brevo_api_key_current'] ) ) {
				$brevo_key = sanitize_text_field( $_POST['cbd_brevo_api_key_current'] );
			}
			update_option( 'cbd_brevo_api_key', $brevo_key );
		}
		
		if ( isset( $_POST['cbd_brevo_list_id'] ) ) {
			update_option( 'cbd_brevo_list_id', absint( $_POST['cbd_brevo_list_id'] ?? 0 ) );
		}
		
		echo '<div class="notice notice-success is-dismissible"><p><strong>Configurações salvas com sucesso!</strong></p></div>';
	}
	
	$api_key = get_option( 'cbd_gemini_api_key', '' );
	$brevo_api_key = get_option( 'cbd_brevo_api_key', '' );
	$brevo_list_id = get_option( 'cbd_brevo_list_id', 0 );
	
	// Get module settings - default to true if not set (first time)
	$monitor_enabled = get_option( 'cbd_legislation_monitor_enabled' );
	if ( $monitor_enabled === false ) {
		$monitor_enabled = true;
		update_option( 'cbd_legislation_monitor_enabled', true );
	}
	
	$chatbot_enabled = get_option( 'cbd_chatbot_enabled' );
	if ( $chatbot_enabled === false ) {
		$chatbot_enabled = true;
		update_option( 'cbd_chatbot_enabled', true );
	}
	
	$chatbot_humans_enabled = get_option( 'cbd_chatbot_humans_enabled' );
	if ( $chatbot_humans_enabled === false ) {
		$chatbot_humans_enabled = true;
		update_option( 'cbd_chatbot_humans_enabled', true );
	}
	
	// Ensure boolean values
	$monitor_enabled = (bool) $monitor_enabled;
	$chatbot_enabled = (bool) $chatbot_enabled;
	$chatbot_humans_enabled = (bool) $chatbot_humans_enabled;
	
	// Check API key status
	$api_status = cbd_ai_check_api_key_status( $api_key );
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline">⚙️ Configurações CBD AI</h1>
		<hr class="wp-header-end">
		
		<div class="cbd-ai-settings-container" style="max-width: 900px;">
			
			<!-- Unified Settings Form -->
			<form method="post" action="" id="cbd-ai-settings-form">
				<?php wp_nonce_field( 'cbd_ai_settings' ); ?>
			
			<!-- API Key Section -->
			<div class="card" style="margin-top: 20px;">
				<h2 class="title">🔑 Chave API Google Gemini</h2>
				<p class="description" style="margin-bottom: 20px;">
					A chave API do Gemini é necessária para que todos os chatbots e funcionalidades de IA funcionem corretamente.
					<?php
					$current_model = get_option( 'cbd_gemini_model_name', 'gemini-pro' );
					$current_version = get_option( 'cbd_gemini_api_version', 'v1' );
					if ( ! empty( $current_model ) ) {
						echo '<br><strong>Modelo atual:</strong> <code>' . esc_html( $current_model ) . '</code>';
						echo ' | <strong>Versão API:</strong> <code>' . esc_html( $current_version ) . '</code>';
					}
					?>
					<br><small style="color: #666;">O sistema detectará automaticamente os modelos disponíveis ao testar a API Key.</small>
				</p>
					
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="cbd_gemini_api_key">Chave API</label>
							</th>
							<td>
								<?php if ( ! empty( $api_key ) ) : ?>
									<input type="hidden" name="cbd_gemini_api_key_current" value="<?php echo esc_attr( $api_key ); ?>">
								<?php endif; ?>
								<input type="password" 
								       id="cbd_gemini_api_key" 
								       name="cbd_gemini_api_key" 
								       value="" 
								       class="regular-text code" 
								       placeholder="<?php echo ! empty( $api_key ) ? '•••••••• (deixe em branco para manter atual)' : 'AIzaSy...'; ?>"
								       autocomplete="off">
								<?php if ( ! empty( $api_key ) ) : ?>
									<p class="description" style="margin-top: 5px; color: #666;">
										<small>Deixe em branco para manter a chave atual. Digite uma nova chave para alterar.</small>
									</p>
								<?php endif; ?>
								<p class="description">
									<strong>Como obter:</strong>
									<ol style="margin-left: 20px; margin-top: 5px;">
										<li>Acesse <a href="https://makersuite.google.com/app/apikey" target="_blank" rel="noopener">Google AI Studio</a></li>
										<li>Faça login com sua conta Google</li>
										<li>Clique em "Create API Key"</li>
										<li>Copie a chave gerada e cole aqui</li>
									</ol>
								</p>
								
								<!-- API Status -->
								<?php if ( ! empty( $api_key ) ) : ?>
									<div class="api-status" style="margin-top: 15px;">
										<?php if ( $api_status['valid'] ) : ?>
											<span class="dashicons dashicons-yes-alt" style="color: #00a32a; font-size: 20px; vertical-align: middle;"></span>
											<span style="color: #00a32a; font-weight: 600;">API Key válida e funcionando</span>
										<?php else : ?>
											<span class="dashicons dashicons-warning" style="color: #d63638; font-size: 20px; vertical-align: middle;"></span>
											<span style="color: #d63638; font-weight: 600;">API Key inválida ou erro de conexão</span>
											<?php if ( ! empty( $api_status['message'] ) ) : ?>
												<p class="description" style="color: #d63638; margin-top: 5px;">
													<?php echo esc_html( $api_status['message'] ); ?>
												</p>
											<?php endif; ?>
										<?php endif; ?>
									</div>
								<?php else : ?>
									<div class="api-status" style="margin-top: 15px;">
										<span class="dashicons dashicons-info" style="color: #2271b1; font-size: 20px; vertical-align: middle;"></span>
										<span style="color: #2271b1;">Configure sua API Key para ativar os chatbots</span>
									</div>
								<?php endif; ?>
								
								<!-- Test Button -->
								<?php if ( ! empty( $api_key ) ) : ?>
									<p style="margin-top: 15px;">
										<button type="button" 
										        class="button button-secondary" 
										        id="test-api-btn"
										        onclick="testApiKey()">
											<span class="dashicons dashicons-admin-tools" style="vertical-align: middle;"></span>
											Testar API Key
										</button>
										<span id="test-result" style="margin-left: 10px;"></span>
									</p>
								<?php endif; ?>
							</td>
						</tr>
					</table>
			</div>
			
			<!-- Brevo Newsletter Section -->
			<div class="card" style="margin-top: 20px;">
				<h2 class="title">📧 Newsletter - Brevo (Sendinblue)</h2>
				<p class="description" style="margin-bottom: 20px;">
					Configure a integração com Brevo para gerenciar subscrições de newsletter.
					<br><small style="color: #666;">O widget de newsletter nos posts será conectado automaticamente à sua lista do Brevo.</small>
				</p>
					
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="cbd_brevo_api_key">API Key do Brevo</label>
							</th>
							<td>
								<?php if ( ! empty( $brevo_api_key ) ) : ?>
									<input type="hidden" name="cbd_brevo_api_key_current" value="<?php echo esc_attr( $brevo_api_key ); ?>">
								<?php endif; ?>
								<input type="password" 
								       id="cbd_brevo_api_key" 
								       name="cbd_brevo_api_key" 
								       value="" 
								       class="regular-text code" 
								       placeholder="<?php echo ! empty( $brevo_api_key ) ? '•••••••• (deixe em branco para manter atual)' : 'xkeysib-...'; ?>"
								       autocomplete="off">
								<?php if ( ! empty( $brevo_api_key ) ) : ?>
									<p class="description" style="margin-top: 5px; color: #666;">
										<small>Deixe em branco para manter a chave atual. Digite uma nova chave para alterar.</small>
									</p>
								<?php endif; ?>
								<p class="description">
									<strong>Como obter:</strong>
									<ol style="margin-left: 20px; margin-top: 5px;">
										<li>Acesse <a href="https://app.brevo.com/settings/keys/api" target="_blank" rel="noopener">Brevo API Keys</a></li>
										<li>Faça login na sua conta Brevo</li>
										<li>Clique em "Generate a new API key"</li>
										<li>Copie a chave gerada e cole aqui</li>
									</ol>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="cbd_brevo_list_id">ID da Lista</label>
							</th>
							<td>
								<input type="number" 
								       id="cbd_brevo_list_id" 
								       name="cbd_brevo_list_id" 
								       value="<?php echo esc_attr( $brevo_list_id ); ?>" 
								       class="regular-text" 
								       placeholder="1"
								       min="1">
								<p class="description">
									<strong>Como encontrar:</strong>
									<ol style="margin-left: 20px; margin-top: 5px;">
										<li>Acesse <a href="https://app.brevo.com/contact/list-listing" target="_blank" rel="noopener">Brevo Lists</a></li>
										<li>Clique na lista que deseja usar</li>
										<li>O ID da lista aparece na URL: <code>.../list-listing/1</code> (o número é o ID)</li>
									</ol>
								</p>
								<?php if ( ! empty( $brevo_api_key ) ) : ?>
									<p style="margin-top: 15px;">
										<button type="button" 
										        class="button button-secondary" 
										        id="test-brevo-btn"
										        onclick="testBrevoConnection()">
											<span class="dashicons dashicons-admin-tools" style="vertical-align: middle;"></span>
											Testar Conexão
										</button>
										<span id="brevo-test-result" style="margin-left: 10px;"></span>
									</p>
								<?php endif; ?>
							</td>
						</tr>
					</table>
			</div>
			
			<!-- Features Section -->
			<div class="card" style="margin-top: 20px;">
				<h2 class="title">🚀 Funcionalidades</h2>
				<p class="description" style="margin-bottom: 20px;">
					Ative ou desative os módulos de IA do tema.
				</p>
					
					<table class="form-table">
						<tr>
							<th scope="row">Módulos de IA</th>
							<td>
								<fieldset>
									<label style="display: block; margin-bottom: 10px;">
										<input type="checkbox" 
										       name="cbd_chatbot_enabled" 
										       value="1" 
										       <?php checked( $chatbot_enabled, true ); ?>>
										<strong>Chatbot CBD para Animais</strong>
										<p class="description" style="margin-left: 25px; margin-top: 5px;">
											Chatbot especializado em responder perguntas sobre CBD para cães, gatos e outros animais.
										</p>
									</label>
									
									<label style="display: block; margin-bottom: 10px;">
										<input type="checkbox" 
										       name="cbd_chatbot_humans_enabled" 
										       value="1" 
										       <?php checked( $chatbot_humans_enabled, true ); ?>>
										<strong>Chatbot CBD para Humanos</strong>
										<p class="description" style="margin-left: 25px; margin-top: 5px;">
											Chatbot especializado em responder perguntas sobre CBD para uso humano.
										</p>
									</label>
									
									<label style="display: block; margin-bottom: 10px;">
										<input type="checkbox" 
										       name="cbd_legislation_monitor_enabled" 
										       value="1" 
										       <?php checked( $monitor_enabled, true ); ?>>
										<strong>Monitor de Legislação</strong>
										<p class="description" style="margin-left: 25px; margin-top: 5px;">
											Monitora automaticamente alterações na legislação portuguesa e europeia sobre CBD.
										</p>
									</label>
								</fieldset>
							</td>
						</tr>
					</table>
			</div>
			
			<!-- Submit Button for all settings -->
			<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
				<?php submit_button( 'Salvar Todas as Configurações', 'primary', 'submit', false ); ?>
			</div>
			
			</form>
			
			<!-- Information Section -->
			<div class="card" style="margin-top: 20px;">
				<h2 class="title">ℹ️ Informações</h2>
				<div class="inside">
					<p>Este tema inclui os seguintes módulos de IA:</p>
					<ul style="list-style: disc; margin-left: 20px;">
						<li><strong>Chatbot CBD para Animais:</strong> Responde perguntas sobre dosagem, benefícios, segurança e legalidade do CBD para animais</li>
						<li><strong>Chatbot CBD para Humanos:</strong> Responde perguntas sobre CBD para uso humano, incluindo dosagem e interações medicamentosas</li>
						<li><strong>Monitor de Legislação:</strong> Monitora automaticamente sites oficiais (Infarmed, Diário da República, UE) e gera alertas sobre mudanças legislativas</li>
						<li><strong>Otimizador SEO:</strong> Analisa e sugere melhorias para otimizar conteúdo para motores de busca</li>
					</ul>
					
					<hr style="margin: 20px 0;">
					
					<h3>📚 Links Úteis</h3>
					<ul style="list-style: disc; margin-left: 20px;">
						<li><a href="https://ai.google.dev/docs" target="_blank" rel="noopener">Documentação Google Gemini API</a></li>
						<li><a href="https://makersuite.google.com/app/apikey" target="_blank" rel="noopener">Google AI Studio (Obter API Key)</a></li>
						<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=cbd-legislation-sources' ) ); ?>">Gerir Fontes Legislativas</a></li>
					</ul>
				</div>
			</div>
			
		</div>
	</div>
	
	<script>
	function testApiKey() {
		const apiKey = document.getElementById('cbd_gemini_api_key').value;
		const resultDiv = document.getElementById('test-result');
		const testBtn = document.getElementById('test-api-btn');
		
		if (!apiKey) {
			resultDiv.innerHTML = '<span style="color: #d63638;">Por favor, insira uma API Key primeiro.</span>';
			return;
		}
		
		testBtn.disabled = true;
		testBtn.innerHTML = '<span class="dashicons dashicons-update" style="animation: spin 1s linear infinite; vertical-align: middle;"></span> Testando...';
		resultDiv.innerHTML = '';
		
		// Create form data
		const formData = new FormData();
		formData.append('action', 'cbd_ai_test_api_key');
		formData.append('api_key', apiKey);
		formData.append('nonce', '<?php echo wp_create_nonce( 'cbd_ai_test_api' ); ?>');
		
		fetch(ajaxurl, {
			method: 'POST',
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				resultDiv.innerHTML = '<span style="color: #00a32a;"><span class="dashicons dashicons-yes-alt" style="vertical-align: middle;"></span> ' + (data.data.message || 'API Key válida e funcionando!') + '</span>';
				// Reload page after 2 seconds to show updated status
				setTimeout(() => {
					location.reload();
				}, 2000);
			} else {
				resultDiv.innerHTML = '<span style="color: #d63638;"><span class="dashicons dashicons-warning" style="vertical-align: middle;"></span> ' + (data.data.message || 'Erro ao testar API Key') + '</span>';
			}
		})
		.catch(error => {
			resultDiv.innerHTML = '<span style="color: #d63638;"><span class="dashicons dashicons-warning" style="vertical-align: middle;"></span> Erro de conexão</span>';
		})
		.finally(() => {
			testBtn.disabled = false;
			testBtn.innerHTML = '<span class="dashicons dashicons-admin-tools" style="vertical-align: middle;"></span> Testar API Key';
		});
	}
	
	// Add spin animation
	const style = document.createElement('style');
	style.textContent = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
	document.head.appendChild(style);
	
	function testBrevoConnection() {
		const apiKey = document.getElementById('cbd_brevo_api_key').value;
		const resultDiv = document.getElementById('brevo-test-result');
		const testBtn = document.getElementById('test-brevo-btn');
		
		if (!apiKey) {
			resultDiv.innerHTML = '<span style="color: #d63638;">Por favor, insira uma API Key primeiro.</span>';
			return;
		}
		
		testBtn.disabled = true;
		testBtn.innerHTML = '<span class="dashicons dashicons-update" style="animation: spin 1s linear infinite; vertical-align: middle;"></span> Testando...';
		resultDiv.innerHTML = '';
		
		const formData = new FormData();
		formData.append('action', 'cbd_ai_test_brevo');
		formData.append('api_key', apiKey);
		formData.append('nonce', '<?php echo wp_create_nonce( 'cbd_ai_test_brevo' ); ?>');
		
		fetch(ajaxurl, {
			method: 'POST',
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				resultDiv.innerHTML = '<span style="color: #00a32a;"><span class="dashicons dashicons-yes-alt" style="vertical-align: middle;"></span> ' + (data.data.message || 'Conexão com Brevo estabelecida com sucesso!') + '</span>';
			} else {
				resultDiv.innerHTML = '<span style="color: #d63638;"><span class="dashicons dashicons-warning" style="vertical-align: middle;"></span> ' + (data.data.message || 'Erro ao testar conexão') + '</span>';
			}
		})
		.catch(error => {
			resultDiv.innerHTML = '<span style="color: #d63638;"><span class="dashicons dashicons-warning" style="vertical-align: middle;"></span> Erro de conexão</span>';
		})
		.finally(() => {
			testBtn.disabled = false;
			testBtn.innerHTML = '<span class="dashicons dashicons-admin-tools" style="vertical-align: middle;"></span> Testar Conexão';
		});
	}
	</script>
	<?php
}

/**
 * AJAX handler for API key test
 */
function cbd_ai_ajax_test_api_key() {
	check_ajax_referer( 'cbd_ai_test_api', 'nonce' );
	
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Permissão negada' ) );
	}
	
	$api_key = sanitize_text_field( $_POST['api_key'] ?? '' );
	$result = cbd_ai_test_gemini_api_key( $api_key );
	
	if ( $result['success'] ) {
		wp_send_json_success( $result );
	} else {
		wp_send_json_error( $result );
	}
}
add_action( 'wp_ajax_cbd_ai_test_api_key', 'cbd_ai_ajax_test_api_key' );

/**
 * AJAX handler for Brevo connection test
 */
function cbd_ai_ajax_test_brevo() {
	check_ajax_referer( 'cbd_ai_test_brevo', 'nonce' );
	
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Permissão negada' ) );
	}
	
	require_once CBD_AI_THEME_PATH . '/inc/class-brevo-integration.php';
	
	$api_key = sanitize_text_field( $_POST['api_key'] ?? '' );
	
	// Temporarily set API key for testing
	$original_key = get_option( 'cbd_brevo_api_key' );
	update_option( 'cbd_brevo_api_key', $api_key );
	
	$brevo = new CBD_Brevo_Integration();
	$result = $brevo->test_connection();
	
	// Restore original key
	update_option( 'cbd_brevo_api_key', $original_key );
	
	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	} else {
		wp_send_json_success( $result );
	}
}
add_action( 'wp_ajax_cbd_ai_test_brevo', 'cbd_ai_ajax_test_brevo' );
