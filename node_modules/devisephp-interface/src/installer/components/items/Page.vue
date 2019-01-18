<template>
  <devise-installer-item :item="item" id="nav-page" title="First Page (required)">
    <template slot="instructions">
      <p>It's time to create your first page. We'd suggest maybe making your homepage. There's a lot to cover here but don't be intimidated. We will walk you through each step.</p>
      <p>
        A Devise page is built on two parts: A layout file which follows
        <a
          href="https://laravel.com/docs/5.7/blade"
          target="_blank"
        >Laravel's Blade System</a> and slices.
      </p>
      <p>
        <strong>What a Layout Is:</strong> A layout blade file is a file that is intended to be used across many pages. This way you don't have to set the &lt;head&gt;, Javascript includes, style inclues, etc on every single page. Each page that is assigned that layout extends it placing it's content where you see fit. We have provided a boilerplate for you to the right. Copy the contents and save them to "/resources/views/main.blade.php".
      </p>

      <p>
        <strong>Language:</strong>: The language should be pretty obvious: What language is this page in? But what is exciting is that if you have multiple languages you'll be able to quickly deploy localized content based on whatever language the user has selected. More on that in the official documention. For now: select your first language you created above in the sites section.
      </p>

      <p>
        <strong>Slug:</strong> Finally, the slug is just the url the page lives on. The homepage slug would be "/" while an about page might live at "/about" or "/about-us". The important thing is that it is lower case, has no spaces and is prefixed with a slash.
      </p>
    </template>

    <template slot="example">
      <h3 class="dvs-mb-4">Create Your first Page
        <template v-if="item">(Already Created)</template>
      </h3>
      <form class="dvs-mb-8" :class="{'dvs-opacity-50': item}">
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Page Title</label>
          <input type="text" v-model="newPage.title" :disabled="item">
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-8">
          <label>Layout</label>
          <select v-model="newPage.layout">
            <option :value="layout" v-for="layout in layouts" :key="layout">{{ layout }}</option>
          </select>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-6" v-if="languages.length">
          <label>Language</label>
          <select v-model="newPage.language_id" :disabled="item">
            <option
              v-for="language in languages"
              :key="language.id"
              :value="language.id"
            >{{ language.code }}</option>
          </select>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-6">
          <label>Slug</label>
          <input type="text" v-model="newPage.slug" :disabled="item">
        </fieldset>
        <button
          type="submit"
          class="dvs-btn dvs-bg-green dvs-text-white"
          @click.prevent="attemptCreatePage()"
          :disabled="item"
        >Create Page</button>
      </form>

      <h3 class="dvs-mb-4">A solid boilerplate for your first layout file</h3>
      <p>
        Save the following to
        <span class="dvs-font-mono">/resource/views/main.blade.php</span>
      </p>
      <pre class="lang-html line-numbers">
              <code v-html="layoutTemplate"></code>
            </pre>
    </template>
  </devise-installer-item>
</template>

<script>
import { mapActions, mapState } from 'vuex';

import Item from './../Item';

export default {
  data() {
    return {
      newPage: {
        site_id: 1,
        language_id: 1,
        title: 'Homepage',
        layout: 'main',
        language: null,
        slug: '/'
      },
      layoutTemplate: `
            &lt;!doctype html&gt;
            &lt;html lang="&#123;&#123; app()-&gt;getLocale() &#125;&#125;"&gt;
              &lt;head&gt;
                &#64;isset($page)
                &#123;!! Devise::head($page) !!&#125;
                &#64;else
                &#123;!! Devise::head() !!&#125;
                &#64;endif

                &lt;meta charset="utf-8"&gt;
                &lt;meta http-equiv="X-UA-Compatible" content="IE=edge"&gt;
                &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
                &lt;meta name="csrf-token" content="&#123;&#123; csrf_token() &#125;&#125;"&gt;

                &lt;style&gt;
                  &#123;&#123; require public_path('css/essentials.css') &#125;&#125;
                &lt;/style&gt;

                &lt;title&gt;Your Project&lt;/title&gt;
              &lt;/head&gt;

              &lt;body&gt;
                &lt;div id="app"&gt;
                    &lt;div&gt;
                      &lt;div id="devise-blocker"&gt;&lt;/div&gt;
                      &lt;devise&gt;&lt;/devise&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                
                &lt;script src="&#123;&#123;mix('/js/manifest.js')&#125;&#125;"&gt;&lt;/script&gt;
                &lt;script src="&#123;&#123;mix('/js/devise-administration-vendor.js')&#125;&#125;"&gt;&lt;/script&gt;
                &lt;script src="&#123;&#123;mix('/js/app.js')&#125;&#125;"&gt;&lt;/script&gt;

                &lt;noscript id="deferred-styles"&gt;
                  &lt;link rel="stylesheet" type="text/css" href="&#123;&#123; mix('css/app.css') &#125;&#125;"/&gt;
                &lt;/noscript&gt;

                &lt;script&gt;
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
                &lt;/script&gt;
              &lt;/body&gt;
            &lt;/html&gt;
            `
    };
  },
  methods: {
    ...mapActions(['createPage']),
    attemptCreatePage() {
      this.createPage(this.newPage);
    }
  },
  computed: {
    ...mapState({
      languages: state => state.languages.data
    }),
    layouts() {
      return window.deviseSettings.$config.layouts;
    }
  },
  components: {
    Item
  },
  props: {
    item: {
      required: true
    }
  }
};
</script>
