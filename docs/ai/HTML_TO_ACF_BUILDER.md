
# HTML → WordPress ACF Flexible Builder — Cursor AI Master Prompt

This document defines a working pattern for Cursor AI to convert HTML templates into a modular WordPress theme using **ACF Pro Flexible Content**, **Contact Form 7**, and **Polylang Pro**.

You can place this file in:

docs/ai/HTML_TO_ACF_BUILDER.md

Then in Cursor you can say:

"Use rules from HTML_TO_ACF_BUILDER.md and convert this HTML section into a component."

Cursor should then generate layouts, fields, and templates following the rules below.

---

# 1. Goal

Given an HTML template section, the AI must generate:

1. Component folder
2. ACF layout definition
3. Rendering template
4. Optional demo data
5. Optional Contact Form 7 relation integration
6. Polylang compatibility

The architecture must remain **modular and scalable**.

---

# 2. Project Architecture

Theme structure must follow a component system:

theme/
 ├ inc/
 │   ├ acf/
 │   │   component-loader.php
 │
 │   ├ components/
 │   │   hero/
 │   │       fields.php
 │   │       template.php
 │   │       demo.php
 │   │
 │   │   subscribe/
 │   │       fields.php
 │   │       template.php
 │   │       demo.php

Each component represents one HTML section.

---

# 3. Component Rules

Each component contains:

fields.php
Defines the ACF Flexible Layout and returns an array.

Example:

```php
return [
 'key' => 'layout_hero',
 'name' => 'hero',
 'label' => 'Hero',
 'display' => 'block',
 'sub_fields' => []
];
```

template.php

Must define a render function that returns HTML as string.

Function requirements:

1. Function must return rendered HTML (do not echo directly in component template file)
2. Function must accept two parameters:
   - `$layout` (current layout data array; use it as the source of component values)
   - `$index` (0-based index of this component in the page render order)
3. Function name should follow component naming, for example:
   `builder_render_<component>_component( $layout, $index )`
4. The file should return/call nothing outside function definitions.

Example:

```php
function builder_render_hero_component( $layout, $index ) {
	$title = $layout['title'] ?? '';
	$layout_name = $layout['acf_fc_layout'] ?? 'hero';

	ob_start();
	?>
	<section class="hero hero-<?php echo esc_attr( $index ); ?>" data-layout="<?php echo esc_attr( $layout_name ); ?>">
		<h1><?php echo esc_html( $title ); ?></h1>
	</section>
	<?php
	return ob_get_clean();
}
```

demo.php (optional)

Example:

```php
return [
 'acf_fc_layout' => 'hero',
 'title' => 'Welcome',
 'subtitle' => 'Example subtitle'
];
```

---

# 4. Flexible Content Builder

All components must register into a single flexible field.

Loader must:

1. Scan components directory
2. Collect layouts
3. Register flexible field

Example:

```php
$components = glob(get_template_directory() . '/inc/components/*', GLOB_ONLYDIR);

foreach ($components as $component) {
    $layouts[] = require $component . '/fields.php';
}

acf_add_local_field_group([
 'key' => 'group_page_builder',
 'title' => 'Page Builder',
 'fields' => [
  [
   'key' => 'field_page_sections',
   'label' => 'Sections',
   'name' => 'page_sections',
   'type' => 'flexible_content',
   'layouts' => $layouts
  ]
 ]
]);
```

---

# 5. Template Rendering

Flexible layouts automatically load the component template file,
then call the component render function with layout data + index.

Example:

```php
if (have_rows('page_sections')):
 $component_index = 0;
 while (have_rows('page_sections')): the_row();

  $layout_name = get_row_layout();
  $layout = get_row(true);
  $template = get_template_directory() . "/inc/components/$layout_name/template.php";

  if(file_exists($template)){
     include_once $template;

     $function_name = "builder_render_{$layout_name}_component";

     if (function_exists($function_name)) {
        echo $function_name($layout, $component_index);
     }
  }

  $component_index++;
 endwhile;
endif;
```

