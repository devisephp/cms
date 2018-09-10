import { WSAETIMEDOUT } from 'constants';

var tinycolor = require('tinycolor2')

const getters = {
  
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

  lang: state => {
    return deviseSettings.$lang
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
  mothershipUrl: state => {
    return state.mothership['url']
  },
  mothershipApiKey: state => {
    return state.mothership['api-key']
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
      // Used by the admin panels
      panel: {
        background: `linear-gradient(135deg, #2C3858 , #182039)`,
        color: '#F3F3F3',
        secondaryColor: '#979797'
      },
      panelCard: {
        backgroundColor: `#182039`,
        color: '#eee'
      },
      panelSidebar: { 
        backgroundColor: '#182039',
        color: '#eee',
        borderColor: '#3d4852'
      },
      panelIcons: { 
        color: '#658BEF',
        secondaryColor: '#EB8F89'
      },
      actionButton: {
        color: '#ffffff',
        backgroundColor: '#EB8F89',
        borderColor: '#EB8F89',
        borderWidth: '2px',
      },
      actionButtonGhost: {
        color: '#EB8F89',
        borderColor: '#EB8F89',
        borderWidth: '2px'
      },
      help: {
        color: '#EB8F89',
        borderColor: '#EB8F89',
        backgroundColor: tinycolor('#EB8F89').lighten(25).toString()
      },

      adminBackground: { color: 'rgba(0,0,0,0.8)' },
      adminText: { color: '#b8c2cc' },
      actionButtonBackground: { color: 'white' },
      actionButtonText: { color: 'black' },
      regularButtonBackground: { color: '#3d4852' },
      regularButtonText: { color: 'white' },
      chartColor1: { color: 'rgba(54, 162, 235, 1)' },
      chartColor2: { color: 'rgba(75, 192, 192, 1)' },
      chartColor3: { color: 'rgba(255, 206, 86, 1)' },
      chartColor4: { color: 'rgba(255, 99, 132, 1)' },
      chartColor5: { color: 'rgba(153, 102, 255, 1)' },
      chartColor6: { color: 'rgba(255, 159, 64, 1)' }
    }

    return defaultColors

    if (state.page) {
      let site = getters.siteById(state.page.site_id)

      if (site && site.settings) {
        var colors = site.settings.colors
      }
    }

    colors = Object.assign({}, defaultColors, colors)

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
