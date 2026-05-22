<?php
/**
 * ACF Flexible Content component loader.
 *
 * @package builder-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build ACF Flexible Content layouts from component field definitions.
 *
 * @return array
 */
function builder_theme_get_component_layouts() {
	$layouts        = array();
	$components_dir = get_template_directory() . '/inc/components';
	$components     = glob( $components_dir . '/*', GLOB_ONLYDIR );

	if ( empty( $components ) ) {
		return $layouts;
	}

	foreach ( $components as $component ) {
		$fields_file = $component . '/fields.php';

		if ( ! file_exists( $fields_file ) ) {
			continue;
		}

		$layout = require $fields_file;

		if ( is_array( $layout ) ) {
			$layouts[] = $layout;
		}
	}

	return $layouts;
}

/**
 * Register page builder flexible content field group.
 *
 * @return void
 */
function builder_theme_register_page_builder_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$layouts = builder_theme_get_component_layouts();

	if ( empty( $layouts ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_page_builder',
			'title'                 => 'Page Builder',
			'fields'                => array(
				array(
					'key'          => 'field_page_sections',
					'label'        => 'Sections',
					'name'         => 'page_sections',
					'type'         => 'flexible_content',
					'button_label' => 'Add Section',
					'layouts'      => $layouts,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);
}
add_action( 'acf/init', 'builder_theme_register_page_builder_fields' );