---

# 6. HTML → ACF Field Conversion Rules

| HTML element | ACF field |
|--------------|-----------|
h1,h2,h3 | text
p | textarea
img | image (return_format: array)
button | text/url
ul/li | repeater
cards/grid | repeater group

---

# 6.1 Image Field Rules (Mandatory)

All ACF image fields must use:

Return Format: array

This rule applies to:

- section/background images
- content images
- icon images
- button icon images
- any image inside repeater/group fields

Image field example:

```php
[
 'key' => 'field_hero_image',
 'label' => 'Hero Image',
 'name' => 'hero_image',
 'type' => 'image',
 'return_format' => 'array'
]
```

Template rendering must read from `url` and `alt`:

```php
$image = $layout['hero_image'] ?? [];

if (!empty($image['url'])) {
    echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? '') . '">';
}
```

Never assume image return value is an ID or URL string.

---

# 7. Contact Form 7 Integration

Forms must be connected using an **ACF Relationship field**.

Rules:

Field Type: relationship  
Post Type: wpcf7_contact_form  
Max: 1  
Return Format: Post Object

Visual structure requirement (mandatory):

- CF7 form markup must preserve the original HTML form structure and classes exactly.
- Keep the same wrapper classes, field order, label placement, and button classes from the source HTML.
- When converting HTML sections (for example consultation/contact blocks), put the exact visual form structure inside the selected CF7 form template.
- The section template should render the CF7 shortcode only; visual form markup must be maintained in CF7 so frontend output matches the original design.

Rendering:

```php
$form_posts = $layout['subscribe_form'] ?? [];

if (!empty($form_posts)) {
    $form = $form_posts[0];
    echo do_shortcode('[contact-form-7 id="' . $form->ID . '"]');
}
```

Seeder must insert relation as array:

```php
update_field('subscribe_form', [$form_id], $page_id);
```

---

# 8. Polylang Rules

ACF content must NOT use pll__().

ACF values are translated via **Polylang page translations**.

Only static UI text must be registered.

Examples:

Read More  
Search  
Submit  
Next  
Previous  

Register:

```php
pll_register_string('read_more','Read More','theme');
```

Usage:

```php
echo pll__('Read More');
```

Never wrap ACF fields in pll__().

---

# 9. Demo Data Seeder

Seeder can auto-create pages and fill flexible layouts.

Example:

```php
$page_id = wp_insert_post([
 'post_title' => 'Home',
 'post_status' => 'publish',
 'post_type' => 'page'
]);

$sections[] = require get_template_directory().'/inc/components/hero/demo.php';

update_field('page_sections',$sections,$page_id);
```

---

# 9.1 Header/Footer HTML Parsing (Options Pages)

Header and footer HTML conversion must be handled in a separate flow from page components.

This flow is for global theme parts only:

- Header HTML
- Footer HTML

Do not generate these as `inc/components/<name>/` flexible components.

Use ACF Options Pages and register dedicated field groups.

Store options-page code in a dedicated directory tree:

theme/
 ├ inc/
 │   ├ acf/
 │   │   ├ options/
 │   │   │   options-pages.php
 │   │   │
 │   │   │   ├ fields/
 │   │   │   │   header.php
 │   │   │   │   footer.php

Rules:

1. Register options pages hierarchy:
   - Top level: Theme Settings
   - Sub page: Header Builder
   - Sub page: Footer Builder
2. Register dedicated ACF field groups for each options page:
   - `group_header_builder`
   - `group_footer_builder`
3. Use HTML-based specific `group` fields for header/footer data (no flexible content)
4. Rendering must read from options context (`'option'` post ID)
5. Header/Footer parsing pipeline is independent from section component pipeline
6. Keep options-page declarations in `inc/acf/options/options-pages.php`
7. Keep header/footer field group declarations in `inc/acf/options/fields/`

