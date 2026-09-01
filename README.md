# Sedgemore WordPress Project Guide

This project is a custom WordPress site using the `sadgemore` theme. Most pages are edited in WordPress through normal page settings plus extra editable sections such as Hero, Intro, Services, Experiences, Stay, and Contact.

Use this guide for day-to-day content management and for developer handover.

## Project Structure

- `wp-content/themes/sadgemore/` - active custom theme.
- `wp-content/themes/sadgemore/page-templates/` - page templates selected from the WordPress page editor.
- `wp-content/themes/sadgemore/post-type-templates/` - templates for custom post type single views.
- `wp-content/themes/sadgemore/inc/` - developer files for content fields, forms, submissions, and theme helpers.
- `wp-content/themes/sadgemore/template-parts/` - shared template fragments, including header navigation.
- `wp-content/themes/sadgemore/assets/` and `wp-content/themes/sadgemore/js/` - theme CSS, JS, vendor scripts, and custom scripts.
- `wp-content/themes/sadgemore/README_SUBMISSIONS.md` - deeper guide for form submissions and follow-up email management.

Avoid editing files in `old_files_15_july`, backup templates, or `front-page.backup.php` unless intentionally restoring legacy work.

## Theme Setup

Main theme bootstrap lives in `wp-content/themes/sadgemore/functions.php`.

For developers, it does four important things:

- Loads local ACF field definitions from `inc/acf-*-fields.php`.
- Registers scripts and styles.
- Registers custom post types through `inc/posttype.php`.
- Loads AJAX and submission management through `inc/ajax.php` and `inc/submissions.php`.

Theme option pages are registered in `inc/template-functions.php`:

- WP Admin -> Theme Settings
- WP Admin -> Theme Settings -> Header
- WP Admin -> Theme Settings -> Footer

These option pages feed global header/footer content such as logos, menu links, footer text, and social links.

## Page Templates

Create or edit pages from WP Admin -> Pages. The template is selected in the page editor under Template / Page Attributes.

### Home

Template: `page-templates/home.php`

Purpose: the main homepage experience with hero, offer cards, how-we-work steps, trusted brands, Privé section, destinations, and enquiry form.

Main editable sections:

- Hero background image/video.
- Three offer cards.
- Privé section body copy.
- Privé benefit bullets.
- Destination/story cards.

Notes:

- The "How we work" steps are fixed in the template and need a developer to edit.
- The "Trusted Brands" strip is fixed in the template and needs a developer to edit.
- Enquiry form entries are stored under WP Admin -> Submissions.

### About

Template: `page-templates/about.php`

Purpose: editorial About page with hero/approach content, trusted brands, and supporting brand story sections.

Notes:

- Much of the current revised About page is fixed inside the template.
- The trusted brand logos are fixed inside the template.
- If a content manager cannot find text or images in the page editor, that content likely needs a developer edit in this template.

There is also a legacy `about_09april24.php` and older backup files. Treat those as historical reference only.

### Travel

Template: `page-templates/travel.php`

Main editable areas include:

- Hero.
- Approach.
- Services / service cards.
- Story sections.
- Partner logos.
- Reasons.
- Testimonial.
- Privé section.
- Closing enquiry form and interest options.

Some Travel content also comes from the Travel Type category-style settings. Ask a developer if that content is not visible on the page editor screen.

### Concierge

Template: `page-templates/concierge.php`

Main editable areas include:

- Hero.
- Core services.
- Supporting services.
- How we work.
- Membership promo.
- Enquiry form copy and interest options.

### Membership

Template: `page-templates/membership.php`

Main editable areas include:

- Hero slides, eyebrow, title, intro, and button.
- Intro section.
- Philosophy section.
- Pillars.
- Membership tiers.
- Interest form copy.

Some title fields support simple formatting such as line breaks and italics. The template also includes default text in a few places, so leaving a field empty may show default content instead of a blank space.

### Our Work

Archive/page template: `page-templates/our-work.php`

Single item template: `post-type-templates/single-our-work.php`

The archive page presents Our Work entries and page-level editorial sections. Individual entries are managed under WP Admin -> Our Work.

Single Our Work editable fields:

- Overview - About the project copy.
- Main video - main media video.
- Main image - primary image if no video is used.
- Services text - services introduction text.
- Services list - services provided list.
- Media list - gallery/media rows.

The single template shows "Services Provided" before the About section within the project layout.

### Hotels & Resorts

Template: `page-templates/hotels-resorts.php`

Main editable areas include hero, intro, hotel collection, destinations, process, and enquiry.

### Itineraries

Template: `page-templates/itineraries.php`

