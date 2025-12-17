<?php
/**
 * 404 Error Template
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();
?>

<div class="content-area text-center py-12">
	<div class="max-w-2xl mx-auto">
		<h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
		<h2 class="text-3xl font-bold mb-4">Página não encontrada</h2>
		<p class="text-gray-600 mb-8">
			Desculpe, a página que você está procurando não existe ou foi movida.
		</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
			Voltar ao início
		</a>
	</div>
</div>

<?php
get_footer();

