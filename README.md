# Builder Project - Quick Prompts

## Full Guides

- Main rules: `docs/ai/HTML_TO_ACF_BUILDER.md`
- Non-dev workflow: `docs/ai/NON_DEVELOPER_GUIDE.md`

---

## 1) Convert HTML Section -> ACF Component

Use when you have one page section (hero, banner, services, etc.).

```text
Use rules from docs/ai/HTML_TO_ACF_BUILDER.md
Convert this HTML section into a component:

[paste one full HTML section]
```

Data to provide:

- Full section HTML
- Preferred component name (optional)

---

## 2) Convert Section With Contact Form 7

Use when section contains a form.

```text
Use rules from docs/ai/HTML_TO_ACF_BUILDER.md
Convert this HTML section into a component with Contact Form 7 relationship integration.
Keep exact visual form structure/classes.

[paste one full HTML section with form]
```

Data to provide:

- Full section HTML with form
- CF7 form name (optional)

---

## 3) Generate CF7 Form Template (Copy/Paste Ready)

Use when you only need CF7 form content from HTML form.

```text
Convert this HTML form into Contact Form 7 template content.
Return ready-to-copy output for CF7 Form tab.
Keep exact wrappers/classes/field order/labels/button classes.

[paste form HTML only]
```

Data to provide:

- Form HTML block only

---

## 4) Parse Header HTML -> Theme Settings (Options)

Use for global header (not flexible content component).

```text
Use rules from docs/ai/HTML_TO_ACF_BUILDER.md
Parse this Header HTML into ACF options-page group/repeater fields and implement header rendering.
Do not use wp_nav_menu/menu_location; use structured custom menu fields.

[paste full header HTML]
```

Data to provide:

- Full header HTML
- Menu behavior notes (if any)

---

## 5) Parse Footer HTML -> Theme Settings (Options)

Use for global footer (not flexible content component).

```text
Use rules from docs/ai/HTML_TO_ACF_BUILDER.md
Parse this Footer HTML into ACF options-page group/repeater fields and implement footer rendering.
Do not use flexible content for footer.

[paste full footer HTML]
```

Data to provide:

- Full footer HTML

---

## 6) Enqueue Template Assets (WP Way)

Use when adding template CSS/JS files.

```text
Register and enqueue these CSS/JS files in functions.php using WordPress standards.
Load CSS in head and JS in footer.
Use WordPress core jQuery (no duplicate local jQuery file).
Add jQuery noConflict-safe support for `$` usage.

[paste CSS/JS file list]
```

Data to provide:

- Asset list from template
- Real paths inside theme (`css/`, `js/`, etc.)




# =====================================
# NEW AI AUTOMATION FEATURES
# =====================================

## Added Features

This upgraded version includes:

1. Auto CPT Detection
2. Full Page Parser
3. WooCommerce Detection
4. Smart ACF Field Detection
5. Auto Query Generation


# HOW TO USE NEW FEATURES

## 1) Auto CPT Detection

### What It Does
AI automatically detects when repeated content should become:
- Custom Post Type
- Repeater
- Taxonomy
- WooCommerce Products

### Example Prompt

Use rules from docs/ai/HTML_TO_ACF_BUILDER.md

Convert this section into a dynamic WordPress component.
Automatically detect:
- CPTs
- repeaters
- taxonomies
- WP_Query structures

[paste section HTML]

### Example Result
Projects grid automatically becomes:
- CPT: project
- archive query
- single template recommendation


# =====================================

## 2) Full Page Parser

### What It Does
Instead of converting sections one by one,
AI can now parse the FULL HTML page automatically.

### Detects Automatically
- Hero
- Services
- FAQ
- Testimonials
- CTA
- Blog
- Products
- Contact
- Team
- Pricing

### Example Prompt

Use rules from docs/ai/HTML_TO_ACF_BUILDER.md

Parse this FULL HTML page into:
- flexible content layouts
- reusable components
- ACF fields
- queries
- recommended theme structure

[paste full HTML page]


# =====================================

## 3) WooCommerce Detection

### What It Does
AI automatically detects ecommerce/product layouts.

### Detects
- prices
- add to cart buttons
- sale badges
- product cards
- product galleries

### Example Prompt

Use rules from docs/ai/HTML_TO_ACF_BUILDER.md

Convert this ecommerce section into WooCommerce architecture.

Requirements:
- native WooCommerce integration
- dynamic product loop
- preserve classes

[paste ecommerce HTML]


# =====================================

## 4) Smart ACF Field Detection

### What It Does
AI automatically selects best ACF field types.

### Auto Mapping
- image -> image field
- gallery -> gallery field
- cards -> repeater
- button -> link field
- text editor -> wysiwyg
- dropdown -> select
- related posts -> relationship field

### Example
AI detects:
- repeated cards
- nested content
- rich text
- CTA blocks

And generates optimized editable admin structure.


# =====================================

## 5) Auto Query Generation

### What It Does
AI automatically creates:
- WP_Query
- WooCommerce queries
- pagination-ready loops

### Example Generated Query

```php
$args = [
  'post_type' => 'project',
  'posts_per_page' => 6
];
```

### Example Prompt

Generate dynamic WordPress query structure for this section.

[paste HTML]


# =====================================

# RECOMMENDED WORKFLOW

## BEST METHOD

1. Paste FULL HTML page
2. Use Full Page Parser prompt
3. AI splits sections automatically
4. AI detects:
   - CPTs
   - WooCommerce
   - repeaters
   - queries
5. AI generates:
   - flexible content
   - PHP components
   - field structure
   - WP architecture

# FINAL RESULT

HTML Template
    ↓
AI Parsing
    ↓
Flexible Content
    ↓
ACF Fields
    ↓
CPT Detection
    ↓
WooCommerce Integration
    ↓
Dynamic WordPress Theme

