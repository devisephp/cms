<template>
  <div class="dvs-flex">
    <div id="sidebar" class="dvs-absolute dvs-pin-l dvs-pin-t dvs-pin-b dvs-bg-grey-lighter">Sidebar</div>

    <div id="content" class="dvs-absolute dvs-pin dvs-overflow-scroll">
      <section>
        <div>
          <h1 class="dvs-mb-8 dvs-font-light">Welcome to Devise</h1>

          <p
            class="dvs-text-xl dvs-mb-16"
          >We are very excited that you are giving Devise 2 a spin. We are still in the early beta stages of this product so things may change but until then we encourage you to check out the project, submit any PR's or suggestions on Github.</p>

          <div class="dvs-text-left dvs-w-full">
            <h2 class="dvs-mb-4">Installation</h2>

            <p
              class="dvs-mb-4"
            >Below we have setup an interactive installer that will continually poll to see if you have correctly configured your server and application for Devise. Once you have turned all the items in "Required Setup" green you are good to go. However, we have also provided some helpful items in "Non-required Setup" that you may want to take a look at.</p>
          </div>
        </div>
        <div></div>
      </section>

      <template v-if="checklist">
        <!-- Database -->
        <devise-installer-item :item="checklist.database" title="Database Connection (required)">
          <template slot="instructions">
            <p>
              Your application will need to connect to a database. You can do this by editing your
              <span
                class="dvs-font-monospace"
              >.env</span> file in the root of your project and ensuring the following values are set:
            </p>
          </template>

          <template slot="example">In your .env file
            <pre class="lang-ini line-numbers" data-start="1">
                <code>
                  DB_CONNECTION=mysql
                  <br>DB_HOST=127.0.0.1
                  <br>DB_PORT=3306
                  <br>DB_DATABASE=database_name
                  <br>DB_USERNAME=root
                  <br>DB_PASSWORD=
                  <br>
                </code>
              </pre>
          </template>
        </devise-installer-item>

        <!-- Migrations -->
        <devise-installer-item :item="checklist.migrations" title="Database Migrations (required)">
          <template slot="instructions">
            <p>Now to populate the database you'll run the Laravel artisan migration command. This command will build out the tables needed for Devise to run properly.</p>
            <p>
              More information on migrations can be found
              <a
                href="https://laravel.com/docs/5.7/migrations"
              >here</a>
            </p>
          </template>

          <template slot="example">
            <p>From the root of your project on the command line run the following command</p>
            <pre class="lang-bash" data-start="1">
                <code>
                  php artisan migrate
                </code>
              </pre>
          </template>
        </devise-installer-item>

        <!-- Authentication -->
        <devise-installer-item :item="checklist.auth" title="Authentication (required)">
          <template slot="instructions">
            <p>Devise is not opinionated about the authentication system that you use. But to get started fast you can use the one that ships with Laravel which is great for systems with simple permissions.</p>
            <p>
              More information on laravels authentication you can read the documentation
              <a
                href="https://laravel.com/docs/5.7/authentication"
              >here</a>
            </p>
          </template>

          <template slot="example">
            <p>From the root of your project on the command line run the following command</p>
            <pre class="lang-bash" data-start="1">
                <code>
                  php artisan make:auth
                </code>
              </pre>
          </template>
        </devise-installer-item>

        <!-- User -->
        <devise-installer-item :item="checklist.auth" title="First Administration User (required)">
          <template slot="instructions">
            <p>For the first user to login you will need to create a user. You can either enter one directly into the database manually or add one using the form to the right.</p>
          </template>

          <template slot="example">
            <h3 class="dvs-mb-4">Create Your first User</h3>
            <form>
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Name</label>
                <input type="text" v-model="newUser.name">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Email</label>
                <input type="email" v-model="newUser.email">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6">
                <label>Password</label>
                <input type="text" v-model="newUser.password">
              </fieldset>
              <button class="dvs-btn dvs-bg-green dvs-text-white">Create User</button>
            </form>
          </template>
        </devise-installer-item>

        <!-- Site -->
        <devise-installer-item :item="checklist.site" title="First Site and Language (required)">
          <template slot="instructions">
            <p>Devise works as a multi-tenant system out of the box meaning that you can run multiple sites under the same code base. Even if you are running only one domain Devise needs to know about it. Use the form to the right to set this up.</p>
            <p>
              Each site also needs a language. You can assign any number of languages once you have completed installation. The language should be the
              <a
                href="https://www.loc.gov/standards/iso639-2/php/code_list.php"
              >ISO Code</a> of that language
            </p>

            <help>
              <p>The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.</p>
            </help>
          </template>

          <template slot="example">
            <h3 class="dvs-mb-4">Create Your first Site</h3>
            <form>
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Site Name</label>
                <input type="text" v-model="newSite.name">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Site Domain</label>
                <input type="text" v-model="newSite.domain">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6">
                <label>Language</label>
                <input type="text" v-model="newSite.language">
              </fieldset>
              <button class="dvs-btn dvs-bg-green dvs-text-white">Create Site</button>
            </form>
          </template>
        </devise-installer-item>

        <!-- Create your first page -->
        <devise-installer-item :item="checklist.site" title="First Page (required)">
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
              <strong>What a Layout Is:</strong> A layout blade file is a file that is intended to be used across many pages. This way you don't have to set the &lt;head&gt;, Javascript includes, style inclues, etc on every single page. Each page that is assigned that layout extends it placing it's content where you see fit. We have provided a boilerplate for you to the right. Copy the contents and save them to "/resources/views/layouts/master.blade.php"
            </p>

            <p>
              <strong>Language:</strong>: The language should be pretty obvious: What language is this page in? But what is exciting is that if you have multiple languages you'll be able to quickly deploy localized content based on whatever language the user has selected. More on that in the official documention. For now: select your first language you created above in the sites section.
            </p>

            <p>
              <strong>Slug:</strong> Finally, the slug is just the url the page lives on. The homepage slug would be "/" while an about page might live at "/about" or "/about-us". The important thing is that it is lower case, has no spaces and is prefixed with a slash.
            </p>
          </template>

          <template slot="example">
            <h3 class="dvs-mb-4">Create Your first Page</h3>
            <form class="dvs-mb-8">
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Page Name</label>
                <input type="text" v-model="newPage.name">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Layout</label>
                <input type="text" v-model="newPage.layout">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6">
                <label>Language</label>
                <input type="text" v-model="newPage.language">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6">
                <label>Slug</label>
                <input type="text" v-model="newPage.slug">
              </fieldset>
              <button class="dvs-btn dvs-bg-green dvs-text-white">Create Page</button>
            </form>

            <h3 class="dvs-mb-4">A solid boilerplate for your first layout file</h3>
            <p>
              Save the following to
              <span
                class="dvs-font-mono"
              >/resource/views/layouts/master.blade.php</span>
            </p>
            <pre class="lang-html line-numbers">
              <code v-html="layoutTemplate"></code>
            </pre>
          </template>
        </devise-installer-item>

        <!-- Assets -->
        <devise-installer-item :item="checklist.auth" title="Assets (required)">
          <template slot="instructions">
            <p>Devise has some styles and assets that it will need to reach. You can quickly publish these assets by running the command to the right.</p>
          </template>

          <template slot="example">
            <p>From the root of your project on the command line run the following command</p>
            <pre class="lang-bash" data-start="1">
                <code>
                  php artisan vendor:publish --tag=dvs-assets
                </code>
              </pre>
          </template>
        </devise-installer-item>
      </template>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

export default {
  data() {
    return {
      newUser: {
        name: '',
        email: '',
        password: '',
        confirm_password: ''
      },
      newSite: {
        name: '',
        domain: '',
        language: 'en'
      },
      newPage: {
        name: '',
        layout: '',
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
  mounted() {
    this.startChecker();
  },
  methods: {
    ...mapActions(['refreshChecklist']),
    startChecker() {
      setInterval(() => {
        this.refreshChecklist();
      }, 5000);
    }
  },
  computed: {
    ...mapState({
      checklist: state => state.checklist
    })
  }
};
</script>

<style lang="scss">
body {
  background-color: aquamarine;
}

#sidebar {
  width: 200px;
}

#content {
  left: 200px;
}

section {
  display: flex;

  > div {
    &:first-child {
      width: 50%;
      color: rgb(72, 82, 91);
      background-color: #f8fafc;
      padding: 3em;
    }

    &:last-child {
      width: 50%;
      background-color: #22292f;
      color: #f8fafc;
      padding: 3em;
      font-size: 0.8em;
    }
  }
}
</style>