import { WSAETIMEDOUT } from 'constants';

var tinycolor = require('tinycolor2')

const getters = {

  // Admin Menu
  adminMenu: state => {
    return state.adminMenu
  },

  settingsMenu: state => {
    return state.settingsMenu
  },

  breakpoint: state => {
    return state.breakpoint.breakpoint
  },

  breakpointAndDimensions: state => {
    return state.breakpoint
  },

  // This takes a component name and returns the corresponding component from
  // deviseSettings.$deviseComponents. This contains the name, template, and field
  // configuration.
  component: state => (name) => {
    return deviseSettings.$deviseComponents[name]
  },

  componentFromView: state => (view) => {
    for (var component in deviseSettings.$deviseComponents) {
      if (deviseSettings.$deviseComponents[component].view === 'slices.' + view) {
        return deviseSettings.$deviseComponents[component]
      }
    }
    return false
  },

  deviseInterface: state => {
    return deviseSettings.$interface
  },

  sliceConfig: state => (slice) => {
    return deviseSettings.$deviseComponents[slice.metadata.name] ? deviseSettings.$deviseComponents[slice.metadata.name] : deviseSettings.$deviseComponents[slice.name]
  },

  fieldConfig: (state, getters) => ({fieldKey, slice}) => {
    let sliceConfig = getters.sliceConfig(slice)
    if (typeof sliceConfig.config[fieldKey] !== 'undefined') {
      return sliceConfig.config[fieldKey]
    }
  },

  // Languages
  languages: state => {
    return state.languages
  },

  // Media manager

  files: state => {
    return state.files
  },

  directories: state => {
    return state.directories
  },

  currentDirectory: state => {
    return state.currentDirectory
  },

  // Meta
  meta: state => {
    return state.meta
  },

  // Models
  storeModels: state => {
    return state.models
  },

  modelSettings: state => {
    return state.modelSettings
  },

  // Mothership API
  mothership: state => {
    return state.mothership
  },

  changes: state => {
    return state.changes
  },

  // Pages
  pages: state => {
    return state.pages
  },

  page: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.pageId)
    return state.pages.data.find(page => page.id === id)
  },

  currentPage: (state, getters, rootState) => {
    return deviseSettings.$page
  },

  // Sites
  sites: state => {
    return state.sites
  },

  site: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.siteId)
    return getters.siteById(id)
  },

  siteById: state => (id) => {
    return state.sites.data.find(site => site.id === id)
  },

  theme: (state, getters, rootState) => {
    var defaultColors = {
      sidebarTop: { color: 'rgba(242,242,242,1)' },
      sidebarBottom: { color: 'rgba(230,230,230,1)' },
      sidebarText: { color: 'rgba(107,107,107,1)' },
      buttonsActionText: { color: 'rgba(0,0,0,1)' },
      buttonsActionLeft: { color: '#fafafa' },
      buttonsActionRight: { color: '#e8e8e8' },
      buttonsActionShadowColor: { color: 'rgba(126,126,126,0.14)' },
      buttonsActionShadowSize: { text: '2px' },
      userBackground: { color: 'rgba(0,0,0,0.6)' },
      userText: { color: '#ffffff' },
      userShadowColor: { color: 'rgba(0,0,0,0.43)' },
      userShadowSize: { text: '30px' },
      statsText: { color: 'rgba(107,107,107,1)' },
      statsLeft: { color: '#eaeaea' },
      statsRight: { color: '#d6d6d6' },
      statsShadowColor: { color: 'rgba(0,0,0,0.51)' },
      statsShadowSize: { text: '30px' },
      adminBackground: { color: 'rgba(255,255,255,1)' },
      adminText: { color: 'rgba(80,80,80,1)' },
      chartColor1: { color: 'rgba(54, 162, 235, 1)' },
      chartColor2: { color: 'rgba(75, 192, 192, 1)' },
      chartColor3: { color: 'rgba(255, 206, 86, 1)' },
      chartColor4: { color: 'rgba(255, 99, 132, 1)' },
      chartColor5: { color: 'rgba(153, 102, 255, 1)' },
      chartColor6: { color: 'rgba(255, 159, 64, 1)' }
    }

    if (state.page) {
      let site = getters.siteById(state.page.site_id)

      if (site && site.settings) {
        var colors = site.settings.colors
      }
    }

    colors = Object.assign({}, defaultColors, colors)

    colors.buttonsInverseLeft = {
      color: tinycolor(colors.buttonsActionLeft.color).spin(90).toString()
    }

    colors.buttonsInverseRight = {
      color: tinycolor(colors.buttonsActionRight.color).spin(90).toString()
    }

    colors.buttonsInverseText = {
      color: tinycolor(colors.buttonsActionText.color).spin(90).toString()
    }

    return colors
  },

  // Slices
  slicesList: state => {
    return state.slices
  },

  slicesDirectories: state => {
    return state.slicesDirectories
  },

  // Templates
  templates: state => {
    return state.templates
  },

  template: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.templateId)
    return state.templates.data.find(template => template.id === id)
  },

  // Redirects
  redirects: state => {
    return state.redirects
  },

  redirect: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.redirectId)
    return state.redirects.data.find(redirect => redirect.id === id)
  },

  currentRedirect: state => {
    return deviseSettings.$redirect
  },

  // Users
  users: state => {
    return state.users
  },

  user: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.userId)
    return state.users.data.find(user => user.id === id)
  },

  currentUser: state => {
    return deviseSettings.$user
  }
}

export default getters
