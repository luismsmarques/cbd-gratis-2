/**
 * ActionCard Component - Vue 3
 * 
 * Card de Navegação para Hub de Animais e Homepage
 * Props: titulo, descricao, icone, url, cor
 * 
 * @package CBD_AI_Theme
 * @since 1.0.0
 */
window.ActionCard = {
	props: {
		titulo: {
			type: String,
			required: true
		},
		descricao: {
			type: String,
			default: ''
		},
		icone: {
			type: String,
			default: '📋'
		},
		url: {
			type: String,
			default: '#'
		},
		cor: {
			type: String,
			default: 'primary',
			validator: (value) => ['primary', 'teal', 'success', 'warning', 'info'].includes(value)
		},
		tamanho: {
			type: String,
			default: 'medium',
			validator: (value) => ['small', 'medium', 'large'].includes(value)
		}
	},
	computed: {
		cardClass() {
			return `mui-action-card mui-action-card-${this.cor} mui-action-card-${this.tamanho}`;
		},
		iconSize() {
			const sizes = {
				small: '2rem',
				medium: '3rem',
				large: '4rem'
			};
			return sizes[this.tamanho] || '3rem';
		}
	},
	template: `
		<a :href="url" :class="['mui-card', 'mui-card-elevated', cardClass]" style="text-decoration: none; display: block; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid var(--mui-gray-200);">
			<div class="mui-card-content" style="text-align: center; padding: 24px;">
				<div class="mui-action-card-icon" :style="{ fontSize: iconSize, marginBottom: '16px' }">
					{{ icone }}
				</div>
				<h3 class="mui-typography-h6" style="margin: 0 0 8px 0; color: var(--mui-gray-900);">
					{{ titulo }}
				</h3>
				<p v-if="descricao" class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">
					{{ descricao }}
				</p>
				<div class="mui-action-card-action" style="margin-top: 16px;">
					<span class="mui-button mui-button-text" style="color: var(--mui-blue-primary);">
						Explorar
						<svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-left: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
						</svg>
					</span>
				</div>
			</div>
		</a>
	`,
	mounted() {
		// Add hover effect styles dynamically
		const style = document.createElement('style');
		style.textContent = `
			.mui-action-card {
				border: 1px solid var(--mui-gray-200) !important;
			}
			.mui-action-card:hover {
				transform: translateY(-4px);
			}
			.mui-action-card-primary:hover {
				border-color: var(--mui-blue-primary) !important;
			}
			.mui-action-card-teal:hover {
				border-color: var(--mui-teal-primary) !important;
			}
			.mui-action-card-success:hover {
				border-color: var(--mui-success) !important;
			}
			.mui-action-card-info:hover {
				border-color: var(--mui-info) !important;
			}
		`;
		if (!document.getElementById('mui-action-card-styles')) {
			style.id = 'mui-action-card-styles';
			document.head.appendChild(style);
		}
	}
};