Main editable areas include hero, intro, destination cards, process steps, enquiry copy, and interest options.

### Private Yachts

Template: `page-templates/private-yachts.php`

Main editable areas include hero, intro, split section, what we arrange, testimonial, destinations, and enquiry.

### Private Villas

Template: `page-templates/private-villas.php`

Main editable areas include hero, intro, pillars, image strip, experience section, process, testimonial, and enquiry.

### Events

Template: `page-templates/events.php`

Main editable areas include hero, intro, services, difference, process, connected services, and CTA form.

### Blog Story

Template: `page-templates/blog.php`

This is a long-form editorial layout for destination stories, example itineraries, hotel/stay features, and campaign-style blog posts.

The Blog Story editor is split into tabs such as Hero, Statement, Stats, Itinerary, Experiences, Stay, and Contact. Think of these tabs as the editable sections of the page. You do not need to know how the template is coded; fill in the fields, preview the page, and publish when it looks right.

You can create a Blog Story in two ways:

- Posts -> Add New. Use this for normal stories, articles, and destination posts.
- Pages -> Add New -> choose the `Blog Story` template. Use this when the story should be managed as a standalone page.

Before filling in the Blog Story tabs, set these normal WordPress fields:

- Title - the admin title and the default page heading.
- Permalink/slug - the page URL.
- Excerpt - a short summary. This may appear in several places if matching Blog Story fields are left empty.
- Main content editor - general story copy. This may be used if some Blog Story copy fields are left empty.
- Featured image - the main fallback image if a Blog Story image field is left empty.
- Categories - useful for posts; these can appear as the destination/location fallback.

Blog Story tabs and what they control:

- Hero
  - Location - the small vertical place label on the hero image.
  - Kicker - small text above the main title.
  - Hero title override - use this only if the front-end title should be different from the WordPress title.
  - Hero descriptor - short supporting text on the hero image.
  - Hero image - the large full-screen image at the top of the story.
- Statement
  - Aside label - small label beside the supporting image.
  - Aside image - a portrait-style supporting image.
  - Headline - the large editorial headline after the hero.
  - Left text and Right text - the two columns of body copy.
  - Pull quote - the italic quote below the two columns.
- Stats
  - Add one row for each statistic.
  - Each row has a Value and a Label.
  - Best result: add 4 stats, because the design is built as a four-column strip on desktop.
  - Example values: `8 nights`, `3 regions`, `Private guide`, `May-Oct`.
- Itinerary
  - Intro title - the section heading.
  - Intro note - short text beside the heading.
  - Days - add one row for each day, chapter, stop, or story moment.
  - Each day row includes Day number, Kicker, Title, Body, and Tags.
  - Tags are typed as a comma-separated list. Example: `Private access, Whisky tasting, Highlands`.
- Experiences
  - Section title - heading above the image gallery.
  - Section note - short text beside the heading.
  - Experiences - add one row for each image card.
  - Each experience row includes Image, Region, and Title.
  - Best result: add at least 3 images. Add 4 or more if you want the horizontal scrolling gallery effect.
- Stay
  - Image - large accommodation, property, destination, or closing feature image.
  - Eyebrow - small label above the stay name.
  - Name - hotel, villa, yacht, destination, or feature name.
  - Location - the location line below the name.
  - Text - body copy for the stay/feature block.
  - Facts - add one row for each fact. Each row has a Label and Value.
  - CTA label and CTA URL - the button text and where the button links.
- Contact
  - Kicker, Title, Description, and Note - text for the enquiry section at the bottom.
  - Interest label - heading above the interest choices.
  - Interest options - add one row for each selectable interest.
  - Message label and Message placeholder - text shown around the message box.
  - Enquiries from this form are saved under WP Admin -> Submissions.

Recommended Blog Story build order:

1. Create the post or page.
2. Add the title, URL slug, excerpt, featured image, and category if it is a post.
3. Save as Draft once. This makes sure all Blog Story tabs are available.
4. Fill the Hero tab first.
5. Fill the Statement tab.
6. Add 4 rows in the Stats tab.
7. Add Itinerary rows in the order they should appear.
8. Add Experience image cards.
9. Fill the Stay tab.
10. Fill the Contact tab.
11. Preview the story on desktop and mobile.
12. Publish when everything looks correct.

Blog Story image guidance:

- Hero image: use a wide landscape photo, ideally at least 1800px wide.
- Statement aside image: use a portrait or vertical crop.
- Experience images: use consistent editorial photos; landscape or portrait can work because the template crops them to equal cards.
- Stay image: use a strong landscape or room/property image.
- Add descriptive alt text in the Media Library so images are more accessible.

