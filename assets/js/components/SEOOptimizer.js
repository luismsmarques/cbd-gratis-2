/**
 * SEO Optimizer Component (Vue 3 - CDN Version)
 */
window.SEOOptimizer = {
  template: `
    <div class="seo-optimizer">
      <div class="mb-6">
        <h3 class="text-xl font-bold mb-4">Otimizador SEO de Conteúdo</h3>
        <p class="text-gray-600">
          Analise e otimize seu conteúdo sobre CBD para melhorar o SEO e aumentar o tráfego orgânico.
        </p>
      </div>
      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Input Section -->
        <div class="card">
          <h4 class="text-lg font-bold mb-4">Seu Conteúdo</h4>
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium mb-2">Título</label>
              <input 
                type="text" 
                v-model="title" 
                placeholder="Título do artigo..."
                class="input"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-2">Conteúdo</label>
              <textarea 
                v-model="content" 
                rows="10"
                placeholder="Cole ou digite o conteúdo aqui..."
                class="input"
              ></textarea>
              <p class="text-xs text-gray-500 mt-1">
                {{ wordCount }} palavras
              </p>
            </div>
            <button 
              @click="analyzeContent" 
              class="btn btn-primary w-full"
              :disabled="loading || !content.trim()"
            >
              {{ loading ? 'Analisando...' : 'Analisar Conteúdo' }}
            </button>
          </div>
        </div>
        
        <!-- Results Section -->
        <div class="card">
          <h4 class="text-lg font-bold mb-4">Análise SEO</h4>
          
          <div v-if="!analysis && !loading" class="text-center py-8 text-gray-500">
            <p>Digite seu conteúdo e clique em "Analisar Conteúdo" para ver os resultados.</p>
          </div>
          
          <div v-if="loading" class="text-center py-8">
            <div class="spinner mx-auto"></div>
            <p class="mt-4 text-gray-600">Analisando conteúdo...</p>
          </div>
          
          <div v-if="analysis && !loading" class="space-y-6">
            <!-- SEO Score -->
            <div>
              <div class="flex items-center justify-between mb-2">
                <span class="font-medium">Pontuação SEO</span>
                <span 
                  class="seo-score"
                  :class="getScoreClass(analysis.score)"
                >
                  {{ analysis.score }}/100
                </span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div 
                  class="h-2 rounded-full transition-all"
                  :class="getScoreColorClass(analysis.score)"
                  :style="{ width: analysis.score + '%' }"
                ></div>
              </div>
            </div>
            
            <!-- Keyword Density -->
            <div>
              <h5 class="font-bold mb-3">Densidade de Palavras-chave</h5>
              <div class="space-y-2">
                <div 
                  v-for="(data, keyword) in analysis.keyword_density" 
                  :key="keyword"
                  class="flex items-center justify-between text-sm p-2 bg-gray-50 rounded"
                >
                  <span>{{ keyword }}</span>
                  <div class="flex items-center gap-2">
                    <span class="font-medium">{{ data.density }}%</span>
                    <span 
                      class="text-xs px-2 py-1 rounded"
                      :class="getDensityBadgeClass(data.status)"
                    >
                      {{ getDensityStatusText(data.status) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Suggestions -->
            <div v-if="suggestions && suggestions.length > 0">
              <h5 class="font-bold mb-3">Sugestões de Melhoria</h5>
              <ul class="space-y-2">
                <li 
                  v-for="(suggestion, index) in suggestions" 
                  :key="index"
                  class="text-sm p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded"
                >
                  {{ suggestion }}
                </li>
              </ul>
            </div>
            
            <!-- Meta Description -->
            <div v-if="metaDescription">
              <h5 class="font-bold mb-2">Meta Description Sugerida</h5>
              <div class="p-3 bg-blue-50 rounded text-sm">
                {{ metaDescription }}
              </div>
              <p class="text-xs text-gray-500 mt-1">
                {{ metaDescription.length }} caracteres
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  `,
  data() {
    return {
      title: '',
      content: '',
      analysis: null,
      suggestions: [],
      metaDescription: '',
      loading: false,
      apiUrl: window.cbdAIData?.apiUrl || '/wp-json/cbd-ai/v1/',
      nonce: window.cbdAIData?.nonce || ''
    }
  },
  computed: {
    wordCount() {
      return this.content.trim() ? this.content.trim().split(/\s+/).length : 0;
    }
  },
  methods: {
    async analyzeContent() {
      if (!this.content.trim()) {
        return;
      }
      
      this.loading = true;
      this.analysis = null;
      this.suggestions = [];
      this.metaDescription = '';
      
      try {
        const response = await fetch(this.apiUrl + 'optimize', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': this.nonce
          },
          body: JSON.stringify({
            content: this.content,
            title: this.title
          })
        });
        
        const data = await response.json();
        
        if (data.analysis) {
          this.analysis = data.analysis;
        }
        
        if (data.suggestions) {
          this.suggestions = data.suggestions;
        }
        
        if (data.meta_description) {
          this.metaDescription = data.meta_description;
        }
      } catch (error) {
        if (typeof window.CBDDebug !== 'undefined') {
          window.CBDDebug.error('Error analyzing content:', error);
        }
        alert('Erro ao analisar conteúdo. Por favor, tente novamente.');
      } finally {
        this.loading = false;
      }
    },
    getScoreClass(score) {
      if (score >= 80) return 'excellent';
      if (score >= 60) return 'good';
      if (score >= 40) return 'fair';
      return 'poor';
    },
    getScoreColorClass(score) {
      if (score >= 80) return 'bg-green-500';
      if (score >= 60) return 'bg-blue-500';
      if (score >= 40) return 'bg-yellow-500';
      return 'bg-red-500';
    },
    getDensityBadgeClass(status) {
      const classes = {
        optimal: 'bg-green-100 text-green-800',
        too_high: 'bg-red-100 text-red-800',
        low: 'bg-yellow-100 text-yellow-800',
        missing: 'bg-gray-100 text-gray-800'
      };
      return classes[status] || classes.missing;
    },
    getDensityStatusText(status) {
      const texts = {
        optimal: 'Ótimo',
        too_high: 'Alto',
        low: 'Baixo',
        missing: 'Ausente'
      };
      return texts[status] || 'Desconhecido';
    }
  }
};

// Also make available as const for compatibility
const SEOOptimizer = window.SEOOptimizer;

