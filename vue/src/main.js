import Vue from 'vue'
import VueTippy from 'vue-tippy'
import Devise from './Devise'
import Help from './components/utilities/Help'
import Slices from './Slices'
import DeviseStore from './vuex/store'
import { DeviseBus } from './event-bus.js'
import routes from './router/route.config.js'
import alertConfirm from './directives/alert-confirm'

import EditPage from './components/pages/Editor'

Vue.config.productionTip = false

const DevisePlugin = {
  install (Vue, { store, router, bus, options }) {
    if (typeof store === 'undefined') {
      throw new Error('Please provide a vuex store.')
    }

    if (typeof router === 'undefined') {
      throw new Error('Please provide a vue router.')
    }

    // Set the devise route to Edit Page for any application routes
    // that aren't setup to take over the admin. This allows us to see the
    // page editor even if you are navigating around the application routes.
    router.options.routes.map(route => {
      if (!route.hasOwnProperty('components')) {
        route.components = {}
      }
      if (!route.components.hasOwnProperty('devise')) {
        route.components.devise = EditPage
      }
    })
    router.addRoutes(routes)

    // If the bus isn't set we'll use our own bus
    if (typeof bus === 'undefined') {
      window.bus = DeviseBus
    }

    // Tooltips
    Vue.use(VueTippy)

    // VueRouter Register global components
    Vue.component('Devise', Devise)
    Vue.component('Help', Help)
    Vue.component('Slices', Slices)

    // Register devise vuex module and sync it with the store
    store.registerModule('devise', DeviseStore)

    // Register alert / confirm directive
    Vue.directive('devise-alert-confirm', alertConfirm)

    // We call Vue.mixin() here to inject functionality into all components.
    Vue.mixin({
      data () {
        return {
          deviseOptions: options,
          tippyConfiguration: {
            interactive: true,
            animation: 'shift-toward',
            arrow: true,
            inertia: true,
            interactiveBorder: 20,
            maxWidth: '300px',
            theme: 'devise',
            trigger: 'mouseenter focus'
          }
        }
      },
      methods: {
        // Convienience method to push things into the router from templates
        goToPage (pageName) {
          this.$router.push({name: pageName})
        }
      },
      // This sets a prop to be accepted by all components in a custom Vue
      // app that resides within Devise. Makes it a little easier to pass
      // down any data to custom child components
      props: ['devise', 'slices', 'models'],
      store: store
    })
  }
}

export default DevisePlugin
