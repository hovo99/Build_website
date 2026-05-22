<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Builder_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function builder_theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'builder_theme_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function builder_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'builder_theme_pingback_header' );

/**
 * Render ACF flexible content rows using component naming convention.
 *
 * Expected component renderer naming:
 * builder_render_<layout>_component( $layout, $index ): string
 *
 * @param array $content Flexible content rows.
 * @return string
 */
function builder_theme_render_acf_content( $content ) {
	$output = '';

	if ( empty( $content ) || ! is_array( $content ) ) {
		return $output;
	}

	foreach ( $content as $index => $content_item ) {
		if ( empty( $content_item['acf_fc_layout'] ) ) {
			continue;
		}

		$layout_name = sanitize_key( $content_item['acf_fc_layout'] );

		if ( empty( $layout_name ) ) {
			continue;
		}

		$template = get_template_directory() . '/inc/components/' . $layout_name . '/template.php';

		if ( ! file_exists( $template ) ) {
			continue;
		}

		include_once $template;

		$function_name = 'builder_render_' . $layout_name . '_component';

		if ( ! function_exists( $function_name ) ) {
			continue;
		}

		$component_html = call_user_func( $function_name, $content_item, $index );

		if ( is_string( $component_html ) ) {
			$output .= $component_html;
		}
	}

	return $output;
}

/**
 * Render page sections flexible content for current page.
 *
 * @return void
 */
function builder_theme_render_page_sections() {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$sections = get_field( 'page_sections' );

	if ( empty( $sections ) || ! is_array( $sections ) ) {
		return;
	}

	echo builder_theme_render_acf_content( $sections ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
