# Design System CBD.gratis - Guia de Redesign de Componentes

## 📋 Visão Geral do Projeto

**Projeto:** cbd.gratis - Portal de Informação sobre CBD em Portugal  
**Objetivo:** Portal de autoridade sobre CBD com foco em E-E-A-T (Expertise, Authoritativeness, Trustworthiness)  
**Identidade Visual:** Rigor, Segurança e Inovação (portal de saúde/legalidade)

---

## 🎯 Objetivos de Design (E-E-A-T)

### Máxima E-E-A-T
- **Rigor:** Design que transmite precisão, profissionalismo e confiabilidade
- **Segurança:** Elementos visuais que reforçam credibilidade e segurança da informação
- **Inovação:** Toques modernos que demonstram atualização tecnológica

### Performance & Consistência
- Arquitetura modular Vue.js/MUI sobre WordPress
- Consistência visual e interatividade em todos os componentes
- Cobertura completa de todas as páginas e ferramentas interativas

---

## 🛠️ Stack Tecnológico

### Backend/CMS
- **WordPress** - Sistema de gestão de conteúdo base

### Framework de Interatividade
- **Vue.js 3** (CDN: `https://unpkg.com/vue@3/dist/vue.global.prod.js`)
- Componentes Vue como objetos globais (`window.ComponentName`)

### Design System/CSS
- **Material UI (MUI) Simulado** - Classes CSS customizadas que simulam componentes MUI
- **Tailwind CSS** - Framework utilitário (já existente no tema)
- Classes MUI customizadas em `assets/css/mui-design-system.css`

### Estrutura de Arquivos
```
cbd-ai-theme/
├── assets/
│   ├── css/
│   │   └── mui-design-system.css      # Design System base
│   └── js/
│       └── components/
│           ├── StatusCard.js          # Componente Vue de Status/Alerta
│           └── ActionCard.js          # Componente Vue de Navegação
├── templates/
│   ├── template-animais.php           # Hub de Animais
│   ├── template-caes.php              # CBD para Cães
│   ├── template-gatos.php             # CBD para Gatos
│   ├── template-cbd-humanos.php       # CBD para Pessoas
│   ├── template-calculadora-dosagem.php # Calculadora
│   ├── template-chatbot-cbd.php      # Chatbot
│   └── template-legislation.php       # Monitor Legislativo
└── front-page.php                     # Homepage
```

---

## 🎨 Paleta de Cores

### Cores de Rigor
```css
--mui-blue-primary: #1976d2;    /* Azul principal */
--mui-blue-dark: #1565c0;       /* Azul escuro */
--mui-blue-light: #42a5f5;      /* Azul claro */
--mui-gray-900: #212121;        /* Cinza muito escuro */
--mui-gray-800: #424242;
--mui-gray-700: #616161;
--mui-gray-600: #757575;
--mui-gray-500: #9e9e9e;
--mui-gray-400: #bdbdbd;
--mui-gray-300: #e0e0e0;
--mui-gray-200: #eeeeee;
--mui-gray-100: #f5f5f5;
--mui-gray-50: #fafafa;
```

### Cores de Inovação/Saúde
```css
--mui-teal-primary: #00897b;    /* Teal principal */
--mui-teal-dark: #00695c;       /* Teal escuro */
--mui-teal-light: #4db6ac;      /* Teal claro */
--mui-mint-primary: #81c784;    /* Mint principal */
--mui-mint-dark: #66bb6a;       /* Mint escuro */
--mui-mint-light: #a5d6a7;      /* Mint claro */
```

### Cores de Status
```css
--mui-success: #4caf50;         /* Verde sucesso */
--mui-warning: #ff9800;          /* Laranja aviso */
--mui-error: #f44336;            /* Vermelho erro */
--mui-info: #2196f3;             /* Azul informação */
```

