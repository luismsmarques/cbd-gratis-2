/**
 * Vue Error Handler - Tratamento de erros global para componentes Vue
 * 
 * Helper centralizado para inicialização segura de componentes Vue
 * com fallback UI em caso de erro
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

(function() {
	'use strict';
	
	/**
	 * CBD Vue Helper
	 * Gerencia inicialização de componentes Vue com error handling
	 */
	window.CBDVueHelper = {
		/**
		 * Inicializa componente Vue com error handling completo
		 * 
		 * @param {string} componentName - Nome do componente (ex: 'StatusCard')
		 * @param {string} containerId - ID do container HTML (ex: 'status-card-app')
		 * @param {object} componentConfig - Configuração do componente Vue (data, template, etc)
		 * @returns {boolean} - true se inicializado com sucesso, false caso contrário
		 */
		initComponent: function(componentName, containerId, componentConfig) {
			try {
				// Verificar se Vue está disponível
				if (typeof Vue === 'undefined') {
					throw new Error('Vue.js não está carregado. Verifique se o script foi carregado corretamente.');
				}
				
				// Verificar se componente está disponível
				if (typeof window[componentName] === 'undefined') {
					throw new Error(`Componente ${componentName} não está disponível. Verifique se o script do componente foi carregado.`);
				}
				
				// Verificar se container existe
				const container = document.getElementById(containerId);
				if (!container) {
					throw new Error(`Container #${containerId} não encontrado no DOM.`);
				}
				
				// Verificar se já foi montado
				if (container.__vue_app__) {
					if (typeof window.CBDDebug !== 'undefined' && window.CBDDebug.isEnabled()) {
						window.CBDDebug.warn(`Componente ${componentName} já foi montado no container #${containerId}`);
					}
					return true;
				}
				
				// Criar e montar aplicação Vue
				const { createApp } = Vue;
				
				// Preparar configuração do componente
				const appConfig = {
					components: {
						[componentName]: window[componentName]
					},
					...componentConfig
				};
				
				// Criar aplicação
				const app = createApp(appConfig);
				
				// Montar aplicação
				app.mount(`#${containerId}`);
				
				// Log de sucesso apenas em desenvolvimento
				if (typeof window.CBDDebug !== 'undefined' && window.CBDDebug.isEnabled()) {
					window.CBDDebug.log(`Componente ${componentName} montado com sucesso em #${containerId}`);
				}
				
				return true;
				
			} catch (error) {
				// Sempre logar erros (crítico)
				if (typeof window.CBDDebug !== 'undefined') {
					window.CBDDebug.error(`Erro ao inicializar ${componentName}:`, error);
				} else {
					console.error(`[CBD Error] Erro ao inicializar ${componentName}:`, error);
				}
				
				// Mostrar fallback UI
				this.showFallbackUI(containerId, componentName, error);
				
				return false;
			}
		},
		
		/**
		 * Mostra UI de fallback quando componente falha
		 * 
		 * @param {string} containerId - ID do container
		 * @param {string} componentName - Nome do componente que falhou
		 * @param {Error} error - Objeto de erro
		 */
		showFallbackUI: function(containerId, componentName, error) {
			const container = document.getElementById(containerId);
			if (!container) {
				return;
			}
			
			// Criar HTML de fallback usando classes MUI
			const fallbackHTML = `
				<div class="mui-card mui-card-elevated">
					<div class="mui-card-content">
						<div class="mui-alert mui-alert-error">
							<div class="mui-alert-icon" style="font-size: 1.5rem;">⚠</div>
							<div class="mui-alert-message">
								<h3 class="mui-typography-h6" style="margin: 0 0 8px 0; font-weight: 600;">
									Erro ao carregar componente
								</h3>
								<p class="mui-typography-body2" style="margin: 0 0 8px 0;">
									Não foi possível carregar o componente <strong>${componentName}</strong>. 
									Por favor, recarregue a página ou entre em contato com o suporte se o problema persistir.
								</p>
								<p class="mui-typography-caption" style="margin: 0;">
									<button 
										onclick="window.location.reload()" 
										class="mui-button mui-button-text mui-button-small"
										style="padding: 4px 8px; margin-top: 8px;"
									>
										Recarregar página
									</button>
								</p>
							</div>
						</div>
					</div>
				</div>
			`;
			
			// Inserir fallback no container
			container.innerHTML = fallbackHTML;
		},
		
		/**
		 * Verifica se todas as dependências estão disponíveis
		 * 
		 * @param {string} componentName - Nome do componente
		 * @returns {object} - Objeto com status de cada dependência
		 */
		checkDependencies: function(componentName) {
			return {
				vue: typeof Vue !== 'undefined',
				component: typeof window[componentName] !== 'undefined',
				cbdData: typeof window.cbdAIData !== 'undefined'
			};
		}
	};
	
	// Log inicial apenas em desenvolvimento
	if (typeof window.CBDDebug !== 'undefined' && window.CBDDebug.isEnabled()) {
		window.CBDDebug.log('Vue Error Handler carregado');
	}
})();

