# Correções Sugeridas - CBD AI Theme

Este documento lista correções específicas baseadas na análise UX/UI completa.

---

## 🔴 Prioridade ALTA

### 1. Remover Console.log de Produção

**Problema:** 41 ocorrências de `console.log/error/warn` encontradas no código.

**Solução:** Criar wrapper de debug

**Arquivo:** `assets/js/debug-helper.js` (novo)

```javascript
/**
 * Debug Helper - Remove console.log em produção
 */
window.CBDDebug = {
    enabled: window.location.hostname === 'localhost' || 
             window.location.hostname.includes('.local') ||
             (window.location.search.includes('debug=true')),
    
    log: function(...args) {
        if (this.enabled) {
            console.log('[CBD Debug]', ...args);
        }
    },
    
    error: function(...args) {
        // Erros sempre mostram
        console.error('[CBD Error]', ...args);
    },
    
    warn: function(...args) {
        if (this.enabled) {
            console.warn('[CBD Warn]', ...args);
        }
    }
};
```

**Substituir em todos os arquivos:**
- `console.log` → `CBDDebug.log`
- `console.warn` → `CBDDebug.warn`
- Manter `console.error` para erros críticos

---

### 2. Melhorar Página 404

**Problema:** Página 404 muito básica, não usa design system.

**Arquivo:** `404.php`

**Solução:** Redesenhar com MUI Design System

```php
<?php
get_header();
?>

<main class="main-content min-h-screen py-12 md:py-20" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.03), var(--mui-gray-50));">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            
            <!-- 404 Icon -->
            <div class="mb-8">
                <div class="mui-card mui-card-elevated" style="display: inline-block; padding: 48px;">
                    <h1 class="mui-typography-h1" style="font-size: 6rem; margin: 0; color: var(--mui-gray-400);">
                        404
                    </h1>
                </div>
            </div>
            
            <!-- Error Message -->
            <h2 class="mui-typography-h2 mb-4">
                Página não encontrada
            </h2>
            
            <p class="mui-typography-body1 mb-8" style="color: var(--mui-gray-600);">
                Desculpe, a página que você está procurando não existe ou foi movida.
            </p>
            
            <!-- Search Form -->
            <div class="mui-card mui-card-elevated mb-8" style="padding: 24px;">
                <h3 class="mui-typography-h6 mb-4">Pesquisar no site</h3>
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="mui-text-field" style="margin-bottom: 16px;">
                        <input 
                            type="search" 
                            name="s" 
                            placeholder="Digite sua pesquisa..."
                            class="mui-input mui-input-outlined"
                            value=""
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="mui-button mui-button-contained mui-button-primary"
                    >
                        Pesquisar
                    </button>
                </form>
            </div>
            
            <!-- Quick Links -->
            <div class="mb-8">
                <h3 class="mui-typography-h6 mb-4">Links Úteis</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mui-button mui-button-outlined">
                        Página Inicial
                    </a>
                    <?php
                    $animais_page = get_page_by_path( 'cbd-animais' );
                    if ( $animais_page ) :
                    ?>
                        <a href="<?php echo esc_url( get_permalink( $animais_page->ID ) ); ?>" class="mui-button mui-button-outlined">
                            CBD para Animais
                        </a>
                    <?php endif; ?>
                    
                    <?php
                    $monitor_page = get_page_by_path( 'monitor-legislacao' );
                    if ( $monitor_page ) :
                    ?>
                        <a href="<?php echo esc_url( get_permalink( $monitor_page->ID ) ); ?>" class="mui-button mui-button-outlined">
                            Monitor Legislação
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
</main>

<?php
get_footer();
```

---

### 3. Error Handling em Componentes Vue

**Problema:** Componentes Vue podem falhar silenciosamente.

**Solução:** Adicionar try-catch e fallback

**Arquivo:** `assets/js/vue-error-handler.js` (novo)

