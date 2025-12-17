	</main><!-- #main -->

	<footer id="colophon" class="site-footer bg-gray-800 text-white mt-12">
		<div class="container mx-auto px-4 py-8">
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-widget">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="footer-widget">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<div class="footer-widget">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
				<p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. Todos os direitos reservados.</p>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container' => false,
					'menu_class' => 'flex justify-center gap-4 mt-4',
					'fallback_cb' => false,
				) );
				?>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

