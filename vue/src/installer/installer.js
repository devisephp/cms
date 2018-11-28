import Vue from 'vue';

import 'es6-promise/auto';

import store from './vuex/store';

import Installer from './components/Installer';
Vue.component('devise-installer', Installer);

import Item from './components/Item';
Vue.component('devise-installer-item', Item);

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
import 'prismjs/components/prism-ini.min.js';
import 'prismjs/components/prism-javascript.min.js';
import 'prismjs/components/prism-bash.min.js';
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

console.log(store);

new Vue({
  el: '#installer-app',
  store
});
