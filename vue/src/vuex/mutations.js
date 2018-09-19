export default {

  // Breakpoints
  setBreakpoint (state, payload) {
    state.breakpoint = payload
  },

  // Languages
  setLanguages (state, payload) {
    state.languages = payload
  },

  createLanguage (state, payload) {
    state.languages.data.push(payload)
  },

  updateLanguage (state, {language, data}) {
    language = data
  },

  // Media manager
  setCurrentDirectory (state, directory) {
    state.currentDirectory = directory
  },

  setFiles (state, payload) {
    state.files = payload
  },

  setSearchableMedia (state, payload) {
    state.searchableMedia = payload
  },

  setDirectories (state, payload) {
    state.directories = payload
  },

  toggleFileOnOff (state, payload) {
    payload.file.on = payload.on
    state.files.splice(state.files.indexOf(payload.file), 1, payload.file)
  },

  // Meta
  setMeta (state, payload) {
    state.meta = payload
  },

  createMeta (state, payload) {
    state.meta.data.push(payload)
  },

  updateMeta (state, {meta, data}) {
    meta = data
  },

  deleteMeta (state, meta) {
    state.meta.data.splice(state.meta.data.indexOf(meta), 1)
  },

  // Models
  setModels (state, payload) {
    state.models = payload
  },

  setModelSettings (state, payload) {
    state.modelSettings = payload
  },

  // Mothership
  setMothership (state, payload) {
    state.mothership = payload
  },

  setChanges (state, payload) {
    state.changes = payload
  },

  // Pages
  createPage (state, page) {
    state.pages.data.push(page)
  },

  setPage (state, payload) {
    state.page = payload
  },

  setPages (state, payload) {
    state.pages = payload
  },

  setPagesList (state, payload) {
    state.pagesList.data = payload
  },

  appendPage (state, payload) {
    state.pages.data.push(payload)
  },

  updatePage (state, {page, data}) {
    page = data
  },

  deletePage (state, page) {
    state.pages.data.splice(state.pages.data.indexOf(page), 1)
  },

  // Page Versions
  createPageVersion (state, {page, data}) {
    page.versions.push(data)
  },

  deletePageVersion (state, {page, version}) {
    let theVersion = page.versions.find(ver => {
      return ver.id === version.id
    })
    page.versions.splice(page.versions.indexOf(theVersion), 1)
  },

  updatePageVersion (state, {page, version, data}) {
    let theVersion = page.versions.find(ver => {
      return ver.id === version.id
    })
    theVersion = data
    return theVersion
  },

  updatePageVersionAnalytics (state, {page, version, data}) {
    let theVersion = page.versions.find(ver => {
      return ver.id === version.id
    })
    theVersion = Object.assign({}, theVersion, {analytics: data})
    return theVersion
  },

  // Sites
  createSite (state, site) {
    state.sites.data.push(site)
  },

  setSites (state, payload) {
    state.sites = payload
  },

  updateSite (state, {site, data}) {
    site.name = data.name
    site.domain = data.domain
    site.languages = data.languages
  },

  deleteSite (state, site) {
    state.sites.data.splice(state.sites.data.indexOf(site), 1)
  },

  // Slices
  setSlices (state, payload) {
    state.slices = payload
  },

  setSlicesDirectories (state, payload) {
    state.slicesDirectories = payload
  },

  createSlice (state, slice) {
    state.slices.data.push(slice)
  },

  updateSlice (state, {slice, data}) {
    slice.name = data.name
  },

  deleteSlice (state, slice) {
    state.slices.data.splice(state.slices.data.indexOf(slice), 1)
  },

  // Templates
  createTemplate (state, template) {
    state.templates.data.push(template)
  },

  updateTemplate (state, {template, data}) {
    template = data
  },

  deleteTemplate (state, template) {
    state.templates.data.splice(state.templates.data.indexOf(template), 1)
  },

  updateCurrentTemplate (state, templateId) {
    state.currentTemplate = templateId
  },

  setTemplates (state, payload) {
    state.templates = payload
  },

  // Redirect
  createRedirect (state, redirect) {
    state.redirects.data.push(redirect)
  },

  setRedirects (state, payload) {
    state.redirects = payload
  },

  updateRedirect (state, {redirect, data}) {
    redirect = data
  },

  deleteRedirect (state, redirect) {
    state.redirects.data.splice(state.redirects.data.indexOf(redirect), 1)
  },

  // User
  createUser (state, user) {
    state.users.data.push(user)
  },

  setUsers (state, payload) {
    state.users = payload
  },

  updateUser (state, {user, data}) {
    user = data
  },

  deleteUser (state, user) {
    state.users.data.splice(state.users.data.indexOf(user), 1)
  }
}
