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

