<?php
/**
 * Icon Checker Script
 * 
 * Execute este script via browser para verificar se todos os ícones estão presentes
 * Acesse: /wp-content/themes/cbd-ai-theme/assets/images/icons/check-icons.php
 * 
 * @package CBD_AI_Theme
 */

// Security check
if ( ! defined( 'ABSPATH' ) ) {
	// Allow direct access for checking
	header( 'Content-Type: text/html; charset=utf-8' );
}

$icons_dir = __DIR__;
$required_icons = array(
	'favicon.ico' => 'Favicon ICO (16x16, 32x32, 48x48)',
	'favicon-16x16.png' => 'Favicon 16x16 PNG',
	'favicon-32x32.png' => 'Favicon 32x32 PNG',
	'apple-touch-icon.png' => 'Apple Touch Icon 180x180 PNG',
	'android-chrome-192x192.png' => 'Android Chrome 192x192 PNG',
	'android-chrome-512x512.png' => 'Android Chrome 512x512 PNG',
	'mstile-144x144.png' => 'Windows Tile 144x144 PNG',
	'site.webmanifest' => 'Web App Manifest JSON',
);

?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verificação de Ícones - CBD AI Theme</title>
	<style>
		body {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
			max-width: 800px;
			margin: 40px auto;
			padding: 20px;
			background: #f5f5f5;
		}
		.container {
			background: white;
			padding: 30px;
			border-radius: 8px;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}
		h1 {
			color: #00897b;
			margin-top: 0;
		}
		.icon-item {
			display: flex;
			align-items: center;
			padding: 12px;
			margin: 8px 0;
			border-radius: 4px;
			background: #f9f9f9;
		}
		.icon-item.missing {
			background: #ffebee;
			border-left: 4px solid #f44336;
		}
		.icon-item.exists {
			background: #e8f5e9;
			border-left: 4px solid #4caf50;
		}
		.status {
			font-weight: bold;
			margin-right: 15px;
			min-width: 80px;
		}
		.status.missing {
			color: #f44336;
		}
		.status.exists {
			color: #4caf50;
		}
		.summary {
			margin-top: 30px;
			padding: 20px;
			background: #e3f2fd;
			border-radius: 4px;
		}
		.summary.missing {
			background: #ffebee;
		}
		.summary.complete {
			background: #e8f5e9;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>🔍 Verificação de Ícones - CBD AI Theme</h1>
		
		<?php
		$missing_count = 0;
		$exists_count = 0;
		
		foreach ( $required_icons as $filename => $description ) {
			$filepath = $icons_dir . '/' . $filename;
			$exists = file_exists( $filepath );
			
			if ( $exists ) {
				$exists_count++;
				$status_class = 'exists';
				$status_text = '✓ Existe';
			} else {
				$missing_count++;
				$status_class = 'missing';
				$status_text = '✗ Faltando';
			}
			
			echo '<div class="icon-item ' . $status_class . '">';
			echo '<span class="status ' . $status_class . '">' . $status_text . '</span>';
			echo '<div>';
			echo '<strong>' . esc_html( $filename ) . '</strong><br>';
			echo '<small>' . esc_html( $description ) . '</small>';
			echo '</div>';
			echo '</div>';
		}
		?>
		
		<div class="summary <?php echo $missing_count > 0 ? 'missing' : 'complete'; ?>">
			<h2>Resumo</h2>
			<p><strong>Ícones presentes:</strong> <?php echo $exists_count; ?> / <?php echo count( $required_icons ); ?></p>
			<p><strong>Ícones faltando:</strong> <?php echo $missing_count; ?></p>
			
			<?php if ( $missing_count > 0 ) : ?>
				<p style="margin-top: 15px;">
					<strong>⚠️ Ação necessária:</strong> Adicione os ícones faltantes conforme instruções no <code>README.md</code>
				</p>
				<p>
					<strong>Ferramentas recomendadas:</strong><br>
					• <a href="https://favicon.io/" target="_blank">Favicon.io</a> - Gera todos os tamanhos automaticamente<br>
					• <a href="https://realfavicongenerator.net/" target="_blank">RealFaviconGenerator</a> - Gerador completo com preview
				</p>
			<?php else : ?>
				<p style="margin-top: 15px; color: #2e7d32;">
					<strong>✓ Todos os ícones estão presentes!</strong> O tema está pronto para uso.
				</p>
			<?php endif; ?>
		</div>
		
		<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
			<p><small>Para mais informações, consulte o <code>README.md</code> neste diretório.</small></p>
		</div>
	</div>
</body>
</html>

