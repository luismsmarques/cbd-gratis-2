<?php
/**
 * Template Name: Chatbot CBD
 * 
 * Página exclusiva para o Chatbot Especialista em CBD (Geral)
 * Design MUI focado em rigor, segurança e inovação
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get URLs for internal linking
$calculadora_url = '';
$monitor_url = '';
$animais_url = '';
$humanos_url = '';

$calculadora_page = get_page_by_path( 'calculadora-de-dosagem' );
if ( ! $calculadora_page ) {
	$calculadora_page = get_page_by_path( 'calculadora-dosagem' );
}
if ( $calculadora_page ) {
	$calculadora_url = get_permalink( $calculadora_page->ID );
}

$monitor_page = get_page_by_path( 'monitor-legislacao' );
if ( ! $monitor_page ) {
	$monitor_page = get_page_by_path( 'monitor-de-legislacao' );
}
if ( $monitor_page ) {
	$monitor_url = get_permalink( $monitor_page->ID );
}

$animais_page = get_page_by_path( 'animais' );
if ( $animais_page ) {
	$animais_url = get_permalink( $animais_page->ID );
}

$humanos_page = get_page_by_path( 'cbd-para-humanos' );
if ( $humanos_page ) {
	$humanos_url = get_permalink( $humanos_page->ID );
}
?>

<!-- Chatbot Page - MUI Design System -->
<main class="main-content min-h-screen py-8 md:py-12" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.03), var(--mui-gray-50));">
	<div class="container mx-auto px-4">
		<div class="max-w-7xl mx-auto">
			
			<!-- Page Header - MUI Typography -->
			<header class="text-center mb-8 md:mb-12">
				<h1 class="mui-typography-h1 mb-4">
					Chatbot Especialista em CBD: O seu Assistente AI para Dúvidas Rápidas e Precisas
				</h1>
				<p class="mui-typography-body1" style="max-width: 768px; margin: 0 auto; color: var(--mui-gray-700);">
					Faça perguntas sobre CBD. Nossa IA especializada está aqui para ajudar com dosagem, benefícios, segurança, legalidade e muito mais!
				</p>
			</header>
			
			<!-- Credibility Alert - MUI Alert -->
			<div class="mb-6 md:mb-8">
				<div class="mui-alert mui-alert-info mui-alert-elevated">
					<div class="mui-alert-icon">ℹ</div>
					<div class="mui-alert-message">
						<h2 class="mui-typography-h6" style="margin: 0 0 8px 0; font-weight: 600;">
							Powered by AI. Base de dados legal verificada pelo Monitor Legislação cbd.gratis.
						</h2>
						<p class="mui-typography-body2" style="margin: 0;">
							Este chatbot utiliza informações validadas da <strong>legislação portuguesa</strong> (Infarmed, Diário da República) e <strong>estudos científicos</strong> para fornecer respostas precisas e atualizadas sobre CBD, dosagem, segurança e legalidade em Portugal.
						</p>
					</div>
				</div>
			</div>
			
			<!-- Proof Social - MUI Chip Style -->
			<div class="mb-6 md:mb-8 text-center">
				<div class="inline-flex items-center gap-3 mui-card mui-card-elevated" style="padding: 12px 24px; display: inline-flex;">
					<div class="flex items-center gap-2">
						<svg style="width: 20px; height: 20px; color: var(--mui-success);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
						</svg>
						<span class="mui-typography-body2" style="font-weight: 600; color: var(--mui-gray-900);">
							Mais de <span style="color: var(--mui-success);">5.000 Questões Respondidas</span> este Mês
						</span>
					</div>
				</div>
			</div>
			
			<!-- Chat Container - Full Width -->
			<div class="mb-12">
				<div class="mui-card mui-card-elevated" style="overflow: hidden;">
						
						<!-- Chat Header -->
					<div style="background: linear-gradient(to right, var(--mui-teal-primary), var(--mui-teal-dark)); padding: 24px; color: white;">
							<div class="flex items-center gap-4">
							<div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
								<span style="font-size: 24px;">🤖</span>
								</div>
								<div class="flex-1">
								<h2 class="mui-typography-h6" style="margin: 0 0 4px 0; color: white; font-weight: 600;">IA Especialista em CBD</h2>
								<p class="mui-typography-body2" style="margin: 0; opacity: 0.9; color: white;">Pronta para responder suas dúvidas</p>
								</div>
							<div class="hidden md:flex items-center gap-2" style="background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 9999px;">
								<div style="width: 8px; height: 8px; background: #4ade80; border-radius: 50%; animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;"></div>
								<span class="mui-typography-caption" style="color: white;">Online</span>
								</div>
							</div>
						</div>
						
						<!-- Chat App Container -->
					<div style="padding: 24px;">
							<div id="chatbot-cbd-app"></div>
						</div>
					</div>
				</div>
				
			<!-- Content Support Section - MUI Cards -->
			<div class="mui-card mui-card-elevated mb-8">
				<div class="mui-card-content">
					<h2 class="mui-typography-h4 mb-6" style="font-weight: 600;">
						O que o nosso Chatbot Especialista Pode Responder
					</h2>
					<div id="chatbot-features-grid" class="mb-8">
						<!-- Card 1: Dosagem -->
						<div class="mui-card" style="background: var(--mui-gray-50); border: 1px solid var(--mui-gray-200);">
							<div class="mui-card-content">
								<div class="flex items-start gap-3">
									<svg style="width: 32px; height: 32px; color: var(--mui-teal-primary); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
								</svg>
									<div>
										<h3 class="mui-typography-subtitle1 mb-2" style="font-weight: 600;">Dosagem</h3>
										<p class="mui-typography-body2" style="margin: 0;">Cálculo preciso de dosagem para pessoas, cães e gatos baseado em peso, condição e concentração do produto.</p>
								</div>
							</div>
						</div>
					</div>
					
						<!-- Card 2: Legalidade -->
						<div class="mui-card" style="background: var(--mui-gray-50); border: 1px solid var(--mui-gray-200);">
							<div class="mui-card-content">
								<div class="flex items-start gap-3">
									<svg style="width: 32px; height: 32px; color: var(--mui-blue-primary); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
							</svg>
							<div>
										<h3 class="mui-typography-subtitle1 mb-2" style="font-weight: 600;">Legalidade (Infarmed)</h3>
										<p class="mui-typography-body2" style="margin: 0;">Informações atualizadas sobre o status legal do CBD em Portugal, regulamentações do Infarmed e diretrizes da UE.</p>
							</div>
						</div>
							</div>
						</div>
						
						<!-- Card 3: Segurança -->
						<div class="mui-card" style="background: var(--mui-gray-50); border: 1px solid var(--mui-gray-200);">
							<div class="mui-card-content">
						<div class="flex items-start gap-3">
									<svg style="width: 32px; height: 32px; color: var(--mui-error); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
							</svg>
							<div>
										<h3 class="mui-typography-subtitle1 mb-2" style="font-weight: 600;">Segurança</h3>
										<p class="mui-typography-body2" style="margin: 0;">Orientações sobre segurança, efeitos secundários, interações medicamentosas e contraindicações do CBD.</p>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Card 4: Efeitos -->
						<div class="mui-card" style="background: var(--mui-gray-50); border: 1px solid var(--mui-gray-200);">
							<div class="mui-card-content">
						<div class="flex items-start gap-3">
									<svg style="width: 32px; height: 32px; color: var(--mui-warning); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
							</svg>
							<div>
										<h3 class="mui-typography-subtitle1 mb-2" style="font-weight: 600;">Efeitos</h3>
										<p class="mui-typography-body2" style="margin: 0;">Informações sobre os efeitos do CBD para ansiedade, dor, inflamação, sono e outras condições de saúde.</p>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Card 5: Usos em Pets -->
						<div class="mui-card" style="background: var(--mui-gray-50); border: 1px solid var(--mui-gray-200);">
							<div class="mui-card-content">
						<div class="flex items-start gap-3">
									<svg style="width: 32px; height: 32px; color: var(--mui-success); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
							</svg>
							<div>
										<h3 class="mui-typography-subtitle1 mb-2" style="font-weight: 600;">Usos em Pets</h3>
										<p class="mui-typography-body2" style="margin: 0;">Guias específicos para uso de CBD em cães e gatos, incluindo dosagem segura, benefícios e precauções veterinárias.</p>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Card 6: Produtos e Marcas -->
						<div class="mui-card" style="background: var(--mui-gray-50); border: 1px solid var(--mui-gray-200);">
							<div class="mui-card-content">
						<div class="flex items-start gap-3">
									<svg style="width: 32px; height: 32px; color: var(--mui-info); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
							</svg>
							<div>
										<h3 class="mui-typography-subtitle1 mb-2" style="font-weight: 600;">Produtos e Marcas</h3>
										<p class="mui-typography-body2" style="margin: 0;">Recomendações sobre tipos de produtos (óleos, cápsulas, cremes), concentrações e marcas confiáveis.</p>
									</div>
							</div>
						</div>
					</div>
				</div>
				
					<!-- Data Sources Explanation (E-E-A-T) - MUI Card -->
					<div class="mui-card" style="background: var(--mui-gray-50); border: 1px solid var(--mui-gray-200);">
						<div class="mui-card-content">
							<h3 class="mui-typography-h6 mb-4" style="font-weight: 600;">Fontes de Dados da IA</h3>
							<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<div class="flex items-start gap-2">
									<svg style="width: 20px; height: 20px; color: var(--mui-blue-primary); flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
							</svg>
							<div>
										<p class="mui-typography-body2" style="margin: 0;">
											<strong>Monitor de Legislação:</strong> Monitorização automática de alterações legislativas em sites oficiais (Infarmed, Diário da República, UE).
										</p>
							</div>
						</div>
						<div class="flex items-start gap-2">
									<svg style="width: 20px; height: 20px; color: var(--mui-success); flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
							</svg>
							<div>
										<p class="mui-typography-body2" style="margin: 0;">
											<strong>Estudos Veterinários Validados:</strong> Base de dados de pesquisas científicas e estudos clínicos sobre CBD em animais e humanos.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Internal Links Section - ActionCards -->
			<div class="mb-8">
				<h2 class="mui-typography-h4 mb-6" style="font-weight: 600;">
					Ferramentas Complementares
				</h2>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<?php if ( $calculadora_url ) : ?>
					<div class="mui-card mui-card-elevated" style="transition: all 0.3s ease;">
						<a href="<?php echo esc_url( $calculadora_url ); ?>" style="text-decoration: none; display: block;">
							<div class="mui-card-content">
							<div class="flex items-start gap-4">
									<div style="width: 48px; height: 48px; background: linear-gradient(to bottom right, var(--mui-teal-primary), var(--mui-teal-dark)); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
										<svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
									</svg>
								</div>
								<div class="flex-1">
										<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">
										Calculadora de Dosagem de CBD
									</h3>
										<p class="mui-typography-body2" style="color: var(--mui-gray-600); margin: 0;">
										Calcule a dosagem precisa de CBD para pessoas, cães e gatos com base no peso e condição.
									</p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php endif; ?>
					
					<?php if ( $monitor_url ) : ?>
					<div class="mui-card mui-card-elevated" style="transition: all 0.3s ease;">
						<a href="<?php echo esc_url( $monitor_url ); ?>" style="text-decoration: none; display: block;">
							<div class="mui-card-content">
							<div class="flex items-start gap-4">
									<div style="width: 48px; height: 48px; background: linear-gradient(to bottom right, var(--mui-blue-primary), var(--mui-blue-dark)); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
										<svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
									</svg>
								</div>
								<div class="flex-1">
										<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">
										Monitor de Legislação Portuguesa
									</h3>
										<p class="mui-typography-body2" style="color: var(--mui-gray-600); margin: 0;">
										Acompanhe as últimas alterações na legislação portuguesa e europeia sobre CBD e cânhamo.
									</p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
			
			<!-- CTA de Conversão/Afiliação (Monetização) - MUI Alert -->
			<!-- OCULTO: Seção de monetização desativada -->
			<!--
			<div id="affiliate-cta-section" class="hidden">
				<div class="mui-alert mui-alert-success mui-alert-elevated">
					<div class="mui-alert-icon">✓</div>
					<div class="mui-alert-message">
						<h3 class="mui-typography-h6 mb-3" style="margin: 0 0 12px 0; font-weight: 600;">
						Encontrou a informação que procurava?
					</h3>
						<p class="mui-typography-body1 mb-4" style="margin: 0 0 16px 0;">
						Explore os nossos produtos recomendados de CBD, testados e validados para garantir qualidade e segurança.
					</p>
					<a 
						href="#produtos-recomendados" 
							class="mui-button mui-button-contained mui-button-primary"
							style="display: inline-flex; align-items: center; gap: 8px;"
					>
						Ver Produtos Recomendados
							<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
						</svg>
					</a>
				</div>
			</div>
			-->
			</div>
			
		</div>
	</div>
</main>

<?php
// Enqueue component script - load in footer to ensure Vue is ready
wp_enqueue_script(
	'cbd-chatbot-cbd-component',
	get_template_directory_uri() . '/assets/js/components/ChatbotCBD.js',
	array( 'vue-prod' ),
	CBD_AI_THEME_VERSION,
	true
);
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
	console.log('CBD AI: Script de inicialização carregado');
	
	function initChatbotCBD() {
		console.log('CBD AI: Tentando inicializar ChatbotCBD...');
		console.log('CBD AI: Vue disponível?', typeof Vue !== 'undefined');
		console.log('CBD AI: Componente disponível?', typeof window.ChatbotCBD !== 'undefined');
		console.log('CBD AI: cbdAIData disponível?', typeof window.cbdAIData !== 'undefined');
		
		// Check if Vue is loaded
		if (typeof Vue === 'undefined') {
			console.warn('CBD AI: Vue.js não foi carregado ainda');
			return false;
		}
		
		// Check if component is loaded
		if (typeof window.ChatbotCBD === 'undefined') {
			console.warn('CBD AI: Componente ChatbotCBD não foi carregado ainda');
			return false;
		}
		
		// Check if container exists
		const container = document.getElementById('chatbot-cbd-app');
		if (!container) {
			console.error('CBD AI: Container #chatbot-cbd-app não encontrado');
			return false;
		}
		
		// Check if already mounted
		if (container.__vue_app__) {
			console.warn('CBD AI: Componente já foi montado');
			return true;
		}
		
		const { createApp } = Vue;
		
		try {
			console.log('CBD AI: Criando aplicação Vue...');
			const app = createApp({
				components: {
					ChatbotCBD: window.ChatbotCBD
				},
				template: '<ChatbotCBD />'
			});
			
			console.log('CBD AI: Montando aplicação no container...');
			app.mount('#chatbot-cbd-app');
			console.log('CBD AI: ✅ ChatbotCBD montado com sucesso!');
			return true;
		} catch (error) {
			console.error('CBD AI: ❌ Erro ao montar aplicação Vue:', error);
			console.error('CBD AI: Mensagem:', error.message);
			console.error('CBD AI: Stack trace:', error.stack);
			return false;
		}
	}
	
	// Wait for everything to be ready
	function waitAndInit() {
		// Check if all dependencies are ready
		if (typeof Vue !== 'undefined' && typeof window.ChatbotCBD !== 'undefined') {
			// Small delay to ensure DOM is ready
			setTimeout(function() {
				if (!initChatbotCBD()) {
					console.error('CBD AI: Falha na inicialização');
				}
			}, 100);
		} else {
			// Retry after a short delay
			setTimeout(waitAndInit, 200);
		}
	}
	
	// Start initialization when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			console.log('CBD AI: DOM carregado, iniciando...');
			setTimeout(waitAndInit, 300);
		});
	} else {
		console.log('CBD AI: DOM já carregado, iniciando...');
		setTimeout(waitAndInit, 300);
	}
	
	// Also listen for script load events
	window.addEventListener('load', function() {
		console.log('CBD AI: Window load event, verificando novamente...');
		setTimeout(function() {
			if (typeof Vue !== 'undefined' && typeof window.ChatbotCBD !== 'undefined') {
				const container = document.getElementById('chatbot-cbd-app');
				if (container && !container.__vue_app__) {
					initChatbotCBD();
				}
			}
		}, 500);
	});

// Show affiliate CTA after user interaction
	// OCULTO: Código de monetização desativado
	/*
	let messageCount = 0;
	const ctaSection = document.getElementById('affiliate-cta-section');
	
	// Monitor chat messages
	const observer = new MutationObserver(function(mutations) {
		mutations.forEach(function(mutation) {
			if (mutation.addedNodes.length) {
				messageCount++;
				// Show CTA after 2 messages (user + AI response)
				if (messageCount >= 2 && ctaSection) {
					ctaSection.classList.remove('hidden');
					ctaSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
				}
			}
		});
	});
	
	// Observe chat container
	const chatContainer = document.getElementById('chatbot-cbd-app');
	if (chatContainer) {
		observer.observe(chatContainer, { childList: true, subtree: true });
	}
	*/
});
</script>

<?php
// Generate WebPage Schema for Chatbot
$webpage_schema = array(
	'@context' => 'https://schema.org',
	'@type' => 'WebPage',
	'name' => 'Chatbot Especialista em CBD - Assistente AI',
	'description' => 'Ferramenta de IA para obter respostas rápidas e precisas sobre dosagem, benefícios, segurança e legalidade do CBD em Portugal. Inclui informações validadas sobre CBD para cães e gatos.',
	'serviceType' => 'Conversational AI Assistant',
	'provider' => array(
		'@type' => 'Organization',
		'name' => get_bloginfo( 'name' ),
		'url' => home_url( '/' ),
	),
	'keywords' => 'chatbot cbd, dosagem cbd, legalidade cbd, cbd cães, cbd gatos, cbd portugal, assistente ai cbd',
	'url' => get_permalink(),
	'inLanguage' => 'pt-PT',
);

// Output Schema JSON-LD
echo '<script type="application/ld+json">' . "\n";
echo wp_json_encode( $webpage_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
echo "\n" . '</script>' . "\n";
?>

<?php
get_footer();
?>
