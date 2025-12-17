<?php
/**
 * SEO and GEO Optimization Functions
 * 
 * Functions to optimize SEO and Geographic SEO for CBD Gratis
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get optimized meta title for homepage
 */
function cbd_ai_get_homepage_meta_title() {
	return 'CBD Portugal | Legalidade, Informação e Guias para Animais | CBD Gratis';
}

/**
 * Get optimized H1 for homepage
 */
function cbd_ai_get_homepage_h1() {
	return 'CBD em Portugal: O seu Portal de Informação, Legalidade e Guias para Animais';
}

/**
 * Get SEO-optimized definitions for Featured Snippets
 */
function cbd_ai_get_cbd_definition() {
	return 'CBD (canabidiol) é um composto natural extraído da planta Cannabis sativa, especificamente do cânhamo. Ao contrário do THC, o CBD não possui efeitos psicoativos e é legal em Portugal quando extraído de plantas de cânhamo com menos de 0,2% de THC. O CBD interage com o sistema endocanabinoide presente em humanos e animais, oferecendo potenciais benefícios para ansiedade, dor, inflamação e outras condições de saúde.';
}

/**
 * Get SEO-optimized legal definition for Featured Snippets
 */
function cbd_ai_get_legal_definition() {
	return 'O CBD é legal em Portugal quando extraído de plantas de cânhamo com teor de THC inferior a 0,2%. A comercialização de produtos de CBD para uso tópico e cosmético é permitida, enquanto produtos para consumo oral requerem autorização do Infarmed. A legislação portuguesa segue as diretrizes da União Europeia sobre cânhamo industrial e cannabis medicinal. É essencial verificar regularmente as atualizações legislativas, pois as regulamentações podem mudar.';
}

/**
 * Add custom meta title for homepage
 */
