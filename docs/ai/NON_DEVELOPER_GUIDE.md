# Non-Developer Guide: HTML Template -> WordPress Theme Builder

This guide is for content editors or project managers who want to convert HTML template sections into reusable WordPress sections, without coding.

It uses the rules in `docs/ai/HTML_TO_ACF_BUILDER.md`.

---

## 1) What you need

Before starting, make sure your WordPress site has:

- Active theme: `builder-theme`
- ACF Pro (active)
- Contact Form 7 (active)
- Polylang Pro (optional, for multilingual sites)

---

## 2) Convert one HTML section at a time

Always work with one section per request (for example: hero, banner, consultation, services, testimonials).

In Cursor, use:

```text
Use rules from docs/ai/HTML_TO_ACF_BUILDER.md
Convert this HTML section into a component:

[paste one full HTML section here]
```

Cursor generates component files inside:

- `wp-content/themes/builder-theme/inc/components/<component-name>/fields.php`
- `wp-content/themes/builder-theme/inc/components/<component-name>/template.php`
- `wp-content/themes/builder-theme/inc/components/<component-name>/demo.php` (optional)

---

## 3) Add the section in WordPress admin

1. Go to **Pages**
2. Edit your target page
3. Find **Page Builder / Sections**
4. Click **Add Section**
5. Choose the generated layout
6. Fill text, images, buttons, etc.

---

## 4) Forms (Contact Form 7) - important

If the section contains a form:

1. Create/edit form in **Contact Form 7**
2. Keep the same visual classes and structure from source HTML
3. In section fields, choose that CF7 form in the Relationship field

Where editors get CF7 form content to paste:

1. Source comes from the original section HTML provided by designer/template.
2. In WordPress admin go to **Contact -> Contact Forms**.
3. Open the target form (or click **Add New**).
4. In the CF7 editor, go to the **Form** tab.
5. Paste/update the CF7 form layout there (this is the exact form structure used on frontend).
6. Click **Save**.
7. Copy the form title/ID for reference.
8. Go back to your page section and select this form in the ACF Relationship field.
9. Update the page.

Quick dashboard flow:

- **WP Admin -> Contact -> Contact Forms -> (Add New / Edit) -> Form tab -> Paste layout -> Save**

Tip for editors:

- If you only have raw HTML, ask Cursor to convert that form HTML into valid CF7 tags while keeping exact classes.

Required AI behavior for future requests:

- When user provides a form HTML block, AI must generate a ready-to-copy CF7 form template.
- Output must be paste-ready for the CF7 **Form** tab.
- Keep visual classes, wrappers, field order, labels, and button classes from source HTML.
- Use valid CF7 tags (for example `[text*]`, `[email*]`, `[tel*]`, `[select]`, `[textarea]`, `[submit]`).

Important:

- Section template should render only CF7 shortcode
- Visual form HTML should be preserved in CF7 form content

---

## 5) Header and Footer (global settings)

Header/Footer are NOT page components.

Use these admin pages:

- **Theme Settings -> Header Builder**
- **Theme Settings -> Footer Builder**

They use structured ACF groups/repeaters and affect the whole site.

---

## 6) Translation rules (Polylang)

- ACF content is translated per page translation
- Do not wrap ACF values with `pll__()`
- Register only static UI strings for translation

---

## 7) Recommended workflow

1. Copy one HTML section
2. Ask Cursor to convert it
3. Fill fields in WordPress admin
4. Check frontend result
5. Repeat for next section

---

## 8) Ready-to-copy prompts

### A) Normal content section

```text
Use rules from docs/ai/HTML_TO_ACF_BUILDER.md
Convert this HTML section into a component:

[paste HTML]
```

### B) Section with Contact Form 7

```text
Use rules from docs/ai/HTML_TO_ACF_BUILDER.md
Convert this HTML section into a component with Contact Form 7 relationship integration.
Keep the exact visual form structure/classes in CF7 form content.

[paste HTML]
```

### C) Header/Footer HTML

```text
Use rules from docs/ai/HTML_TO_ACF_BUILDER.md
Parse this header/footer HTML into options-page group/repeater fields and update rendering.
Do not use flexible content for header/footer.

[paste HTML]
```

---

## 9) Common mistakes to avoid

- Converting multiple sections in one request
- Using header/footer as normal page components
- Breaking form classes when moving form HTML to CF7
- Using image fields as ID/URL when rule requires array
- Forgetting to select created CF7 form in section relationship field

---

## 10) Done checklist

Before publishing, verify:

- Section appears in frontend
- Images load correctly
- Buttons/links work
- Form submits successfully
- Header/Footer render from Theme Settings
- Mobile layout looks correct