Implementation note (important for future generation):

- Header and footer must use dedicated, well-structured ACF `group` + `repeater` fields.
- Do not use Flexible Content for header/footer.
- Do not rely on standard WordPress menu locations (`menu_location` + `wp_nav_menu`) for header navigation; use custom structured menu fields in options.
- Footer navigation/content areas should follow the same structured-field approach.
- Rendering should always read from options data (`get_field( '<field_name>', 'option' )`).

Example options page registration:

```php
if ( function_exists( 'acf_add_options_page' ) ) {
	$parent = acf_add_options_page(
		array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-settings',
			'capability' => 'edit_theme_options',
			'redirect'   => true,
		)
	);

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
			'page_title' => 'Footer Builder',
			'menu_title' => 'Footer Builder',
			'menu_slug'  => 'footer-builder',
			'capability' => 'edit_theme_options',
		)
	);
}
```

Example field group registration:

```php
acf_add_local_field_group(
	array(
		'key'      => 'group_header_builder',
		'title'    => 'Header Builder',
		'location' => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'header-builder',
				),
			),
		),
		'fields'   => array(
			array(
				'key'   => 'field_header_group',
				'label' => 'Header Group',
				'name'  => 'header_group',
				'type'  => 'group',
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key'   => 'field_header_logo',
						'label' => 'Logo',
						'name'  => 'logo',
						'type'  => 'image',
						'return_format' => 'array',
					),
					array(
						'key'   => 'field_header_menu_label',
						'label' => 'Menu Label',
						'name'  => 'menu_label',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_header_cta',
						'label' => 'Header CTA',
						'name'  => 'header_cta',
						'type'  => 'link',
					),
				),
			),
		),
	)
);

acf_add_local_field_group(
	array(
		'key'      => 'group_footer_builder',
		'title'    => 'Footer Builder',
		'location' => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'footer-builder',
				),
			),
		),
		'fields'   => array(
			array(
				'key'   => 'field_footer_group',
				'label' => 'Footer Group',
				'name'  => 'footer_group',
				'type'  => 'group',
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key'   => 'field_footer_logo',
						'label' => 'Logo',
						'name'  => 'logo',
						'type'  => 'image',
						'return_format' => 'array',
					),
					array(
						'key'   => 'field_footer_text',
						'label' => 'Footer Text',
						'name'  => 'footer_text',
						'type'  => 'textarea',
					),
					array(
						'key'   => 'field_footer_copyright',
						'label' => 'Copyright',
						'name'  => 'copyright',
						'type'  => 'text',
					),
				),
			),
		),
	)
);
```

Example options rendering read:

```php
$header_group = get_field( 'header_group', 'option' );
$footer_group = get_field( 'footer_group', 'option' );
```

---

# 10. HTML → Component Workflow

When HTML is provided:

1. Detect section
2. Choose component name
3. Extract fields
4. Generate fields.php
5. Generate template.php with render function `( $layout, $index )` returning HTML
6. Generate optional demo.php

Example HTML:

```html
<section class="hero">
 <h1>Welcome</h1>
 <p>Subtitle</p>
 <a>Start</a>
</section>
```

Component:

components/hero/

Fields:

title  
subtitle  
button_text  

---

# 11. Coding Standards

Generated code must:

• use acf_add_local_field_group()  
• follow WordPress coding standards  
• be modular  
• avoid global variables  
• avoid monolithic templates

---

# 12. Expected Output

When HTML is given, the AI must output:

1. component folder name
2. fields.php
3. template.php (function-based renderer returning HTML with layout + index params)
4. demo.php (if applicable)

---

# 13. Quality Standards

The generated code must be:

Production ready  
Readable  
ACF Pro compatible  
Polylang compatible  
Contact Form 7 compatible

---

# End of Document



# ================================
# AI AUTOMATION UPGRADES
# ================================

