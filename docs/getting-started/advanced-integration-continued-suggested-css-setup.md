---
description: >-
  Now that you have your site compiling let's talk about how we might suggest
  setting up your CSS in this environment. Below we're going to show how to
  setup SASS but adapt to any precompiler.
---

# Advanced Integration Continued: Suggested CSS Setup

{% hint style="info" %}
This is only a suggested setup. There are a LOT of ways to setup your CSS. If you want to explore more take a look at the Vue CLI project or you can even just use good 'ol Laravel Mix to compile your styles and have two things running on your command line while working. Whatever makes you comfy is what matters. Things this structure did for us is:

* Allowed us to load essential CSS and defer the bulk of the css as non-blocking which pleases the browser gods
* Create multiple CSS files for different sites when using multi-tenancy in Devise and the sites differed in style.
* Have a single compiler instead of running Vue CLI and Laravel Mix.
* Handles hot reloading
* Injects the essentials into the &lt;head&gt; so there is no blocking CSS

If that sounds interesting to you give the following a go or steal pieces of it to streamline your project.
{% endhint %}

### Create a SASS folder in src

In `src` create a `sass` folder.

### Create essentials.scss and global.scss

So, we're actually going to generate three css files. One is going to be loaded in the &lt;head&gt; of your HTML and the other two are going to be deferred and loaded at the bottom of the page. Why? Well, essentials is going to contain styles for everything \(love this term 😑 \) "above the fold" while the meat of the CSS is going to be loaded at the bottom of the page to load everything up all snappy.

So, create `src/sass/essentials.scss` and `src/sass/global.scss` and maybe drop a test style into each. 

### Create styles folder and add two files inside it

Create two files inside the root of your CLI project \(ex: `project-name/project-app/`\) and name them the same as your main SCSS files. In this example we're going to create `essentials.js` and `global.js`

Place the following inside each of the files and change the contents appropriately.

{% code-tabs %}
{% code-tabs-item title="/project-app/styles/essentials.js" %}
```css
import '../sass/essentials.scss';

```
{% endcode-tabs-item %}
{% endcode-tabs %}

### Create buildpages.js

To split out our styles we're going to need to do a little hacky bit here with Vue CLI. If anyone has any suggestions on a better way to do this we are all ears. In the root of the CLI project \( ex:`project-name/project-app/)` create buildpages.js and add the following to it:

{% code-tabs %}
{% code-tabs-item title="/project-app/buildpages.js" %}
```javascript
module.exports = {
  app: {
    // Styles coming from style tags in your components 
    // if you wish to do that
    entry: 'src/main.js',
    template: 'public/index.html',
    filename: 'index.html',
    title: 'App',
  },
  global: {
    // Styles generated from global.scss THROUGH globals.js
    entry: 'src/styles/global.js',
    template: 'public/index.html',
    filename: 'index.html',
    title: 'App',
  },
  essentials: {
    // Styles generated from essentials.scss THROUGH essentials.js
    entry: 'src/styles/essentials.js',
    template: 'public/index.html',
    filename: 'index.html',
    title: 'Essential',
  },
};

```
{% endcode-tabs-item %}
{% endcode-tabs %}

### Update your vue.config.js

Add the following into your `vue.config.js` at the top

```javascript
const PagesObject = require('./buildpages.js');
```

Then add this somewhere in the main module exports object:

{% code-tabs %}
{% code-tabs-item title="project-app/vue.config.js" %}
```javascript
module.exports = {


...

  indexPath: undefined,
  pages: PagesObject,
  chainWebpack: (config) => {
    config.plugins.delete('prefetch');
    // TODO: Remove this workaround once https://github.com/vuejs/vue-cli/issues/2463 is fixed
    // Remove preload plugins for multi-page build to prevent infinite recursion
    Object.keys(PagesObject).forEach((page) => {
      config.plugins.delete(`preload-${page}`);
      config.plugins.delete(`prefetch-${page}`);
    });
  },
  
  ...
  
}

```
{% endcode-tabs-item %}
{% endcode-tabs %}

### Finally, update your main layout

Add the following to the head

