# CBD AI Theme - Tema WordPress com IA Integrada

Tema WordPress especializado em conteúdo sobre CBD (Canabidiol) com três módulos principais de Inteligência Artificial integrados usando Google Gemini API.

## 🚀 Características

### Módulos de IA

1. **Chatbot Especialista em CBD para Animais**
   - Responde perguntas sobre CBD para cães, gatos e outros animais
   - Calcula dosagem baseada em peso e tipo de animal
   - Classifica perguntas e fornece respostas contextualizadas
   - Sugere artigos relacionados

2. **Monitor de Legislação Portuguesa**
   - Monitora automaticamente alterações na legislação sobre CBD
   - Fontes: Infarmed, Diário da República, legislação da UE
   - Sumariza documentos legais complexos em linguagem simples
   - Gera alertas automáticos quando há mudanças

3. **Otimizador SEO de Vocabulário**
   - Analisa densidade de palavras-chave
   - Sugere variações e sinônimos (CBD, canabidiol, óleo de cânhamo)
   - Calcula pontuação SEO
   - Gera meta descriptions otimizadas

### Tecnologias

- **Frontend**: Vue.js 3 (Composition API)
- **CSS Framework**: Tailwind CSS v3 (mobile-first)
- **Build Tool**: Vite
- **Backend**: PHP 7.2+ (WordPress clássico)
- **IA**: Google Gemini API

## 📦 Instalação

### Pré-requisitos

- WordPress 5.8 ou superior
- PHP 7.2 ou superior
- Node.js 18+ e npm

### Passos

1. **Copie o tema para o diretório de temas do WordPress:**
   ```bash
   cp -r cbd-ai-theme /caminho/para/wp-content/themes/
   ```

2. **Instale as dependências Node.js:**
   ```bash
   cd cbd-ai-theme
   npm install
   ```

3. **Configure a API Key do Gemini:**
   - Acesse o WordPress Admin
   - Vá em Configurações > CBD AI
   - Cole sua chave API do Google Gemini
   - Você pode obter uma chave em [Google AI Studio](https://makersuite.google.com/app/apikey)

4. **Ative o tema:**
   - Acesse Aparência > Temas
   - Ative o tema "CBD AI Theme"

5. **Build dos assets (opcional para desenvolvimento):**
   ```bash
   npm run build
   ```

## 🛠️ Desenvolvimento

### Scripts Disponíveis

- `npm run dev` - Inicia servidor de desenvolvimento Vite
- `npm run build` - Build de produção
- `npm run watch` - Watch mode para desenvolvimento
- `npm run tailwind:build` - Compila Tailwind CSS
- `npm run tailwind:watch` - Watch Tailwind CSS

### Estrutura de Arquivos

```
cbd-ai-theme/
├── assets/
│   ├── js/
│   │   ├── main.js          # JavaScript principal
│   │   ├── app.js           # Configuração Vue
│   │   └── components/     # Componentes Vue
│   ├── css/
│   │   ├── tailwind.css     # Input Tailwind
│   │   └── custom.css       # Estilos customizados
├── inc/
│   ├── class-gemini-api.php
│   ├── class-chatbot-handler.php
│   ├── class-content-generator.php
│   ├── class-legislation-monitor.php
│   ├── class-seo-optimizer.php
│   ├── custom-post-types.php
│   ├── rest-api.php
│   ├── admin-settings.php
│   └── template-functions.php
├── templates/
│   ├── template-chatbot.php
│   ├── template-content-generator.php
│   └── template-legislation.php
├── functions.php
├── style.css
└── package.json
```

## 📝 Uso

### Criar Página com Chatbot

1. Crie uma nova página no WordPress
2. Selecione o template "Chatbot CBD Animais"
3. Publique a página

### Criar Página de Monitor Legislativo

1. Crie uma nova página
2. Selecione o template "Monitor Legislação"
3. Publique a página

### Custom Post Types

O tema inclui três custom post types:

- **Artigos CBD** (`cbd_article`) - Artigos sobre CBD
- **Guias CBD** (`cbd_guide`) - Guias de dosagem e uso
- **Alertas Legislativos** (`legislation_alert`) - Alertas automáticos de legislação

### Taxonomias

- **Tipos de Animal** (`animal_type`) - cão, gato, outros
- **Tópicos CBD** (`cbd_topic`) - dosagem, benefícios, segurança, etc.
- **Tipos de Legislação** (`legislation_type`) - infarmed, dre, eu, etc.

## 🔧 Configuração

### API Gemini

Configure sua chave API em:
- WordPress Admin > Configurações > CBD AI

### Monitor de Legislação

O monitor executa automaticamente via cron job diário. Para executar manualmente:

```php
$monitor = new CBD_Legislation_Monitor();
$monitor->monitor_sources();
```

## 🎨 Personalização

### Cores

As cores do tema podem ser personalizadas em `tailwind.config.js`:

```javascript
colors: {
  'cbd-green': { ... },
  'cbd-natural': { ... }
}
```

### Componentes Vue

Os componentes Vue estão em `assets/js/components/` e podem ser modificados conforme necessário.

## 📚 REST API Endpoints

- `POST /wp-json/cbd-ai/v1/chatbot` - Enviar pergunta ao chatbot
- `POST /wp-json/cbd-ai/v1/generate-content` - Gerar conteúdo (requer autenticação)
- `POST /wp-json/cbd-ai/v1/optimize` - Otimizar conteúdo SEO (requer autenticação)
- `GET /wp-json/cbd-ai/v1/legislation-alerts` - Obter alertas legislativos

## ⚠️ Avisos Importantes

- **Chatbot**: As informações fornecidas são gerais. Sempre consulte um veterinário antes de usar CBD em animais.
- **Monitor Legislativo**: O monitor verifica fontes públicas, mas não substitui consulta legal profissional.
- **API Gemini**: Requer chave API válida e pode ter limites de uso.

## 📄 Licença

GPL v2 ou posterior

## 🤝 Suporte

Para questões e suporte, consulte a documentação do WordPress ou entre em contato com a equipe de desenvolvimento.

## 🔄 Changelog

### 1.0.0
- Versão inicial
- Módulo chatbot CBD para animais
- Monitor de legislação portuguesa
- Otimizador SEO
- Integração com Gemini API
- Templates responsivos mobile-first

