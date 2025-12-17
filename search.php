<?php
/**
 * Search Results Template
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();
?>

<div class="content-area">
	<header class="search-header mb-8">
		<h1 class="text-3xl md:text-4xl font-bold mb-4">
			Resultados da busca: "<?php echo esc_html( get_search_query() ); ?>"
		</h1>
		<?php
		global $wp_query;
		if ( $wp_query->found_posts > 0 ) {
			printf(
				'<p class="text-gray-600">Encontrados %d resultado(s)</p>',
				$wp_query->found_posts
			);
		}
		?>
	</header>
	
	<?php if ( have_posts() ) : ?>
		<div class="posts-list space-y-6">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
					<h2 class="text-2xl font-bold mb-2">
						<a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-cbd-green-600">
							<?php the_title(); ?>
						</a>
					</h2>
					
					<?php cbd_ai_post_meta(); ?>
					
					<div class="mt-4 text-gray-600">
						<?php echo cbd_ai_get_excerpt( 30 ); ?>
					</div>
					
					<a href="<?php the_permalink(); ?>" class="btn btn-primary mt-4 inline-block">
						Ler mais
					</a>
				</article>
			<?php endwhile; ?>
		</div>
		
		<div class="pagination mt-8">
			<?php
			the_posts_pagination( array(
				'mid_size' => 2,
				'prev_text' => '&laquo; Anterior',
				'next_text' => 'Próxima &raquo;',
			) );
			?>
		</div>
	<?php else : ?>
		<div class="text-center py-12">
			<h2 class="text-2xl font-bold mb-4">Nenhum resultado encontrado</h2>
			<p class="text-gray-600 mb-6">
				Desculpe, não encontramos nenhum conteúdo correspondente à sua busca.
			</p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</div>

<?php
get_sidebar();
get_footer();