## 1) Auto CPT Detection

### Rules
- Detect repeated content blocks automatically.
- Suggest best structure:
  - CPT
  - Taxonomy
  - Repeater
  - WooCommerce Products
  - Blog Posts

### Examples
- Projects Grid -> CPT: project
- Team Members -> CPT: team
- Services Grid -> repeater OR CPT depending on complexity
- Blog Section -> WP Posts Query
- Product Grid -> WooCommerce products

### AI Instructions
If repeated cards contain:
- image
- title
- excerpt
- detail page intent

Prefer Custom Post Type architecture.

Generate:
- CPT name
- taxonomy suggestions
- WP_Query example
- archive template notes
- single template notes


## 2) Full Page Parser

### Rules
Parse FULL HTML pages automatically and split them into reusable ACF flexible content components.

### Detect Sections
- Hero
- About
- Services
- Features
- FAQ
- Testimonials
- CTA
- Team
- Pricing
- Contact
- Blog
- Products
- Footer CTA

### Generate Automatically
- component names
- field groups
- layout names
- component PHP files
- render loop
- suggested file structure

### AI Instructions
Each major visual block should become a separate flexible content layout.


## 3) WooCommerce Detection

### Rules
Detect ecommerce/product layouts automatically.

### Detect
- product cards
- prices
- add to cart buttons
- sale badges
- galleries
- quantity controls
- tabs
- reviews

### Generate
- WooCommerce archive integration
- single product integration
- wc_get_product usage
- WooCommerce hooks where appropriate

### AI Instructions
If ecommerce structure detected:
- use native WooCommerce functions
- avoid rebuilding cart logic manually
- preserve original HTML classes


## 4) Smart ACF Field Detection

### Rules
Automatically detect correct ACF field types.

### Mapping
- image -> image field
- multiple images -> gallery
- cards/items -> repeater
- CTA buttons -> link field
- rich text -> wysiwyg
- dropdown -> select
- relationships -> relationship/post object
- tabs -> repeater/flexible content

### AI Instructions
Always prefer the cleanest editable admin experience.


## 5) Auto Query Generation

### Rules
If dynamic listing detected:
Automatically generate WP_Query examples.

### Examples

Projects:
```php
$args = [
  'post_type' => 'project',
  'posts_per_page' => 6
];
```

Blog:
```php
$args = [
  'post_type' => 'post',
  'posts_per_page' => 3
];
```

WooCommerce:
```php
$args = [
  'post_type' => 'product',
  'posts_per_page' => 8
];
```

### AI Instructions
Always:
- reset postdata
- sanitize variables
- support pagination if needed


# ================================
# QUICK PROMPTS (UPGRADED)
# ================================

## Full Page -> Full WordPress Builder

Use rules from docs/ai/HTML_TO_ACF_BUILDER.md

Parse this FULL HTML page into a production-ready WordPress ACF flexible content architecture.

Requirements:
- Auto detect CPTs
- Auto detect repeaters
- Auto detect WooCommerce sections
- Auto detect queries
- Generate flexible content layouts
- Generate component structure
- Generate recommended theme file structure
- Preserve exact HTML classes
- Preserve responsive structure

[paste full page HTML]


## Smart Dynamic Section Parser

Use rules from docs/ai/HTML_TO_ACF_BUILDER.md

Convert this section into the best possible dynamic structure automatically.

Requirements:
- Detect CPT/repeater automatically
- Detect best ACF field types
- Generate WP_Query if needed
- Detect WooCommerce support if applicable

[paste section HTML]


## WooCommerce Product Section Parser

Use rules from docs/ai/HTML_TO_ACF_BUILDER.md

Convert this ecommerce/product section into WooCommerce-compatible WordPress architecture.

Requirements:
- native WooCommerce integration
- preserve original HTML structure
- generate archive/single recommendations
- generate dynamic product loop

[paste ecommerce HTML]
