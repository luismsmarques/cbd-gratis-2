<?php
/**
 * Main Template File
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();
?>

<div class="content-area">
	<?php if ( have_posts() ) : ?>
		<div class="posts-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="block mb-4 overflow-hidden rounded-lg">
							<?php the_post_thumbnail( 'medium', array( 
								'class' => 'w-full h-[200px] object-cover rounded-lg',
								'loading' => 'lazy',
								'sizes' => '(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw'
							) ); ?>
						</a>
					<?php endif; ?>
					
					<h2 class="text-xl font-bold mb-2">
						<a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-cbd-green-600">
							<?php the_title(); ?>
						</a>
					</h2>
					
					<?php cbd_ai_post_meta( array( 
						'show_author' => false,
						'show_ai_badge' => false,
						'show_updated_date' => false
					) ); ?>
					
					<div class="mt-4 text-gray-600">
						<?php echo cbd_ai_get_excerpt( 20 ); ?>
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
			<h2 class="text-2xl font-bold mb-4">Nenhum conteúdo encontrado</h2>
			<p class="text-gray-600">Desculpe, não encontramos nenhum conteúdo.</p>
		</div>
	<?php endif; ?>
</div>

<?php
get_sidebar();
get_footer();