Editing Blog Story content:

- To update copy, open the matching tab, edit the field, and click Update.
- To reorder days, experiences, stats, facts, or interest options, drag the rows into the order you want.
- To remove one item, delete that row and click Update.
- To replace an image, click the image field, choose a new Media Library item, and click Update.
- To remove an image from only this story, clear the image field. Do not delete it from the Media Library unless you are sure it is not used anywhere else.
- To change the large hero title without changing the admin title or URL, use Hero title override.
- To change the URL, edit the permalink/slug.

Removing or hiding Blog Story sections:

- To hide the whole story from the public site, change it to Draft or Private.
- To remove the story from the admin list but keep it recoverable, move it to Trash.
- To remove one stat, itinerary day, experience, fact, or interest option, delete that row.
- Some empty sections show default content instead of disappearing. For example, if all Stats rows are removed, the page may show default stats such as year, author, word count, and destination.
- If you want an entire section removed from the design, ask a developer to hide that section in the template.
- Do not delete theme files to hide a story or section.

### Blog Editorial Article

Template: `page-templates/blog-editorial.php`

This template follows the Winter Sun HTML reference: narrow editorial column, small uppercase labels, Cormorant headings, large hero image, divider rules, destination-style article sections, image figures, pull quotes, aside notes, closing CTA, and image credits.

Use this template for magazine-style articles where the story is mostly prose and photography, not for itinerary/stat/gallery-heavy posts. The attached HTML file is a visual reference only; the WordPress version is managed through post/page fields.

You can create a Blog Editorial Article in two ways:

- Posts -> Add New -> select the `Blog Editorial Article` template if the article belongs in the blog/news feed.
- Pages -> Add New -> select the `Blog Editorial Article` template if it should be a standalone page.

Before using the custom fields, set the normal WordPress fields:

- Title - admin title and fallback front-end title.
- Slug/permalink - the public URL.
- Excerpt - fallback standfirst.
- Featured image - fallback hero image.
- Categories - optional; used as a fallback label on posts.
- Status - Draft, Private, Published, or Trash controls whether the article is visible.

Blog Editorial Article tabs:

- Hero
  - Label - small uppercase label above the headline. Example: `Winter Sun &middot; 2026/27`.
  - Title - front-end headline. HTML is allowed for emphasis, for example `The Best <em>Escapes</em>`.
  - Standfirst - short introductory paragraph below the headline.
  - Byline - small uppercase author line.
  - Hero image - large image below the heading.
  - Hero image credit - caption under the hero image. HTML is allowed for emphasis.
- Intro
  - Intro paragraphs - opening body copy before the first divider.
- Article Blocks
  - Add rows in the exact order they should appear.
  - Divider - full-width rule between sections. Enable Short divider when needed.
  - Editorial section - label, heading, and body copy. Use this for destinations or main prose sections.
  - Image - image plus caption. Enable Portrait image width for narrower vertical images.
  - Pull quote - large italic quote with a left rule.
  - Aside / Worth watching - small labelled note section.
  - Closing CTA - closing label, heading, body, button label, and button URL.
  - Image credits - final small-print credit section.

Recommended block order to match the Winter Sun reference:

1. Fill Hero fields.
2. Fill Intro paragraphs.
3. Add Divider.
4. Add Editorial section.
5. Repeat Divider, Editorial section, and Image blocks as needed.
6. Add Pull quote after an image when the article needs emphasis.
7. Add Short divider before a planning or closing note when the design needs a lighter pause.
8. Add Aside / Worth watching.
9. Add Closing CTA.
10. Add Divider.
11. Add Image credits.

Managing Blog Editorial Articles:

- Create: add a post/page, select the template, fill the fields, preview, then publish.
- Read/preview: use Preview from the editor, or View after publishing.
- Update: edit the fields or block rows, click Update, then clear any site cache if the public page still shows old content.
- Reorder: drag Article Blocks into the desired order.
- Remove one section: delete that Article Block row and update the post/page.
- Hide the article: change status to Draft or Private.
- Delete the article: move it to Trash from the post/page list.
- Replace images: update the image field; do not delete Media Library files unless they are unused everywhere.

### Contact and Agreement

Templates:

- `page-templates/contact_us.php`
- `page-templates/agreement.php`

These are older-style templates with extra editable fields for contact details, enquiry options, agreement copy, and terms and conditions.

## Custom Post Types

Registered in `inc/posttype.php`.

