/* eslint-disable */
require('./bootstrap');

window.Vue = require('vue')
// Devise in Boilerplate
import Devise from './main.js'

// Devise requires a bus, vue-router and vuex. We initialize these in your application
// so that both apps can share the same store and router. All devise vuex
// is namespaced under the "devise" namespace.
import { DeviseBus } from './event-bus.js'
window.$bus = DeviseBus
import router from './router/route-boilerplate-app.config'
import store from './vuex/store-boilerplate-app'
import { sync } from 'vuex-router-sync'
sync(store, router)

// We initialize the Devise plugin and pass our router, store, and bus to share
// these resources so that your application can tap into them.
Vue.use(Devise, {
  store: store,
  router: router,
  bus: window.$bus,
  options: {
    adminClass: ''
  }
})

// When we want to initialize something after Devise is done loading
window.$bus.$on('devise-loaded', function () {})

// Initialize the application's Vue app
const app = new Vue({
  el: '#app',
  router: router
})
