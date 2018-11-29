<template>
  <div class="dvs-flex">
    <div
      id="sidebar"
      class="dvs-absolute dvs-pin-l dvs-pin-t dvs-pin-b dvs-bg-grey-lighter dvs-p-4"
    >
      <scrollactive
        :offset="80"
        :duration="800"
        bezier-easing-value=".5,0,.35,1"
        scroll-container-selector="#content"
        id="menu"
      >
        <ul class="dvs-list-reset">
          <li>
            <a href="#nav-welcome" class="scrollactive-item">Welcome</a>
          </li>
          <li>
            <a href="#nav-required" class="scrollactive-item">Required</a>
            <ul class="dvs-list-reset dvs-ml-4">
              <li class="dvs-flex">
                <item-check :item="checklist.database" :size="15" class="dvs-mr-2"></item-check>
                <a href="#nav-database-connection" class="scrollactive-item">Database Connection</a>
              </li>
              <li class="dvs-flex">
                <item-check :item="checklist.migrations" :size="15" class="dvs-mr-2"></item-check>
                <a href="#nav-database-migration" class="scrollactive-item">Database Migration</a>
              </li>
              <li class="dvs-flex">
                <item-check :item="checklist.auth" :size="15" class="dvs-mr-2"></item-check>
                <a href="#nav-auth" class="scrollactive-item">Authentication</a>
              </li>
              <li class="dvs-flex">
                <item-check :item="checklist.user" :size="15" class="dvs-mr-2"></item-check>
                <a href="#nav-user" class="scrollactive-item">First User</a>
              </li>
              <li class="dvs-flex">
                <item-check :item="checklist.site" :size="15" class="dvs-mr-2"></item-check>
                <a href="#nav-site" class="scrollactive-item">First Site</a>
              </li>
              <li class="dvs-flex">
                <item-check :item="checklist.page" :size="15" class="dvs-mr-2"></item-check>
                <a href="#nav-page" class="scrollactive-item">First Page</a>
              </li>
              <li class="dvs-flex">
                <item-check :item="checklist.image_library" :size="15" class="dvs-mr-2"></item-check>
                <a href="#nav-image-library" class="scrollactive-item">Image Library</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#nav-required" class="scrollactive-item">Suggested</a>
            <ul class="dvs-list-reset dvs-ml-4">
              <li>
                <a href="#nav-database-connection" class="scrollactive-item">Image Optimization</a>
                <ul>
                  <li class="dvs-flex">
                    <item-check
                      :item="checklist.image_optimization.gifsicle"
                      :size="15"
                      class="dvs-mr-2"
                    ></item-check>
                    <a href="#nav-image-optimization" class="scrollactive-item">Gifsicle</a>
                  </li>
                  <li class="dvs-flex">
                    <item-check
                      :item="checklist.image_optimization.jpegoptim"
                      :size="15"
                      class="dvs-mr-2"
                    ></item-check>
                    <a href="#nav-image-optimization" class="scrollactive-item">Jpegoptim</a>
                  </li>
                  <li class="dvs-flex">
                    <item-check
                      :item="checklist.image_optimization.optipng"
                      :size="15"
                      class="dvs-mr-2"
                    ></item-check>
                    <a href="#nav-image-optimization" class="scrollactive-item">Optipng</a>
                  </li>
                  <li class="dvs-flex">
                    <item-check
                      :item="checklist.image_optimization.pngquant"
                      :size="15"
                      class="dvs-mr-2"
                    ></item-check>
                    <a href="#nav-image-optimization" class="scrollactive-item">Pngquant</a>
                  </li>
                  <li class="dvs-flex">
                    <item-check
                      :item="checklist.image_optimization.svgo"
                      :size="15"
                      class="dvs-mr-2"
                    ></item-check>
                    <a href="#nav-image-optimization" class="scrollactive-item">Svgo</a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dvs-flex">
            <a href="#nav-remove-laravel-route" class="scrollactive-item">Remove Laravel Routes</a>
          </li>
        </ul>
      </scrollactive>
    </div>

    <div id="content" class="dvs-absolute dvs-pin dvs-overflow-scroll">
      <section id="nav-welcome" name="nav-welcome">
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

      <section id="nav-required"></section>

      <template v-if="checklist">
        <!-- Database -->
        <devise-installer-item
          :item="checklist.database"
          id="nav-database-connection"
          title="Database Connection (required)"
        >
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
        <devise-installer-item
          :item="checklist.migrations"
          id="nav-database-migration"
          title="Database Migrations (required)"
        >
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
        <devise-installer-item
          :item="checklist.auth"
          id="nav-auth"
          title="Authentication (required)"
        >
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
        <devise-installer-item
          :item="checklist.user"
          id="nav-user"
          title="First Administration User (required)"
        >
          <template slot="instructions">
            <p>For the first user to login you will need to create a user. You can either enter one directly into the database manually or add one using the form to the right.</p>
          </template>

          <template slot="example">
            <h3 class="dvs-mb-4">Create Your first User
              <template v-if="checklist.user">(Already Created)</template>
            </h3>
            <form :class="{'dvs-opacity-50': checklist.user}">
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Name</label>
                <input type="text" v-model="newUser.name" :disabled="checklist.user">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Email</label>
                <input type="email" v-model="newUser.email" :disabled="checklist.user">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6">
                <label>Password</label>
                <input type="text" v-model="newUser.password" :disabled="checklist.user">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6">
                <label>Confirm Password</label>
                <input
                  type="text"
                  v-model="newUser.password_confirmation"
                  :disabled="checklist.user"
                >
              </fieldset>
              <button
                class="dvs-btn dvs-bg-green dvs-text-white"
                :disabled="checklist.user"
                @click.prevent="attemptCreateUser()"
              >Create User</button>
            </form>
          </template>
        </devise-installer-item>

        <!-- Site -->
        <devise-installer-item
          :item="checklist.site"
          id="nav-site"
          title="First Site and Language (required)"
        >
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
              <p>
                <strong>Important:</strong> The domain should be the
                <em>final</em> domain name. If you're working on this site locally you will need to add an override in your .env file like the example to the right.
              </p>
            </help>
          </template>

          <template slot="example">
            <h3 class="dvs-mb-4">Create Your first Site
              <template v-if="checklist.user">(Already Created)</template>
            </h3>
            <form class="dvs-mb-8" :class="{'dvs-opacity-50': checklist.site}">
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Site Name</label>
                <input type="text" v-model="newSite.name" :disabled="checklist.site">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Site's Actual Domain (See below)</label>
                <input type="text" v-model="newSite.domain" :disabled="checklist.site">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6" v-if="languages.count">
                <label>Default Language</label>
                <select v-model="newSite.selectedLanguage" :disabled="checklist.site">
                  <option :value="null">Select a Language</option>
                  <option
                    v-for="language in languages"
                    :key="language.id"
                    :value="language.id"
                  >{{ language.code }}</option>
                </select>
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6" v-else>
                <label>Default Language</label>
                <input type="text" v-model="newSite.code" :disabled="checklist.site">
              </fieldset>
              <button
                type="submit"
                class="dvs-btn dvs-bg-green dvs-text-white"
                @click.prevent="attemptCreateSite()"
                :disabled="checklist.site"
              >Create Site</button>
            </form>

            <h3 class="dvs-mb-4">A note on the domain during development</h3>
            <p>If you're working locally using something like Larvel's Valet or Homestead make sure you provide the acutal domain name above and add a development override in your local .env file. Since this is the first site it needs to have a "1" (which will be the ID of the site)</p>
            <pre class="lang-bash" data-start="1">
              <code>
                SITE_1_DOMAIN=project-name.test 
              </code>
            </pre>
          </template>
        </devise-installer-item>

        <!-- Create your first page -->
        <devise-installer-item :item="checklist.page" id="nav-page" title="First Page (required)">
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
              <strong>What a Layout Is:</strong> A layout blade file is a file that is intended to be used across many pages. This way you don't have to set the &lt;head&gt;, Javascript includes, style inclues, etc on every single page. Each page that is assigned that layout extends it placing it's content where you see fit. We have provided a boilerplate for you to the right. Copy the contents and save them to "/resources/views/layouts/master.blade.php". Then in the layout field enter dot-notation of that directory: "layouts.master".
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
                <label>Page Title</label>
                <input type="text" v-model="newPage.title">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-4">
                <label>Layout</label>
                <input type="text" v-model="newPage.layout">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6" v-if="languages.count">
                <label>Language</label>
                <select v-model="newPage.language_id" :disabled="checklist.page">
                  <option
                    v-for="language in languages"
                    :key="language.id"
                    :value="language.id"
                  >{{ language.code }}</option>
                </select>
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mb-6">
                <label>Slug</label>
                <input type="text" v-model="newPage.slug">
              </fieldset>
              <button
                type="submit"
                class="dvs-btn dvs-bg-green dvs-text-white"
                @click.prevent="attemptCreatePage()"
              >Create Page</button>
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

        <!-- ImageMagick -->
        <devise-installer-item
          :item="checklist.image_library"
          id="nav-image-library"
          title="Image Library"
        >
          <template slot="instructions">
            <p>Devise allows users to select images from a media manager and manipulate them. To do this Devise needs ImageMagick (preferred) or GD installed. You don't need both - just one or the other. Getting either library installed can be a little tricky depending on the version of PHP you're running and environment but we have provided a few tips to the right.</p>
          </template>

          <template slot="example">
            <h3 class="dvs-mb-4">
              Mac OS (using
              <a href="https://brew.sh/" target="_blank">Homebrew</a>)
            </h3>
            <p>On the command line run the following command</p>
            <pre class="lang-bash" data-start="1">
                <code>
                  brew install imagemagick
                </code>
              </pre>
            <p>Or</p>
            <pre class="lang-bash" data-start="1">
                <code>
                  brew install gd
                </code>
              </pre>

            <h3 class="dvs-mb-4">Windows</h3>
            <p>This is very much dependent on what you are using for development but any help you can provide others is greatly appreciated. Please submit any ideas for this section through a pull request.</p>
          </template>
        </devise-installer-item>

        <!-- Image Optimization -->
        <devise-installer-item
          :item="checklist.image_optimization.jpegoptim || checklist.image_optimization.optipng || checklist.image_optimization.pngquant || checklist.image_optimization.svgo || checklist.image_optimization.gifsicle"
          id="nav-image-optimization"
          title="Image Optimization"
        >
          <template slot="instructions">
            <p>When images are uploaded to the media manager nothing happens. We store the highest resolution image we can. However, when a user select's an image when populating content Devise will attempt to optimize the image by running a series of optimizations depending on file type. These are not required but you can greatly increase the performance for end-users by having these installed.</p>
          </template>

          <template slot="example">
            <h3 class="dvs-mb-4">
              Mac OS (using
              <a href="https://brew.sh/" target="_blank">Homebrew</a>)
            </h3>
            <p>On the command line run the following command</p>
            <pre class="lang-bash" data-start="1">
                <code>
                  brew install jpegoptim
                  brew install optipng
                  brew install pngquant
                  brew install svgo
                  brew install gifsicle
                </code>
              </pre>

            <h3 class="dvs-mb-4">Ubuntu</h3>
            <p>On the command line run the following command</p>
            <pre class="lang-bash" data-start="1">
                <code>
                  sudo apt-get install jpegoptim
                  sudo apt-get install optipng
                  sudo apt-get install pngquant
                  sudo npm install -g svgo
                  sudo apt-get install gifsicle
                </code>
              </pre>
          </template>
        </devise-installer-item>

        <!-- Laravel Routes -->
        <devise-installer-item
          id="nav-remove-laravel-route"
          title="Remove Laravel Routes (Optional)"
        >
          <template slot="instructions">
            <p>Laravel ships with a default route for the homepage and if you ran the "make:auth" command above added some more. You most likely want to remove these.</p>
            <help>
              <strong>Important:</strong> Do NOT remove the Auth::routes(); line from web.php
            </help>
          </template>

          <template slot="example">
            <h3 class="dvs-mb-4">Where the routes are located:</h3>
            <p>In '/routes/web.php' remove the following:</p>
            <pre class="lang-bash" data-start="1">
                <code>
                  Route::get('/', function () {
                      return view('welcome');
                  });
                </code>
              </pre>
            <pre class="lang-bash" data-start="1">
                <code>
                  Route::get('/home', 'HomeController@index')->name('home');
                </code>
              </pre>
          </template>
        </devise-installer-item>
      </template>
    </div>

    <messages/>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

