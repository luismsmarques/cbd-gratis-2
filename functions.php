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

	// Enqueue chatbot formatter (shared utility)
	if ( is_page_template( 'templates/template-chatbot.php' ) ||
		 is_page_template( 'templates/template-chatbot-humans.php' ) ||
		 is_page_template( 'templates/template-legislation.php' ) ) {
		wp_enqueue_script(
			'cbd-ai-chatbot-formatter',
			CBD_AI_THEME_URI . '/assets/js/chatbot-formatter.js',
			array(),
			CBD_AI_THEME_VERSION,
			false // Load in header so it's available for components
		);
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

