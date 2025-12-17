#!/bin/bash
# Script de deploy para cPanel - Copia apenas os arquivos do tema

# Remove tema antigo
rm -rf $HOME/public_html/wp-content/themes/cbd-ai-theme

# Cria diretório de temas se não existir
mkdir -p $HOME/public_html/wp-content/themes

# Copia apenas o conteúdo do tema (sem a estrutura app/public/)
if [ -d "app/public/wp-content/themes/cbd-ai-theme" ]; then
    cp -R app/public/wp-content/themes/cbd-ai-theme $HOME/public_html/wp-content/themes/
elif [ -d "wp-content/themes/cbd-ai-theme" ]; then
    cp -R wp-content/themes/cbd-ai-theme $HOME/public_html/wp-content/themes/
fi

# Ajusta permissões
chmod -R 755 $HOME/public_html/wp-content/themes/cbd-ai-theme
find $HOME/public_html/wp-content/themes/cbd-ai-theme -type f -exec chmod 644 {} \;

echo "Deploy concluído: Tema copiado para $HOME/public_html/wp-content/themes/cbd-ai-theme"

