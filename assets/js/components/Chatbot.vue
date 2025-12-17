<template>
  <div class="chatbot-container">
    <div class="chat-messages space-y-4 mb-6" ref="messagesContainer">
      <div 
        v-for="(message, index) in messages" 
        :key="index"
        :class="['chat-message p-4 rounded-lg', message.type === 'user' ? 'bg-cbd-green-100 ml-auto max-w-[80%]' : 'bg-gray-100 max-w-[80%]']"
      >
        <div class="font-medium mb-2" v-if="message.type === 'assistant'">
          Assistente CBD
        </div>
        <div v-html="message.text"></div>
        <div v-if="message.dosage_info" class="mt-3 p-3 bg-white rounded border border-cbd-green-300">
          <strong>Informação de Dosagem:</strong>
          <p class="text-sm mt-1">{{ message.dosage_info.recommendation }}</p>
        </div>
        <div v-if="message.related_articles && message.related_articles.length > 0" class="mt-3">
          <strong class="text-sm">Artigos relacionados:</strong>
          <ul class="list-disc list-inside mt-1 text-sm">
            <li v-for="article in message.related_articles" :key="article.url">
              <a :href="article.url" class="text-cbd-green-600 hover:underline">{{ article.title }}</a>
            </li>
          </ul>
        </div>
      </div>
      
      <div v-if="loading" class="chat-message bg-gray-100 p-4 rounded-lg max-w-[80%]">
        <div class="flex items-center gap-2">
          <div class="spinner"></div>
          <span>Pensando...</span>
        </div>
      </div>
    </div>
    
    <form @submit.prevent="sendMessage" class="flex gap-2">
      <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
        <select v-model="animalType" class="input text-sm">
          <option value="">Tipo de animal (opcional)</option>
          <option value="cão">Cão</option>
          <option value="gato">Gato</option>
          <option value="outros">Outros</option>
        </select>
        <input 
          type="number" 
          v-model.number="weight" 
          placeholder="Peso (kg)" 
          step="0.1"
          min="0"
          class="input text-sm"
        />
      </div>
      <div class="flex gap-2 w-full">
        <input 
          type="text" 
          v-model="currentMessage" 
          @keyup.enter="sendMessage"
          placeholder="Digite sua pergunta sobre CBD para animais..."
          class="input flex-1"
          :disabled="loading"
        />
        <button 
          type="submit" 
          class="btn btn-primary"
          :disabled="loading || !currentMessage.trim()"
        >
          Enviar
        </button>
      </div>
    </form>
    
    <div class="mt-4 text-xs text-gray-500">
      <p>⚠️ <strong>Importante:</strong> Este chatbot fornece informações gerais. Sempre consulte um veterinário antes de usar CBD no seu animal.</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Chatbot',
  data() {
    return {
      messages: [
        {
          type: 'assistant',
          text: 'Olá! Sou um assistente especializado em CBD para animais. Como posso ajudar você hoje?'
        }
      ],
      currentMessage: '',
      animalType: '',
      weight: null,
      loading: false,
      apiUrl: window.cbdAIData?.apiUrl || '/wp-json/cbd-ai/v1/',
      nonce: window.cbdAIData?.nonce || ''
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
        const response = await fetch(this.apiUrl + 'chatbot', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': this.nonce
          },
          body: JSON.stringify({
            question: userMessage,
            animal_type: this.animalType || '',
            weight: this.weight || 0
          })
        });
        
        const data = await response.json();
        
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
          text: 'Desculpe, ocorreu um erro de conexão. Por favor, tente novamente.'
        });
      } finally {
        this.loading = false;
        this.scrollToBottom();
      }
    },
    scrollToBottom() {
      this.$nextTick(() => {
        if (this.$refs.messagesContainer) {
          this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
        }
      });
    }
  },
  mounted() {
    this.scrollToBottom();
  }
}
</script>

<style scoped>
.chatbot-container {
  max-height: 600px;
  display: flex;
  flex-direction: column;
}

.chat-messages {
  flex: 1;
  overflow-y: auto;
  min-height: 300px;
  max-height: 500px;
  padding: 1rem;
  background: #f9fafb;
  border-radius: 0.5rem;
}
</style>

