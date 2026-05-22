
# AI Builder Upgrade Usage Guide

## Recommended Workflow

### 1. Full Page Conversion
Paste the entire HTML page.

AI will:
- split sections
- detect CPTs
- generate flexible content
- create queries
- detect WooCommerce

Use:
Full Page -> Full WordPress Builder


### 2. Dynamic Sections
For grids/cards/repeated items use:

Smart Dynamic Section Parser


### 3. WooCommerce Templates
For ecommerce/product templates use:

WooCommerce Product Section Parser


## Best Practices

### Use Full HTML
Always provide:
- full section
- wrapper classes
- nested structures

### Preserve Classes
Do not remove original frontend classes.

### Use Native WordPress APIs
- WP_Query
- WooCommerce hooks
- wp_get_attachment_image
- esc_html
- esc_attr
- esc_url

### Use Flexible Content
Every major section should become:
- reusable
- modular
- editable

## Recommended Theme Structure

theme/
├── assets/
├── inc/
├── template-parts/
│   └── flexible/
├── acf-json/
├── woocommerce/
├── functions.php
├── front-page.php
└── style.css

