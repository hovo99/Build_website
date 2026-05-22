<?php
/**
 * ACF options pages declarations.
 *
 * @package builder-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register ACF options pages hierarchy for theme settings.
 *
 * @return void
 */
function builder_theme_register_options_pages() {
	if ( ! function_exists( 'acf_add_options_page' ) || ! function_exists( 'acf_add_options_sub_page' ) ) {
		return;
	}

	$parent = acf_add_options_page(
		array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-settings',
			'capability' => 'edit_theme_options',
			'redirect'   => true,
		)
	);

	if ( empty( $parent['menu_slug'] ) ) {
		return;
	}

	acf_add_options_sub_page(
		array(
			'parent_slug' => $parent['menu_slug'],
			'page_title'  => 'Header Builder',
			'menu_title'  => 'Header Builder',
			'menu_slug'   => 'header-builder',
			'capability'  => 'edit_theme_options',
		)
	);

	acf_add_options_sub_page(
		array(
			'parent_slug' => $parent['menu_slug'],
			'page_title'  => 'Footer Builder',
			'menu_title'  => 'Footer Builder',
			'menu_slug'   => 'footer-builder',
			'capability'  => 'edit_theme_options',
		)
	);
}
add_action( 'acf/init', 'builder_theme_register_options_pages' );

require_once get_template_directory() . '/inc/acf/options/fields/header.php';
require_once get_template_directory() . '/inc/acf/options/fields/footer.php';