### Elevação (Shadows)
```css
--mui-shadow-1: 0px 2px 1px -1px rgba(0,0,0,0.2), ...;
--mui-shadow-2: 0px 3px 1px -2px rgba(0,0,0,0.2), ...;
--mui-shadow-4: 0px 2px 4px -1px rgba(0,0,0,0.2), ...;
--mui-shadow-8: 0px 5px 5px -3px rgba(0,0,0,0.2), ...;
--mui-shadow-16: 0px 8px 10px -5px rgba(0,0,0,0.2), ...;
```

---

## 🧩 Componentes Vue Existentes

### StatusCard Component

**Localização:** `assets/js/components/StatusCard.js`  
**Uso:** Cards de alerta/status para Monitor e Homepage

**Props:**
- `status` (String, required): `'success' | 'warning' | 'error' | 'info'`
- `titulo` (String, required): Título do card
- `dataAtualizacao` (String, optional): Data da última atualização
- `mensagem` (String, optional): Mensagem adicional

**Exemplo de Uso:**
```html
<div id="status-card-app"></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Vue !== 'undefined' && typeof window.StatusCard !== 'undefined') {
        const { createApp } = Vue;
        createApp({
            components: { StatusCard: window.StatusCard },
            template: `
                <StatusCard 
                    status="success" 
                    titulo="Status Legislativo: Estável" 
                    dataAtualizacao="<?php echo date_i18n('d/m/Y H:i'); ?>"
                    mensagem="Nenhum alerta legislativo significativo encontrado no momento."
                />
            `
        }).mount('#status-card-app');
    }
});
</script>
```

---

### ActionCard Component

**Localização:** `assets/js/components/ActionCard.js`  
**Uso:** Cards de navegação para Hub de Animais e Homepage

**Props:**
- `titulo` (String, required): Título do card
- `descricao` (String, optional): Descrição do card
- `icone` (String, optional): Emoji ou ícone (default: '📋')
- `url` (String, optional): URL de destino (default: '#')
- `cor` (String, optional): `'primary' | 'teal' | 'success' | 'warning' | 'info'` (default: 'primary')
- `tamanho` (String, optional): `'small' | 'medium' | 'large'` (default: 'medium')

**Exemplo de Uso:**
```html
<div id="action-cards-app" class="grid grid-cols-1 md:grid-cols-3 gap-6"></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Vue !== 'undefined' && typeof window.ActionCard !== 'undefined') {
        const { createApp } = Vue;
        const app = createApp({
            components: { ActionCard: window.ActionCard },
            template: `
                <ActionCard 
                    titulo="CBD para Pessoas" 
                    descricao="Guia completo sobre benefícios e dosagem"
                    icone="👤" 
                    url="/cbd-humanos" 
                    cor="primary" 
                    tamanho="large" 
                />
            `
        });
        app.mount('#action-cards-app');
    }
});
</script>
```

---

## 📐 Classes CSS MUI Disponíveis

### Cards
```html
<!-- Card básico -->
<div class="mui-card">
    <div class="mui-card-content">
        <!-- Conteúdo -->
    </div>
</div>

<!-- Card com elevação (hover effect) -->
<div class="mui-card mui-card-elevated">
    <!-- Conteúdo -->
</div>
```

### Tipografia
```html
<h1 class="mui-typography-h1">Título Principal</h1>
<h2 class="mui-typography-h2">Subtítulo</h2>
<h3 class="mui-typography-h3">Título de Seção</h3>
<h4 class="mui-typography-h4">Título Menor</h4>
<h5 class="mui-typography-h5">Título Pequeno</h5>
<h6 class="mui-typography-h6">Título Muito Pequeno</h6>
<p class="mui-typography-body1">Texto corpo principal</p>
<p class="mui-typography-body2">Texto corpo secundário</p>
<p class="mui-typography-caption">Texto de legenda</p>
<p class="mui-typography-subtitle1">Subtítulo 1</p>
<p class="mui-typography-subtitle2">Subtítulo 2</p>
```

### Botões
```html
<!-- Botão contido (filled) -->
<button class="mui-button mui-button-contained mui-button-primary">
    Botão Principal
</button>

<!-- Botão outline -->
<button class="mui-button mui-button-outlined mui-button-primary">
    Botão Outline
</button>

<!-- Botão texto -->
<button class="mui-button mui-button-text">
    Botão Texto
</button>
```

