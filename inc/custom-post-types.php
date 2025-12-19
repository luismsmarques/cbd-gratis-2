<?php
/**
 * Custom Post Types and Taxonomies
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Custom Post Types
 */
function cbd_ai_register_post_types() {
	// Legislation Alerts
	register_post_type( 'legislation_alert', array(
		'labels' => array(
			'name' => 'Alertas Legislativos',
			'singular_name' => 'Alerta Legislativo',
			'add_new' => 'Adicionar Novo',
			'add_new_item' => 'Adicionar Novo Alerta',
			'edit_item' => 'Editar Alerta',
			'new_item' => 'Novo Alerta',
			'view_item' => 'Ver Alerta',
			'search_items' => 'Pesquisar Alertas',
			'not_found' => 'Nenhum alerta encontrado',
			'not_found_in_trash' => 'Nenhum alerta encontrado no lixo',
		),
		'public' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-warning',
		'rewrite' => array( 'slug' => 'alertas-legislativos' ),
	) );
	
	// Legislation Sources
	register_post_type( 'legislation_source', array(
		'labels' => array(
			'name' => 'Fontes Legislativas',
			'singular_name' => 'Fonte Legislativa',
			'add_new' => 'Adicionar Nova',
			'add_new_item' => 'Adicionar Nova Fonte',
			'edit_item' => 'Editar Fonte',
			'new_item' => 'Nova Fonte',
			'view_item' => 'Ver Fonte',
			'search_items' => 'Pesquisar Fontes',
			'not_found' => 'Nenhuma fonte encontrada',
			'not_found_in_trash' => 'Nenhuma fonte encontrada no lixo',
		),
		'public' => false,
		'show_ui' => false,
		'show_in_menu' => false,
		'supports' => array( 'title' ),
		'menu_icon' => 'dashicons-admin-links',
	) );
	
	// CBD Stores
	register_post_type( 'cbd_store', array(
		'labels' => array(
			'name' => 'Lojas CBD',
			'singular_name' => 'Loja CBD',
			'add_new' => 'Adicionar Nova',
			'add_new_item' => 'Adicionar Nova Loja',
			'edit_item' => 'Editar Loja',
			'new_item' => 'Nova Loja',
			'view_item' => 'Ver Loja',
			'search_items' => 'Pesquisar Lojas',
			'not_found' => 'Nenhuma loja encontrada',
			'not_found_in_trash' => 'Nenhuma loja encontrada no lixo',
		),
		'public' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-store',
		'rewrite' => array( 'slug' => 'lojas-cbd' ),
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'cbd_ai_register_post_types' );

/**
 * Register Taxonomies
 */
function cbd_ai_register_taxonomies() {
	// Animal Type Taxonomy
	register_taxonomy( 'animal_type', array( 'post' ), array(
		'labels' => array(
			'name' => 'Tipos de Animal',
			'singular_name' => 'Tipo de Animal',
			'search_items' => 'Pesquisar Tipos',
			'all_items' => 'Todos os Tipos',
			'edit_item' => 'Editar Tipo',
			'update_item' => 'Atualizar Tipo',
			'add_new_item' => 'Adicionar Novo Tipo',
			'new_item_name' => 'Nome do Novo Tipo',
			'menu_name' => 'Tipos de Animal',
		),
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'animal' ),
	) );
	
	// CBD Topic Taxonomy
	register_taxonomy( 'cbd_topic', array( 'post' ), array(
		'labels' => array(
			'name' => 'Tópicos CBD',
			'singular_name' => 'Tópico CBD',
			'search_items' => 'Pesquisar Tópicos',
			'all_items' => 'Todos os Tópicos',
			'edit_item' => 'Editar Tópico',
			'update_item' => 'Atualizar Tópico',
			'add_new_item' => 'Adicionar Novo Tópico',
			'new_item_name' => 'Nome do Novo Tópico',
			'menu_name' => 'Tópicos CBD',
		),
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'topico-cbd' ),
	) );
	
	// Legislation Type Taxonomy
	register_taxonomy( 'legislation_type', array( 'legislation_alert' ), array(
		'labels' => array(
			'name' => 'Tipos de Legislação',
			'singular_name' => 'Tipo de Legislação',
			'search_items' => 'Pesquisar Tipos',
			'all_items' => 'Todos os Tipos',
			'edit_item' => 'Editar Tipo',
			'update_item' => 'Atualizar Tipo',
			'add_new_item' => 'Adicionar Novo Tipo',
			'new_item_name' => 'Nome do Novo Tipo',
			'menu_name' => 'Tipos de Legislação',
		),
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'tipo-legislacao' ),
	) );
	
	// Source Type Taxonomy
	register_taxonomy( 'source_type', array( 'legislation_source' ), array(
		'labels' => array(
			'name' => 'Tipos de Fonte',
			'singular_name' => 'Tipo de Fonte',
			'search_items' => 'Pesquisar Tipos',
			'all_items' => 'Todos os Tipos',
			'edit_item' => 'Editar Tipo',
			'update_item' => 'Atualizar Tipo',
			'add_new_item' => 'Adicionar Novo Tipo',
			'new_item_name' => 'Nome do Novo Tipo',
			'menu_name' => 'Tipos de Fonte',
		),
		'hierarchical' => true,
		'show_ui' => false,
		'show_admin_column' => false,
		'query_var' => true,
	) );
	
	// Store Type Taxonomy
	register_taxonomy( 'store_type', array( 'cbd_store' ), array(
		'labels' => array(
			'name' => 'Tipos de Loja',
			'singular_name' => 'Tipo de Loja',
			'search_items' => 'Pesquisar Tipos',
			'all_items' => 'Todos os Tipos',
			'edit_item' => 'Editar Tipo',
			'update_item' => 'Atualizar Tipo',
			'add_new_item' => 'Adicionar Novo Tipo',
			'new_item_name' => 'Nome do Novo Tipo',
			'menu_name' => 'Tipos de Loja',
		),
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'tipo-loja' ),
	) );
	
	// Store Location Taxonomy
	register_taxonomy( 'store_location', array( 'cbd_store' ), array(
		'labels' => array(
			'name' => 'Localizações',
			'singular_name' => 'Localização',
			'search_items' => 'Pesquisar Localizações',
			'all_items' => 'Todas as Localizações',
			'edit_item' => 'Editar Localização',
			'update_item' => 'Atualizar Localização',
			'add_new_item' => 'Adicionar Nova Localização',
			'new_item_name' => 'Nome da Nova Localização',
			'menu_name' => 'Localizações',
		),
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'localizacao' ),
	) );
	
	// Store Category Taxonomy
	register_taxonomy( 'store_category', array( 'cbd_store' ), array(
		'labels' => array(
			'name' => 'Categorias de Produtos',
			'singular_name' => 'Categoria de Produtos',
			'search_items' => 'Pesquisar Categorias',
			'all_items' => 'Todas as Categorias',
			'edit_item' => 'Editar Categoria',
			'update_item' => 'Atualizar Categoria',
			'add_new_item' => 'Adicionar Nova Categoria',
			'new_item_name' => 'Nome da Nova Categoria',
			'menu_name' => 'Categorias de Produtos',
		),
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'categoria-produtos' ),
	) );
	
	// Add default terms
	cbd_ai_add_default_terms();
}
add_action( 'init', 'cbd_ai_register_taxonomies' );

