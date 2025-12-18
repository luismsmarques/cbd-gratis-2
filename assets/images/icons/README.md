# Ícones e Favicons - CBD AI Theme

Este diretório contém todos os ícones necessários para favicon e ícones de aplicação móvel.

## Ícones Necessários

Para que o tema funcione completamente, você precisa criar os seguintes ícones:

### 1. Favicon Padrão
- **favicon.ico** - 16x16, 32x32, 48x48 (formato ICO)
- **favicon-16x16.png** - 16x16 pixels (PNG)
- **favicon-32x32.png** - 32x32 pixels (PNG)

### 2. Apple Touch Icons (iOS)
- **apple-touch-icon.png** - 180x180 pixels (PNG)
  - Usado quando o site é adicionado à tela inicial do iOS
  - Deve ter cantos arredondados (iOS adiciona automaticamente)

### 3. Android Chrome Icons
- **android-chrome-192x192.png** - 192x192 pixels (PNG)
- **android-chrome-512x512.png** - 512x512 pixels (PNG)
  - Usados quando o site é adicionado à tela inicial do Android
  - Ícone de 512x512 é usado para splash screen

### 4. Windows Tiles
- **mstile-144x144.png** - 144x144 pixels (PNG)
  - Usado no Windows 10/11 quando o site é fixado

## Especificações de Design

### Cores do Tema
- **Cor Principal**: #00897b (Teal)
- **Cor Secundária**: #2d712d (Verde CBD)
- **Fundo**: Branco ou transparente

### Design Sugerido
O ícone deve representar:
- CBD/Cânhamo (folha de cânhamo estilizada)
- Ou as letras "CBD" de forma estilizada
- Ou uma combinação de ambos

### Requisitos Técnicos
- **Formato**: PNG (transparência permitida)
- **Fundo**: Transparente ou branco
- **Estilo**: Simples, legível em tamanhos pequenos
- **Contraste**: Alto contraste para visibilidade

## Ferramentas Recomendadas para Criar Ícones

### Online (Gratuitas)
1. **Favicon.io** - https://favicon.io/
   - Gera todos os tamanhos automaticamente
   - Permite upload de imagem ou texto
   - Gera favicon.ico automaticamente

2. **RealFaviconGenerator** - https://realfavicongenerator.net/
   - Gera todos os ícones necessários
   - Inclui preview em diferentes dispositivos
   - Gera site.webmanifest automaticamente

3. **Favicon Generator** - https://www.favicon-generator.org/
   - Upload de imagem e gera todos os tamanhos

### Software Desktop
1. **GIMP** (Gratuito)
2. **Photoshop**
3. **Figma** (Online/Gratuito)
4. **Inkscape** (Gratuito, para SVG)

## Processo Recomendado

### Opção 1: Usando Favicon.io
1. Acesse https://favicon.io/
2. Escolha "Text" ou "Image"
3. Se Text: Digite "CBD" ou "CG"
4. Escolha fonte e cores (#00897b)
5. Clique em "Create Favicon"
6. Baixe o pacote ZIP
7. Extraia os arquivos para este diretório

### Opção 2: Usando RealFaviconGenerator
1. Acesse https://realfavicongenerator.net/
2. Faça upload de uma imagem (mínimo 260x260px)
3. Configure as opções:
   - iOS: 180x180
   - Android Chrome: 192x192 e 512x512
   - Windows: 144x144
   - Favicon: 16x16, 32x32
4. Gere e baixe o pacote
5. Extraia os arquivos para este diretório
6. Substitua o site.webmanifest se necessário

### Opção 3: Criar Manualmente
1. Crie uma imagem base (512x512px recomendado)
2. Use um editor de imagens para criar cada tamanho:
   - Redimensione mantendo proporções
   - Exporte como PNG
3. Para favicon.ico, use um conversor online:
   - https://convertio.co/png-ico/
   - https://www.icoconverter.com/

## Estrutura de Arquivos Final

```
assets/images/icons/
├── favicon.ico
├── favicon-16x16.png
├── favicon-32x32.png
├── apple-touch-icon.png
├── android-chrome-192x192.png
├── android-chrome-512x512.png
├── mstile-144x144.png
├── site.webmanifest
└── README.md (este arquivo)
```

## Verificação

Após adicionar os ícones, verifique:

1. **Favicon no navegador**: Recarregue a página e verifique se o favicon aparece na aba
2. **iOS**: Adicione o site à tela inicial do iPhone/iPad e verifique o ícone
3. **Android**: Adicione o site à tela inicial do Android e verifique o ícone
4. **Ferramentas de teste**:
   - https://realfavicongenerator.net/favicon_checker
   - https://www.favicon-checker.com/

## Notas Importantes

- Todos os arquivos devem estar neste diretório
- Os caminhos no código são relativos ao tema
- O site.webmanifest já está configurado
- A cor do tema (#00897b) já está definida no código
- Após adicionar os ícones, limpe o cache do navegador

## Suporte

Se tiver problemas:
1. Verifique se todos os arquivos estão no diretório correto
2. Verifique as permissões dos arquivos (644)
3. Limpe o cache do navegador
4. Verifique o console do navegador para erros 404