import Messages from './Messages';

export default {
  data() {
    return {
      newUser: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      newSite: {
        name: '',
        domain: '',
        code: 'en',
        selectedLanguage: null,
        languages: [],
        settings: {}
      },
      newPage: {
        site_id: 1,
        language_id: 1,
        title: 'Homepage',
        layout: 'layouts.master',
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
    this.getLanguages();
    this.startChecker();
  },
  methods: {
    ...mapActions([
      'refreshChecklist',
      'createUser',
      'createSite',
      'createPage',
      'createLanguage',
      'getLanguages'
    ]),
    startChecker() {
      this.refreshChecklist();
      setInterval(() => {
        this.refreshChecklist();
      }, 5000);
    },
    attemptCreateUser() {
      this.createUser(this.newUser);
    },
    attemptCreateSite() {
      // If a language hasn't been created yet
      if (!this.languages.count) {
        this.createLanguage(this.newSite).then(response => {
          this.newSite.languages = [];
          this.newSite.languages.push({ id: response.data.data.id, default: 1 });
          this.createSite(this.newSite);
        });
      } else {
        // If a language was created but the site failed we will end up here
        this.newSite.languages = [];
        this.newSite.languages.push({ id: this.newSite.selectedLanguage, default: 1 });
        this.createSite(this.newSite);
      }
    },
    attemptCreatePage() {
      this.createPage(this.newPage);
    }
  },
  computed: {
    ...mapState({
      checklist: state => state.checklist,
      languages: state => state.languages.data
    })
  },
  components: {
    Messages
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

#menu {
  font-size: 0.9em;

  a {
    text-decoration: none;
    font-weight: normal;

    &.is-active {
      font-weight: bold;
    }
  }

  ul {
    padding-bottom: 1em;

    > li:first-child {
      margin-top: 0.5em;
    }
  }
  li {
    padding-top: 0.5em;
    padding-bottom: 0.5em;
  }
}
</style>