/**
 * StatusCard Component - Vue 3
 * 
 * Card de Alerta/Status para Monitor e Homepage
 * Props: status, titulo, dataAtualizacao
 * 
 * @package CBD_AI_Theme
 * @since 1.0.0
 */
window.StatusCard = {
	props: {
		status: {
			type: String,
			required: true,
			validator: (value) => ['success', 'warning', 'error', 'info'].includes(value)
		},
		titulo: {
			type: String,
			required: true
		},
		dataAtualizacao: {
			type: String,
			default: ''
		},
		mensagem: {
			type: String,
			default: ''
		}
	},
	computed: {
		statusClass() {
			return `mui-alert-${this.status}`;
		},
		statusIcon() {
			const icons = {
				success: '✓',
				warning: '⚠',
				error: '✕',
				info: 'ℹ'
			};
			return icons[this.status] || 'ℹ';
		},
		statusColor() {
			const colors = {
				success: 'var(--mui-success)',
				warning: 'var(--mui-warning)',
				error: 'var(--mui-error)',
				info: 'var(--mui-info)'
			};
			return colors[this.status] || 'var(--mui-info)';
		}
	},
	template: `
		<div class="mui-card mui-card-elevated">
			<div class="mui-card-content">
				<div :class="['mui-alert', statusClass]">
					<div class="mui-alert-icon" :style="{ color: statusColor }">
						{{ statusIcon }}
					</div>
					<div class="mui-alert-message">
						<h3 class="mui-typography-h6" style="margin: 0 0 8px 0; font-weight: 600;">
							{{ titulo }}
						</h3>
						<p v-if="mensagem" class="mui-typography-body2" style="margin: 0 0 4px 0;">
							{{ mensagem }}
						</p>
						<p v-if="dataAtualizacao" class="mui-typography-caption" style="margin: 0;">
							Última atualização: {{ dataAtualizacao }}
						</p>
					</div>
				</div>
			</div>
		</div>
	`
};

