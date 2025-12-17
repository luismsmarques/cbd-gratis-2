# Guia de Instalação - CBD AI Theme

## Passo a Passo

### 1. Instalar Dependências Node.js

```bash
cd wp-content/themes/cbd-ai-theme
npm install
```

### 2. Configurar API Key do Gemini

1. Acesse [Google AI Studio](https://makersuite.google.com/app/apikey)
2. Crie uma nova API Key
3. No WordPress Admin, vá em **Configurações > CBD AI**
4. Cole a API Key no campo "Chave API Gemini"
5. Salve as configurações

### 3. Compilar Assets (Opcional)

Para desenvolvimento:
```bash
npm run dev
```

Para produção:
```bash
npm run build
npm run tailwind:build
```

### 4. Ativar o Tema

1. WordPress Admin > **Aparência > Temas**
2. Encontre "CBD AI Theme"
3. Clique em **Ativar**

### 5. Criar Páginas com Templates

#### Chatbot CBD Animais
1. Criar nova página
2. Título: "Chatbot CBD"
3. Template: "Chatbot CBD Animais"
4. Publicar

#### Monitor de Legislação
1. Criar nova página
2. Título: "Legislação CBD"
3. Template: "Monitor Legislação"
4. Publicar

#### Gerador de Conteúdo (Apenas para Administradores)
1. Criar nova página
2. Título: "Gerador de Conteúdo"
3. Template: "Gerador de Conteúdo"
4. Publicar

### 6. Configurar Menu

1. WordPress Admin > **Aparência > Menus**
2. Adicione as páginas criadas ao menu principal
3. Salve o menu

## Troubleshooting

### Componentes Vue não carregam

- Verifique se o Vue.js está sendo carregado corretamente
- Verifique o console do navegador para erros
- Certifique-se de que a API REST está funcionando: `/wp-json/cbd-ai/v1/`

### Erro de API Gemini

- Verifique se a API Key está configurada corretamente
- Verifique se a API Key tem créditos disponíveis
- Verifique os logs do WordPress para erros específicos

### Tailwind CSS não aplica estilos

- Execute `npm run tailwind:build`
- Limpe o cache do navegador
- Verifique se o arquivo `tailwind-output.css` foi gerado

## Próximos Passos

1. Personalize as cores em `tailwind.config.js`
2. Adicione conteúdo inicial usando os Custom Post Types
3. Configure os widgets na sidebar
4. Teste o chatbot e outros módulos de IA