```javascript
/**
 * Vue Error Handler - Tratamento de erros global
 */
window.CBDVueHelper = {
    /**
     * Inicializa componente Vue com error handling
     */
    initComponent: function(componentName, containerId, componentConfig) {
        try {
            // Verificar dependências
            if (typeof Vue === 'undefined') {
                throw new Error('Vue.js não está carregado');
            }
            
            if (typeof window[componentName] === 'undefined') {
                throw new Error(`Componente ${componentName} não está disponível`);
            }
            
            const container = document.getElementById(containerId);
            if (!container) {
                throw new Error(`Container #${containerId} não encontrado`);
            }
            
            // Verificar se já foi montado
            if (container.__vue_app__) {
                console.warn(`Componente ${componentName} já foi montado`);
                return true;
            }
            
            // Criar e montar aplicação
            const { createApp } = Vue;
            const app = createApp({
                components: {
                    [componentName]: window[componentName]
                },
                ...componentConfig
            });
            
            app.mount(`#${containerId}`);
            
            return true;
            
        } catch (error) {
            console.error(`Erro ao inicializar ${componentName}:`, error);
            
            // Mostrar fallback UI
            const container = document.getElementById(containerId);
            if (container) {
                container.innerHTML = `
                    <div class="mui-alert mui-alert-error">
                        <div class="mui-alert-icon">✕</div>
                        <div class="mui-alert-message">
                            <h3 class="mui-typography-h6">Erro ao carregar componente</h3>
                            <p class="mui-typography-body2">Por favor, recarregue a página ou entre em contato com o suporte.</p>
                        </div>
                    </div>
                `;
            }
            
            return false;
        }
    }
};
```

**Uso nos templates:**

```javascript
// Antes:
const app = createApp({...});
app.mount('#container');

// Depois:
CBDVueHelper.initComponent('StatusCard', 'status-card-app', {
    template: '<StatusCard :status="status" :titulo="titulo" />',
    data() {
        return { status: 'success', titulo: 'Título' };
    }
});
```

---

## 🟡 Prioridade MÉDIA

### 4. Adicionar ARIA Completo

**Problema:** Alguns elementos não têm atributos ARIA adequados.

**Solução:** Adicionar ARIA em componentes críticos

**Exemplo - Tabs:**

```html
<div class="mui-tabs" role="tablist" aria-label="Seções de conteúdo">
    <button 
        class="mui-tab mui-tab-active" 
        role="tab" 
        aria-selected="true" 
        aria-controls="tabpanel-1" 
        id="tab-1"
        aria-label="Aba de Dosagem"
    >
        Dosagem
    </button>
    <!-- ... -->
</div>
<div 
    id="tabpanel-1" 
    class="mui-tabpanel" 
    role="tabpanel" 
    aria-labelledby="tab-1"
>
    <!-- Conteúdo -->
</div>
```

**Exemplo - Accordion:**

```html
<div class="mui-accordion">
    <div 
        class="mui-accordion-summary" 
        role="button"
        aria-expanded="false"
        aria-controls="accordion-content-1"
        id="accordion-header-1"
        tabindex="0"
    >
        <h3 class="mui-typography-subtitle1">Título</h3>
        <span class="mui-accordion-icon">+</span>
    </div>
    <div 
        id="accordion-content-1"
        class="mui-accordion-details"
        role="region"
        aria-labelledby="accordion-header-1"
    >
        <!-- Conteúdo -->
    </div>
</div>
```

---

### 5. Navegação por Teclado em Tabs

**Problema:** Tabs não são navegáveis por teclado (setas).

**Solução:** Adicionar JavaScript para navegação por teclado

**Arquivo:** `assets/js/keyboard-navigation.js` (novo)

```javascript
/**
 * Keyboard Navigation Helper
 */
