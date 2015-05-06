# Create Page

Create a new page for your website.

### Title of the Page

The title of the page is used for SEO purposes and allows you to set a custom title on this specific page.

### Short description of the page

The description is to share information about this page to other admins and remind yourself the purpose of this page.

### Language

Every page must belong to a <a href="<?= url('/admin/languages') ?>">language</a>. Out of the box the default language is English.

### View Template to Use

This is the html template for this page. <a href="<?= url('/admin/templates') ?>">Templates</a> are built by the design/development team in advance with content placeholders. When editing this page later, you will be able to place custom content in those content placeholders.

### Route Name

This is a unique name that should not be changed. It may be used by developers to reference and link to this page througout the application.

### Page Slug

This is the url to this page. You may access the page by navigating to <?= url('@livespan([name="slug"])') ?>

### Publish on save

Should we go ahead and publish this new page live to the site? If this is off, this page will not be available to users until you have publish a page version of this page.

### Meta Title

The meta title is placed inside of the page's meta tags. This is primarily for search engine optimization (SEO). It should describe in a short few words the purpose of this page.

### Meta Description

The meta description is a longer, more verbose description of the purpose of this page for search engine optimization.

### Meta Keywords

The meta keywords are a comma separated list of words that you would want a search engine to identify with this site.

### Head Code

Place any javascript or styles you might want custom to this page. This might be a good place for analytics or any custom one-off styles.

### Footer Code

Place any javascript, styles or html you might want custom to this page. It will appear at the bottom of the page. Perhaps you want a legal description block or analytics code?

### Administration Page?

Is this page for administration purposes only? Should it be visibile on the public site or only in the admin section?

### Before

Calls a Laravel filter before running this api endpoint. This is a good place for permission checks. These filters are strings. You can supply multiple filters with a comma. You can even use [Devise permissions](/admin/permissions).

```
auth,isAdministrator
```