### Alertas
```html
<!-- Alerta de sucesso -->
<div class="mui-alert mui-alert-success">
    <div class="mui-alert-icon">✓</div>
    <div class="mui-alert-message">
        <h2 class="mui-typography-h5">Título</h2>
        <p class="mui-typography-body1">Mensagem</p>
    </div>
</div>

<!-- Variantes: mui-alert-warning, mui-alert-error, mui-alert-info -->
<!-- Com elevação: adicionar mui-alert-elevated -->
```

### Tabs
```html
<div class="mui-tabs-container">
    <div class="mui-tabs" role="tablist">
        <button class="mui-tab mui-tab-active" role="tab" aria-selected="true" 
                aria-controls="tabpanel-1" id="tab-1">Tab 1</button>
        <button class="mui-tab" role="tab" aria-selected="false" 
                aria-controls="tabpanel-2" id="tab-2">Tab 2</button>
    </div>
    <div id="tabpanel-1" class="mui-tabpanel" role="tabpanel" aria-labelledby="tab-1">
        <!-- Conteúdo Tab 1 -->
    </div>
    <div id="tabpanel-2" class="mui-tabpanel hidden" role="tabpanel" aria-labelledby="tab-2">
        <!-- Conteúdo Tab 2 -->
    </div>
</div>
```

### Tabelas
```html
<div class="mui-table-container">
    <table class="mui-table">
        <thead>
            <tr>
                <th class="mui-table-head">Coluna 1</th>
                <th class="mui-table-head">Coluna 2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="mui-table-cell">Dado 1</td>
                <td class="mui-table-cell">Dado 2</td>
            </tr>
        </tbody>
    </table>
</div>
```

### Campos de Texto
```html
<div class="mui-text-field">
    <label for="input-id" class="mui-input-label">Label</label>
    <input type="text" id="input-id" name="input-name" 
           class="mui-input" placeholder="Placeholder">
</div>
```

### Accordion
```html
<div class="mui-accordion mui-card mui-card-elevated">
    <div class="mui-accordion-summary" aria-expanded="true">
        <h3 class="mui-typography-subtitle1">Título do Item</h3>
        <span class="mui-accordion-icon">−</span>
    </div>
    <div class="mui-accordion-details">
        <p class="mui-typography-body2">Conteúdo expandido</p>
    </div>
</div>
```

### Chips
```html
<div class="mui-chips-container">
    <button class="mui-chip mui-chip-clickable" type="button">
        Chip 1
    </button>
    <button class="mui-chip mui-chip-clickable" type="button">
        Chip 2
    </button>
</div>
```

### Listas
```html
<ul class="mui-list">
    <li class="mui-list-item">
        <span class="mui-list-item-text">Item da lista</span>
    </li>
</ul>
```

---

## 📄 Padrões de Implementação por Página

### Homepage (`front-page.php`)
- **Hero Section:** `StatusCard` + Grid de 3 `ActionCard`
- **H1:** `mui-typography-h1`
- **Cards:** Usar `ActionCard` com `tamanho="large"`

### CBD para Animais (`template-animais.php`)
- **H1:** `mui-typography-h1`
- **Cards:** 2 `ActionCard` grandes (Cães e Gatos) em grid 2 colunas
- **Tabela:** `mui-table` para comparação

### CBD para Cães (`template-caes.php`)
- **H1:** `mui-typography-h1`
- **Navegação:** `mui-tabs` para seções (Dosagem, Segurança, Condições)
- **Tabela:** `mui-table` para dosagem

### CBD para Gatos (`template-gatos.php`)
- **H1:** `mui-typography-h1`
- **Alerta:** `mui-alert mui-alert-error` destacado para "Zero THC"
- **Listas:** `mui-list` para informações estruturadas

### CBD para Pessoas (`template-cbd-humanos.php`)
- **H1:** `mui-typography-h1`
- **Benefícios:** `mui-card` para cada benefício
- **FAQ:** `mui-accordion` com Vue.js para interatividade