{% code-tabs %}
{% code-tabs-item title="resources/views/layouts/main.blade.php" %}
```php
@if(App::environment() == 'production' || App::environment() == 'staging' )
  <style><?php echo File::get( public_path( vuemix('/css/chunk-vendors.css', '/app') ) ) ?></style>
  <style><?php echo File::get( public_path( vuemix('/css/essentials.css', '/app') ) ) ?></style>
@else
  <link rel="stylesheet" href="{{vuemix('/css/chunk-vendors.css', '/app')}}">
  <link rel="stylesheet" href="{{vuemix('/css/essentials.css', '/app')}}">
@endif
```
{% endcode-tabs-item %}
{% endcode-tabs %}

Add the following to just before `</body>` 

```markup
    <noscript id="deferred-styles">
      <link rel="stylesheet" href="{{vuemix('/css/global.css', '/app')}}">
    </noscript>

    <script>
      var loadDeferredStyles = function() {
        var addStylesNode = document.getElementById("deferred-styles");
        var replacement = document.createElement("div");
        replacement.innerHTML = addStylesNode.textContent;
        document.body.appendChild(replacement)
        addStylesNode.parentElement.removeChild(addStylesNode);
      };
      var raf = requestAnimationFrame || mozRequestAnimationFrame ||
          webkitRequestAnimationFrame || msRequestAnimationFrame;
      if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
      else window.addEventListener('load', loadDeferredStyles);
    </script>
```

### Congrats! You should be setup!

You should be setup and ready for destruction! Try building and see if the three files are created. If not do let us know in the issues and we can update this documentation.

## Using Tailwind

Devise uses [TailwindCSS](https://tailwindcss.com) under the hood for its own CSS. If you haven't used it before we couldn't recommend it enough. We have prefixed Devise styles with `dvs` to prevent conflicts. Since no Devise styles are loaded unless you are logged in you shouldn't really rely on those. To get your own tailwind up and running add the following to your SCSS files listed above:

```css
@tailwind preflight;

@tailwind components;

// Examples
@import "essentials/globals";
@import "essentials/navigation";
// End examples

@tailwind utilities;

```

### Remove PostCSS config from package.json

If your package.json file includes the following be sure to remove it.

```text
  "postcss": {
    "plugins": {
      "autoprefixer": {}
    }
  },
```

### Create a postcss.config.js in your Vue CLI app

In your Vue CLI app add or edit `postcss.config.js` to contain:

```javascript
const tailwind = require('tailwindcss');
const autoprefixer = require('autoprefixer');

module.exports = {
  plugins: [tailwind('./tailwind.js'), autoprefixer()],
};
```

### Build and test

Try building your app from the Vue CLI UI. You should see your CSS in   
`` Now you an use Tailwind like so on your slices and components:

```markup
<div class="p-8 bg-pink font-bold font-sans text-xl">
    Look! Extra large bolded sans font with padding and a pink background
</div>
```

## Purging the fat

When using something like tailwind you may want to cut any styles that are not being used. Add `@fullhuman/postcss-purgecss` to your dev-dependencies and edit `postcss.config.js` in the root of your Vue CLI project and add the following contents:

{% code-tabs %}
{% code-tabs-item title="/project-app/postcss.config.js" %}
```javascript
const purgecss = require("@fullhuman/postcss-purgecss");
const glob = require('glob-all');
const path = require('path');

module.exports = {
  plugins: [
    require('tailwindcss')('./tailwind.js'),
    require('autoprefixer')(),
    process.env.NODE_ENV === "production" ? purgecss({
      content: [
        "./src/**/*.vue",
        "./../resources/**/*.blade.php"
      ],
      extractors: [
        {
          extractor: class {
            static extract (content) {
              return content.match(/[a-zA-Z0-9-:_/]+/g) || [];
            }
          },
          extensions: ['vue', 'html', 'php'],
        },
      ],
      
      // Example of when you have a package dependency that may have styles
      // that you don't want to cut out. Purge will scan these files and prevent
      // them from being purged.
      paths: glob.sync([
        path.join(__dirname, "node_modules/tiny-slider/**/*.js"),
        path.join(__dirname, "node_modules/tiny-slider/**/*.css"),
      ]),
      
      // Leave mobile, tablet, desktop, largeDesktop, and ultraWideDesktop as 
      // Those are Devise breakpoints. In this example "/tns-*/" is just an 
      // example for tinyslider and can be removed
      whitelistPatterns: [
        /mobile/,
        /tablet/,
        /desktop/,
        /largeDesktop/,
        /ultraWideDesktop/,
        /tns-*/,
      ]
    }) : ""
  ],
};

```
{% endcode-tabs-item %}
{% endcode-tabs %}

