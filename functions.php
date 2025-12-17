<?php
/**
 * CBD AI Theme Functions and Definitions
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define theme constants
define( 'CBD_AI_THEME_VERSION', '1.0.0' );
define( 'CBD_AI_THEME_PATH', get_template_directory() );
define( 'CBD_AI_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function cbd_ai_theme_setup() {
	// Add theme support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	// Register navigation menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Menu Principal', 'cbd-ai-theme' ),
		'footer'  => esc_html__( 'Menu Rodapé', 'cbd-ai-theme' ),
	) );
	
	// Add custom menu walker for dropdowns
	require_once CBD_AI_THEME_PATH . '/inc/class-menu-walker.php';

	// Set content width
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'cbd_ai_theme_setup' );

/**
 * Get Critical CSS for Above-the-Fold Content
 * 
 * Returns minimal CSS needed for initial render (header, trust bar, hero section)
 * This CSS is inlined in the <head> to prevent render blocking
 * 
 * @return string Critical CSS
 */
function cbd_ai_get_critical_css() {
	$critical_css = '
		/* Critical CSS - Above the Fold */
		/* Reset & Base */
		*,::before,::after{box-sizing:border-box}
		body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;line-height:1.7;color:#1f2937;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
		h1,h2,h3,h4,h5,h6{font-weight:700;line-height:1.3;color:#111827;letter-spacing:-0.02em;margin:0}
		
		/* Layout Essentials */
		.container{width:100%;margin-left:auto;margin-right:auto;padding-left:1rem;padding-right:1rem}
		@media (min-width:640px){.container{max-width:640px}}
		@media (min-width:768px){.container{max-width:768px}}
		@media (min-width:1024px){.container{max-width:1024px}}
		@media (min-width:1280px){.container{max-width:1280px}}
		.flex{display:flex}
		.grid{display:grid}
		.hidden{display:none}
		.items-center{align-items:center}
		.justify-between{justify-content:space-between}
		.flex-shrink-0{flex-shrink:0}
		.flex-1{flex:1 1 0%}
		.w-full{width:100%}
		.min-h-screen{min-height:100vh}
		.flex-grow{flex-grow:1}
		
		/* Trust Bar */
		.trust-bar{background-color:#f9fafb;border-bottom:1px solid #e5e7eb;padding-top:.5rem;padding-bottom:.5rem;font-size:.75rem;line-height:1.5}
		.trust-bar svg{flex-shrink:0;width:1rem;height:1rem}
		@media (max-width:767px){.trust-bar{display:none}}
		
		/* Header */
		.site-header{background:#fff;border-bottom:1px solid #e5e7eb;position:sticky;top:0;z-index:50;box-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05)}
		@media (min-width:1024px){.site-header{position:static}}
		.site-branding{display:flex;align-items:center;flex-shrink:0}
		.site-branding a{display:flex;align-items:center;gap:.5rem;text-decoration:none;color:inherit}
		.site-branding .text-2xl{font-size:1.5rem;line-height:2rem}
		.site-branding .text-3xl{font-size:1.875rem;line-height:2.25rem}
		@media (min-width:768px){.site-branding .text-2xl{font-size:1.875rem;line-height:2.25rem}.site-branding .text-3xl{font-size:1.875rem;line-height:2.25rem}}
		
		/* Navigation */
		.main-navigation{display:none}
		@media (min-width:1024px){.main-navigation{display:flex;flex:1 1 0%;justify-content:flex-end;min-width:0}}
		.mobile-navigation{display:none;padding-bottom:.5rem;border-top:1px solid #e5e7eb;margin-top:.5rem;padding-top:.5rem}
		@media (min-width:1024px){.mobile-navigation{display:none!important}}
		#mobile-menu-toggle{display:block;color:#374151;padding:.5rem;flex-shrink:0}
		@media (min-width:1024px){#mobile-menu-toggle{display:none}}
		#mobile-menu-toggle svg{width:1.5rem;height:1.5rem}
		
		/* Hero Section - Basic Styles */
		.hero-authority{padding-top:1.5rem;padding-bottom:2.5rem;background:linear-gradient(to bottom,#fff,rgba(0,137,123,0.05),#fff)}
		@media (min-width:768px){.hero-authority{padding-top:2.5rem;padding-bottom:2.5rem}}
		.max-w-4xl{max-width:56rem;margin-left:auto;margin-right:auto}
		.text-center{text-align:center}
		
		/* Typography */
		.mui-typography-h1{font-size:2.25rem;line-height:1.2;font-weight:700;margin-bottom:1.5rem;color:#111827}
		@media (min-width:768px){.mui-typography-h1{font-size:3rem;line-height:1.1}}
		
		/* Colors */
		.bg-white{background-color:#fff}
		.bg-gray-50{background-color:#f9fafb}
		.text-gray-600{color:#4b5563}
		.text-gray-700{color:#374151}
		.text-gray-900{color:#111827}
		.text-cbd-green-600{color:#2d712d}
		.text-blue-600{color:#2563eb}
		
		/* Spacing */
		.px-4{padding-left:1rem;padding-right:1rem}
		.py-2{padding-top:.5rem;padding-bottom:.5rem}
		.py-4{padding-top:1rem;padding-bottom:1rem}
		.py-6{padding-top:1.5rem;padding-bottom:1.5rem}
		.mb-4{margin-bottom:1rem}
		.mb-6{margin-bottom:1.5rem}
		.mb-8{margin-bottom:2rem}
		.gap-1{gap:.25rem}
		.gap-2{gap:.5rem}
		.gap-4{gap:1rem}
		
		/* Utilities */
		.shadow-sm{box-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05)}
		.top-0{top:0}
		.z-50{z-index:50}
	';
	
	// Minify CSS (remove comments, extra whitespace)
	$critical_css = preg_replace( '/\s+/', ' ', $critical_css );
	$critical_css = preg_replace( '/\s*([{}:;,])\s*/', '$1', $critical_css );
	$critical_css = trim( $critical_css );
	
	return $critical_css;
}

/**
 * Output Critical CSS inline in <head>
 */
function cbd_ai_output_critical_css() {
	$critical_css = cbd_ai_get_critical_css();
	if ( ! empty( $critical_css ) ) {
		echo '<style id="cbd-ai-critical-css">' . $critical_css . '</style>' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_output_critical_css', 1 );

/**
 * Enqueue Scripts and Styles
 */
function cbd_ai_theme_scripts() {
	// Enqueue Debug Helper FIRST - must load before all other scripts
	wp_enqueue_script(
		'cbd-ai-debug-helper',
		CBD_AI_THEME_URI . '/assets/js/debug-helper.js',
		array(), // No dependencies - must load first
		CBD_AI_THEME_VERSION,
		false // Load in header
	);
	
	// Enqueue styles - load in correct order
	// Note: Critical CSS is already inlined via cbd_ai_output_critical_css()
	// These stylesheets are loaded asynchronously via style_loader_tag filter
	wp_enqueue_style(
		'cbd-ai-theme-style',
		get_stylesheet_uri(),
		array(),
		CBD_AI_THEME_VERSION
	);

	// Enqueue Tailwind CSS (built) - priority: compiled > source
	$tailwind_file = CBD_AI_THEME_PATH . '/assets/css/tailwind-output.css';
	if ( ! file_exists( $tailwind_file ) ) {
		$tailwind_file = CBD_AI_THEME_PATH . '/assets/css/tailwind.css';
	}
	
	if ( file_exists( $tailwind_file ) ) {
		$tailwind_uri = str_replace( CBD_AI_THEME_PATH, CBD_AI_THEME_URI, $tailwind_file );
		wp_enqueue_style(
			'cbd-ai-tailwind',
			$tailwind_uri,
			array( 'cbd-ai-theme-style' ),
			CBD_AI_THEME_VERSION
		);
	} else {
		// Fallback: add inline basic styles if Tailwind not found
		$inline_css = '
			.container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
			.flex { display: flex; }
			.grid { display: grid; }
			.hidden { display: none; }
			.bg-white { background-color: #fff; }
			.bg-gray-50 { background-color: #f9fafb; }
			.text-gray-600 { color: #4b5563; }
			.text-gray-700 { color: #374151; }
			.text-gray-900 { color: #111827; }
			.text-cbd-green-600 { color: #2d712d; }
			.font-bold { font-weight: 700; }
			.p-4 { padding: 1rem; }
			.p-8 { padding: 2rem; }
			.px-4 { padding-left: 1rem; padding-right: 1rem; }
			.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
			.py-8 { padding-top: 2rem; padding-bottom: 2rem; }
			.mb-4 { margin-bottom: 1rem; }
			.mb-8 { margin-bottom: 2rem; }
			.mt-4 { margin-top: 1rem; }
			.mt-8 { margin-top: 2rem; }
			.mt-12 { margin-top: 3rem; }
			.gap-2 { gap: 0.5rem; }
			.gap-4 { gap: 1rem; }
			.gap-6 { gap: 1.5rem; }
			.rounded-lg { border-radius: 0.5rem; }
			.shadow-sm { box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); }
			.shadow-md { box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
			.sticky { position: sticky; }
			.top-0 { top: 0; }
			.z-50 { z-index: 50; }
			.min-h-screen { min-height: 100vh; }
			.flex-grow { flex-grow: 1; }
			.items-center { align-items: center; }
			.justify-between { justify-content: space-between; }
			.w-full { width: 100%; }
			.max-w-4xl { max-width: 56rem; }
			.max-w-6xl { max-width: 72rem; }
			.text-2xl { font-size: 1.5rem; line-height: 2rem; }
			.text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
			.text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
			@media (min-width: 768px) {
				.md\\:block { display: block; }
				.md\\:hidden { display: none; }
				.md\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
			}
		';
		wp_add_inline_style( 'cbd-ai-theme-style', $inline_css );
	}

	// Enqueue custom CSS
	wp_enqueue_style(
		'cbd-ai-custom',
		CBD_AI_THEME_URI . '/assets/css/custom.css',
		array( 'cbd-ai-theme-style' ),
		CBD_AI_THEME_VERSION
	);
	
	// Enqueue UX fixes CSS
	wp_enqueue_style(
		'cbd-ai-ux-fixes',
		CBD_AI_THEME_URI . '/assets/css/ux-fixes.css',
		array( 'cbd-ai-custom' ),
		CBD_AI_THEME_VERSION
	);
	
	// Enqueue Authority Design CSS
	wp_enqueue_style(
		'cbd-ai-authority-design',
		CBD_AI_THEME_URI . '/assets/css/authority-design.css',
		array( 'cbd-ai-ux-fixes' ),
		CBD_AI_THEME_VERSION
	);
	
	// Enqueue MUI Design System CSS (global - used on all pages)
	wp_enqueue_style(
		'cbd-ai-mui-design-system',
		CBD_AI_THEME_URI . '/assets/css/mui-design-system.css',
		array( 'cbd-ai-authority-design' ),
		CBD_AI_THEME_VERSION
	);
	
	// Enqueue Chatbot Design CSS (only on chatbot pages)
	if ( is_page_template( 'templates/template-chatbot.php' ) ||
		 is_page_template( 'templates/template-chatbot-humans.php' ) ||
		 is_page_template( 'templates/template-chatbot-cbd.php' ) ) {
		wp_enqueue_style(
			'cbd-ai-chatbot-design',
			CBD_AI_THEME_URI . '/assets/css/chatbot-design.css',
			array( 'cbd-ai-authority-design' ),
			CBD_AI_THEME_VERSION
		);
	}
	
	// Enqueue Chatbot Humans CSS (only on chatbot humans page)
	if ( is_page_template( 'templates/template-chatbot-humans.php' ) ) {
		wp_enqueue_style(
			'cbd-ai-chatbot-humans-design',
			CBD_AI_THEME_URI . '/assets/css/chatbot-humans-design.css',
			array( 'cbd-ai-chatbot-design' ),
			CBD_AI_THEME_VERSION
		);
	}
	
	// Enqueue Legislation Chatbot CSS (only on legislation page)
	if ( is_page_template( 'templates/template-legislation.php' ) ) {
		wp_enqueue_style(
			'cbd-ai-chatbot-design',
			CBD_AI_THEME_URI . '/assets/css/chatbot-design.css',
			array( 'cbd-ai-authority-design' ),
			CBD_AI_THEME_VERSION
		);
		
		wp_enqueue_style(
			'cbd-ai-legislation-chatbot',
			CBD_AI_THEME_URI . '/assets/css/legislation-chatbot.css',
			array( 'cbd-ai-chatbot-design' ),
			CBD_AI_THEME_VERSION
		);
	}

	// Enqueue chatbot formatter (shared utility for all chatbots)
	if ( is_page_template( 'templates/template-chatbot.php' ) ||
		 is_page_template( 'templates/template-chatbot-humans.php' ) ||
		 is_page_template( 'templates/template-chatbot-cbd.php' ) ||
		 is_page_template( 'templates/template-legislation.php' ) ) {
		wp_enqueue_script(
			'cbd-ai-chatbot-formatter',
			CBD_AI_THEME_URI . '/assets/js/chatbot-formatter.js',
			array(),
			CBD_AI_THEME_VERSION,
			false // Load in header so it's available for components
		);
	}

	// Enqueue Vue.js app (only on pages that need it)
	if ( is_page_template( 'templates/template-chatbot.php' ) ||
		 is_page_template( 'templates/template-chatbot-humans.php' ) ||
		 is_page_template( 'templates/template-chatbot-cbd.php' ) ||
		 is_page_template( 'templates/template-content-generator.php' ) ||
		 is_page_template( 'templates/template-legislation.php' ) ||
		 is_page_template( 'templates/template-animais.php' ) ||
		 is_page_template( 'templates/template-caes.php' ) ||
		 is_page_template( 'templates/template-gatos.php' ) ||
		 is_page_template( 'templates/template-cbd-humanos.php' ) ||
		 is_page_template( 'templates/template-calculadora-dosagem.php' ) ||
		 is_singular( array( 'cbd_article', 'cbd_guide' ) ) ||
		 is_front_page() ) {
		
		// Vue.js from CDN (production build) - loaded in header for component availability
		wp_enqueue_script(
			'vue-prod',
			'https://unpkg.com/vue@3/dist/vue.global.prod.js',
			array( 'cbd-ai-chatbot-formatter' ), // Depend on formatter
			'3.4.0',
			false
		);

		// Enqueue Vue Error Handler - must load after Vue but before components
		wp_enqueue_script(
			'cbd-ai-vue-error-handler',
			CBD_AI_THEME_URI . '/assets/js/vue-error-handler.js',
			array( 'vue-prod' ), // Depend on Vue
			CBD_AI_THEME_VERSION,
			false // Load in header
		);

		// Localize script for REST API - make available globally
		wp_localize_script( 'vue-prod', 'cbdAIData', array(
			'apiUrl' => rest_url( 'cbd-ai/v1/' ),
			'nonce'  => wp_create_nonce( 'wp_rest' ),
			'siteUrl' => home_url(),
		) );
		
		// Enqueue StatusCard and ActionCard components (for homepage and templates)
		if ( is_front_page() ||
			 is_page_template( 'templates/template-animais.php' ) ||
			 is_page_template( 'templates/template-legislation.php' ) ) {
			
			wp_enqueue_script(
				'cbd-ai-status-card',
				CBD_AI_THEME_URI . '/assets/js/components/StatusCard.js',
				array( 'vue-prod' ),
				CBD_AI_THEME_VERSION,
				false
			);
			
			wp_enqueue_script(
				'cbd-ai-action-card',
				CBD_AI_THEME_URI . '/assets/js/components/ActionCard.js',
				array( 'vue-prod' ),
				CBD_AI_THEME_VERSION,
				false
			);
		}
	}

	// Enqueue main script for all pages
	wp_enqueue_script(
		'cbd-ai-main',
		CBD_AI_THEME_URI . '/assets/js/main.js',
		array(),
		CBD_AI_THEME_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'cbd_ai_theme_scripts' );

/**
 * Modify CSS link tags to load asynchronously (non-critical CSS)
 * Changes media attribute from "all" to "print" initially, then script converts to "all"
 * 
 * @param string $html   The link tag HTML
 * @param string $handle The stylesheet handle
 * @param string $href   The stylesheet URL
 * @param string $media  The media attribute
 * @return string Modified link tag
 */
function cbd_ai_modify_css_link_tag( $html, $handle, $href, $media ) {
	// List of non-critical stylesheets to load asynchronously
	$async_styles = array(
		'cbd-ai-theme-style',
		'cbd-ai-tailwind',
		'cbd-ai-custom',
		'cbd-ai-ux-fixes',
		'cbd-ai-authority-design',
		'cbd-ai-mui-design-system',
		'cbd-ai-chatbot-design',
		'cbd-ai-chatbot-humans-design',
		'cbd-ai-legislation-chatbot',
	);
	
	// Only modify non-critical stylesheets
	if ( in_array( $handle, $async_styles, true ) ) {
		// Change media to "print" so it doesn't block rendering
		// The inline script will convert it to "all" after load
		$html = str_replace( 'media=\'all\'', 'media=\'print\'', $html );
		$html = str_replace( 'media="all"', 'media="print"', $html );
		// Add onload attribute for browsers that support it
		$html = str_replace( '>', ' onload="this.media=\'all\'">', $html );
	}
	
	return $html;
}
add_filter( 'style_loader_tag', 'cbd_ai_modify_css_link_tag', 10, 4 );

/**
 * Add defer/async attributes to scripts to prevent render blocking
 * 
 * @param string $tag    The script tag HTML
 * @param string $handle The script handle
 * @param string $src    The script source URL
 * @return string Modified script tag
 */
function cbd_ai_add_script_attributes( $tag, $handle, $src ) {
	// Scripts to defer (execute after DOM is parsed, maintain order)
	// Use defer for scripts that depend on each other or need DOM ready
	$defer_scripts = array(
		'cbd-ai-debug-helper',
		'cbd-ai-chatbot-formatter',
		'vue-prod', // Vue.js needs to load before components, so use defer to maintain order
		'cbd-ai-vue-error-handler',
		'cbd-ai-status-card',
		'cbd-ai-action-card',
	);
	
	// Scripts to async (execute as soon as downloaded, independent)
	// Use async only for completely independent scripts
	$async_scripts = array(
		// Currently no async scripts - Vue and components need defer for proper order
	);
	
	// Add defer attribute
	if ( in_array( $handle, $defer_scripts, true ) ) {
		// Only add defer if not already present
		if ( strpos( $tag, ' defer' ) === false && strpos( $tag, " defer='" ) === false ) {
			$tag = str_replace( ' src', ' defer src', $tag );
		}
	}
	
	// Add async attribute
	if ( in_array( $handle, $async_scripts, true ) ) {
		// Only add async if not already present and not defer
		if ( strpos( $tag, ' async' ) === false && strpos( $tag, " async='" ) === false && strpos( $tag, ' defer' ) === false ) {
			$tag = str_replace( ' src', ' async src', $tag );
		}
	}
	
	return $tag;
}
add_filter( 'script_loader_tag', 'cbd_ai_add_script_attributes', 10, 3 );

/**
 * Add script to load async CSS (convert media="print" to media="all" on load)
 * This ensures non-critical CSS doesn't block rendering
 */
function cbd_ai_add_async_css_loader() {
	?>
	<script>
	(function() {
		// Function to load async CSS
		function loadAsyncCSS() {
			var links = document.querySelectorAll('link[media="print"]');
			for (var i = 0; i < links.length; i++) {
				links[i].setAttribute('media', 'all');
			}
		}
		
		// Run immediately if DOM is ready, otherwise wait
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', loadAsyncCSS);
		} else {
			loadAsyncCSS();
		}
		
		// Also handle links that load after DOM is ready (with fallback for older browsers)
		if (typeof MutationObserver !== 'undefined') {
			var observer = new MutationObserver(function(mutations) {
				loadAsyncCSS();
			});
			
			if (document.head) {
				observer.observe(document.head, {
					childList: true,
					subtree: true
				});
			}
		} else {
			// Fallback for older browsers: check periodically
			setInterval(loadAsyncCSS, 100);
		}
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'cbd_ai_add_async_css_loader', 2 );

/**
 * Add noscript fallback for async CSS loading
 * Ensures CSS loads even if JavaScript is disabled
 */
function cbd_ai_add_css_noscript_fallback() {
	?>
	<noscript>
		<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" />
		<?php
		// Add other critical stylesheets that were loaded async
		$tailwind_file = CBD_AI_THEME_PATH . '/assets/css/tailwind-output.css';
		if ( ! file_exists( $tailwind_file ) ) {
			$tailwind_file = CBD_AI_THEME_PATH . '/assets/css/tailwind.css';
		}
		if ( file_exists( $tailwind_file ) ) {
			$tailwind_uri = str_replace( CBD_AI_THEME_PATH, CBD_AI_THEME_URI, $tailwind_file );
			echo '<link rel="stylesheet" href="' . esc_url( $tailwind_uri ) . '" />';
		}
		?>
	</noscript>
	<?php
}
add_action( 'wp_head', 'cbd_ai_add_css_noscript_fallback', 99 );

/**
 * Register Widget Areas
 */
function cbd_ai_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Principal', 'cbd-ai-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Widgets para a sidebar principal', 'cbd-ai-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Rodapé 1', 'cbd-ai-theme' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Primeira coluna do rodapé', 'cbd-ai-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Rodapé 2', 'cbd-ai-theme' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Segunda coluna do rodapé', 'cbd-ai-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Rodapé 3', 'cbd-ai-theme' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Terceira coluna do rodapé', 'cbd-ai-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'cbd_ai_theme_widgets_init' );

// Include required files
require_once CBD_AI_THEME_PATH . '/inc/class-gemini-api.php';
require_once CBD_AI_THEME_PATH . '/inc/class-chatbot-handler.php';
require_once CBD_AI_THEME_PATH . '/inc/class-content-generator.php';
require_once CBD_AI_THEME_PATH . '/inc/class-web-scraper.php';
require_once CBD_AI_THEME_PATH . '/inc/class-legislation-sources.php';
require_once CBD_AI_THEME_PATH . '/inc/class-legislation-monitor.php';
require_once CBD_AI_THEME_PATH . '/inc/class-legislation-chatbot-handler.php';
require_once CBD_AI_THEME_PATH . '/inc/class-chatbot-humans-handler.php';
require_once CBD_AI_THEME_PATH . '/inc/class-chatbot-cbd-handler.php';
require_once CBD_AI_THEME_PATH . '/inc/class-seo-optimizer.php';
require_once CBD_AI_THEME_PATH . '/inc/class-schema-markup.php';
require_once CBD_AI_THEME_PATH . '/inc/breadcrumbs.php';
require_once CBD_AI_THEME_PATH . '/inc/template-functions.php';

// Include SEO/GEO functions
require_once CBD_AI_THEME_PATH . '/inc/seo-geo-functions.php';
require_once CBD_AI_THEME_PATH . '/inc/custom-post-types.php';
require_once CBD_AI_THEME_PATH . '/inc/rest-api.php';
require_once CBD_AI_THEME_PATH . '/inc/admin-settings.php';
require_once CBD_AI_THEME_PATH . '/inc/admin-legislation-sources.php';
require_once CBD_AI_THEME_PATH . '/inc/migrate-legislation-sources.php';
require_once CBD_AI_THEME_PATH . '/inc/debug-gemini.php';
require_once CBD_AI_THEME_PATH . '/inc/class-featured-image-generator.php';

/**
 * Output Schema.org JSON-LD markup
 */
function cbd_ai_output_schema_markup() {
	CBD_Schema_Markup::output_schema();
}
add_action( 'wp_head', 'cbd_ai_output_schema_markup', 5 );

