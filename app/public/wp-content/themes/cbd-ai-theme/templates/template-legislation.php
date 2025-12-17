<?php
/**
 * Template Name: Monitor Legislação
 * 
 * Página de Monitor de Legislação Portuguesa sobre CBD
 * Design MUI focado em rigor e relatório oficial
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();
?>

<!-- Legislation Page - MUI Design Relatório Oficial -->
<main class="main-content">
	<div class="legislation-chatbot-page py-8 md:py-12" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(25, 118, 210, 0.05), var(--mui-gray-50));">
		<div class="container mx-auto px-4">
			<div class="max-w-7xl mx-auto">
				
				<!-- Page Header - MUI Typography -->
				<header class="text-center mb-8 md:mb-12">
					<div style="display: flex; align-items: center; justify-content: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
						<div style="width: 64px; height: 64px; background-color: rgba(25, 118, 210, 0.12); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
							<span style="font-size: 2rem;">⚖️</span>
						</div>
						<div>
							<h1 class="mui-typography-h1 mb-4">
								Monitor de Legislação Portuguesa sobre CBD e Cânhamo
							</h1>
							<p class="mui-typography-body1" style="max-width: 768px; margin: 0 auto; color: var(--mui-gray-700);">
								Acompanhe as últimas alterações na legislação portuguesa e europeia sobre CBD e cannabis medicinal.
							</p>
						</div>
					</div>
				</header>
				
				<!-- StatusCard Component - Destaque -->
				<div id="legislation-status-card-app" style="max-width: 900px; margin: 0 auto 32px;"></div>
				
				<!-- Main Content Grid -->
				<div class="main-content-grid">
					
					<!-- Chatbot Container (Main) - MUI Card -->
					<div class="main-content-area">
						<div class="mui-card mui-card-elevated">
							
							<!-- Chat Header - MUI Card Header -->
							<div style="background: linear-gradient(to right, var(--mui-blue-primary), var(--mui-blue-dark)); color: white; padding: 24px; border-radius: 4px 4px 0 0;">
								<div style="display: flex; align-items: center; gap: 16px;">
									<div style="width: 48px; height: 48px; background-color: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
										<span style="font-size: 1.5rem;">⚖️</span>
									</div>
									<div style="flex: 1;">
										<h2 class="mui-typography-h6 mb-2" style="margin: 0 0 4px 0; color: white; font-weight: 600;">IA Especialista em Legislação</h2>
										<p class="mui-typography-body2" style="margin: 0; opacity: 0.9; color: white;">Pronta para esclarecer suas dúvidas sobre legislação</p>
									</div>
									<div style="display: flex; align-items: center; gap: 8px; background-color: rgba(255, 255, 255, 0.2); padding: 6px 12px; border-radius: 16px;">
										<div style="width: 8px; height: 8px; background-color: #81c784; border-radius: 50%; animation: pulse 2s infinite;"></div>
										<span class="mui-typography-caption" style="color: white;">Online</span>
									</div>
								</div>
							</div>
							
							<!-- Chat App Container - MUI Card Content -->
							<div class="mui-card-content" style="padding: 24px;">
								<div id="legislation-chatbot-app"></div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<!-- Legislation History Table - MUI Data Table -->
	<?php
	$monitor = new CBD_Legislation_Monitor();
	$all_alerts = $monitor->get_recent_alerts( 10 );
	if ( ! empty( $all_alerts ) ) :
	?>
	<section class="legislation-history-section py-16 md:py-20" style="background: var(--mui-gray-50);">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						Histórico de Alterações Legislativas
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Registo cronológico das alterações na legislação portuguesa sobre CBD
					</p>
				</header>
				
				<div class="mui-card mui-card-elevated">
					<div class="mui-table-container">
						<table class="mui-table">
							<thead>
								<tr>
									<th class="mui-table-head">Data</th>
									<th class="mui-table-head">Alteração</th>
									<th class="mui-table-head">Fonte</th>
									<th class="mui-table-head" style="text-align: center;">Ações</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $all_alerts as $alert ) : ?>
									<tr>
										<td class="mui-table-cell" style="font-weight: 500;">
											<?php echo esc_html( $alert['date'] ); ?>
										</td>
										<td class="mui-table-cell">
											<?php echo esc_html( wp_trim_words( $alert['title'], 15 ) ); ?>
										</td>
										<td class="mui-table-cell">
											<?php echo esc_html( $alert['source'] ?? 'N/A' ); ?>
										</td>
										<td class="mui-table-cell" style="text-align: center;">
											<a href="<?php echo esc_url( $alert['url'] ); ?>" class="mui-button mui-button-text mui-button-small" style="color: var(--mui-blue-primary);">
												Ver detalhes
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>
</main>

<?php
// Enqueue component scripts
wp_enqueue_script(
	'cbd-legislation-chatbot-component',
	get_template_directory_uri() . '/assets/js/components/ChatbotLegislation.js',
	array( 'vue-prod', 'cbd-ai-main' ),
	CBD_AI_THEME_VERSION,
	true
);

wp_enqueue_script(
	'cbd-ai-status-card',
	CBD_AI_THEME_URI . '/assets/js/components/StatusCard.js',
	array( 'vue-prod' ),
	CBD_AI_THEME_VERSION,
	false
);
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Initialize StatusCard
	function initStatusCard() {
		if (typeof Vue === 'undefined' || typeof window.StatusCard === 'undefined') {
			setTimeout(initStatusCard, 100);
			return;
		}
		
		const { createApp } = Vue;
		const container = document.getElementById('legislation-status-card-app');
		if (!container) return;
		
		<?php
		$monitor = new CBD_Legislation_Monitor();
		$recent_alerts = $monitor->get_recent_alerts( 1 );
		$has_alert = ! empty( $recent_alerts ) && isset( $recent_alerts[0] );
		?>
		
		const statusApp = createApp({
			components: {
				StatusCard: window.StatusCard
			},
			data() {
				return {
					status: '<?php echo $has_alert ? "warning" : "success"; ?>',
					titulo: '<?php echo $has_alert ? "Alerta Legislativo Ativo" : "Status Legislativo: Estável"; ?>',
					mensagem: '<?php echo $has_alert ? esc_js( wp_trim_words( $recent_alerts[0]['title'], 20 ) ) : "Nenhum alerta legislativo significativo encontrado no momento."; ?>',
					dataAtualizacao: '<?php echo date_i18n( 'd/m/Y H:i' ); ?>'
				};
			},
			template: '<StatusCard :status="status" :titulo="titulo" :mensagem="mensagem" :dataAtualizacao="dataAtualizacao" />'
		});
		statusApp.mount('#legislation-status-card-app');
	}
	
	function initLegislationChatbot() {
		if (typeof Vue === 'undefined') {
			setTimeout(initLegislationChatbot, 100);
			return;
		}
		
		if (typeof window.ChatbotLegislation === 'undefined') {
			setTimeout(initLegislationChatbot, 100);
			return;
		}
		
		const { createApp } = Vue;
		
		try {
			const app = createApp({
				components: {
					ChatbotLegislation: window.ChatbotLegislation
				},
				template: '<ChatbotLegislation />'
			});
			
			app.mount('#legislation-chatbot-app');
		} catch (error) {
			console.error('Erro ao montar aplicação Vue:', error);
		}
	}
	
	// Initialize components
	setTimeout(initStatusCard, 200);
	setTimeout(initLegislationChatbot, 300);
});
</script>

<?php
get_footer();
?>
