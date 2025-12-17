<?php
/**
 * Sidebar Template
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

// Sidebar is now integrated into single.php template
// This file is kept for backward compatibility
if ( ! is_singular() && is_active_sidebar( 'sidebar-1' ) ) {
	?>
	<aside id="secondary" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside>
	<?php
}

