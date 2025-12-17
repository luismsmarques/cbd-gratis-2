# Configuração Git Version Control no cPanel

Este guia explica como configurar o Git Version Control no cPanel para fazer deployment automático do tema WordPress.

## 📋 Pré-requisitos

1. Acesso ao cPanel com Git Version Control habilitado
2. Repositório GitHub configurado: `https://github.com/luismsmarques/cbd-gratis-2`
3. Caminho do tema no servidor: `/home/USUARIO/public_html/wp-content/themes/cbd-ai-theme`

## 🚀 Passos para Configuração

### 1. Acessar Git Version Control no cPanel

1. Faça login no cPanel
2. Navegue até **Files** > **Git™ Version Control**

### 2. Criar/Clonar Repositório

1. Clique em **Create** no canto superior direito
2. Ative o toggle **Clone a Repository**
3. No campo **Clone URL**, insira:
   ```
   https://github.com/luismsmarques/cbd-gratis-2.git
   ```
4. No campo **Repository Path**, insira o caminho completo do tema:
   ```
   /home/USUARIO/public_html/wp-content/themes/cbd-ai-theme
   ```
   > ⚠️ **Importante**: Substitua `USUARIO` pelo seu nome de usuário do cPanel

5. No campo **Repository Name**, insira:
   ```
   cbd-ai-theme
   ```

6. Clique em **Create**

### 3. Configurar Deployment Automático

O arquivo `.cpanel.yml` já está configurado no repositório para fazer deployment automático. Ele irá:

- Copiar todos os arquivos do repositório para a pasta do tema
- Ajustar permissões corretamente (755 para pastas, 644 para arquivos)

### 4. Fazer Pull/Deploy Manual (se necessário)

1. Na lista de repositórios, clique em **Manage** ao lado do repositório
2. Vá para a aba **Pull or Deploy**
3. Clique em **Update from Remote** para puxar as últimas alterações
4. Clique em **Deploy HEAD Commit** para fazer o deployment

## 🔄 Workflow de Atualização

### Quando você fizer push para o GitHub:

1. O cPanel detectará automaticamente as mudanças
2. Use **Update from Remote** para baixar as alterações
3. Use **Deploy HEAD Commit** para aplicar as alterações ao tema

### Deployment Automático via Post-Receive Hook

O cPanel adiciona automaticamente um hook `post-receive` que executa o `.cpanel.yml` quando você faz push para o repositório. Isso significa que:

- Quando você faz `git push` para o GitHub
- E depois faz **Update from Remote** no cPanel
- O deployment acontece automaticamente via `.cpanel.yml`

## ⚙️ Configuração do .cpanel.yml

O arquivo `.cpanel.yml` está configurado para:

```yaml
---
deployment:
  tasks:
    - export DEPLOYPATH=/home/$USER/public_html/wp-content/themes/cbd-ai-theme
    - /bin/cp -R * $DEPLOYPATH/
    - /bin/chmod -R 755 $DEPLOYPATH
    - /bin/find $DEPLOYPATH -type f -exec chmod 644 {} \;
```

**Nota**: Se o caminho do seu tema for diferente, você precisará ajustar a variável `DEPLOYPATH` no `.cpanel.yml`.

## 🔐 SSH para Repositórios Privados

Se o repositório for privado, você precisará configurar SSH:

1. Acesse **Advanced** > **Terminal** no cPanel
2. Siga o guia: [Set Up Access to Private Repositories](https://docs.cpanel.net/cpanel/files/git-version-control/#guide-to-git-set-up-access-to-private-repositories)

## 📝 Notas Importantes

- ⚠️ **Nunca modifique ou delete a pasta `.git`** dentro do repositório
- ✅ O `.gitignore` está configurado para ignorar arquivos desnecessários (node_modules, arquivos temporários, etc.)
- 🔄 Sempre faça **Update from Remote** antes de **Deploy HEAD Commit**
- 📁 Certifique-se de que o caminho do repositório está correto antes de criar

## 🐛 Troubleshooting

### Repositório não aparece na lista
- Certifique-se de que criou o repositório através da interface do cPanel
- Repositórios criados manualmente via linha de comando podem não aparecer

### Deployment falha
- Verifique as permissões da pasta do tema
- Certifique-se de que o caminho no `.cpanel.yml` está correto
- Verifique os logs de erro no cPanel

### Arquivos não atualizam
- Faça **Update from Remote** primeiro
- Depois faça **Deploy HEAD Commit**
- Verifique se há conflitos de merge

### Erros 404 - Arquivos CSS/JS não encontrados
Este é um problema comum que pode ter várias causas:

1. **Verificar se o repositório foi clonado corretamente:**
   - Acesse **File Manager** no cPanel
   - Navegue até `/public_html/wp-content/themes/cbd-ai-theme`
   - Verifique se os arquivos `style.css`, `functions.php` e a pasta `assets/` existem

2. **Verificar se o deployment foi executado:**
   - No Git Version Control, clique em **Manage**
   - Vá para **Pull or Deploy**
   - Clique em **Update from Remote** (aguarde concluir)
   - Clique em **Deploy HEAD Commit** (aguarde concluir)

3. **Verificar permissões dos arquivos:**
   - No File Manager, selecione a pasta `cbd-ai-theme`
   - Clique em **Permissions** (ou **Permissões**)
   - Pastas devem ter permissão **755**
   - Arquivos devem ter permissão **644**

4. **Verificar se os arquivos existem no repositório GitHub:**
   - Acesse: https://github.com/luismsmarques/cbd-gratis-2
   - Verifique se os arquivos `style.css` e `assets/` estão presentes

5. **Se os arquivos não existem no servidor:**
   - No File Manager, verifique se há uma pasta `.git` dentro de `cbd-ai-theme`
   - Se não houver, o repositório não foi clonado corretamente
   - Recrie o repositório no Git Version Control

6. **Limpar cache do WordPress:**
   - Se usar plugin de cache, limpe o cache
   - Ou adicione `?nocache=1` na URL para testar sem cache

## 📚 Referências

- [Documentação Oficial cPanel Git Version Control](https://docs.cpanel.net/cpanel/files/git-version-control/)
- [Documentação Deployment cPanel](https://docs.cpanel.net/knowledge-base/general-systems-administration/how-to-use-git-deployment/)

