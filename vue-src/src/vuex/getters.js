const getters = {
  sliceConfig: state => (slice) => {
    return window.deviseComponents[slice.metadata.name] ? window.deviseComponents[slice.metadata.name] : window.deviseComponents[slice.name]
  },

  fieldConfig: (state, getters) => ({fieldKey, slice}) => {
    let sliceConfig = getters.sliceConfig(slice)
    if (typeof sliceConfig.config[fieldKey] === 'undefined') {
      throw new ReferenceError(`Could not find the configuration for the ${fieldKey} fieldkey from this slice: ${sliceConfig.name}`)
    }
    return sliceConfig.config[fieldKey]
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
  models: state => {
    return state.models
  },

  modelSettings: state => {
    return state.modelSettings
  },

  // Pages
  pages: state => {
    return state.pages
  },

  page: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.pageId)
    return state.pages.data.find(page => page.id === id)
  },

  // Sites
  sites: state => {
    return state.sites
  },

  // Slices
  slices: state => {
    return state.slices
  },

  // Templates
  templates: state => {
    return state.templates
  },

  template: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.templateId)
    return state.templates.data.find(template => template.id === id)
  },

  // Users
  users: state => {
    return state.users
  },

  user: (state, getters, rootState) => {
    var id = parseInt(rootState.route.params.userId)
    return state.users.data.find(user => user.id === id)
  }
}

export default getters