/**
 * Add default taxonomy terms
 */
function cbd_ai_add_default_terms() {
	// Animal types
	$animal_types = array( 'cão', 'gato', 'outros' );
	foreach ( $animal_types as $type ) {
		if ( ! term_exists( $type, 'animal_type' ) ) {
			wp_insert_term( $type, 'animal_type' );
		}
	}
	
	// CBD topics
	$topics = array( 'dosagem', 'beneficios', 'seguranca', 'legalidade', 'pesquisa', 'produtos' );
	foreach ( $topics as $topic ) {
		if ( ! term_exists( $topic, 'cbd_topic' ) ) {
			wp_insert_term( $topic, 'cbd_topic' );
		}
	}
	
	// Legislation types
	$legislation_types = array( 'infarmed', 'dre', 'eu', 'nacional', 'europeia' );
	foreach ( $legislation_types as $type ) {
		if ( ! term_exists( $type, 'legislation_type' ) ) {
			wp_insert_term( $type, 'legislation_type' );
		}
	}
	
	// Store types
	$store_types = array( 'física', 'online', 'híbrida' );
	foreach ( $store_types as $type ) {
		if ( ! term_exists( $type, 'store_type' ) ) {
			wp_insert_term( $type, 'store_type' );
		}
	}
	
	// Store categories
	$store_categories = array( 'óleos', 'cremes', 'cápsulas', 'comestíveis', 'flores', 'outros' );
	foreach ( $store_categories as $category ) {
		if ( ! term_exists( $category, 'store_category' ) ) {
			wp_insert_term( $category, 'store_category' );
		}
	}
}

