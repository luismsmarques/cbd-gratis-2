# Guia de Configuração - Git Version Control no cPanel

Este guia explica como configurar o Git Version Control do cPanel para atualizar automaticamente o tema WordPress no servidor.

## 📋 Pré-requisitos

1. Acesso ao cPanel com Git Version Control habilitado
2. Node.js instalado no servidor (geralmente via cPanel ou SSH)
3. Repositório Git configurado (GitHub, GitLab, Bitbucket, etc.)

## 🚀 Passo a Passo

### 1. Preparar o Repositório Local

No seu ambiente de desenvolvimento local, execute:

```bash
cd wp-content/themes/cbd-ai-theme

# Inicializar repositório Git (se ainda não foi feito)
git init

# Adicionar todos os arquivos (exceto os ignorados pelo .gitignore)
git add .

# Fazer o primeiro commit
git commit -m "Configuração inicial do tema CBD AI"

# Adicionar o repositório remoto (substitua pela URL do seu repositório)
git remote add origin https://github.com/seu-usuario/seu-repositorio.git

# Enviar para o repositório remoto
git push -u origin main
# ou
git push -u origin master
```

### 2. Configurar no cPanel

#### 2.1. Criar Repositório no cPanel

1. Acesse o **cPanel**
2. Na seção **Arquivos**, clique em **Git™ Version Control**
3. Clique em **Criar** (botão no canto superior direito)
4. Configure:
   - **Clone a Repository**: ✅ Ativado
   - **Clone URL**: Cole a URL do seu repositório remoto
     - Exemplo HTTPS: `https://github.com/seu-usuario/seu-repositorio.git`
     - Exemplo SSH: `[email protected]:seu-usuario/seu-repositorio.git`
   - **Repository Path**: `/home/seu-usuario/public_html/wp-content/themes/cbd-ai-theme`
     - ⚠️ **IMPORTANTE**: Este deve ser o caminho completo até a pasta do tema
     - Substitua `seu-usuario` pelo seu nome de usuário do cPanel
   - **Repository Name**: `cbd-ai-theme` (ou outro nome descritivo)
5. Clique em **Criar**

#### 2.2. Verificar SSH (se usar SSH)

Se você usar uma URL SSH para clonar repositórios privados:

1. O cPanel solicitará verificação da chave SSH do host remoto
2. Clique em **Save and Continue** para adicionar a chave
3. Para mais informações, consulte: [Guide to Git - Set Up Access to Private Repositories](https://docs.cpanel.net/cpanel/files/git-version-control/)

### 3. Configurar Deployment Automático

Após criar o repositório:

1. Na lista de repositórios, encontre o seu repositório
2. Clique em **Gerenciar** (Manage)
3. Vá para a aba **Pull or Deploy**
4. O arquivo `.cpanel.yml` já está configurado e será usado automaticamente

### 4. Fazer o Primeiro Deploy

1. No cPanel, vá em **Gerenciar** > **Pull or Deploy**
2. Clique em **Update from Remote** para fazer o primeiro pull
3. Após o pull, clique em **Deploy HEAD Commit**
4. O sistema executará automaticamente:
   - Instalação de dependências npm
   - Compilação dos assets (Vite)
   - Compilação do Tailwind CSS
   - Ajuste de permissões

### 5. Atualizações Futuras

Agora, sempre que você fizer push para o repositório remoto:

1. No cPanel, vá em **Gerenciar** > **Pull or Deploy**
2. Clique em **Update from Remote** para buscar as mudanças
3. Clique em **Deploy HEAD Commit** para aplicar as mudanças

**Ou configure um hook automático** (requer acesso SSH):
- Configure um webhook no seu repositório Git para chamar o cPanel automaticamente
- Ou configure um cron job no cPanel para fazer pull periódico

## ⚙️ Configuração do .cpanel.yml

O arquivo `.cpanel.yml` está configurado para:

1. **Instalar dependências**: `npm install`
2. **Compilar Vite**: `npm run build`
3. **Compilar Tailwind**: `npm run tailwind:build`
4. **Ajustar permissões**: `chmod -R 755`

### Personalizar o .cpanel.yml

Se precisar ajustar o caminho ou comandos, edite o arquivo `.cpanel.yml` na raiz do tema.

**Variáveis disponíveis:**
- `$HOME` - Diretório home do usuário
- `$CPANEL_USER` - Nome de usuário do cPanel

**Exemplo de caminho personalizado:**
```yaml
deployment:
  tasks:
    - cd $HOME/public_html/wp-content/themes/cbd-ai-theme && npm install
```

## 🔧 Troubleshooting

### Erro: "npm: command not found"

**Solução**: Node.js não está instalado ou não está no PATH.

1. Verifique se o Node.js está instalado no servidor
2. No `.cpanel.yml`, ajuste o caminho do Node.js:
   ```yaml
   - export PATH="/usr/local/bin:$PATH" && npm install
   ```

### Erro: "Permission denied"

**Solução**: Problema de permissões.

1. Verifique as permissões da pasta do tema
2. O `.cpanel.yml` já inclui `chmod -R 755`, mas você pode ajustar se necessário

### Assets não compilam

**Solução**: Verifique os logs de deployment.

1. No cPanel, vá em **Gerenciar** > **Pull or Deploy**
2. Verifique as mensagens de erro após o deploy
3. Teste os comandos manualmente via SSH:
   ```bash
   cd ~/public_html/wp-content/themes/cbd-ai-theme
   npm install
   npm run build
   npm run tailwind:build
   ```

### Repositório não atualiza

**Solução**: Verifique a configuração do repositório.

1. Verifique se a URL do repositório está correta
2. Verifique se você tem permissões para acessar o repositório
3. Para repositórios privados, configure SSH keys no cPanel

## 📚 Recursos Adicionais

- [Documentação oficial do cPanel Git Version Control](https://docs.cpanel.net/cpanel/files/git-version-control/)
- [Guia de Deployment do cPanel](https://docs.cpanel.net/cpanel/files/git-version-control/#manage-repositories)
- [Configuração de SSH para repositórios privados](https://docs.cpanel.net/cpanel/files/git-version-control/#ssh-host-key-verification)

## ✅ Checklist Final

- [ ] Repositório Git criado e configurado localmente
- [ ] Arquivos commitados e enviados para o repositório remoto
- [ ] Repositório criado no cPanel Git Version Control
- [ ] Caminho do repositório aponta para a pasta do tema WordPress
- [ ] Arquivo `.cpanel.yml` está na raiz do repositório
- [ ] Primeiro deploy executado com sucesso
- [ ] Assets compilados corretamente (verificar pasta `assets/dist` e `assets/css/tailwind-output.css`)

## 🎯 Próximos Passos

Após configurar tudo:

1. Faça uma alteração pequena no tema
2. Commit e push para o repositório remoto
3. No cPanel, faça **Update from Remote** e **Deploy HEAD Commit**
4. Verifique se as mudanças aparecem no site WordPress

---

**Nota**: O arquivo `.cpanel.yml` deve estar commitado no repositório remoto para funcionar. Certifique-se de fazer push deste arquivo.

