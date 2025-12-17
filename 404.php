<?php
/**
 * 404 Error Template - MUI Design System
 * 
 * Página de erro 404 redesenhada com design system MUI completo
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get page URLs for quick links
$animais_page = get_page_by_path( 'cbd-animais' );
if ( ! $animais_page ) {
	$animais_page = get_page_by_path( 'cbd-para-animais' );
}
$animais_url = $animais_page ? get_permalink( $animais_page->ID ) : '';

$monitor_page = get_page_by_path( 'monitor-legislacao' );
if ( ! $monitor_page ) {
	$monitor_page = get_page_by_path( 'monitor-de-legislacao' );
}
$monitor_url = $monitor_page ? get_permalink( $monitor_page->ID ) : '';

$chatbot_page = get_page_by_path( 'chatbot-cbd' );
if ( ! $chatbot_page ) {
	$chatbot_page = get_page_by_path( 'chatbot' );
}
$chatbot_url = $chatbot_page ? get_permalink( $chatbot_page->ID ) : '';
?>

<main class="main-content min-h-screen py-12 md:py-20" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.03), var(--mui-gray-50));">
	<div class="container mx-auto px-4">
		<div class="max-w-2xl mx-auto text-center">
			
			<!-- 404 Icon Card -->
			<div class="mb-8">
				<div class="mui-card mui-card-elevated" style="display: inline-block; padding: 48px 64px;">
					<h1 class="mui-typography-h1" style="font-size: 6rem; margin: 0; color: var(--mui-gray-400); font-weight: 300; line-height: 1;">
						404
					</h1>
				</div>
			</div>
			
			<!-- Error Message -->
			<h2 class="mui-typography-h2 mb-4">
				Página não encontrada
			</h2>
			
			<p class="mui-typography-body1 mb-8" style="color: var(--mui-gray-600); max-width: 600px; margin-left: auto; margin-right: auto;">
				Desculpe, a página que você está procurando não existe ou foi movida. 
				Use a busca abaixo ou navegue pelos links úteis.
			</p>
			
			<!-- Search Form Card -->
			<div class="mui-card mui-card-elevated mb-8" style="padding: 24px;">
				<h3 class="mui-typography-h6 mb-4" style="margin: 0 0 16px 0;">Pesquisar no site</h3>
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: flex; gap: 0;">
					<div class="mui-text-field" style="flex: 1; margin: 0;">
						<input 
							type="search" 
							name="s" 
							placeholder="Digite sua pesquisa..."
							class="mui-input mui-input-outlined"
							value="<?php echo esc_attr( get_search_query() ); ?>"
							aria-label="Campo de pesquisa"
						>
					</div>
					<button 
						type="submit" 
						class="mui-button mui-button-contained mui-button-primary"
						aria-label="Pesquisar"
					>
						<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
						</svg>
					</button>
				</form>
			</div>
			
			<!-- Quick Links -->
			<div class="mb-8">
				<h3 class="mui-typography-h6 mb-4">Links Úteis</h3>
				<div class="flex flex-wrap justify-center gap-4">
					<a 
						href="<?php echo esc_url( home_url( '/' ) ); ?>" 
						class="mui-button mui-button-outlined"
					>
						<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
						</svg>
						Página Inicial
					</a>
					
					<?php if ( $animais_url ) : ?>
						<a 
							href="<?php echo esc_url( $animais_url ); ?>" 
							class="mui-button mui-button-outlined"
						>
							<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
							</svg>
							CBD para Animais
						</a>
					<?php endif; ?>
					
					<?php if ( $monitor_url ) : ?>
						<a 
							href="<?php echo esc_url( $monitor_url ); ?>" 
							class="mui-button mui-button-outlined"
						>
							<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
							</svg>
							Monitor Legislação
						</a>
					<?php endif; ?>
					
					<?php if ( $chatbot_url ) : ?>
						<a 
							href="<?php echo esc_url( $chatbot_url ); ?>" 
							class="mui-button mui-button-outlined"
						>
							<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
							</svg>
							Chatbot CBD
						</a>
					<?php endif; ?>
				</div>
			</div>
			
			<!-- Help Text -->
			<div class="mui-alert mui-alert-info">
				<div class="mui-alert-icon">ℹ</div>
				<div class="mui-alert-message">
					<p class="mui-typography-body2" style="margin: 0;">
						Se você acredita que esta é uma página que deveria existir, 
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-decoration: underline;">volte à página inicial</a> 
						ou use a busca acima para encontrar o conteúdo desejado.
					</p>
				</div>
			</div>
			
		</div>
	</div>
</main>

<?php
get_footer();
