/**
 * Legislation Alert Component (Vue 3 - CDN Version)
 */
window.LegislationAlert = {
  template: `
    <div class="legislation-alerts">
      <div v-if="loading" class="text-center py-8">
        <div class="spinner mx-auto"></div>
        <p class="mt-4 text-gray-600">Carregando alertas...</p>
      </div>
      
      <div v-else-if="alerts.length === 0" class="text-center py-8">
        <p class="text-gray-600">Nenhum alerta legislativo encontrado no momento.</p>
      </div>
      
      <div v-else class="space-y-4">
        <div 
          v-for="alert in alerts" 
          :key="alert.id"
          class="card border-l-4"
          :class="alert.is_new ? 'border-red-500' : 'border-yellow-500'"
        >
          <div class="flex items-start justify-between mb-2">
            <h3 class="text-xl font-bold">{{ alert.title }}</h3>
            <span 
              class="alert-badge"
              :class="alert.is_new ? 'new' : 'updated'"
            >
              {{ alert.is_new ? 'Novo' : 'Atualizado' }}
            </span>
          </div>
          
          <div class="text-sm text-gray-600 mb-3">
            <span class="font-medium">Fonte:</span> {{ alert.source }}
            <span class="mx-2">•</span>
            <span>{{ alert.date }}</span>
          </div>
          
          <div class="text-gray-700 mb-4" v-html="alert.excerpt"></div>
          
          <div class="flex gap-2">
            <a 
              :href="alert.url" 
              class="btn btn-primary text-sm"
            >
              Ler mais
            </a>
            <a 
              v-if="alert.source_url"
              :href="alert.source_url" 
              target="_blank"
              rel="noopener"
              class="btn btn-secondary text-sm"
            >
              Ver fonte original
            </a>
          </div>
        </div>
      </div>
      
      <div class="mt-8 p-4 bg-blue-50 rounded-lg">
        <h4 class="font-bold mb-2">Sobre o Monitor</h4>
        <p class="text-sm text-gray-700">
          Este monitor verifica automaticamente alterações na legislação portuguesa e europeia 
          relacionadas a CBD e cannabis medicinal. As fontes monitoradas incluem Infarmed, 
          Diário da República e legislação da UE.
        </p>
      </div>
    </div>
  `,
  data() {
    return {
      alerts: [],
      loading: true,
      apiUrl: window.cbdAIData?.apiUrl || '/wp-json/cbd-ai/v1/',
      nonce: window.cbdAIData?.nonce || ''
    }
  },
  async mounted() {
    await this.fetchAlerts();
  },
  methods: {
    async fetchAlerts() {
      this.loading = true;
      
      try {
        const response = await fetch(this.apiUrl + 'legislation-alerts?limit=10', {
          headers: {
            'X-WP-Nonce': this.nonce
          }
        });
        
        const data = await response.json();
        this.alerts = data || [];
      } catch (error) {
        console.error('Error fetching alerts:', error);
        this.alerts = [];
      } finally {
        this.loading = false;
      }
    }
  }
};

// Also make available as const for compatibility
const LegislationAlert = window.LegislationAlert;

