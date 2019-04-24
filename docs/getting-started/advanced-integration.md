# Advanced Integration with VueJS

Let's suppose that you want to add on a new administration section in Devise or build in your own VueJS components so that Webpack can do it's thing and optimize your build? Well, we've set it up so that you can do that very easily. This Guide assumes you've setup a [base install of Devise](installation.md).

## What we're going to setup

Devise comes in two parts:

1. The PHP API that ties into Laravel \([Devise CMS](https://github.com/devisephp/cms)\)
2. The VueJS frontend that gives you and your content managers a way to interact with that API \([Devise Interface](https://github.com/devisephp/interface)\)

What we're going to do here is setup a way for you to recompile the frontend piece with your own Javascript. This is where Devise really shines because it leverages the power of Vue CLI and Webpack to make your bundles as small as possible, chunked out so they are lazy loaded, and compile CSS frameworks like [TailwindCSS](https://tailwindcss.com). So let's get started. Again, this Guide will assume you've setup a [base install of Devise](installation.md) so if you haven't done those steps get those knocked out and then come back here .

## Prerequisites: Setup Vue CLI

[Vue CLI](https://cli.vuejs.org/) is an _amazing_ utility that will do our compiling for us. Go ahead and follow their [install guide](https://cli.vuejs.org/guide/installation.html) and once you're done you should be able to run `vue ui` from your command line and see the UI.

## Create a new Vue project

On the root of your Laravel project create a new Vue project by clicking the "Create" button. We like to name our projects something like "projectname-interface". During the creation you've got a few options but you're going to want to include, at minimum:

* Vue Router
* Vuex
* Babel

Typically, we also include our SASS \(or LESS\) and eslint in our configuration so that we can enjoy the benefits of hot module reloading and linting.

## Add dependencies and install Devise Interface

Once in your project click on the "dependencies" tab and add the following as dependencies.

* devisephp-interface
* vuex-router-sync
* axios

Or add them via the command line with:

`yarn add devisephp-interface vuex-router-sync axios`

## Add other dev dependencies

Again, you can add them with the "dev-dependencies" UI in Vue CLI

* tailwindcss
* webpack-assets-manifest

Or via the command line:

`yarn add -D tailwindcss webpack-assets-manifest`

## Initialize TailwindCSS

From the root of your interface directory:

`yarn tailwind init tailwind.js`

## Create vue.config.js

Inside your new vue-cli project create a vue.config.js file and place the following:

{% hint style="warning" %}
Be sure to change the developmentUrl to your development domain
{% endhint %}

```javascript
// eslint-disable-next-line import/no-extraneous-dependencies
const webpack = require('webpack');
// Creates a manifest file
const WebpackAssetsManifest = require('webpack-assets-manifest');
// Public can be anything you want. We typically put ours in "app"
// because we work on multiple projects and it makes less confusion about where
// things should be living.
const publicDirectory = 'app';

// Development url should match your Laravel Valet url
const developmentUrl = 'http://project-name.test';

const developmentPort = '8080';

module.exports = {

  outputDir: `../public/${publicDirectory}`,
  runtimeCompiler: true,
  filenameHashing: false,

  // Be sure to match "app" with whatever you set above and change
  publicPath:
    process.env.NODE_ENV === 'production'
      ? `/${publicDirectory}`
      : `${developmentUrl}:${developmentPort}/${publicDirectory}/`,

  devServer: {
    disableHostCheck: true,
    useLocalIp: false,
    proxy: `http://localhost:${developmentPort}`,
    publicPath: `${developmentUrl}:${developmentPort}/${publicDirectory}/`,
    port: 8080,
    headers: { 'Access-Control-Allow-Origin': '*' },
  },

  configureWebpack: {
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jquery: 'jquery',
        'window.jQuery': 'jquery',
        jQuery: 'jquery',
      }),
      new WebpackAssetsManifest(),
    ],
  },

  css: {
    extract: true,
  },
};
```

## Create an event bus

In your interface src directory next to your main.js file create `event-bus.js` and put in the following:

```javascript
import Vue from 'vue';

export default new Vue();
```

## Modify your main.js file

Your main.js file is the "entry" to your application. It's where everything starts. Here we are going to initialize VueJS and add Devise Interface as a plugin.

```javascript
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';

