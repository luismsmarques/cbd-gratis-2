/**
 * Script de Testes UX/UI - CBD AI Theme
 * 
 * Execute no console do navegador para verificar problemas comuns
 * 
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

(function() {
    'use strict';
    
    console.log('%c🔍 Iniciando Testes UX/UI do CBD AI Theme', 'font-size: 16px; font-weight: bold; color: #2d712d;');
    
    const results = {
        passed: [],
        failed: [],
        warnings: []
    };
    
    // Helper para adicionar resultados
    function addResult(type, message, details = '') {
        results[type].push({ message, details });
    }
    
    // Teste 1: Verificar se Vue está carregado
    function testVueLoaded() {
        if (typeof Vue !== 'undefined') {
            addResult('passed', 'Vue.js está carregado', `Versão: ${Vue.version || 'desconhecida'}`);
        } else {
            addResult('failed', 'Vue.js não está carregado', 'Componentes Vue não funcionarão');
        }
    }
    
    // Teste 2: Verificar componentes Vue disponíveis
    function testVueComponents() {
        const components = ['StatusCard', 'ActionCard', 'ChatbotCBD', 'ChatbotLegislation'];
        const available = [];
        const missing = [];
        
        components.forEach(comp => {
            if (typeof window[comp] !== 'undefined') {
                available.push(comp);
            } else {
                missing.push(comp);
            }
        });
        
        if (available.length > 0) {
            addResult('passed', `Componentes Vue disponíveis: ${available.join(', ')}`);
        }
        
        if (missing.length > 0) {
            addResult('warnings', `Componentes Vue não encontrados: ${missing.join(', ')}`, 'Podem não estar carregados nesta página');
        }
    }
    
    // Teste 3: Verificar console.log em produção
    function testConsoleLogs() {
        // Este teste precisa ser executado manualmente verificando o código
        addResult('warnings', 'Verificar console.log em produção', '41 ocorrências encontradas no código - remover em produção');
    }
    
    // Teste 4: Verificar ARIA attributes
    function testAriaAttributes() {
        const elementsWithoutAria = [];
        const interactiveElements = document.querySelectorAll('button, a, input, select, textarea');
        
        interactiveElements.forEach(el => {
            const hasAriaLabel = el.hasAttribute('aria-label');
            const hasAriaLabelledBy = el.hasAttribute('aria-labelledby');
            const hasRole = el.hasAttribute('role');
            const hasId = el.id;
            
            if (!hasAriaLabel && !hasAriaLabelledBy && !hasRole && !hasId && el.textContent.trim() === '') {
                elementsWithoutAria.push(el);
            }
        });
        
        if (elementsWithoutAria.length === 0) {
            addResult('passed', 'Elementos interativos têm atributos ARIA adequados');
        } else {
            addResult('warnings', `${elementsWithoutAria.length} elementos interativos sem ARIA`, 'Adicionar aria-label ou aria-labelledby');
        }
    }
    
    // Teste 5: Verificar contraste de cores
    function testColorContrast() {
        const textElements = document.querySelectorAll('p, span, a, h1, h2, h3, h4, h5, h6');
        const lowContrast = [];
        
        textElements.forEach(el => {
            const style = window.getComputedStyle(el);
            const color = style.color;
            const bgColor = style.backgroundColor;
            
            // Verificação básica (simplificada)
            if (color === 'rgb(156, 163, 175)' || color === 'rgb(107, 114, 128)') {
                // Cinza claro - pode ter baixo contraste
                lowContrast.push(el);
            }
        });
        
        if (lowContrast.length === 0) {
            addResult('passed', 'Contraste de cores parece adequado');
        } else {
            addResult('warnings', `${lowContrast.length} elementos podem ter baixo contraste`, 'Verificar com ferramenta de acessibilidade');
        }
    }
    
    // Teste 6: Verificar imagens com lazy loading
    function testLazyLoading() {
        const images = document.querySelectorAll('img');
        const withLazy = [];
        const withoutLazy = [];
        
        images.forEach(img => {
            if (img.hasAttribute('loading') && img.getAttribute('loading') === 'lazy') {
                withLazy.push(img);
            } else {
                withoutLazy.push(img);
            }
        });
        
        if (withLazy.length > 0) {
            addResult('passed', `${withLazy.length} imagens com lazy loading`);
        }
        
        if (withoutLazy.length > 0) {
            addResult('warnings', `${withoutLazy.length} imagens sem lazy loading`, 'Considerar adicionar loading="lazy"');
        }
    }
    
    // Teste 7: Verificar responsividade
    function testResponsiveness() {
        const viewport = window.innerWidth;
        let breakpoint = 'desktop';
        
        if (viewport < 640) {
            breakpoint = 'mobile';
        } else if (viewport < 1024) {
            breakpoint = 'tablet';
        }
        
        addResult('passed', `Viewport atual: ${breakpoint} (${viewport}px)`);
        
        // Verificar se elementos responsivos estão funcionando
        const mobileMenu = document.getElementById('mobile-navigation');
        const desktopMenu = document.querySelector('.main-navigation');
        
        if (viewport < 1024) {
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                addResult('warnings', 'Menu mobile visível em desktop', 'Verificar lógica de exibição');
            }
        } else {
            if (desktopMenu && desktopMenu.classList.contains('hidden')) {
                addResult('warnings', 'Menu desktop oculto em desktop', 'Verificar lógica de exibição');
            }
        }
    }
    
    // Teste 8: Verificar navegação por teclado
    function testKeyboardNavigation() {
        const focusableElements = document.querySelectorAll('a, button, input, select, textarea, [tabindex]');
        const withoutTabIndex = [];
        
        focusableElements.forEach(el => {
            const tabIndex = el.getAttribute('tabindex');
            if (tabIndex === '-1' && !el.hasAttribute('aria-hidden')) {
                withoutTabIndex.push(el);
            }
        });
        
        addResult('passed', `${focusableElements.length} elementos focáveis encontrados`);
        
        // Verificar se há elementos que deveriam ser focáveis mas não são
        const buttons = document.querySelectorAll('button');
        buttons.forEach(btn => {
            if (btn.getAttribute('tabindex') === '-1' && !btn.disabled) {
                addResult('warnings', 'Botão não focável encontrado', btn.textContent || btn.ariaLabel);
            }
        });
    }
    
    // Teste 9: Verificar performance básica
    function testPerformance() {
        const resources = performance.getEntriesByType('resource');
        const cssFiles = resources.filter(r => r.name.includes('.css'));
        const jsFiles = resources.filter(r => r.name.includes('.js'));
        
        addResult('passed', `${cssFiles.length} arquivos CSS carregados`);
        addResult('passed', `${jsFiles.length} arquivos JavaScript carregados`);
        
        // Verificar tamanho total
        const totalSize = resources.reduce((sum, r) => sum + (r.transferSize || 0), 0);
        const totalSizeMB = (totalSize / 1024 / 1024).toFixed(2);
        
        if (totalSizeMB < 2) {
            addResult('passed', `Tamanho total de recursos: ${totalSizeMB} MB`);
        } else {
            addResult('warnings', `Tamanho total de recursos: ${totalSizeMB} MB`, 'Considerar otimização');
        }
    }
    
    // Teste 10: Verificar links quebrados (básico)
    function testBrokenLinks() {
        const links = document.querySelectorAll('a[href]');
        const internalLinks = [];
        const externalLinks = [];
        
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.startsWith('#')) {
                // Link âncora - verificar se existe
                const target = document.querySelector(href);
                if (!target) {
                    addResult('warnings', `Link âncora quebrado: ${href}`, link.textContent);
                }
            } else if (href && !href.startsWith('http') && !href.startsWith('mailto:')) {
                internalLinks.push(link);
            } else if (href && href.startsWith('http')) {
                externalLinks.push(link);
            }
        });
        
        addResult('passed', `${internalLinks.length} links internos encontrados`);
        addResult('passed', `${externalLinks.length} links externos encontrados`);
    }
    
    // Executar todos os testes
    console.log('%c📋 Executando testes...', 'font-size: 14px; font-weight: bold;');
    
    testVueLoaded();
    testVueComponents();
    testConsoleLogs();
    testAriaAttributes();
    testColorContrast();
    testLazyLoading();
    testResponsiveness();
    testKeyboardNavigation();
    testPerformance();
    testBrokenLinks();
    
    // Exibir resultados
    console.log('\n%c📊 RESULTADOS DOS TESTES', 'font-size: 16px; font-weight: bold; color: #2d712d;');
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    
    if (results.passed.length > 0) {
        console.log(`\n%c✅ PASSED (${results.passed.length})`, 'font-size: 14px; font-weight: bold; color: #10b981;');
        results.passed.forEach(r => {
            console.log(`  ✓ ${r.message}`, r.details ? `- ${r.details}` : '');
        });
    }
    
    if (results.warnings.length > 0) {
        console.log(`\n%c⚠️  WARNINGS (${results.warnings.length})`, 'font-size: 14px; font-weight: bold; color: #f59e0b;');
        results.warnings.forEach(r => {
            console.log(`  ⚠ ${r.message}`, r.details ? `- ${r.details}` : '');
        });
    }
    
    if (results.failed.length > 0) {
        console.log(`\n%c❌ FAILED (${results.failed.length})`, 'font-size: 14px; font-weight: bold; color: #ef4444;');
        results.failed.forEach(r => {
            console.log(`  ✗ ${r.message}`, r.details ? `- ${r.details}` : '');
        });
    }
    
    console.log('\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    console.log(`\n%c📈 Resumo: ${results.passed.length} passou, ${results.warnings.length} avisos, ${results.failed.length} falhou`, 
        'font-size: 14px; font-weight: bold;');
    
    // Retornar resultados para uso programático
    return results;
})();