### Calculadora de Dosagem (`template-calculadora-dosagem.php`)
- **H1:** `mui-typography-h1`
- **Container:** `mui-card mui-card-elevated` centralizado
- **Tabs:** `mui-tabs` para seleção Pessoa/Cão/Gato
- **Inputs:** `mui-text-field` para todos os campos
- **Botão:** `mui-button mui-button-contained mui-button-primary`

### Chatbot CBD (`template-chatbot-cbd.php`)
- **H1:** `mui-typography-h1`
- **Container:** `mui-card` para interface do chat
- **Chips:** `mui-chips-container` com `mui-chip-clickable` para sugestões
- **Input:** `mui-text-field` para campo de chat

### Monitor Legislativo (`template-legislation.php`)
- **H1:** `mui-typography-h1`
- **Status:** `StatusCard` destacado no topo
- **Tabela:** `mui-table` para histórico de mudanças

---

## 🔧 Enqueue de Assets (functions.php)

### CSS
```php
wp_enqueue_style(
    'cbd-ai-mui-design-system',
    CBD_AI_THEME_URI . '/assets/css/mui-design-system.css',
    array( 'cbd-ai-authority-design' ),
    CBD_AI_THEME_VERSION
);
```

### JavaScript (Vue.js e Componentes)
```php
// Vue.js (CDN)
wp_enqueue_script(
    'vue-prod',
    'https://unpkg.com/vue@3/dist/vue.global.prod.js',
    array( 'cbd-ai-chatbot-formatter' ),
    '3.4.0',
    false
);

// StatusCard Component
wp_enqueue_script(
    'cbd-ai-status-card-component',
    CBD_AI_THEME_URI . '/assets/js/components/StatusCard.js',
    array( 'vue-prod' ),
    CBD_AI_THEME_VERSION,
    true
);

// ActionCard Component
wp_enqueue_script(
    'cbd-ai-action-card-component',
    CBD_AI_THEME_URI . '/assets/js/components/ActionCard.js',
    array( 'vue-prod' ),
    CBD_AI_THEME_VERSION,
    true
);
```

**Condições de Carregamento:**
- Carregar Vue.js e componentes apenas em páginas que os utilizam
- Verificar templates específicos ou `is_front_page()`

---

## ✅ Checklist de Redesign

Ao redesenhar um componente ou página, verificar:

- [ ] **H1:** Usa `mui-typography-h1`?
- [ ] **Cards:** Usa `mui-card` e `mui-card-elevated` quando apropriado?
- [ ] **Tipografia:** Classes MUI consistentes (`mui-typography-*`)?
- [ ] **Cores:** Paleta MUI respeitada (rigor: azul/cinza, inovação: teal/mint)?
- [ ] **Componentes Vue:** `StatusCard` e `ActionCard` usados quando apropriado?
- [ ] **Interatividade:** Tabs, Accordions, etc. funcionam corretamente?
- [ ] **Responsividade:** Grid Tailwind (`grid-cols-1 md:grid-cols-X`) aplicado?
- [ ] **Acessibilidade:** Atributos ARIA (`role`, `aria-selected`, `aria-labelledby`) presentes?
- [ ] **SEO:** Schema.org markup mantido? Links internos estratégicos?
- [ ] **Performance:** Vue.js inicializado apenas quando necessário?

---

## 🎨 Princípios de Design

### Rigor (E-E-A-T)
- Uso predominante de azul navy e cinzas sólidos
- Tipografia limpa e hierárquica
- Espaçamento generoso e consistente
- Bordas e sombras sutis mas presentes

### Inovação
- Toques de teal/mint green em elementos de destaque
- Animações suaves (hover effects, transitions)
- Componentes interativos (tabs, accordions, chips)

### Consistência
- Sempre usar classes MUI em vez de estilos inline quando possível
- Manter padrão de espaçamento (Tailwind: `gap-6`, `mb-8`, etc.)
- Seguir estrutura de componentes Vue estabelecida

---

## 📝 Notas Importantes

