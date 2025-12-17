/**
 * Chatbot Component for Humans (Vue 3 - CDN Version)
 * Design profissional focado em confiança e conversão
 */
window.ChatbotHumans = {
  template: `
    <div class="chatbot-container">
      <!-- Chat Messages Area -->
      <div class="chat-messages" ref="messagesContainer">
        <!-- Initial Welcome Message -->
        <div v-if="messages.length === 0" class="welcome-message">
          <div class="assistant-message">
            <div class="message-avatar">
              <span class="avatar-icon">🤖</span>
            </div>
            <div class="message-content">
              <div class="message-header">
                <span class="assistant-name">IA Especialista CBD</span>
                <span class="message-time">{{ getCurrentTime() }}</span>
              </div>
              <div class="message-text">
                Olá! Sou a sua IA Especialista em CBD para Humanos. Posso ajudar com questões sobre dosagem, benefícios, segurança, legalidade ou interações medicamentosas do CBD. Qual é a sua primeira pergunta?
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
          v-for="(message, index) in messages" 
          :key="index"
          :class="['chat-message-wrapper', message.type === 'user' ? 'user-message' : 'assistant-message']"
        >
          <div v-if="message.type === 'assistant'" class="message-avatar">
            <span class="avatar-icon">🤖</span>
          </div>
          
          <div class="message-bubble" :class="message.type === 'user' ? 'user-bubble' : 'assistant-bubble'">
            <div v-if="message.type === 'assistant'" class="message-header">
              <span class="assistant-name">IA Especialista CBD</span>
              <span class="message-time">{{ getCurrentTime() }}</span>
            </div>
            <div class="message-text formatted-text" v-html="formatMessage(message.text)"></div>
            
            <!-- Dosage Info -->
            <div v-if="message.dosage_info" class="dosage-card">
              <div class="dosage-header">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <strong>Informação de Dosagem</strong>
              </div>
              <p class="dosage-text">{{ message.dosage_info.recommendation }}</p>
            </div>
            
            <!-- Related Articles -->
            <div v-if="message.related_articles && message.related_articles.length > 0" class="related-articles">
              <div class="related-header">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <strong>Artigos Relacionados:</strong>
              </div>
              <ul class="related-list">
                <li v-for="article in message.related_articles" :key="article.url">
                  <a :href="article.url" class="related-link">
                    {{ article.title }}
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
            <span class="avatar-icon">🤖</span>
          </div>
          <div class="message-bubble assistant-bubble">
            <div class="loading-dots">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <span class="loading-text">Analisando sua pergunta...</span>
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
            placeholder="Digite sua pergunta sobre CBD para humanos..."
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
          ⚠️ <strong>Importante:</strong> Este chatbot fornece informações gerais. Sempre consulte um médico antes de usar CBD.
        </p>
      </form>
    </div>
  `,
  data() {
    return {
      messages: [], // Start empty, initial message is shown via v-if in template
      currentMessage: '',
      weight: null,
      condition: '',
      loading: false,
      apiUrl: window.cbdAIData?.apiUrl || '/wp-json/cbd-ai/v1/',
      nonce: window.cbdAIData?.nonce || '',
      promptStarters: [
        'Qual é a dose recomendada de CBD para começar?',
        'O CBD é seguro para uso humano?',
        'Quais são as interações medicamentosas do CBD?',
        'O CBD é legal em Portugal para uso pessoal?'
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
        console.log('CBD AI: Enviando mensagem:', userMessage);
        console.log('CBD AI: API URL:', this.apiUrl + 'chatbot-humans');
        console.log('CBD AI: Nonce:', this.nonce ? 'Presente' : 'Ausente');
        
        const response = await fetch(this.apiUrl + 'chatbot-humans', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': this.nonce
          },
          body: JSON.stringify({
            question: userMessage,
            weight: this.weight || 0,
            condition: this.condition || ''
          })
        });
        
        console.log('CBD AI: Resposta recebida, status:', response.status);
        
        // Check if response is OK
        if (!response.ok) {
          // Try to get error message from response
          let errorMessage = 'Erro ao processar sua pergunta.';
          try {
            const errorData = await response.json();
            if (errorData.message) {
              errorMessage = errorData.message;
            } else if (errorData.code) {
              errorMessage = `Erro: ${errorData.code}. Tente novamente.`;
            }
          } catch (e) {
            // Response is not JSON (probably HTML error page)
            if (response.status === 500 || response.status === 503) {
              errorMessage = 'Erro no servidor. Por favor, tente novamente em alguns instantes ou verifique se a API Key está configurada corretamente.';
            } else {
              errorMessage = `Erro HTTP ${response.status}. Tente novamente.`;
            }
          }
          
          this.messages.push({
            type: 'assistant',
            text: errorMessage
          });
          return;
        }
        
        // Parse JSON response
        let data;
        try {
          const text = await response.text();
          data = JSON.parse(text);
        } catch (parseError) {
          console.error('JSON Parse Error:', parseError);
          this.messages.push({
            type: 'assistant',
            text: 'Erro ao processar a resposta do servidor. Por favor, tente novamente ou verifique se a API Key está configurada.'
          });
          return;
        }
        
        if (data.success) {
          this.messages.push({
            type: 'assistant',
            text: data.message,
            dosage_info: data.dosage_info,
            related_articles: data.related_articles
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
          text: 'Erro de conexão. Verifique sua conexão com a internet e tente novamente. Se o problema persistir, verifique se a API Key está configurada corretamente.'
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
const ChatbotHumans = window.ChatbotHumans;

