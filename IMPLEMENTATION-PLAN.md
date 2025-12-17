# Plano de Implementação - Funcionalidades de Alta Prioridade

## Objetivo
Implementar Schema.org markup, Open Graph tags e sistema de newsletter funcional para melhorar SEO, compartilhamento social e engajamento.

---

## 1. Schema.org Markup

### Arquivo: `inc/class-schema-markup.php` (novo)

Classe para gerar Schema.org JSON-LD:

**Métodos principais:**
- `generate_article_schema()` - Para posts individuais (Article)
- `generate_breadcrumb_schema()` - Para breadcrumbs (BreadcrumbList)
- `generate_organization_schema()` - Para organização do site (Organization)
- `generate_website_schema()` - Para homepage com SearchAction (WebSite)
- `output_schema()` - Output JSON-LD no `<head>`

**Schemas a implementar:**
- **Article**: title, headline, image, datePublished, dateModified, author, publisher
- **BreadcrumbList**: itemListElement com posição e URL
- **Organization**: name, url, logo, sameAs (redes sociais)
- **WebSite**: name, url, potentialAction (SearchAction)

**Hook:** `wp_head` com prioridade 5

---

## 2. Open Graph Tags

### Arquivo: `inc/class-open-graph.php` (novo)

Classe para gerar Open Graph e Twitter Cards:

**Métodos principais:**
- `generate_og_tags()` - Gera todas as tags Open Graph
- `get_og_image()` - Obtém imagem otimizada (featured image ou fallback)
- `get_og_description()` - Obtém descrição (excerpt ou meta)
- `output_tags()` - Output no `<head>`

**Tags a implementar:**
- **Open Graph**: og:title, og:description, og:image, og:url, og:type, og:site_name, og:locale
- **Article**: article:published_time, article:modified_time, article:author
- **Twitter**: twitter:card, twitter:title, twitter:description, twitter:image

**Hook:** `wp_head` com prioridade 10

---

## 3. Newsletter Handler

### Arquivo: `inc/class-newsletter-handler.php` (novo)

Classe para processar submissões de newsletter:

**Métodos principais:**
- `handle_subscription()` - Processa submissão
- `validate_email()` - Valida formato de email
- `save_subscriber()` - Salva no banco (tabela custom ou options)
- `send_confirmation()` - Envia email de confirmação (opcional)
- `get_subscribers()` - Lista assinantes (admin)

**Estrutura de dados:**
- Criar tabela custom `wp_cbd_newsletter_subscribers` ou usar options API
- Campos: email, name (opcional), subscribed_at, status, source

### REST API Endpoint

**Arquivo:** `inc/rest-api.php` (modificar)

- Rota: `POST /wp-json/cbd-ai/v1/newsletter/subscribe`
- Validação, sanitização, nonce check
- Retorna JSON com success/error

---

## 4. Modificações em Arquivos Existentes

### `functions.php`
- Adicionar `require_once` para novas classes após linha 280
- Registrar hooks para schema e open graph

### `header.php`
- Usar hook `wp_head` (já existe) para output de schema e OG

### `inc/template-functions.php`
- Modificar `cbd_ai_breadcrumbs()` para incluir schema JSON-LD
- Adicionar método auxiliar `cbd_ai_get_breadcrumb_schema()`

### `single.php`
- Modificar formulário newsletter (linha 174-183)
- Adicionar `data-action` e `data-nonce` para JavaScript
- Adicionar ID `newsletter-form` para targeting
- Adicionar container para mensagens

### JavaScript (novo ou modificar `assets/js/main.js`)
- Adicionar handler AJAX para formulário de newsletter
- Mostrar mensagens de sucesso/erro
- Validação client-side

---

## Fluxo de Dados

### Newsletter Flow:
```
Formulário (single.php) 
  → JavaScript AJAX 
  → REST API (/wp-json/cbd-ai/v1/newsletter/subscribe)
  → Newsletter_Handler::handle_subscription()
  → Validação → Salvar no banco
  → Resposta JSON → Atualizar UI
```

### Schema/OG Flow:
```
WordPress Template Load
  → Schema_Markup::output_schema() (wp_head hook)
  → Open_Graph::output_tags() (wp_head hook)
  → Output no <head> do HTML
```

---

## Considerações Técnicas

1. **Performance:** Schema e OG são gerados dinamicamente mas leves
2. **Compatibilidade:** Usar funções WordPress nativas (get_the_excerpt, get_post_thumbnail_url)
3. **Segurança:** Sanitização de todos os inputs, nonce verification
4. **Extensibilidade:** Estrutura preparada para API customizada de newsletter
5. **Fallbacks:** Imagens padrão se não houver featured image

---

## Ordem de Implementação Sugerida

1. Schema.org markup (base para SEO)
2. Open Graph tags (compartilhamento social)
3. Newsletter handler + REST API (backend)
4. Frontend newsletter (AJAX + formulário)
5. Breadcrumbs schema (melhoria)
6. Integração e testes

---

## Testes Necessários

1. Verificar Schema.org no Google Rich Results Test
2. Testar Open Graph no Facebook Debugger e Twitter Card Validator
3. Testar submissão de newsletter (sucesso e erros)
4. Verificar breadcrumbs schema em páginas diferentes
5. Testar em diferentes tipos de post (post, page, cbd_article, cbd_guide)

---

## Estrutura de Arquivos

### Novos Arquivos a Criar:
1. `inc/class-schema-markup.php` - Classe para gerar Schema.org JSON-LD
2. `inc/class-open-graph.php` - Classe para gerar Open Graph e Twitter Card tags
3. `inc/class-newsletter-handler.php` - Handler para processar submissões de newsletter

### Arquivos a Modificar:
1. `functions.php` - Incluir novas classes e registrar hooks
2. `header.php` - Adicionar hook para Open Graph tags (ou usar wp_head existente)
3. `inc/template-functions.php` - Adicionar schema aos breadcrumbs
4. `single.php` - Conectar formulário de newsletter ao handler
5. `inc/rest-api.php` - Adicionar endpoint REST para newsletter
6. `assets/js/main.js` - Adicionar handler AJAX para newsletter

---

## Próximos Passos (Após Implementação)

- Integrar API externa de newsletter quando disponível
- Adicionar configurações admin para personalizar schemas
- Implementar sistema de afiliados (quando solicitado)
- Adicionar analytics para tracking de conversões

---

**Versão:** 1.0  
**Data:** 2024  
**Status:** Planejamento

