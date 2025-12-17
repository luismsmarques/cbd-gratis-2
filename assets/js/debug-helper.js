/**
 * Debug Helper - Remove console.log em produção
 * 
 * Wrapper para console.log que só funciona em ambiente de desenvolvimento
 * ou quando ?debug=true está na URL
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

(function() {
	'use strict';
	
	// Detectar ambiente de desenvolvimento
	const isDevelopment = (
		window.location.hostname === 'localhost' ||
		window.location.hostname === '127.0.0.1' ||
		window.location.hostname.includes('.local') ||
		window.location.hostname.includes('.test') ||
		window.location.search.includes('debug=true')
	);
	
	/**
	 * CBD Debug Helper
	 * Substitui console.log/warn em produção
	 */
	window.CBDDebug = {
		enabled: isDevelopment,
		
		/**
		 * Log de debug (só em desenvolvimento)
		 */
		log: function(...args) {
			if (this.enabled) {
				console.log('[CBD Debug]', ...args);
			}
		},
		
		/**
		 * Warning (só em desenvolvimento)
		 */
		warn: function(...args) {
			if (this.enabled) {
				console.warn('[CBD Warn]', ...args);
			}
		},
		
		/**
		 * Error (sempre loga - crítico)
		 */
		error: function(...args) {
			// Erros sempre são logados
			console.error('[CBD Error]', ...args);
		},
		
		/**
		 * Info (só em desenvolvimento)
		 */
		info: function(...args) {
			if (this.enabled) {
				console.info('[CBD Info]', ...args);
			}
		},
		
		/**
		 * Verificar se debug está ativo
		 */
		isEnabled: function() {
			return this.enabled;
		}
	};
	
	// Log inicial apenas em desenvolvimento
	if (isDevelopment) {
		console.log('[CBD Debug] Debug helper carregado - modo desenvolvimento ativo');
	}
})();