// Devise requires a bus, vue-router and vuex. We initialize these in your application
// so that both apps can share the same store and router. All devise vuex
// is namespaced under the "devise" namespace.
import { sync } from 'vuex-router-sync';

// Inclue Devise Interface
import Devise from 'devisephp-interface';

// Vuex, Router, Bus
import store from './store';
import router from './router';
import EventBus from './event-bus';

/**
 * Import any global components that we need
 * You'll need to name the tag, provide the chunk name, and point it to the
 * single file component file
 */
// eslint-disable-next-line max-len
// Vue.component('my-component', () => import(/* webpackChunkName: "app-ui" */ './components/MyComponent.vue'));


// Load axios for http requests and add the Laravel CSRF token to the headers
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  // eslint-disable-next-line no-console
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.config.productionTip = false;

window.bus = EventBus;
sync(store, router);
Vue.use(Devise, {
  store,
  router,
  bus: window.bus,
  options: {
    adminClass: '',
  },
});

// eslint-disable-next-line no-unused-vars
const app = new Vue({
  el: '#app',
  router,
  mounted() {
    this.appLoaded();
  },
  methods: {
    appLoaded() {
      window.deviseSettings.$bus.$on('devise-loaded', () => { });
    },
  },
});
```

## Modify router.js

In your interface folder's `src` directory modify router.js to be the following:

```javascript
/* eslint-disable implicit-arrow-linebreak */
import Vue from 'vue';
import VueRouter from 'vue-router';

const routes = [];

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'abstract',
  transitionOnLoad: true,
  routes,
});

export default router;
```

## Modify your layout

We're almost there! We need to modify the layout of our blade file to accommodate for hot module reloading. If you followed the basic installation it will be located in `/resources/views/layouts/main.blade.php`. It needs to look something like the following:

```markup
<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    @isset($page)
    {!! Devise::head($page) !!}
    @else
    {!! Devise::head() !!}
    @endif

    @if(Auth::user())
      <link href=/devise/css/chunk-vendors.css rel=stylesheet>
      <link href=/devise/css/main.css rel=stylesheet>
      <link href=/devise/css/styles.css rel=stylesheet>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>

  <body>
    <div id="app">
        <div v-cloak>
          <devise>
            <div slot="on-top"></div>

            <div slot="static-content">
                @yield('content')
            </div>

            <div slot="on-bottom"></div>
          </devise>
        </div>
    </div>

    <script rel="prefetch" src="{{vuemix('/js/chunk-vendors.js', '/app')}}"></script>
    <script rel="prefetch" src="{{vuemix('/js/app.js', '/app')}}"></script>
  </body>
</html>
```

## Update package.json script

Update the `scripts` section of package.json with the following:

{% code-tabs %}
{% code-tabs-item title="/project-app/package.json" %}
```javascript
  "scripts": {
    "serve": "npm link devisephp-interface && cp ./hmr/hot ../public/app/ && vue-cli-service serve",
    "build": "vue-cli-service build",
    "lint": "vue-cli-service lint"
  },
```
{% endcode-tabs-item %}
{% endcode-tabs %}

## Create HOT file

Create a directory in your Vue CLI project root called `hmr` and a file within it called `hot` with the following contents:

{% code-tabs %}
{% code-tabs-item title="/project-app/hmr/hot" %}
```javascript
http://localhost:8080/
```
{% endcode-tabs-item %}
{% endcode-tabs %}

## Clear the output directory setting

Vue CLI has a default setting in the "Output Directory" of the parameters in the build script. To change this click on "Tasks", then "Build", then "Parameters" and clear the "Output Directory" setting so that nothing is in it.

## Build!

You did great! Head to the Tasks tab on the Vue CLI UI, click "Build", and then the "Run" button. If you have no errors you should see a bunch of new files in `/public/app` \(or wherever you configured your output to be in your vue.config.js\).

When you visit your site if you only see a white screen make sure you have logged in at `http://your-project.test/login` and logged in.

## Troubleshooting

First, there are many ways to accomplish what we are doing here and every project is going to have individual needs. If you need a little guidance on how to set things up take a look at the [DevisePHP Marketing Source](https://github.com/devisephp/marketing). That project is a great baseline to refer to. Of course, feel free to submit an issue and we can try and give you a hand.

### Common Issues

* Before anything else take a look on the "output" tab on the build screen and really read the error. Typically, I'll forget to add a dependency or publish my tailwind.js config file. 

