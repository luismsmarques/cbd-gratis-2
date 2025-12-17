<?php
/**
 * Custom Menu Walker for CBD AI Theme
 * Supports dropdowns and submenus
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Walker for Navigation Menu
 */
class CBD_AI_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start the element output.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		$classes = array( 'dropdown-menu', 'sub-menu' );
		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
	}

	/**
	 * End the element output.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		$output .= "$indent</ul>{$n}";
	}

	/**
	 * Start the element output.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// Add has-children class if item has children
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$classes[] = 'has-dropdown';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . ' class="nav-link">';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . apply_filters( 'the_title', $item->title, $item->ID ) . ( isset( $args->link_after ) ? $args->link_after : '' );
		
		// Add dropdown arrow if item has children
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$item_output .= '<svg class="w-4 h-4 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
		}
		
		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * End the element output.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";
	}
}

/**
 * Fallback menu function
 */
function cbd_ai_fallback_menu() {
	?>
	<ul class="flex items-center gap-1" id="primary-menu">
		<li class="menu-item-has-children has-dropdown">
			<a href="#animais" class="nav-link px-4 py-2 text-gray-700 hover:text-cbd-green-600 font-medium flex items-center gap-1">
				Animais
				<svg class="w-4 h-4 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
				</svg>
			</a>
			<ul class="dropdown-menu sub-menu">
				<li><a href="#caes" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-cbd-green-600">CBD para Cães</a></li>
				<li><a href="#gatos" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-cbd-green-600">CBD para Gatos</a></li>
				<li><a href="#dosagem" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-cbd-green-600">Guia de Dosagem</a></li>
				<li><a href="#faq" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-cbd-green-600">FAQ</a></li>
			</ul>
		</li>
		<li>
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'legislacao' ) ) ?: '#' ); ?>" class="nav-link px-4 py-2 text-gray-700 hover:text-cbd-green-600 font-medium">
				Legalidade
			</a>
		</li>
		<li>
			<a href="#ciencia" class="nav-link px-4 py-2 text-gray-700 hover:text-cbd-green-600 font-medium">
				Cânhamo & Ciência
			</a>
		</li>
	</ul>
	<?php
}
