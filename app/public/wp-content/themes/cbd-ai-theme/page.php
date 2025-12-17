<?php
/**
 * Page Template
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();
?>

<div class="content-area max-w-4xl mx-auto">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-lg shadow-md p-8' ); ?>>
			<?php cbd_ai_breadcrumbs(); ?>
			
			<header class="entry-header mb-6">
				<h1 class="entry-title text-3xl md:text-4xl font-bold">
					<?php the_title(); ?>
				</h1>
			</header>
			
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-thumbnail mb-6 overflow-hidden rounded-lg">
					<?php the_post_thumbnail( 'large', array( 
						'class' => 'w-full h-auto max-h-[400px] object-cover rounded-lg',
						'loading' => 'lazy'
					) ); ?>
				</div>
			<?php endif; ?>
			
			<div class="entry-content prose prose-lg max-w-none">
				<?php the_content(); ?>
			</div>
			
			<?php
			// Comments
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</article>
	<?php endwhile; ?>
</div>

<?php
get_footer();

