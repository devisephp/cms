
// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'

// Router and Vuex
import router from './router/index.js'
import store from './vuex/store'
import { sync } from 'vuex-router-sync'
sync(store, router)

require('./bootstrap')

/* eslint-disable no-new */
window.Vue = new Vue({
  el: '#app',
  template: '<App/>',
  components: { App },
  router: router
})
