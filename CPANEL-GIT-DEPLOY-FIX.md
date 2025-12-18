# Solução para Erro de Deploy no cPanel - Branches Divergentes

## Problema
Erro: `Diverging branches can't be fast-forwarded` no cPanel Git Version Control.

## Causa
O cPanel está configurado para fazer apenas **fast-forward merges**. Quando há qualquer divergência entre o repositório local e remoto (mesmo temporária), o deploy falha.

## Soluções

### Solução 1: Configurar cPanel para Permitir Merge (Recomendado)

No cPanel, ao configurar o Git Version Control:

1. Acesse **Git Version Control** no cPanel
2. Encontre o repositório configurado
3. Nas configurações, altere:
   - **Pull Type**: De `Fast-forward only` para `Merge` ou `Rebase`
   - Ou desmarque a opção "Fast-forward only"

### Solução 2: Garantir Histórico Linear (Preventivo)

Para evitar divergência no futuro:

1. **Sempre fazer pull antes de push:**
   ```bash
   git pull origin master
   git push origin master
   ```

2. **Ou usar rebase para manter histórico linear:**
   ```bash
   git pull --rebase origin master
   git push origin master
   ```

### Solução 3: Forçar Sincronização (Se necessário)

Se o erro persistir, você pode forçar sincronização:

```bash
# No servidor cPanel (via SSH ou terminal)
cd /path/to/your/theme
git fetch origin
git reset --hard origin/master
```

**⚠️ ATENÇÃO:** `git reset --hard` descarta alterações locais não commitadas!

## Configuração Recomendada no cPanel

1. **Pull Type**: `Merge` (permite merge commits)
2. **Auto Deploy**: Habilitado (deploy automático após push)
3. **Branch**: `master` (ou sua branch principal)

## Verificação

Após configurar, teste fazendo um push:

```bash
# Local
git push origin master
```

O cPanel deve fazer deploy automaticamente sem erros.

## Prevenção

Para evitar o problema no futuro:

1. **Sempre sincronizar antes de push:**
   ```bash
   git pull origin master
   git push origin master
   ```

2. **Usar rebase para histórico limpo:**
   ```bash
   git pull --rebase origin master
   git push origin master
   ```

3. **Evitar edições diretas no servidor** (se houver acesso SSH)

---

**Status Atual:** Repositório local e remoto estão sincronizados ✅  
**Próximo Passo:** Configurar cPanel para permitir merge (não apenas fast-forward)

