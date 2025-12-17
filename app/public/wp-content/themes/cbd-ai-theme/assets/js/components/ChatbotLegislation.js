/**
 * Legislation Chatbot Component (Vue 3 - CDN Version)
 * Chatbot especializado em legislação portuguesa sobre CBD
 */
window.ChatbotLegislation = {
  template: `
    <div class="chatbot-container legislation-chatbot">
      <!-- Chat Messages Area -->
      <div class="chat-messages" ref="messagesContainer">
        <!-- Initial Welcome Message -->
        <div v-if="messages.length === 1" class="welcome-message">
          <div class="assistant-message">
            <div class="message-avatar">
              <span class="avatar-icon">⚖️</span>
            </div>
            <div class="message-content">
              <div class="message-header">
                <span class="assistant-name">IA Especialista em Legislação</span>
                <span class="message-time">{{ getCurrentTime() }}</span>
              </div>
              <div class="message-text">
                Olá! Sou a sua IA Especialista em Legislação Portuguesa sobre CBD e Cânhamo. Posso ajudar a entender a legislação atual, requisitos legais, regulamentações do Infarmed, decretos do Diário da República e legislação da UE. Qual é a sua dúvida sobre legislação?
              </div>
            </div>
          </div>
          
          <!-- Prompt Starters -->
          <div class="prompt-starters">
            <h4 class="prompt-title">💡 Sugestões de Perguntas:</h4>
            <div class="prompt-buttons">
              <button 
                v-for="(prompt, index) in promptStarters" 
                :key="index"
                @click="sendPrompt(prompt)"
                class="prompt-btn"
                type="button"
              >
                {{ prompt }}
              </button>
            </div>
          </div>
        </div>
        
        <!-- Chat Messages -->
        <div 
          v-for="(message, index) in messages.slice(1)" 
          :key="index"
          :class="['chat-message-wrapper', message.type === 'user' ? 'user-message' : 'assistant-message']"
        >
          <div v-if="message.type === 'assistant'" class="message-avatar">
            <span class="avatar-icon">⚖️</span>
          </div>
          
          <div class="message-bubble" :class="message.type === 'user' ? 'user-bubble' : 'assistant-bubble'">
            <div v-if="message.type === 'assistant'" class="message-header">
              <span class="assistant-name">IA Especialista em Legislação</span>
              <span class="message-time">{{ getCurrentTime() }}</span>
            </div>
            <div class="message-text formatted-text" v-html="formatMessage(message.text)"></div>
            
            <!-- Legal Info Card -->
            <div v-if="message.legal_info" class="legal-info-card">
              <div class="legal-info-header">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <strong>Informação Legal</strong>
              </div>
              <div class="legal-info-content">
                <p v-if="message.legal_info.source" class="legal-source">
                  <strong>Fonte:</strong> {{ message.legal_info.source }}
                </p>
                <p v-if="message.legal_info.last_update" class="legal-update">
                  <strong>Última atualização:</strong> {{ message.legal_info.last_update }}
                </p>
              </div>
            </div>
            
            <!-- Related Alerts -->
            <div v-if="message.related_alerts && message.related_alerts.length > 0" class="related-alerts">
              <div class="related-header">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <strong>Alertas Legislativos Relacionados:</strong>
              </div>
              <ul class="related-list">
                <li v-for="alert in message.related_alerts" :key="alert.url">
                  <a :href="alert.url" class="related-link">
                    <span class="alert-title">{{ alert.title }}</span>
                    <span class="alert-date">{{ alert.date }}</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          
          <div v-if="message.type === 'user'" class="message-avatar user-avatar">
            <span class="avatar-icon">👤</span>
          </div>
        </div>
        
        <!-- Loading Indicator -->
        <div v-if="loading" class="assistant-message loading-message">
          <div class="message-avatar">
            <span class="avatar-icon">⚖️</span>
          </div>
          <div class="message-bubble assistant-bubble">
            <div class="loading-dots">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <span class="loading-text">Analisando legislação...</span>
          </div>
        </div>
      </div>
      
      <!-- Input Form -->
      <form @submit.prevent="sendMessage" class="chat-input-form">
        <!-- Main Input -->
        <div class="input-wrapper">
          <input 
            type="text" 
            v-model="currentMessage" 
            @keyup.enter="sendMessage"
            placeholder="Digite sua pergunta sobre legislação portuguesa sobre CBD..."
            class="chat-input"
            :disabled="loading"
            ref="chatInput"
          />
          <button 
            type="submit" 
            class="send-button"
            :disabled="loading || !currentMessage.trim()"
            :class="{ 'disabled': loading || !currentMessage.trim() }"
          >
            <svg v-if="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
            <div v-else class="spinner-small"></div>
          </button>
        </div>
        
        <!-- Disclaimer -->
        <p class="input-disclaimer">
          ⚠️ <strong>Importante:</strong> As informações fornecidas são baseadas na legislação atual e podem estar sujeitas a alterações. Sempre consulte fontes oficiais (Infarmed, Diário da República) para informações precisas e atualizadas.
        </p>
      </form>
    </div>
  `,
  data() {
    return {
      messages: [
        {
          type: 'assistant',
          text: ''
        }
      ],
      currentMessage: '',
      loading: false,
      apiUrl: window.cbdAIData?.apiUrl || '/wp-json/cbd-ai/v1/',
      nonce: window.cbdAIData?.nonce || '',
      promptStarters: [
        'O CBD é legal em Portugal?',
        'Quais são os requisitos para comercializar CBD?',
        'Preciso de receita médica para comprar CBD?',
        'O que diz a legislação europeia sobre CBD?'
      ]
    }
  },
  methods: {
    async sendMessage() {
      if (!this.currentMessage.trim() || this.loading) {
        return;
      }
      
      const userMessage = this.currentMessage.trim();
      this.currentMessage = '';
      
      // Add user message
      this.messages.push({
        type: 'user',
        text: userMessage
      });
      
      this.loading = true;
      this.scrollToBottom();
      
      try {
        const response = await fetch(this.apiUrl + 'legislation-chatbot', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': this.nonce
          },
          body: JSON.stringify({
            question: userMessage
          })
        });
        
        const data = await response.json();
        
        if (data.success) {
          this.messages.push({
            type: 'assistant',
            text: data.message,
            legal_info: data.legal_info,
            related_alerts: data.related_alerts
          });
        } else {
          this.messages.push({
            type: 'assistant',
            text: data.message || 'Desculpe, ocorreu um erro ao processar sua pergunta.'
          });
        }
      } catch (error) {
        console.error('Error:', error);
        this.messages.push({
          type: 'assistant',
          text: 'Desculpe, ocorreu um erro de conexão. Por favor, tente novamente.'
        });
      } finally {
        this.loading = false;
        this.scrollToBottom();
        this.$nextTick(() => {
          if (this.$refs.chatInput) {
            this.$refs.chatInput.focus();
          }
        });
      }
    },
    sendPrompt(prompt) {
      this.currentMessage = prompt;
      this.sendMessage();
    },
    scrollToBottom() {
      this.$nextTick(() => {
        if (this.$refs.messagesContainer) {
          this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
        }
      });
    },
    getCurrentTime() {
      const now = new Date();
      return now.toLocaleTimeString('pt-PT', { hour: '2-digit', minute: '2-digit' });
    },
    formatMessage(text) {
      // Use shared formatter if available, otherwise use local implementation
      if (typeof window.CBDChatbotFormatter !== 'undefined' && window.CBDChatbotFormatter.format) {
        return window.CBDChatbotFormatter.format(text);
      }
      
      // Fallback to local implementation
      if (!text || typeof text !== 'string') {
        return '';
      }
      
      let formatted = text;
      const div = document.createElement('div');
      div.textContent = formatted;
      formatted = div.innerHTML;
      
      const lines = formatted.split('\n');
      const result = [];
      let inList = false;
      let listType = null;
      let listItems = [];
      
      for (let i = 0; i < lines.length; i++) {
        const line = lines[i].trim();
        
        if (!line) {
          if (inList) {
            const tag = listType === 'ol' ? 'ol' : 'ul';
            result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
            listItems = [];
            inList = false;
            listType = null;
          }
          continue;
        }
        
        const numberedMatch = line.match(/^(\d+)\.\s+(.+)$/);
        if (numberedMatch) {
          if (!inList || listType !== 'ol') {
            if (inList) {
              const tag = listType === 'ol' ? 'ol' : 'ul';
              result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
              listItems = [];
            }
            inList = true;
            listType = 'ol';
          }
          listItems.push(`<li>${numberedMatch[2]}</li>`);
          continue;
        }
        
        const bulletMatch = line.match(/^[\*\-\+]\s+(.+)$/);
        if (bulletMatch) {
          if (!inList || listType !== 'ul') {
            if (inList) {
              const tag = listType === 'ol' ? 'ol' : 'ul';
              result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
              listItems = [];
            }
            inList = true;
            listType = 'ul';
          }
          listItems.push(`<li>${bulletMatch[1]}</li>`);
          continue;
        }
        
        if (inList) {
          const tag = listType === 'ol' ? 'ol' : 'ul';
          result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
          listItems = [];
          inList = false;
          listType = null;
        }
        
        let processedLine = line;
        processedLine = processedLine.replace(/\*\*([^*]+?)\*\*/g, '<strong>$1</strong>');
        
        if (processedLine.match(/^###\s+/)) {
          processedLine = processedLine.replace(/^###\s+(.+)$/, '<h3>$1</h3>');
          result.push(processedLine);
        } else if (processedLine.match(/^##\s+/)) {
          processedLine = processedLine.replace(/^##\s+(.+)$/, '<h2>$1</h2>');
          result.push(processedLine);
        } else if (processedLine.match(/^#\s+/)) {
          processedLine = processedLine.replace(/^#\s+(.+)$/, '<h2>$1</h2>');
          result.push(processedLine);
        } else {
          result.push(`<p>${processedLine}</p>`);
        }
      }
      
      if (inList) {
        const tag = listType === 'ol' ? 'ol' : 'ul';
        result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
      }
      
      return result.join('');
    }
  },
  mounted() {
    this.scrollToBottom();
    this.$nextTick(() => {
      if (this.$refs.chatInput) {
        this.$refs.chatInput.focus();
      }
    });
  }
};

// Also make available as const for compatibility
const ChatbotLegislation = window.ChatbotLegislation;

