<?php
/**
 * Template Name: Gerador de Conteúdo
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

// Only allow logged-in users with edit_posts capability
if ( ! is_user_logged_in() || ! current_user_can( 'edit_posts' ) ) {
	wp_die( 'Você não tem permissão para acessar esta página.' );
}

get_header();
?>

<div class="content-area max-w-6xl mx-auto">
	<div class="bg-white rounded-lg shadow-md p-8">
		<header class="mb-8">
			<h1 class="text-3xl md:text-4xl font-bold mb-4">Gerador de Conteúdo com IA</h1>
			<p class="text-gray-600">
				Use a IA para gerar artigos, FAQs e guias sobre CBD para animais.
			</p>
		</header>
		
		<div id="content-generator-app"></div>
	</div>
</div>

<script type="module">
import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

// Simple content generator component
const ContentGenerator = {
	template: `
		<div class="content-generator">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
				<div class="card">
					<h3 class="text-xl font-bold mb-4">Gerar Conteúdo</h3>
					<div class="space-y-4">
						<div>
							<label class="block text-sm font-medium mb-2">Tipo de Conteúdo</label>
							<select v-model="contentType" class="input">
								<option value="article">Artigo</option>
								<option value="faq">FAQ</option>
								<option value="guide">Guia de Dosagem</option>
							</select>
						</div>
						<div>
							<label class="block text-sm font-medium mb-2">Tópico</label>
							<input type="text" v-model="topic" placeholder="Ex: Benefícios do CBD para cães" class="input" />
						</div>
						<div v-if="contentType === 'article' || contentType === 'guide'">
							<label class="block text-sm font-medium mb-2">Tipo de Animal</label>
							<select v-model="animalType" class="input">
								<option value="">Geral</option>
								<option value="cão">Cão</option>
								<option value="gato">Gato</option>
							</select>
						</div>
						<div v-if="contentType === 'article'">
							<label class="block text-sm font-medium mb-2">Número de Palavras</label>
							<input type="number" v-model.number="wordCount" min="300" max="3000" class="input" />
						</div>
						<button @click="generateContent" class="btn btn-primary w-full" :disabled="loading">
							{{ loading ? 'Gerando...' : 'Gerar Conteúdo' }}
						</button>
					</div>
				</div>
				
				<div class="card">
					<h3 class="text-xl font-bold mb-4">Resultado</h3>
					<div v-if="loading" class="text-center py-8">
						<div class="spinner mx-auto"></div>
						<p class="mt-4 text-gray-600">Gerando conteúdo...</p>
					</div>
					<div v-else-if="generatedContent" class="space-y-4">
						<div v-if="generatedContent.title">
							<label class="block text-sm font-medium mb-2">Título</label>
							<input type="text" :value="generatedContent.title" class="input" readonly />
						</div>
						<div>
							<label class="block text-sm font-medium mb-2">Conteúdo</label>
							<textarea :value="generatedContent.content || generatedContent.faqs" rows="15" class="input" readonly></textarea>
						</div>
						<div v-if="generatedContent.meta_description">
							<label class="block text-sm font-medium mb-2">Meta Description</label>
							<textarea :value="generatedContent.meta_description" rows="2" class="input" readonly></textarea>
						</div>
						<button @click="copyToClipboard" class="btn btn-secondary w-full">
							Copiar Conteúdo
						</button>
					</div>
					<div v-else class="text-center py-8 text-gray-500">
						<p>Preencha os campos e clique em "Gerar Conteúdo"</p>
					</div>
				</div>
			</div>
		</div>
	`,
	data() {
		return {
			contentType: 'article',
			topic: '',
			animalType: '',
			wordCount: 1000,
			generatedContent: null,
			loading: false,
			apiUrl: window.cbdAIData?.apiUrl || '/wp-json/cbd-ai/v1/',
			nonce: window.cbdAIData?.nonce || ''
		}
	},
	methods: {
		async generateContent() {
			if (!this.topic.trim()) {
				alert('Por favor, insira um tópico');
				return;
			}
			
			this.loading = true;
			this.generatedContent = null;
			
			try {
				const response = await fetch(this.apiUrl + 'generate-content', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-WP-Nonce': this.nonce
					},
					body: JSON.stringify({
						type: this.contentType,
						topic: this.topic,
						animal_type: this.animalType || '',
						word_count: this.wordCount
					})
				});
				
				const data = await response.json();
				
				if (response.ok) {
					this.generatedContent = data;
				} else {
					alert('Erro ao gerar conteúdo: ' + (data.message || 'Erro desconhecido'));
				}
			} catch (error) {
				if (typeof window.CBDDebug !== 'undefined') {
					window.CBDDebug.error('Error:', error);
				}
				alert('Erro ao gerar conteúdo. Por favor, tente novamente.');
			} finally {
				this.loading = false;
			}
		},
		copyToClipboard() {
			const content = this.generatedContent.content || this.generatedContent.faqs || '';
			navigator.clipboard.writeText(content).then(() => {
				alert('Conteúdo copiado para a área de transferência!');
			});
		}
	}
};

createApp({
	components: {
		ContentGenerator
	}
}).mount('#content-generator-app');
</script>

<?php
get_footer();

