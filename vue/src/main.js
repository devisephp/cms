import Vue from 'vue'
import VueTippy from 'vue-tippy'
import Devise from './Devise'
import Help from './components/utilities/Help'
import Slices from './Slices'
import TemplatePreviewSettings from './components/templates/PreviewSettings' // Required for recursion
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
    Vue.component('TemplatePreviewSettings', TemplatePreviewSettings)

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
        // The collectionData looks at the slices passed to it and extracts
        // the data for easier access
        getCollectionData (slices, name) {
          let collection = this.getCollection(slices, name)
          return collection.map(function (record) {
            return record.data
          })
        },
        // Returns only the slices that match the name passed
        // Primarily this is a helper function for getCollectionData
        getCollection (slices, name) {
          console.log(slices)
          let collection = slices.filter(function (slice) {
            return slice.metadata.name === name
          })

          // If settings property is present we know we are in template builder
          // We clear out the existing placeholder data and store it in a temp
          // variable to repopulate based on the number of instances the User
          // has set.
          if (collection[0] && collection[0].settings) {
            let tempCollection = collection[0]
            collection.splice(0, collection.length)

            for (var i = 0; i < tempCollection.settings.numberOfInstances; i++) {
              collection.push(tempCollection)
            }
          }

          return collection
        },

        // Convienience method to push things into the router from templates
        goToPage (pageName) {
          this.$router.push({name: pageName})
        }
      },
      // This sets a prop to be accepted by all components in a custom Vue
      // app that resides within Devise. Makes it a little easier to pass
      // down any data to custom child components
      props: ['devise'],
      store: store
    })
  }
}

export default DevisePlugin