- `team` - Team entries. Supports title, editor, and featured image.
- `travel` - Travel entries. Supports title, editor, and featured image. Publicly queryable is disabled; content is generally surfaced through templates rather than single public URLs.
- `events` - Event entries. Supports title, editor, and featured image.
- `our-work` - Our Work entries. Public single URL uses `post-type-templates/single-our-work.php`.
- `partnership` - Partnership entries. Supports title, editor, and featured image.
- `sedgemore_submission` - Private admin-only form submissions, registered in `inc/submissions.php`.

Taxonomy:

- `travel-type` - hierarchical taxonomy for `travel`, visible in admin but not public.

After adding or changing rewrite settings for custom post types, visit WP Admin -> Settings -> Permalinks and click Save Changes to flush rewrite rules.

## Editable Page Sections

Many pages on this site are not edited only through the main WordPress content box. Instead, they have extra editable fields arranged into tabs such as Hero, Intro, Services, Experiences, Stay, and Contact.

These fields are powered by a WordPress plugin called Advanced Custom Fields, often shortened to ACF. Content editors do not need to manage the plugin directly. In everyday use, ACF simply means "the extra page fields below the title/content area."

For content managers:

- If the extra fields do not appear, check that the correct page template is selected.
- After choosing or changing a page template, save the page as Draft or Update it, then refresh the editor.
- Tabs usually match the front-end page sections. For example, the Hero tab controls the top of the page.
- Short text fields are usually for labels, headings, buttons, and small notes.
- Larger text boxes are for paragraph copy.
- Image fields use the Media Library.
- Repeating rows are used for lists of items, such as cards, stats, itinerary days, gallery images, facts, and form options.
- Add one row for each item you want to show.
- Drag rows to reorder items.
- Delete a row to remove that specific item.
- Empty fields do not behave the same on every page. Some sections disappear when empty, while others use default text, the page title, the excerpt, the main content, or the featured image.
- If text or images are not available in the editor, they may be fixed inside the page template and need a developer to change them.

For developers:

- Keep field names stable once content exists.
- Use unique field keys when adding fields.
- Return images/files in a format the template expects, or use helper functions that support URL, ID, and array return types.
- Use `esc_html()` for plain text, `esc_url()` for URLs, and `wp_kses_post()` where editors are intentionally allowed to enter simple HTML.
- Many title fields allow `<br>`, `<em>`, and `<i>` for line breaks and emphasis.

## Header, Navigation, and Footer

Header rendering is handled by `header.php` and `template-parts/header_nav_inner.php`.

Header option fields used by the theme include:

- `header_logo`
- `dark_logo`
- `left_menu`
- `right_menu`

Footer rendering is handled by `footer.php`.

Footer option fields include:

- `footer_logo`
- `information`
- `footer_links`
- `social_media`
- `footer_sentence`

Manage these from WP Admin -> Theme Settings -> Header and WP Admin -> Theme Settings -> Footer.

## Forms and Submissions

AJAX form handlers live in `inc/ajax.php`.

Important handlers:

- `home_form` - homepage enquiry form. Stores private `Submissions` and sends email.
- `event_contact_form` - used by some event/work/membership-style forms.
- `contact_us_form` - older contact form.
- `newsletter_subscribe` - newsletter form.
- `data_fetch` - AJAX search.

Submission storage and admin tools live in `inc/submissions.php`.

Where content managers manage submissions:

- WP Admin -> Submissions
- WP Admin -> Submissions -> Export
- WP Admin -> Submissions -> Settings

See `wp-content/themes/sadgemore/README_SUBMISSIONS.md` for the submission workflow, CSV export, and follow-up email settings.

## Creating a New Page

For content managers:

1. Go to WP Admin -> Pages -> Add New.
2. Enter the page title.
3. Choose the correct Template in the page settings.
4. Save as Draft once so the extra editable fields load.
5. Fill the extra fields for that template.
6. Set a featured image if the template or listing uses one.
7. Preview on desktop and mobile before publishing.
8. Add the page to navigation if required through Theme Settings or WordPress menus, depending on how that link is managed.

For pages with extra editable fields:

- Fill fields tab by tab from top to bottom because the tabs usually follow the front-end page order.
- Add rows for each card, section item, image, stat, fact, or option.
- Keep image choices consistent within the same section. For example, a hero wants a wide image, while portrait side images usually work better in aside-style sections.
- Use the page title and slug for admin organization and URL structure; use section title fields when the front-end headline needs different wording.
- If a template has an enquiry/contact tab, update both the visible copy and any interest/option rows.

For developers:

1. Create a new file in `page-templates/`.
2. Add a template header:

```php
<?php
/**
 * Template Name: Example
 *
 * @package sadgemore
 */
```

