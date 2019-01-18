export default {
  // Breakpoints
  setBreakpoint(state, payload) {
    state.breakpoint = payload;
  },

  setDevMode(state, payload) {
    state.devMode = payload;
  },

  // Languages
  setLanguages(state, payload) {
    state.languages = payload;
  },

  createLanguage(state, payload) {
    state.languages.data.push(payload);
  },

  updateLanguage(state, { language, data }) {
    language = data;
  },

  // Layouts
  setLayouts(state, payload) {
    state.layouts = payload;
  },

  // Media Regeneration
  addToMediaRegenerationRequests(state, payload) {
    state.mediaRegenerationRequests.push(payload);
  },

  // Media manager
  setCurrentDirectory(state, directory) {
    state.currentDirectory = directory;
  },

  setFiles(state, payload) {
    state.files = payload;
  },

  setSearchableMedia(state, payload) {
    state.searchableMedia.data = payload;
  },

  setDirectories(state, payload) {
    state.directories = payload;
  },

  // Meta
  setMeta(state, payload) {
    state.meta = payload;
  },

  createMeta(state, payload) {
    state.meta.data.push(payload);
  },

  updateMeta(state, { meta, data }) {
    meta = data;
  },

  deleteMeta(state, meta) {
    state.meta.data.splice(state.meta.data.indexOf(meta), 1);
  },

  // Models
  setModels(state, payload) {
    state.models = payload;
  },

  setModelSettings(state, payload) {
    state.modelSettings = payload;
  },

  // Mothership
  setMothership(state, payload) {
    state.mothership = payload;
  },

  setChanges(state, payload) {
    state.changes = payload;
  },

  // Current Page
  setCurrentPage(state, page) {
    Object.assign({}, state.currentPage, page);
  },

  setPreviewModeInCurrentPage(state, mode) {
    state.currentPage.previewMode = mode;
  },

  // Pages
  createPage(state, page) {
    state.pages.data.push(page);
  },

  setPages(state, payload) {
    state.pages = payload;
  },

  setPagesList(state, payload) {
    state.pagesList.data = payload;
  },

  appendPage(state, payload) {
    state.pages.data.push(payload);
  },

  updatePage(state, { page, data }) {
    page = data;
  },

  deletePage(state, page) {
    state.pages.data.splice(state.pages.data.indexOf(page), 1);
  },

  // Page Versions
  createPageVersion(state, { page, data }) {
    page.versions.push(data);
  },

  deletePageVersion(state, { page, version }) {
    let theVersion = page.versions.find(ver => {
      return ver.id === version.id;
    });
    page.versions.splice(page.versions.indexOf(theVersion), 1);
  },

  updatePageVersion(state, { page, version, data }) {
    let theVersion = page.versions.find(ver => {
      return ver.id === version.id;
    });
    theVersion = data;
    return theVersion;
  },

  updatePageVersionAnalytics(state, { page, version, data }) {
    let theVersion = page.versions.find(ver => {
      return ver.id === version.id;
    });
    theVersion = Object.assign({}, theVersion, { analytics: data });
    return theVersion;
  },

  // Sites
  createSite(state, site) {
    state.sites.data.push(site);
  },

  setSites(state, payload) {
    state.sites = payload;
  },

  updateSite(state, { site, data }) {
    site.name = data.name;
    site.domain = data.domain;
    site.languages = data.languages;
  },

  deleteSite(state, site) {
    state.sites.data.splice(state.sites.data.indexOf(site), 1);
  },

  // Slices
  setSlices(state, payload) {
    state.slices = payload;
  },

  setSlicesDirectories(state, payload) {
    state.slicesDirectories = payload;
  },

  createSlice(state, slice) {
    state.slices.data.push(slice);
  },

  updateSlice(state, { slice, data }) {
    slice.name = data.name;
  },

  deleteSlice(state, slice) {
    state.slices.data.splice(state.slices.data.indexOf(slice), 1);
  },

  // Redirect
  createRedirect(state, redirect) {
    state.redirects.data.push(redirect);
  },

  setRedirects(state, payload) {
    state.redirects = payload;
  },

  updateRedirect(state, { redirect, data }) {
    redirect = data;
  },

  deleteRedirect(state, redirect) {
    state.redirects.data.splice(state.redirects.data.indexOf(redirect), 1);
  },

  // User
  createUser(state, user) {
    state.users.data.push(user);
  },

  setUsers(state, payload) {
    state.users = payload;
  },

  updateUser(state, { user, data }) {
    user = data;
  },

  deleteUser(state, user) {
    state.users.data.splice(state.users.data.indexOf(user), 1);
  }
};
