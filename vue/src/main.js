import Vue from 'vue'
import VueTippy from 'vue-tippy'
import Devise from './Devise'
import Help from './components/utilities/Help'
import Logo from './components/utilities/Logo'
import Slices from './Slices'
import DeviseStore from './vuex/store'
import PortalVue from 'portal-vue'
import { DeviseBus } from './event-bus.js'
import routes from './router/route.config.js'
import alertConfirm from './directives/alert-confirm'
import Vuebar from 'vuebar';

import EditPage from './components/pages/Editor'

Vue.config.productionTip = false

import { mapGetters } from 'vuex'

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

    for (const route in routes) {
      if (routes.hasOwnProperty(route)) {
        const routeToCheck = routes[route];
        var canAdd = true
        
        for (const customRoute in router.options.routes) {
          if (router.options.routes.hasOwnProperty(customRoute)) {
            const routeToCheckAgainst = router.options.routes[customRoute];
            if (routeToCheckAgainst.name === routeToCheck.name) {
              canAdd = false
            }
          }
        }

        if (canAdd) {
          router.addRoutes([routeToCheck])
        }
      }
    }

    if (typeof deviseSettings === 'undefined') {
      window.deviseSettings = function () {};
    }

    // If the bus isn't set we'll use our own bus
    if (typeof bus === 'undefined') {
      deviseSettings.__proto__.$bus = DeviseBus
    } else {
      deviseSettings.__proto__.$bus = bus
    }

    // Tooltips
    Vue.use(VueTippy)

    // Portals to render items outside of their component
    Vue.use(PortalVue)

    // Scrollbar hiding
    Vue.use(Vuebar);

    // VueRouter Register global components
    Vue.component('Devise', Devise)
    Vue.component('Logo', Logo)
    Vue.component('Help', Help)
    Vue.component('Slices', Slices)

    // Register devise vuex module and sync it with the store
    store.registerModule('devise', DeviseStore)

    // Register alert / confirm directive
    Vue.directive('devise-alert-confirm', alertConfirm)

    let deviseOptions = Object.assign({
      breakpoints: {
        mobile: 575,
        tablet: 768,
        desktop: 991,
        largeDesktop: 1199
      }
    }, options)

    // We call Vue.mixin() here to inject functionality into all components.
    Vue.mixin({
      data () {
        return {
          deviseOptions: deviseOptions,
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
        goToPage (pageName, params) {
          this.$router.push({name: pageName, params: params})
        },
        launchMediaManager (callbackObject, callbackProperty) {
          deviseSettings.$bus.$emit('devise-launch-media-manager', {
            callback: function (media) {
              callbackObject[callbackProperty] = media.url
            }
          })
        }
      },
      computed: {
        ...mapGetters('devise', [
          'currentPage',
          'theme'
        ]),
        sidebarTheme () {
          return {
            backgroundImage: `linear-gradient(180deg, ${this.theme.sidebarTop.color} 0%, ${this.theme.sidebarBottom.color} 100%)`,
            color: this.theme.sidebarText.color
          }
        },
        adminTheme () {
          return {
            background: this.theme.adminBackground.color,
            color: this.theme.adminText.color
          }
        },
        actionButtonTheme () {
          return {
            backgroundImage: `linear-gradient(90deg, ${this.theme.buttonsActionLeft.color} 0%, ${this.theme.buttonsActionRight.color} 100%)`,
            color: this.theme.buttonsActionText.color,
            boxShadow: `2px 2px ${this.theme.buttonsActionShadowSize.text} ${this.theme.buttonsActionShadowColor.color}`
          }
        },
        regularButtonTheme () {
          return {
            backgroundColor: this.theme.buttonsInverseLeft.color,
            color: this.theme.buttonsInverseText.color
          }
        },
        infoBlockTheme () {
          return {
            borderRadius: '0.3rem',
            backgroundImage: `linear-gradient(90deg, ${this.theme.statsLeft.color} 0%, ${this.theme.statsRight.color} 100%)`,
            color: this.theme.statsText.color,
            boxShadow: `2px 2px ${this.theme.statsShadowSize.text} ${this.theme.statsShadowColor.color}`
          }
        },
        infoBlockFlatTheme () {
          return {
            borderRadius: '0.3rem',
            background: this.theme.statsLeft.color,
            color: this.theme.statsText.color,
          }
        }
      },
      // This sets a prop to be accepted by all components in a custom Vue
      // app that resides within Devise. Makes it a little easier to pass
      // down any data to custom child components
      props: ['devise', 'slices', 'models', 'responsiveBreakpoint'],
      store: store
    })

    if (typeof deviseSettings.$mothership !== 'undefined' && deviseSettings.$mothership['api-key'] !== null) {
      store.commit('devise/setMothership', deviseSettings.$mothership['api-key'])
    }
  }
}

export default DevisePlugin
