<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-white' ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen flex flex-col">
	<!-- Top Bar - Trust Indicators -->
	<div class="trust-bar bg-gray-50 border-b border-gray-200 py-2 hidden md:block">
		<div class="container mx-auto px-4">
			<div class="flex items-center justify-between text-xs text-gray-600">
				<div class="flex items-center gap-4">
					<span class="flex items-center gap-1">
						<svg class="w-4 h-4 text-cbd-green-600" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
						</svg>
						Informação validada por AI
					</span>
					<span class="flex items-center gap-1">
						<svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
						</svg>
						Atualizado diariamente
					</span>
				</div>
				<div class="flex items-center gap-4">
					<span>🇵🇹 Portal especializado em Portugal</span>
				</div>
			</div>
		</div>
	</div>

	<!-- Main Header -->
	<header id="masthead" class="site-header bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
		<div class="container mx-auto px-4">
			<!-- Logo and Mobile Menu -->
			<div class="flex items-center justify-between py-2 md:py-4 gap-2 md:gap-4">
				<div class="site-branding flex items-center flex-shrink-0">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2">
							<span class="text-2xl md:text-3xl font-bold text-gray-900">CBD</span>
							<span class="text-2xl md:text-3xl font-light text-cbd-green-600">Gratis</span>
						</a>
					<?php endif; ?>
				</div>
				
				<!-- Desktop Navigation -->
				<nav id="site-navigation" class="main-navigation hidden lg:flex flex-1 justify-end min-w-0">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id' => 'primary-menu',
						'container' => false,
						'menu_class' => 'flex items-center gap-1',
						'walker' => new CBD_AI_Menu_Walker(),
						'fallback_cb' => 'cbd_ai_fallback_menu',
					) );
					?>
				</nav>
				
				<!-- Mobile Menu Toggle -->
				<button id="mobile-menu-toggle" class="lg:hidden text-gray-700 hover:text-cbd-green-600 p-2 flex-shrink-0" aria-label="Menu" aria-expanded="false">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
					</svg>
				</button>
			</div>
			
			<!-- Mobile Navigation -->
			<nav id="mobile-navigation" class="mobile-navigation hidden lg:hidden pb-2 md:pb-4 border-t border-gray-200 mt-2 md:mt-4 pt-2 md:pt-4">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id' => 'mobile-menu',
					'container' => false,
					'menu_class' => 'flex flex-col gap-2',
					'fallback_cb' => 'cbd_ai_fallback_menu',
				) );
				?>
			</nav>
		</div>
	</header>

	<main id="main" class="site-main flex-grow">
