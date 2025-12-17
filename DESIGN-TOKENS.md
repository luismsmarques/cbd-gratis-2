# Design Tokens - CBD AI Theme

**Versão:** 1.0.0  
**Última Atualização:** 2024

Este documento descreve todos os tokens de design utilizados no tema CBD AI Theme, baseado no Material UI Design System.

---

## 📋 Índice

1. [Paleta de Cores](#paleta-de-cores)
2. [Tipografia](#tipografia)
3. [Espaçamentos](#espaçamentos)
4. [Shadows / Elevation](#shadows--elevation)
5. [Border Radius](#border-radius)
6. [Transições](#transições)
7. [Breakpoints](#breakpoints)

---

## 🎨 Paleta de Cores

### Cores de Rigor (Azul e Cinzas)

| Token | Valor | Uso |
|-------|-------|-----|
| `--mui-blue-primary` | `#1976d2` | Cor primária azul - botões principais, links importantes |
| `--mui-blue-dark` | `#1565c0` | Hover de elementos azuis primários |
| `--mui-blue-light` | `#42a5f5` | Estados hover/light de elementos azuis |
| `--mui-gray-900` | `#212121` | Texto principal, títulos |
| `--mui-gray-800` | `#424242` | Texto secundário |
| `--mui-gray-700` | `#616161` | Texto terciário |
| `--mui-gray-600` | `#757575` | Texto de apoio, labels |
| `--mui-gray-500` | `#9e9e9e` | Placeholders, ícones secundários |
| `--mui-gray-400` | `#bdbdbd` | Bordas, divisores |
| `--mui-gray-300` | `#e0e0e0` | Bordas claras |
| `--mui-gray-200` | `#eeeeee` | Backgrounds sutis |
| `--mui-gray-100` | `#f5f5f5` | Backgrounds de cards |
| `--mui-gray-50` | `#fafafa` | Backgrounds de páginas |

**Uso Recomendado:**
- Azul: Elementos de ação primária, links importantes, destaques
- Cinzas: Hierarquia de texto, backgrounds, bordas

---

### Cores de Inovação/Saúde (Teal e Mint)

| Token | Valor | Uso |
|-------|-------|-----|
| `--mui-teal-primary` | `#00897b` | Cor de inovação - elementos de destaque secundário |
| `--mui-teal-dark` | `#00695c` | Hover de elementos teal |
| `--mui-teal-light` | `#4db6ac` | Estados light de elementos teal |
| `--mui-mint-primary` | `#81c784` | Cor de saúde - elementos relacionados a bem-estar |
| `--mui-mint-dark` | `#66bb6a` | Hover de elementos mint |
| `--mui-mint-light` | `#a5d6a7` | Estados light de elementos mint |

**Uso Recomendado:**
- Teal: Elementos de inovação, tecnologia, modernidade
- Mint: Elementos relacionados a saúde, bem-estar, natureza

---

### Cores de Status

| Token | Valor | Uso |
|-------|-------|-----|
| `--mui-success` | `#4caf50` | Sucesso, confirmação, status positivo |
| `--mui-warning` | `#ff9800` | Avisos, atenção necessária |
| `--mui-error` | `#f44336` | Erros, ações destrutivas |
| `--mui-info` | `#2196f3` | Informações, dicas |

**Uso Recomendado:**
- Success: Mensagens de sucesso, badges de status positivo
- Warning: Alertas que requerem atenção
- Error: Mensagens de erro, ações destrutivas
- Info: Informações gerais, tooltips

---

### Cores Específicas do Tema CBD

| Token | Valor | Uso |
|-------|-------|-----|
| `--mui-cbd-green-50` | `#f0f9f0` | Backgrounds sutis relacionados a CBD |
| `--mui-cbd-green-100` | `#d4edda` | Backgrounds de alertas sucesso |
| `--mui-cbd-green-200` | `#bce5bc` | Backgrounds de badges |
| `--mui-cbd-green-500` | `#3d8f3d` | Cor principal do tema CBD |
| `--mui-cbd-green-600` | `#2d712d` | Hover de elementos CBD |
| `--mui-cbd-green-700` | `#255a25` | Estados ativos |
| `--mui-cbd-green-800` | `#166534` | Gradientes escuros |
| `--mui-cbd-green-900` | `#14532d` | Gradientes muito escuros |
| `--mui-cbd-green-950` | `#0f2817` | Gradientes extremamente escuros |

**Uso Recomendado:**
- Verde CBD: Elementos relacionados ao tema CBD, botões principais do tema, links internos

---

## 📝 Tipografia

### Escala de Tipografia MUI

| Classe | Font Size | Font Weight | Line Height | Letter Spacing | Uso |
|--------|-----------|-------------|-------------|----------------|-----|
| `.mui-typography-h1` | `2.5rem` (40px) | `300` | `1.2` | `-0.01562em` | Título principal da página |
| `.mui-typography-h2` | `2rem` (32px) | `300` | `1.2` | `-0.00833em` | Subtítulos principais |
| `.mui-typography-h3` | `1.75rem` (28px) | `400` | `1.2` | `0em` | Títulos de seção |
| `.mui-typography-h4` | `1.5rem` (24px) | `400` | `1.235` | `0.00735em` | Subtítulos de seção |
| `.mui-typography-h5` | `1.25rem` (20px) | `400` | `1.334` | `0em` | Títulos de cards |
| `.mui-typography-h6` | `1.125rem` (18px) | `500` | `1.6` | `0.0075em` | Títulos pequenos |
| `.mui-typography-body1` | `1rem` (16px) | `400` | `1.5` | `0.00938em` | Texto corpo principal |
| `.mui-typography-body2` | `0.875rem` (14px) | `400` | `1.43` | `0.01071em` | Texto corpo secundário |
| `.mui-typography-subtitle1` | `1rem` (16px) | `400` | `1.75` | `0.00938em` | Subtítulos |
| `.mui-typography-subtitle2` | `0.875rem` (14px) | `500` | `1.57` | `0.00714em` | Subtítulos pequenos |
| `.mui-typography-caption` | `0.75rem` (12px) | `400` | `1.66` | `0.03333em` | Legendas, notas |
| `.mui-typography-button` | `0.875rem` (14px) | `500` | `1.75` | `0.02857em` | Texto de botões |

**Responsividade:**
- Em mobile (< 768px), H1 reduz para `2rem`
- Em mobile, H2 reduz para `1.5rem`
- Em mobile, H3 reduz para `1.25rem`

---

## 📏 Espaçamentos

### Escala de Espaçamento (Base 8px)

| Token | Valor | Pixels | Uso |
|-------|-------|--------|-----|
| `--mui-spacing-1` | `0.25rem` | `4px` | Espaçamentos mínimos |
| `--mui-spacing-2` | `0.5rem` | `8px` | Espaçamento base |
| `--mui-spacing-3` | `0.75rem` | `12px` | Espaçamentos pequenos |
| `--mui-spacing-4` | `1rem` | `16px` | Espaçamento padrão |
| `--mui-spacing-5` | `1.25rem` | `20px` | Espaçamentos médios |
| `--mui-spacing-6` | `1.5rem` | `24px` | Espaçamentos entre elementos |
| `--mui-spacing-8` | `2rem` | `32px` | Espaçamentos entre seções |
| `--mui-spacing-10` | `2.5rem` | `40px` | Espaçamentos grandes |
| `--mui-spacing-12` | `3rem` | `48px` | Espaçamentos muito grandes |
| `--mui-spacing-16` | `4rem` | `64px` | Espaçamentos hero |
| `--mui-spacing-20` | `5rem` | `80px` | Espaçamentos extremos |
| `--mui-spacing-24` | `6rem` | `96px` | Espaçamentos hero grandes |

**Uso Recomendado:**
- Use múltiplos de 8px para consistência
- Prefira `--mui-spacing-4` (16px) como padrão
- Use `--mui-spacing-8` (32px) para espaçamento entre seções principais

**Exemplo:**
```css
.card {
  padding: var(--mui-spacing-4);
  margin-bottom: var(--mui-spacing-6);
}
```

---

## 🌑 Shadows / Elevation

### Sistema de Elevação MUI

| Token | Valor | Uso |
|-------|-------|-----|
| `--mui-shadow-1` | `0px 2px 1px -1px rgba(0,0,0,0.2), 0px 1px 1px 0px rgba(0,0,0,0.14), 0px 1px 3px 0px rgba(0,0,0,0.12)` | Cards básicos, elementos em repouso |
| `--mui-shadow-2` | `0px 3px 1px -2px rgba(0,0,0,0.2), 0px 2px 2px 0px rgba(0,0,0,0.14), 0px 1px 5px 0px rgba(0,0,0,0.12)` | Botões, elementos interativos |
| `--mui-shadow-4` | `0px 2px 4px -1px rgba(0,0,0,0.2), 0px 4px 5px 0px rgba(0,0,0,0.14), 0px 1px 10px 0px rgba(0,0,0,0.12)` | Cards elevados, hover states |
| `--mui-shadow-8` | `0px 5px 5px -3px rgba(0,0,0,0.2), 0px 8px 10px 1px rgba(0,0,0,0.14), 0px 3px 14px 2px rgba(0,0,0,0.12)` | Modais, dropdowns |
| `--mui-shadow-16` | `0px 8px 10px -5px rgba(0,0,0,0.2), 0px 16px 24px 2px rgba(0,0,0,0.14), 0px 6px 30px 5px rgba(0,0,0,0.12)` | Dialogs, popovers |
| `--mui-shadow-24` | `0px 11px 15px -7px rgba(0,0,0,0.2), 0px 24px 38px 3px rgba(0,0,0,0.14), 0px 9px 46px 8px rgba(0,0,0,0.12)` | Elementos flutuantes máximos |

**Uso Recomendado:**
- Shadow-1: Cards padrão
- Shadow-2: Botões, inputs focados
- Shadow-4: Cards em hover, elementos destacados
- Shadow-8: Dropdowns, menus
- Shadow-16: Modais, dialogs
- Shadow-24: Tooltips flutuantes

**Exemplo:**
```css
.mui-card {
  box-shadow: var(--mui-shadow-1);
}

.mui-card:hover {
  box-shadow: var(--mui-shadow-4);
}
```

---

## 🔲 Border Radius

| Token | Valor | Pixels | Uso |
|-------|-------|--------|-----|
| `--mui-radius-sm` | `0.25rem` | `4px` | Bordas sutis, inputs pequenos |
| `--mui-radius-md` | `0.5rem` | `8px` | Bordas padrão, botões, cards |
| `--mui-radius-lg` | `0.75rem` | `12px` | Cards grandes, containers |
| `--mui-radius-xl` | `1rem` | `16px` | Cards destacados |
| `--mui-radius-2xl` | `1.5rem` | `24px` | Cards muito grandes |
| `--mui-radius-full` | `9999px` | - | Pills, badges circulares |

**Uso Recomendado:**
- Radius-md (8px): Padrão para a maioria dos elementos
- Radius-lg (12px): Cards e containers maiores
- Radius-full: Badges, avatares, pills

**Exemplo:**
```css
.button {
  border-radius: var(--mui-radius-md);
}

.badge {
  border-radius: var(--mui-radius-full);
}
```

---

## ⚡ Transições

| Token | Valor | Uso |
|-------|-------|-----|
| `--mui-transition-fast` | `150ms cubic-bezier(0.4, 0, 0.2, 1)` | Transições rápidas, hovers sutis |
| `--mui-transition-base` | `250ms cubic-bezier(0.4, 0, 0.2, 1)` | Transições padrão |
| `--mui-transition-slow` | `300ms cubic-bezier(0.4, 0, 0.2, 1)` | Transições suaves, animações |
| `--mui-transition-ease` | `cubic-bezier(0.4, 0, 0.2, 1)` | Função de easing padrão MUI |

**Uso Recomendado:**
- Fast: Hovers, mudanças de estado rápidas
- Base: Transições padrão de elementos
- Slow: Animações, transições de página

**Exemplo:**
```css
.button {
  transition: background-color var(--mui-transition-fast);
}

.card {
  transition: transform var(--mui-transition-base);
}
```

---

## 📱 Breakpoints

| Token | Valor | Uso |
|-------|-------|-----|
| `--mui-breakpoint-xs` | `0px` | Mobile pequeno |
| `--mui-breakpoint-sm` | `600px` | Mobile grande / Tablet pequeno |
| `--mui-breakpoint-md` | `960px` | Tablet / Desktop pequeno |
| `--mui-breakpoint-lg` | `1280px` | Desktop |
| `--mui-breakpoint-xl` | `1920px` | Desktop grande |

**Nota:** Breakpoints são apenas para referência. Use media queries diretamente:

```css
@media (min-width: 600px) {
  /* Tablet e acima */
}

@media (min-width: 960px) {
  /* Desktop e acima */
}
```

**Estratégia Mobile-First:**
- Sempre comece com estilos mobile
- Use `min-width` para adicionar estilos em breakpoints maiores
- Evite `max-width` quando possível

---

## 📚 Guia de Uso

### Quando Usar Cada Token

**Cores:**
- Use `--mui-blue-primary` para ações primárias
- Use `--mui-teal-primary` para elementos de inovação
- Use `--mui-cbd-green-600` para elementos específicos do tema CBD
- Use `--mui-gray-*` para hierarquia de texto e backgrounds

**Espaçamentos:**
- Use múltiplos de `--mui-spacing-4` (16px) para consistência
- Prefira `--mui-spacing-4`, `--mui-spacing-6`, `--mui-spacing-8` para espaçamentos comuns

**Shadows:**
- Use `--mui-shadow-1` para cards padrão
- Use `--mui-shadow-4` para hover states
- Use `--mui-shadow-8` ou superior para elementos flutuantes

**Border Radius:**
- Use `--mui-radius-md` como padrão
- Use `--mui-radius-full` para elementos circulares

---

## 🔄 Migração de Valores Hardcoded

### Antes (Hardcoded)
```css
.card {
  padding: 16px;
  margin-bottom: 24px;
  border-radius: 8px;
  box-shadow: 0px 2px 4px rgba(0,0,0,0.1);
  color: #212121;
}
```

### Depois (Com Tokens)
```css
.card {
  padding: var(--mui-spacing-4);
  margin-bottom: var(--mui-spacing-6);
  border-radius: var(--mui-radius-md);
  box-shadow: var(--mui-shadow-4);
  color: var(--mui-gray-900);
}
```

---

## ✅ Checklist de Consistência

Ao criar novos estilos, verifique:

- [ ] Cores usam variáveis `--mui-*` ou `--mui-cbd-green-*`
- [ ] Espaçamentos usam `--mui-spacing-*`
- [ ] Shadows usam `--mui-shadow-*`
- [ ] Border radius usa `--mui-radius-*`
- [ ] Transições usam `--mui-transition-*`
- [ ] Tipografia usa classes `.mui-typography-*`

---

## 📖 Referências

- [Material Design Guidelines](https://material.io/design)
- [MUI Design System](https://mui.com/material-ui/customization/theming/)
- [Design Tokens W3C](https://www.w3.org/community/design-tokens/)

---

**Última Atualização:** 2024  
**Mantido por:** Equipa de Front-end CBD.gratis

