# Troubleshooting - Erro 403 (Forbidden)

## 🔍 Problema
Os arquivos estão retornando erro **403 Forbidden** ao tentar acessar:
- Arquivos CSS retornam 403
- Arquivos JS retornam 403
- Arquivos do tema não podem ser acessados

## ✅ Solução Passo a Passo

### Passo 1: Verificar Permissões dos Arquivos

O erro 403 geralmente é causado por permissões incorretas. Siga estes passos:

1. **No cPanel, acesse File Manager**
2. **Navegue até:** `/public_html/wp-content/themes/cbd-ai-theme`
3. **Selecione a pasta `cbd-ai-theme`**
4. **Clique em "Permissions" (ou "Permissões")**
5. **Configure:**
   - **Numeric Value**: `755` (para pastas)
   - **Marcar**: "Recurse into subdirectories" ✅
   - **Clique em "Change Permissions"**

6. **Agora ajuste permissões dos arquivos:**
   - **Selecione novamente a pasta `cbd-ai-theme`**
   - **Clique em "Permissions"**
   - **Configure:**
     - **Numeric Value**: `644` (para arquivos)
     - **Marcar**: "Recurse into subdirectories" ✅
     - **Clique em "Change Permissions"**

### Passo 2: Verificar Permissões Específicas

Verifique se estas pastas/arquivos têm as permissões corretas:

**Pastas (devem ser 755):**
- `/public_html/wp-content/themes/cbd-ai-theme` → `755`
- `/public_html/wp-content/themes/cbd-ai-theme/assets` → `755`
- `/public_html/wp-content/themes/cbd-ai-theme/assets/css` → `755`
- `/public_html/wp-content/themes/cbd-ai-theme/assets/js` → `755`

**Arquivos (devem ser 644):**
- `/public_html/wp-content/themes/cbd-ai-theme/style.css` → `644`
- `/public_html/wp-content/themes/cbd-ai-theme/functions.php` → `644`
- Todos os arquivos `.css` em `assets/css/` → `644`
- Todos os arquivos `.js` em `assets/js/` → `644`

### Passo 3: Verificar Arquivo .htaccess

O arquivo `.htaccess` foi adicionado ao repositório para proteger o tema. Verifique:

1. **No File Manager, navegue até:** `/public_html/wp-content/themes/cbd-ai-theme`
2. **Verifique se existe o arquivo `.htaccess`**
3. **Se não existir:**
   - Faça **Update from Remote** no Git Version Control
   - Ou crie manualmente o arquivo `.htaccess` com o conteúdo do repositório

4. **Se o `.htaccess` existir mas estiver causando problemas:**
   - Renomeie temporariamente para `.htaccess.backup`
   - Teste se os arquivos carregam
   - Se funcionar, o problema está no `.htaccess`

### Passo 4: Verificar Configuração do Servidor

Alguns servidores bloqueiam acesso direto a arquivos em pastas de temas. Verifique:

1. **Tente acessar diretamente um arquivo CSS:**
   ```
   https://cbd.gratis/wp-content/themes/cbd-ai-theme/assets/css/style.css
   ```

2. **Se retornar 403:**
   - O problema pode ser configuração do servidor
   - Entre em contato com o suporte do hosting

### Passo 5: Verificar Owner dos Arquivos

O owner (proprietário) dos arquivos deve ser o seu usuário cPanel:

1. **No File Manager, selecione a pasta `cbd-ai-theme`**
2. **Clique com botão direito** → **Change Permissions**
3. **Verifique o "Owner"** - deve ser seu usuário cPanel
4. **Se não for:**
   - Entre em contato com o suporte do hosting
   - Ou use o Terminal do cPanel para corrigir:
     ```bash
     chown -R SEU_USUARIO:SEU_USUARIO /home/SEU_USUARIO/public_html/wp-content/themes/cbd-ai-theme
     ```

### Passo 6: Verificar Configuração de Segurança do cPanel

Alguns recursos de segurança do cPanel podem bloquear acesso:

1. **No cPanel, procure por "Hotlink Protection"**
2. **Verifique se está bloqueando arquivos do tema**
3. **Desative temporariamente para testar**

4. **Verifique "IP Blocker"**
5. **Certifique-se que seu IP não está bloqueado**

### Passo 7: Verificar Logs de Erro

1. **No cPanel, vá em "Metrics" > "Errors"**
2. **Verifique se há erros relacionados a permissões**
3. **Procure por mensagens como:**
   - "Permission denied"
   - "Forbidden"
   - "Access denied"

## 🔧 Solução Rápida via Terminal (cPanel)

Se você tem acesso ao Terminal do cPanel:

```bash
# Navegar até a pasta do tema
cd ~/public_html/wp-content/themes/cbd-ai-theme

# Ajustar permissões de pastas para 755
find . -type d -exec chmod 755 {} \;

# Ajustar permissões de arquivos para 644
find . -type f -exec chmod 644 {} \;

# Garantir que o owner está correto
chown -R $(whoami):$(whoami) .
```

## 📝 Checklist de Verificação

Use este checklist para diagnosticar:

- [ ] Permissões das pastas estão em **755**
- [ ] Permissões dos arquivos estão em **644**
- [ ] Arquivo `.htaccess` existe e está correto
- [ ] Owner dos arquivos é seu usuário cPanel
- [ ] Hotlink Protection não está bloqueando
- [ ] IP não está bloqueado
- [ ] Arquivos existem no servidor (não são 404)
- [ ] Logs de erro não mostram problemas de permissão

## 🆘 Se Nada Funcionar

1. **Entre em contato com o suporte do hosting:**
   - Informe que está recebendo erro 403
   - Peça para verificar permissões e configuração do servidor
   - Peça para verificar se há regras de segurança bloqueando

2. **Alternativa temporária:**
   - Faça upload manual dos arquivos CSS/JS
   - Use o File Manager para fazer upload direto
   - Isso pode ajudar a identificar se é problema de Git ou permissões

## 🔄 Depois de Corrigir

1. **Limpe o cache:**
   - Cache do WordPress
   - Cache do navegador (Ctrl+Shift+R)
   - Cache do CDN (se usar)

2. **Teste novamente:**
   - Acesse o site
   - Verifique o console do navegador (F12)
   - Confirme que não há mais erros 403

## 📚 Referências

- [Guia de Configuração cPanel Git](CPANEL-GIT-SETUP.md)
- [Troubleshooting 404](TROUBLESHOOTING-404.md)
- [Documentação cPanel File Permissions](https://docs.cpanel.net/cpanel/files/change-permissions/)