3. Scope CSS under a wrapper class unique to that template.
4. Add an ACF local field group in `inc/acf-example-fields.php` if editors need extra page fields.
5. Require that file from `functions.php`.
6. Use fallbacks so the page does not break when fields are empty.
7. Escape all output.
8. Run PHP syntax checks before handing over.

## Editing Existing Content

For content managers:

- Pages: WP Admin -> Pages -> select the page -> edit the normal WordPress fields and any extra section fields.
- Our Work items: WP Admin -> Our Work -> select or add item -> edit the normal WordPress fields and any extra section fields.
- Travel/events/team/partnership entries: use their matching admin menu items.
- Header/footer content: WP Admin -> Theme Settings.
- Form submissions: WP Admin -> Submissions.
- Media: WP Admin -> Media.

Extra field editing workflow:

- Find the front-end section, then look for the matching tab in the editor.
- Update plain text fields for short labels, headings, and buttons.
- Update larger text boxes for paragraph copy.
- Update rows for cards, stats, itinerary days, experiences, facts, and form options.
- Drag rows to change the display order.
- Preview after changing images, long headings, or row counts because those changes affect layout on mobile.

Recommended image practice:

- Use compressed JPG/WebP for photos.
- Avoid uploading extremely large source images unless needed.
- Keep hero images wide enough for desktop.
- Add useful alt text where fields support it.

## Removing or Hiding Content

Preferred approach:

- To hide a page or post, switch it to Draft or Private.
- To remove an item from a listing, move it to Trash.
- To remove a navigation item, update Theme Settings or the relevant WordPress menu.
- To remove an editable section, clear its fields only if the template is built to hide empty sections.
- To remove one card/list/gallery item, delete that item from its row list and update the page.
- To remove an uploaded image from a page section, clear that page's image field. Do not delete the image from the Media Library unless it is unused everywhere.
- If clearing a field causes fallback/default content to appear, the template needs a developer change to hide that section completely.
- For Blog Story specifically, see the Blog Story removal notes above because several empty row lists intentionally fall back to default content.

Do not delete template files to hide content. Template deletion can break assigned pages.

## Developer Workflow

Common checks:

```sh
php -l wp-content/themes/sadgemore/page-templates/home.php
php -l wp-content/themes/sadgemore/functions.php
```

Use `rg` to find fields and templates:

```sh
rg "get_field\\('field_name'" wp-content/themes/sadgemore
rg "Template Name:" wp-content/themes/sadgemore/page-templates
```

When changing frontend templates:

- Check desktop, tablet, and mobile.
- Check logged-in and logged-out views, because the WordPress admin bar changes vertical spacing.
- Check forms for validation and successful AJAX responses.
- Watch the browser console for JavaScript errors.
- If a new custom post type or rewrite rule is added, flush permalinks.

## Troubleshooting

Extra editable fields are missing:

- Confirm the correct page template is selected in the page settings.
- Save/update the page and refresh the editor.
- If the fields still do not appear, ask a developer to confirm the Advanced Custom Fields plugin is active and the field setup is loaded.

Text does not change after editing:

- The text may be fixed in the template instead of editable in WordPress.
- Search the theme with `rg "copy text here" wp-content/themes/sadgemore`.

Images do not appear:

- Confirm the image is selected in the correct image field.
- Confirm the media item exists and is publicly accessible.
- If the image still does not appear, ask a developer to check for missing image URLs or template issues.

Forms fail:

- Check WP Admin -> Submissions to see whether the entry was stored.
- Check email settings in WP Admin -> Submissions -> Settings.
- If entries are not being stored, ask a developer to check the form script and form handler.

Header color/logo looks wrong:

- Check `header.php` for template-specific header logic.
- Check the template CSS for `.header_bright`, `.header_dark`, and `.header_nav_fixed` overrides.

Spacing or layout looks wrong on one page:

- Most newer pages have inline, template-scoped CSS. Start with the relevant `page-templates/*.php` file.
- Shared older styling may come from `assets/css/style.css`, `assets/css/responsive.css`, or `assets/css/sedgemore.css`.

## Known Notes

- Some newer templates include large inline CSS blocks. Keep changes scoped to that template wrapper.
- Some brand/logo strips are fixed in template files and are not editable from the WordPress page editor.
- The Home page currently includes the Trusted Brands strip copied from About.
- There are legacy backup templates in the repository. Avoid using them as current source unless explicitly requested.
- `functions.php` contains a helper intended to make old Home ACF fields available on `page-templates/home.php`; be careful when editing that area because it also contains conditional asset deregistration logic.
