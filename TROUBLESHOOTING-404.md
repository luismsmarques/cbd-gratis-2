# Troubleshooting - Erros 404 no Servidor

## 🔍 Problema
Os arquivos CSS e JS estão retornando erro 404 no servidor:
- `style.css` - 404
- `assets/css/*.css` - 404
- `assets/js/*.js` - 404

## ✅ Solução Passo a Passo

### Passo 1: Verificar se o Repositório Foi Clonado

1. Acesse o **cPanel**
2. Vá em **Files** > **File Manager**
3. Navegue até: `/public_html/wp-content/themes/`
4. Verifique se existe a pasta `cbd-ai-theme`
5. Dentro de `cbd-ai-theme`, verifique se existe:
   - ✅ Arquivo `style.css`
   - ✅ Arquivo `functions.php`
   - ✅ Pasta `assets/` (com subpastas `css/` e `js/`)
   - ✅ Pasta `.git/` (indica que é um repositório Git)

**Se a pasta `cbd-ai-theme` não existe ou está vazia:**
- O repositório não foi clonado corretamente
- Vá para o **Passo 2**

**Se os arquivos existem mas ainda dá 404:**
- Vá para o **Passo 3**

### Passo 2: Clonar o Repositório Corretamente

1. Acesse **Files** > **Git™ Version Control**
2. Clique em **Create**
3. Configure:
   - **Clone a Repository**: ✅ Ativado
   - **Clone URL**: `https://github.com/luismsmarques/cbd-gratis-2.git`
   - **Repository Path**: `/home/SEU_USUARIO/public_html/wp-content/themes/cbd-ai-theme`
     > ⚠️ Substitua `SEU_USUARIO` pelo seu usuário cPanel
   - **Repository Name**: `cbd-ai-theme`
4. Clique em **Create**
5. Aguarde o clone completar (pode levar alguns minutos)

### Passo 3: Fazer Deployment dos Arquivos

1. No **Git Version Control**, encontre o repositório `cbd-ai-theme`
2. Clique em **Manage**
3. Vá para a aba **Pull or Deploy**
4. Clique em **Update from Remote**
   - Aguarde a mensagem de sucesso
5. Clique em **Deploy HEAD Commit**
   - Aguarde a mensagem de sucesso

### Passo 4: Verificar Permissões

1. No **File Manager**, navegue até `/public_html/wp-content/themes/cbd-ai-theme`
2. Selecione a pasta `cbd-ai-theme`
3. Clique em **Permissions** (ou **Permissões**)
4. Verifique:
   - **Folders (Diretórios)**: `755`
   - **Files (Arquivos)**: `644`
5. Se estiver diferente, ajuste e clique em **Change Permissions**

**Para ajustar permissões de todos os arquivos de uma vez:**
- Selecione a pasta `cbd-ai-theme`
- Clique em **Permissions**
- Marque **Recurse into subdirectories**
- Defina: Pastas = `755`, Arquivos = `644`
- Clique em **Change Permissions**

### Passo 5: Verificar se os Arquivos Existem no GitHub

1. Acesse: https://github.com/luismsmarques/cbd-gratis-2
2. Verifique se os seguintes arquivos/pastas existem:
   - ✅ `style.css`
   - ✅ `functions.php`
   - ✅ `assets/css/` (com vários arquivos .css)
   - ✅ `assets/js/` (com vários arquivos .js)

**Se os arquivos não existem no GitHub:**
- Faça push dos arquivos locais para o GitHub primeiro

### Passo 6: Limpar Cache

1. **Cache do WordPress:**
   - Se usar plugin de cache (WP Super Cache, W3 Total Cache, etc.)
   - Limpe o cache do plugin
   - Ou desative temporariamente para testar

2. **Cache do Navegador:**
   - Pressione `Ctrl + Shift + R` (Windows/Linux)
   - Ou `Cmd + Shift + R` (Mac)
   - Ou abra em modo anônimo/privado

3. **Cache do CDN (se usar):**
   - Limpe o cache do CDN
   - Ou desative temporariamente para testar

### Passo 7: Verificar Logs de Erro

1. No **cPanel**, vá em **Metrics** > **Errors**
2. Verifique se há erros relacionados ao tema
3. Também verifique os logs do WordPress em:
   - `/public_html/wp-content/debug.log` (se WP_DEBUG estiver ativo)

## 🔧 Solução Alternativa: Upload Manual

Se o Git não funcionar, você pode fazer upload manual:

1. No **File Manager**, navegue até `/public_html/wp-content/themes/`
2. Se a pasta `cbd-ai-theme` existir, renomeie para `cbd-ai-theme-backup`
3. Crie uma nova pasta `cbd-ai-theme`
4. Faça download do repositório do GitHub como ZIP:
   - Acesse: https://github.com/luismsmarques/cbd-gratis-2/archive/refs/heads/master.zip
5. Extraia o ZIP localmente
6. Faça upload de todos os arquivos para `/public_html/wp-content/themes/cbd-ai-theme/`
7. Ajuste as permissões (Passo 4)

## 📝 Checklist de Verificação

Use este checklist para diagnosticar:

- [ ] Pasta `cbd-ai-theme` existe em `/public_html/wp-content/themes/`
- [ ] Arquivo `style.css` existe na pasta do tema
- [ ] Arquivo `functions.php` existe na pasta do tema
- [ ] Pasta `assets/css/` existe e contém arquivos .css
- [ ] Pasta `assets/js/` existe e contém arquivos .js
- [ ] Pasta `.git/` existe (indica repositório Git)
- [ ] Permissões estão corretas (755 para pastas, 644 para arquivos)
- [ ] Deployment foi executado no Git Version Control
- [ ] Cache foi limpo
- [ ] Arquivos existem no repositório GitHub

## 🆘 Se Nada Funcionar

1. Verifique se o tema está ativo no WordPress:
   - WordPress Admin > **Aparência** > **Temas**
   - Certifique-se que "CBD AI Theme" está ativo

2. Verifique a URL do tema no WordPress:
   - WordPress Admin > **Aparência** > **Editor de Temas**
   - Verifique se o caminho está correto

3. Entre em contato com o suporte do hosting se:
   - As permissões não podem ser alteradas
   - O Git Version Control não está disponível
   - Há erros de permissão nos logs

## 📚 Referências

- [Guia de Configuração cPanel Git](CPANEL-GIT-SETUP.md)
- [Documentação cPanel Git Version Control](https://docs.cpanel.net/cpanel/files/git-version-control/)