function cbd_ai_homepage_meta_title( $title ) {
	if ( is_front_page() ) {
		return cbd_ai_get_homepage_meta_title();
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'cbd_ai_homepage_meta_title' );

/**
 * Add meta description for homepage
 */
function cbd_ai_homepage_meta_description() {
	if ( is_front_page() ) {
		$description = 'Portal especializado em CBD em Portugal. Informação atualizada sobre legalidade, dosagem para animais (cães e gatos), legislação portuguesa e guias completos. Monitorização automática por IA.';
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_homepage_meta_description', 1 );

/**
 * Add Open Graph tags for homepage
 */
function cbd_ai_homepage_og_tags() {
	if ( is_front_page() ) {
		$title = cbd_ai_get_homepage_meta_title();
		$description = 'Portal especializado em CBD em Portugal. Informação atualizada sobre legalidade, dosagem para animais e legislação portuguesa.';
		$url = home_url( '/' );
		$image = get_template_directory_uri() . '/assets/images/og-image.jpg'; // Fallback
		
		if ( has_custom_logo() ) {
			$logo_id = get_theme_mod( 'custom_logo' );
			$logo = wp_get_attachment_image_src( $logo_id, 'full' );
			if ( $logo ) {
				$image = $logo[0];
			}
		}
		
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:type" content="website">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta property="og:locale" content="pt_PT">' . "\n";
		echo '<meta property="og:site_name" content="CBD Gratis">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_homepage_og_tags', 5 );

/**
 * Get strategic internal links for homepage
 */
function cbd_ai_get_strategic_internal_links() {
	$links = array();
	
	// CBD para Cães
	$caes_page = get_page_by_path( 'cbd-para-caes' );
	if ( ! $caes_page ) {
		$caes_page = get_page_by_path( 'caes' );
	}
	if ( $caes_page ) {
		$links[] = array(
			'title' => 'CBD para Cães: Guia Completo de Dosagem e Benefícios',
			'url' => get_permalink( $caes_page->ID ),
			'anchor' => 'cbd-para-caes',
			'keywords' => 'CBD para cães, canabidiol cães, dosagem CBD cães'
		);
	}
	
	// Monitor de Legislação
	$legislacao_page = get_page_by_path( 'monitor-legislacao' );
	if ( ! $legislacao_page ) {
		$legislacao_page = get_page_by_path( 'legislacao' );
	}
	if ( $legislacao_page ) {
		$links[] = array(
			'title' => 'Monitor de Legislação Portuguesa sobre CBD',
			'url' => get_permalink( $legislacao_page->ID ),
			'anchor' => 'monitor-legislacao',
			'keywords' => 'CBD legal Portugal, legislação CBD Portugal, legalidade canabidiol'
		);
	}
	
	// CBD para Humanos
	$humanos_page = get_page_by_path( 'cbd-para-humanos' );
	if ( $humanos_page ) {
		$links[] = array(
			'title' => 'CBD para Humanos: Dosagem e Benefícios',
			'url' => get_permalink( $humanos_page->ID ),
			'anchor' => 'cbd-para-humanos',
			'keywords' => 'CBD para humanos, canabidiol Portugal, óleo CBD'
		);
	}
	
	// Chatbot
	$chatbot_page = get_page_by_path( 'chatbot-animais' );
	if ( ! $chatbot_page ) {
		$chatbot_page = get_page_by_path( 'chatbot' );
	}
	if ( $chatbot_page ) {
		$links[] = array(
			'title' => 'Chatbot Especialista em CBD para Animais',
			'url' => get_permalink( $chatbot_page->ID ),
			'anchor' => 'chatbot-especialista',
			'keywords' => 'chatbot CBD animais, IA especialista CBD'
		);
	}
	
	return $links;
}

/**
 * Get latest legal alert for homepage widget
 */
function cbd_ai_get_latest_legal_alert() {
	if ( ! class_exists( 'CBD_Legislation_Monitor' ) ) {
		return null;
	}
	
	$monitor = new CBD_Legislation_Monitor();
	$recent_alerts = $monitor->get_recent_alerts( 1 );
	
	if ( ! empty( $recent_alerts ) ) {
		return $recent_alerts[0];
	}
	
	return null;
}

/**
 * Get recent legal alerts for homepage
 *
 * @param int $limit Number of alerts to retrieve (default: 3)
 * @return array Array of alerts
 */
function cbd_ai_get_recent_legal_alerts( $limit = 3 ) {
	if ( ! class_exists( 'CBD_Legislation_Monitor' ) ) {
		return array();
	}
	
	$monitor = new CBD_Legislation_Monitor();
	return $monitor->get_recent_alerts( $limit );
}

/**
 * Get Monitor Legislação page URL
 *
 * @return string Page URL
 */
function cbd_ai_get_monitor_legislacao_url() {
	// Try different possible slugs
	$slugs = array( 'monitor-legislacao', 'legislacao', 'monitor-de-legislacao' );
	
	foreach ( $slugs as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			return get_permalink( $page->ID );
		}
	}
	
	// Fallback to home URL
	return home_url( '/' );
}

/**
 * Get optimized H1 for CBD para Animais page
 */
function cbd_ai_get_animais_h1() {
	return 'Canabidiol (CBD) para Animais de Estimação: Guia de Segurança e Dosagem';
}

/**
 * Get child pages for CBD para Animais (Cães e Gatos)
 */
function cbd_ai_get_animais_child_pages() {
	$pages = array();
	
	// CBD para Cães
	$caes_page = get_page_by_path( 'cbd-para-caes' );
	if ( ! $caes_page ) {
		$caes_page = get_page_by_path( 'caes' );
	}
	if ( ! $caes_page ) {
		$caes_page = get_page_by_path( 'cbd-caes' );
	}
	
	if ( $caes_page ) {
		$pages[] = array(
			'title' => 'CBD para Cães',
			'short_title' => 'CBD para Cães',
			'subtitle' => 'Guia Completo',
			'description' => 'Descubra como o CBD pode ajudar o seu cão com ansiedade, dor, artrite e outras condições. Guias de dosagem, segurança e benefícios validados por especialistas.',
			'url' => get_permalink( $caes_page->ID ),
			'icon' => '🐕'
		);
	} else {
		// Fallback - create placeholder
		$pages[] = array(
			'title' => 'CBD para Cães',
			'short_title' => 'CBD para Cães',
			'subtitle' => 'Guia Completo',
			'description' => 'Descubra como o CBD pode ajudar o seu cão com ansiedade, dor, artrite e outras condições. Guias de dosagem, segurança e benefícios validados por especialistas.',
			'url' => '#',
			'icon' => '🐕'
		);
	}
	
	// CBD para Gatos
	$gatos_page = get_page_by_path( 'cbd-para-gatos' );
	if ( ! $gatos_page ) {
		$gatos_page = get_page_by_path( 'gatos' );
	}
	if ( ! $gatos_page ) {
		$gatos_page = get_page_by_path( 'cbd-gatos' );
	}
	
	if ( $gatos_page ) {
		$pages[] = array(
			'title' => 'CBD para Gatos',
			'short_title' => 'CBD para Gatos',
			'subtitle' => 'Guia Completo',
			'description' => 'Aprenda sobre o uso seguro de CBD em gatos. Dosagem adequada, benefícios para ansiedade, dor e outras condições comuns em felinos.',
			'url' => get_permalink( $gatos_page->ID ),
			'icon' => '🐱'
		);
	} else {
		// Fallback - create placeholder
		$pages[] = array(
			'title' => 'CBD para Gatos',
			'short_title' => 'CBD para Gatos',
			'subtitle' => 'Guia Completo',
			'description' => 'Aprenda sobre o uso seguro de CBD em gatos. Dosagem adequada, benefícios para ansiedade, dor e outras condições comuns em felinos.',
			'url' => '#',
			'icon' => '🐱'
		);
	}
	
	return $pages;
}

/**
 * Add meta title for CBD para Animais page
 */
function cbd_ai_animais_meta_title( $title ) {
	if ( is_page_template( 'templates/template-animais.php' ) ) {
		return 'CBD para Animais: Guias de Dosagem e Segurança para Cães e Gatos | CBD Gratis';
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'cbd_ai_animais_meta_title' );

/**
 * Add meta description for CBD para Animais page
 */
function cbd_ai_animais_meta_description() {
	if ( is_page_template( 'templates/template-animais.php' ) ) {
		$description = 'Guia completo sobre CBD para animais de estimação. Comparação entre CBD para cães e gatos, dosagem segura, condições tratadas (ansiedade, dor, artrite) e benefícios validados por veterinários.';
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_animais_meta_description', 1 );

/**
 * Add Open Graph tags for CBD para Animais page
 */
function cbd_ai_animais_og_tags() {
	if ( is_page_template( 'templates/template-animais.php' ) ) {
		$title = 'CBD para Animais: Guias de Dosagem e Segurança para Cães e Gatos';
		$description = 'Guia completo sobre CBD para animais de estimação. Comparação entre CBD para cães e gatos, dosagem segura e condições tratadas.';
		$url = get_permalink();
		$image = get_template_directory_uri() . '/assets/images/og-animais.jpg'; // Fallback
		
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
		
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta property="og:locale" content="pt_PT">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_animais_og_tags', 5 );

/**
 * Get optimized H1 for CBD para Cães page
 */
function cbd_ai_get_caes_h1() {
	return 'CBD para Cães: O Guia Definitivo de Dosagem por Peso, Condição e Segurança Veterinária';
}

/**
 * Get optimized H1 for CBD para Gatos page
 */
function cbd_ai_get_gatos_h1() {
	return 'CBD para Gatos: O Guia Veterinário de Dosagem Segura e Produtos Sem THC';
}

/**
 * Add meta title for CBD para Cães page
 */
function cbd_ai_caes_meta_title( $title ) {
	if ( is_page_template( 'templates/template-caes.php' ) ) {
		return 'CBD para Cães: Guia de Dosagem, Segurança por Peso e Onde Comprar | CBD Gratis';
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'cbd_ai_caes_meta_title' );

/**
 * Add meta description for CBD para Cães page
 */
function cbd_ai_caes_meta_description() {
	if ( is_page_template( 'templates/template-caes.php' ) ) {
		$description = 'Guia completo sobre CBD para cães. Dosagem segura por peso, condições tratadas (ansiedade, artrite, epilepsia), benefícios e segurança. Informação validada por veterinários.';
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_caes_meta_description', 1 );

/**
 * Add Open Graph tags for CBD para Cães page
 */
function cbd_ai_caes_og_tags() {
	if ( is_page_template( 'templates/template-caes.php' ) ) {
		$title = 'CBD para Cães: Dosagem, Benefícios e Guia Completo';
		$description = 'Guia completo sobre CBD para cães. Dosagem segura por peso, condições tratadas e benefícios validados por veterinários.';
		$url = get_permalink();
		$image = get_template_directory_uri() . '/assets/images/og-caes.jpg';
		
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
		
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta property="og:locale" content="pt_PT">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_caes_og_tags', 5 );

/**
 * Add meta title for CBD para Gatos page
 */
function cbd_ai_gatos_meta_title( $title ) {
	if ( is_page_template( 'templates/template-gatos.php' ) ) {
		return 'CBD para Gatos: Segurança, Dosagem Correta e Mitos a Evitar | CBD Gratis';
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'cbd_ai_gatos_meta_title' );

/**
 * Add meta description for CBD para Gatos page
 */
function cbd_ai_gatos_meta_description() {
	if ( is_page_template( 'templates/template-gatos.php' ) ) {
		$description = 'Guia completo sobre CBD para gatos. Dosagem segura por peso, condições tratadas (ansiedade, dores, stress), benefícios e segurança. Informação validada por veterinários.';
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_gatos_meta_description', 1 );

/**
 * Add Open Graph tags for CBD para Gatos page
 */
function cbd_ai_gatos_og_tags() {
	if ( is_page_template( 'templates/template-gatos.php' ) ) {
		$title = 'CBD para Gatos: Dosagem, Benefícios e Guia Completo';
		$description = 'Guia completo sobre CBD para gatos. Dosagem segura por peso, condições tratadas e benefícios validados por veterinários.';
		$url = get_permalink();
		$image = get_template_directory_uri() . '/assets/images/og-gatos.jpg';
		
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
		
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta property="og:locale" content="pt_PT">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_gatos_og_tags', 5 );

/**
 * Get optimized H1 for Chatbot CBD page
 */
function cbd_ai_get_chatbot_cbd_h1() {
	return 'Chatbot Especialista em CBD: O seu Assistente AI para Dúvidas Rápidas e Precisas';
}

/**
 * Add meta title for Chatbot CBD page
 */
function cbd_ai_chatbot_cbd_meta_title( $title ) {
	if ( is_page_template( 'templates/template-chatbot-cbd.php' ) ) {
		return 'Chatbot CBD Portugal: Pergunte sobre Dosagem, Legalidade e Segurança | CBD Gratis';
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'cbd_ai_chatbot_cbd_meta_title' );

/**
 * Add meta description for Chatbot CBD page
 */
function cbd_ai_chatbot_cbd_meta_description() {
	if ( is_page_template( 'templates/template-chatbot-cbd.php' ) ) {
		$description = 'Chatbot especialista em CBD com informações validadas. Pergunte sobre dosagem, legalidade em Portugal, segurança, benefícios e uso em animais ou humanos. Base de dados verificada pelo Monitor Legislação.';
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_chatbot_cbd_meta_description', 1 );

/**
 * Add Open Graph tags for Chatbot CBD page
 */
function cbd_ai_chatbot_cbd_og_tags() {
	if ( is_page_template( 'templates/template-chatbot-cbd.php' ) ) {
		$title = 'Chatbot CBD Portugal: Pergunte sobre Dosagem, Legalidade e Segurança';
		$description = 'Chatbot especialista em CBD com informações validadas. Pergunte sobre dosagem, legalidade em Portugal, segurança, benefícios e uso em animais ou humanos. Base de dados verificada pelo Monitor Legislação.';
		$url = get_permalink();
		$image = get_template_directory_uri() . '/assets/images/og-chatbot-cbd.jpg';
		
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
		
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta property="og:locale" content="pt_PT">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_chatbot_cbd_og_tags', 5 );

/**
 * Get optimized H1 for CBD para Pessoas/Humanos page
 */
function cbd_ai_get_humanos_h1() {
	return 'CBD para Pessoas: Guia Completo de Benefícios, Usos e Legalidade em Portugal';
}

/**
 * Add meta title for CBD para Pessoas page
 */
function cbd_ai_humanos_meta_title( $title ) {
	if ( is_page_template( 'templates/template-cbd-humanos.php' ) ) {
		return 'CBD para Pessoas: Benefícios, Dosagem e Legalidade em Portugal | CBD Gratis';
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'cbd_ai_humanos_meta_title' );

/**
 * Add meta description for CBD para Pessoas page
 */
function cbd_ai_humanos_meta_description() {
	if ( is_page_template( 'templates/template-cbd-humanos.php' ) ) {
		$description = 'O guia mais completo sobre CBD em Portugal. Descubra como o óleo de CBD pode ajudar na dor, ansiedade e sono. Informação 100% legal e baseada em evidências.';
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_humanos_meta_description', 1 );

/**
 * Add Open Graph tags for CBD para Pessoas page
 */
function cbd_ai_humanos_og_tags() {
	if ( is_page_template( 'templates/template-cbd-humanos.php' ) ) {
		$title = 'CBD para Pessoas: Benefícios, Dosagem e Legalidade em Portugal';
		$description = 'O guia mais completo sobre CBD em Portugal. Descubra como o óleo de CBD pode ajudar na dor, ansiedade e sono. Informação 100% legal e baseada em evidências.';
		$url = get_permalink();
		$image = get_template_directory_uri() . '/assets/images/og-humanos.jpg';
		
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
		
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta property="og:locale" content="pt_PT">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_humanos_og_tags', 5 );

/**
 * Add meta title for Calculadora de Dosagem page
 */
function cbd_ai_calculadora_meta_title( $title ) {
	if ( is_page_template( 'templates/template-calculadora-dosagem.php' ) ) {
		return 'Calculadora de Dosagem de CBD: Dose Correta para Pessoas, Cães e Gatos | CBD Gratis';
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'cbd_ai_calculadora_meta_title' );

/**
 * Add meta description for Calculadora de Dosagem page
 */
function cbd_ai_calculadora_meta_description() {
	if ( is_page_template( 'templates/template-calculadora-dosagem.php' ) ) {
		$description = 'Calculadora gratuita de dosagem de CBD para pessoas, cães e gatos. Calcule a dose correta baseada no peso, condição e concentração do produto. Fórmulas validadas por especialistas.';
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_calculadora_meta_description', 1 );

/**
 * Add Open Graph tags for Calculadora de Dosagem page
 */
function cbd_ai_calculadora_og_tags() {
	if ( is_page_template( 'templates/template-calculadora-dosagem.php' ) ) {
		$title = 'Calculadora de Dosagem de CBD: Dose Correta para Pessoas, Cães e Gatos';
		$description = 'Calculadora gratuita de dosagem de CBD. Calcule a dose correta baseada no peso, condição e concentração do produto. Fórmulas validadas por especialistas.';
		$url = get_permalink();
		$image = get_template_directory_uri() . '/assets/images/og-calculadora.jpg';
		
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
		
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta property="og:locale" content="pt_PT">' . "\n";
	}
}
add_action( 'wp_head', 'cbd_ai_calculadora_og_tags', 5 );

