<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Builder_Theme
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		builder_theme_render_page_sections();
		?>

	</main>

<?php
get_footer();