1. **Vue.js Inicialização:** Sempre usar `document.addEventListener('DOMContentLoaded')` antes de montar componentes Vue
2. **Verificação de Dependências:** Verificar se `Vue` e componentes (`window.StatusCard`, `window.ActionCard`) existem antes de usar
3. **WordPress Integration:** Usar funções WordPress (`esc_url()`, `esc_html()`, `date_i18n()`) para dados dinâmicos
4. **Mobile-First:** Design responsivo com Tailwind (`md:`, `lg:` breakpoints)
5. **Performance:** Evitar carregar Vue.js em páginas que não precisam

---

## 🚀 Exemplo Completo de Redesign

```php
<?php
/**
 * Template: Exemplo de Página Redesenhada
 */
get_header();
?>

<main class="main-content">
    <div class="container mx-auto px-4 py-8">
        
        <!-- H1 com Tipografia MUI -->
        <h1 class="mui-typography-h1 mb-8">
            Título da Página
        </h1>
        
        <!-- StatusCard Component -->
        <div id="status-app" class="mb-8"></div>
        
        <!-- Grid de ActionCards -->
        <div id="action-cards-app" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12"></div>
        
        <!-- Conteúdo com Tabs MUI -->
        <div class="mui-card mui-card-elevated">
            <div class="mui-tabs-container">
                <div class="mui-tabs" role="tablist">
                    <button class="mui-tab mui-tab-active" role="tab" 
                            aria-selected="true" aria-controls="tab-1" id="tab-btn-1">
                        Tab 1
                    </button>
                    <button class="mui-tab" role="tab" 
                            aria-selected="false" aria-controls="tab-2" id="tab-btn-2">
                        Tab 2
                    </button>
                </div>
                <div id="tab-1" class="mui-tabpanel" role="tabpanel" aria-labelledby="tab-btn-1">
                    <div class="mui-card-content">
                        <p class="mui-typography-body1">Conteúdo Tab 1</p>
                    </div>
                </div>
                <div id="tab-2" class="mui-tabpanel hidden" role="tabpanel" aria-labelledby="tab-btn-2">
                    <div class="mui-card-content">
                        <p class="mui-typography-body1">Conteúdo Tab 2</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar StatusCard
    if (typeof Vue !== 'undefined' && typeof window.StatusCard !== 'undefined') {
        const { createApp } = Vue;
        createApp({
            components: { StatusCard: window.StatusCard },
            template: `
                <StatusCard 
                    status="info" 
                    titulo="Informação Importante" 
                    dataAtualizacao="<?php echo date_i18n('d/m/Y'); ?>"
                />
            `
        }).mount('#status-app');
    }
    
    // Inicializar ActionCards
    if (typeof Vue !== 'undefined' && typeof window.ActionCard !== 'undefined') {
        const { createApp } = Vue;
        createApp({
            components: { ActionCard: window.ActionCard },
            template: `
                <ActionCard titulo="Card 1" descricao="Descrição" icone="📋" url="#" cor="primary" />
                <ActionCard titulo="Card 2" descricao="Descrição" icone="📊" url="#" cor="teal" />
                <ActionCard titulo="Card 3" descricao="Descrição" icone="💡" url="#" cor="info" />
            `
        }).mount('#action-cards-app');
    }
    
    // Gerenciar Tabs
    const tabs = document.querySelectorAll('.mui-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetId = this.getAttribute('aria-controls');
            const allPanels = document.querySelectorAll('.mui-tabpanel');
            const allTabs = document.querySelectorAll('.mui-tab');
            
            allPanels.forEach(panel => panel.classList.add('hidden'));
            allTabs.forEach(t => {
                t.classList.remove('mui-tab-active');
                t.setAttribute('aria-selected', 'false');
            });
            
            document.getElementById(targetId).classList.remove('hidden');
            this.classList.add('mui-tab-active');
            this.setAttribute('aria-selected', 'true');
        });
    });
});
</script>

<?php
get_footer();
?>
```

---

**Última Atualização:** 2024  
**Versão do Design System:** 1.0.0  
**Mantido por:** Equipa de Front-end CBD.gratis