document.addEventListener('DOMContentLoaded', function() {
    // Navegação por teclado em tabs
    const tabLists = document.querySelectorAll('[role="tablist"]');
    
    tabLists.forEach(tabList => {
        const tabs = Array.from(tabList.querySelectorAll('[role="tab"]'));
        
        tabs.forEach((tab, index) => {
            tab.addEventListener('keydown', function(e) {
                let targetIndex = index;
                
                switch(e.key) {
                    case 'ArrowLeft':
                        e.preventDefault();
                        targetIndex = index > 0 ? index - 1 : tabs.length - 1;
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        targetIndex = index < tabs.length - 1 ? index + 1 : 0;
                        break;
                    case 'Home':
                        e.preventDefault();
                        targetIndex = 0;
                        break;
                    case 'End':
                        e.preventDefault();
                        targetIndex = tabs.length - 1;
                        break;
                    default:
                        return;
                }
                
                // Ativar tab
                tabs[targetIndex].focus();
                tabs[targetIndex].click();
            });
        });
    });
    
    // Navegação por teclado em accordions
    const accordions = document.querySelectorAll('.mui-accordion-summary');
    
    accordions.forEach(accordion => {
        accordion.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                accordion.click();
            }
        });
    });
});
```

---

### 6. Otimizar Carregamento de Imagens

**Problema:** Imagens não usam srcset para diferentes resoluções.

**Solução:** Adicionar srcset e sizes

**Exemplo:**

```php
<?php
$image_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src($image_id, 'full');
$image_srcset = wp_get_attachment_image_srcset($image_id, 'full');
$image_sizes = wp_get_attachment_image_sizes($image_id, 'full');
?>

<img 
    src="<?php echo esc_url($image_src[0]); ?>"
    srcset="<?php echo esc_attr($image_srcset); ?>"
    sizes="<?php echo esc_attr($image_sizes); ?>"
    alt="<?php echo esc_attr(get_the_title()); ?>"
    loading="lazy"
    class="w-full h-48 object-cover"
>
```

---

## 🟢 Prioridade BAIXA

### 7. Consolidar Arquivos CSS

**Problema:** 11 arquivos CSS diferentes podem ser combinados.

**Solução:** Criar build process ou combinar arquivos relacionados.

**Estrutura sugerida:**
- `style.css` - Estilos base WordPress
- `mui-design-system.css` - Design system completo
- `theme-custom.css` - Estilos específicos do tema
- `admin.css` - Estilos admin (carregar apenas no admin)

---

### 8. Adicionar Testes Automatizados

**Solução:** Configurar Jest para testes unitários

**Arquivo:** `package.json` (adicionar)

```json
{
  "scripts": {
    "test": "jest",
    "test:watch": "jest --watch"
  },
  "devDependencies": {
    "jest": "^29.0.0",
    "@vue/test-utils": "^2.4.0"
  }
}
```

**Exemplo de teste:**

```javascript
// tests/StatusCard.test.js
import { mount } from '@vue/test-utils';
import StatusCard from '../assets/js/components/StatusCard.js';

describe('StatusCard', () => {
    it('renders correctly with required props', () => {
        const wrapper = mount(StatusCard, {
            props: {
                status: 'success',
                titulo: 'Test Title'
            }
        });
        
        expect(wrapper.text()).toContain('Test Title');
    });
});
```

---

## 📋 Checklist de Implementação

### Fase 1 (Crítico)
- [ ] Criar `debug-helper.js` e substituir console.log
- [ ] Redesenhar página 404
- [ ] Adicionar error handling em componentes Vue
- [ ] Testar em produção

### Fase 2 (Importante)
- [ ] Adicionar ARIA completo
- [ ] Implementar navegação por teclado
- [ ] Otimizar imagens com srcset
- [ ] Consolidar CSS

### Fase 3 (Melhorias)
- [ ] Configurar testes automatizados
- [ ] Documentar componentes
- [ ] Criar guia de estilo
- [ ] Adicionar modo escuro (opcional)

---

**Última atualização:** 2024  
**Status:** Sugestões prontas para implementação ✅

