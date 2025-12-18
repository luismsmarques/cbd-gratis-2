# Configuração de Favicon e Ícones Mobile

## ✅ O que foi implementado

O sistema de favicon e ícones mobile foi completamente configurado no tema. Agora você só precisa adicionar os arquivos de imagem.

## 📁 Estrutura Criada

```
assets/images/icons/
├── .gitkeep
├── README.md (instruções detalhadas)
├── icon-base.svg (template SVG para criar ícones)
├── site.webmanifest (já configurado)
└── check-icons.php (script de verificação)
```

## 🎯 Ícones Necessários

Você precisa criar e adicionar os seguintes arquivos em `assets/images/icons/`:

1. **favicon.ico** - 16x16, 32x32, 48x48 (formato ICO)
2. **favicon-16x16.png** - 16x16 pixels
3. **favicon-32x32.png** - 32x32 pixels
4. **apple-touch-icon.png** - 180x180 pixels (iOS)
5. **android-chrome-192x192.png** - 192x192 pixels (Android)
6. **android-chrome-512x512.png** - 512x512 pixels (Android)
7. **mstile-144x144.png** - 144x144 pixels (Windows)

## 🚀 Como Criar os Ícones

### Opção Rápida (Recomendada)

1. Acesse **https://favicon.io/**
2. Escolha "Text" e digite "CBD"
3. Escolha cor #00897b (teal)
4. Clique em "Create Favicon"
5. Baixe o ZIP
6. Extraia os arquivos para `assets/images/icons/`

### Opção Completa

1. Acesse **https://realfavicongenerator.net/**
2. Faça upload de uma imagem (mínimo 260x260px)
3. Configure todos os tamanhos
4. Baixe e extraia para `assets/images/icons/`

## ✅ Verificação

Após adicionar os ícones:

1. **Via Script**: Acesse `/wp-content/themes/cbd-ai-theme/assets/images/icons/check-icons.php`
2. **No Navegador**: Recarregue a página e verifique o favicon na aba
3. **Mobile**: Adicione o site à tela inicial e verifique o ícone

## 📱 O que foi configurado

- ✅ Favicon padrão (16x16, 32x32)
- ✅ Apple Touch Icon (iOS)
- ✅ Android Chrome Icons (192x192, 512x512)
- ✅ Windows Tiles
- ✅ Web App Manifest
- ✅ Theme Color (#00897b)

## 📝 Notas

- Todos os meta tags são adicionados automaticamente via `wp_head`
- A função está em `functions.php` (linha ~1163)
- O `site.webmanifest` já está configurado
- Consulte `assets/images/icons/README.md` para instruções detalhadas

## 🔗 Links Úteis

- **Favicon.io**: https://favicon.io/
- **RealFaviconGenerator**: https://realfavicongenerator.net/
- **Favicon Checker**: https://realfavicongenerator.net/favicon_checker

