window.Vue = require('vue');

var VueScrollactive = require('vue-scrollactive');
Vue.use(VueScrollactive);

import 'es6-promise/auto';

import store from './vuex/store';

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.$bus = new Vue();

import Installer from './components/Installer';
Vue.component('devise-installer', Installer);

import InstallerFinish from './components/InstallerFinish';
Vue.component('installer-finish', InstallerFinish);

import Item from './components/Item';
Vue.component('devise-installer-item', Item);

import ItemCheck from './components/ItemCheck';
Vue.component('item-check', ItemCheck);

import Help from './components/Help';
Vue.component('help', Help);

import CheckmarkCircleIcon from 'vue-ionicons/dist/ios-checkmark-circle-outline.vue';
Vue.component('checkmark-icon', CheckmarkCircleIcon);

import CloseCircleIcon from 'vue-ionicons/dist/ios-close-circle-outline.vue';
Vue.component('close-circle-icon', CloseCircleIcon);

import AlertIcon from 'vue-ionicons/dist/ios-alert.vue';
Vue.component('alert-icon', AlertIcon);

import Prism from 'prismjs';
import 'prismjs/themes/prism-okaidia.css';
import 'prismjs/components/prism-clike.min.js';
import 'prismjs/components/prism-markup-templating.min.js';
import 'prismjs/components/prism-php.min.js';
import 'prismjs/components/prism-ini.min.js';
import 'prismjs/components/prism-javascript.min.js';
import 'prismjs/components/prism-bash.min.js';

// var loadComponents = require('prismjs/components/index.js');
// loadComponents(['ini', 'javascript', 'bash', 'php']);

import 'prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.js';
import 'prismjs/plugins/line-numbers/prism-line-numbers.js';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';

Prism.highlightAll();

Prism.plugins.NormalizeWhitespace.setDefaults({
  'remove-trailing': true,
  'remove-indent': true,
  'left-trim': true,
  'right-trim': true
  /*'break-lines': 80,
	'indent': 2,
	'remove-initial-line-feed': false,
	'tabs-to-spaces': 4,
	'spaces-to-tabs': 4*/
});

new Vue({
  el: '#installer-app',
  store: store
});
