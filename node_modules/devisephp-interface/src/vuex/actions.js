import commonUtils from './utils/common';

const actions = {
  /*
   * Breakpoint
   */
  setBreakpoint(context, data) {
    return new Promise((resolve, reject) => {
      context.commit('setBreakpoint', data);
      resolve(data);
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  /*
   * Devmode
   */
  setDevMode(context, data) {
    return new Promise((resolve, reject) => {
      context.commit('setDevMode', data);
      resolve(data);
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  /*
   * Languages
   */
  getLanguages(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'languages/')
        .then(function(response) {
          context.commit('setLanguages', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  createLanguage(context, language) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'languages/', language)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: 'Your new language has been added.'
          });
          context.commit('createLanguage', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  updateLanguage(context, language) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'languages/' + language.id, language)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: 'Your new language has been updated.'
          });
          context.commit('updateLanguage', { language: language, data: response.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  /*
   * Media Manager
   */

  setCurrentDirectory(context, directory) {
    return new Promise((resolve, reject) => {
      context.commit('setCurrentDirectory', directory);
      resolve();
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  generateImages(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'media-styles', payload)
        .then(function(response) {
          context.commit('setFiles', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  regenerateMedia(context, payload) {
    context.commit('addToMediaRegenerationRequests', payload);

    return new Promise((resolve, reject) => {
      window.axios
        .put(
          context.state.api.baseUrl +
            'media-styles/' +
            payload.instanceId +
            '/' +
            payload.fieldName,
          payload
        )
        .then(function(response) {
          context.commit('setFiles', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  mediaSearch(context, query) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'media-search?q=' + query)
        .then(function(response) {
          resolve(response.data);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getCurrentFiles(context, options) {
    var imagesOnly = ``;
    if (options && options.type === 'image') {
      imagesOnly = `?type=image`;
    }
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'media/' + context.state.currentDirectory + imagesOnly)
        .then(function(response) {
          context.commit('setFiles', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getCurrentDirectories(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'media-directories/' + context.state.currentDirectory)
        .then(function(response) {
          context.commit('setDirectories', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  toggleFile(context, theFile) {
    let match = context.state.files.find(function(file) {
      return file.name === theFile.name;
    });

    let onOff = typeof match.on === 'undefined' || match.on === false;
    context.commit('toggleFileOnOff', { file: match, on: onOff });
  },

  deleteFile(context, file) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'media' + file.url)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'File Deleted',
            message: 'The file was successfully deleted from the server.'
          });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  createDirectory(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'media-directories', {
          directory: payload.directory,
          name: payload.name
        })
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Directory Created',
            message: 'The directory was successfully created.'
          });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  deleteDirectory(context, directory) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'media-directories', {
          params: { directory: directory }
        })
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Directory Deleted',
            message: 'The directory was successfully deleted from the server.'
          });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  /*
   * Meta
   */
  getMeta(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'meta/')
        .then(function(response) {
          context.commit('setMeta', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  createMeta(context, meta) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'meta/', meta)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: 'Your new meta has been added.'
          });
          context.commit('createMeta', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  updateMeta(context, meta) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'meta/' + meta.id, meta)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: 'Your new meta has been updated.'
          });
          context.commit('updateMeta', { meta: meta, data: response.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  deleteMeta(context, meta) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'meta/' + meta.id)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: 'The meta has been deleted.'
          });
          context.commit('deleteMeta', meta);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  /*
   * Models
   */
  getModels(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'models/')
        .then(function(response) {
          context.commit('setModels', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getModelSettings(context, modelQuery) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'models/settings?' + modelQuery)
        .then(function(response) {
          context.commit('setModelSettings', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getModelRecords(context, { model, filters }) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(
          context.state.api.baseUrl +
            'models/query?class=' +
            model +
            '&' +
            commonUtils.buildFilterParams(filters)
        )
        .then(function(response) {
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  // Pages
  getPages(context, filters) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'pages/?' + commonUtils.buildFilterParams(filters))
        .then(function(response) {
          context.commit('setPages', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getPagesList(context, filters) {
    return new Promise((resolve, reject) => {
      let params = filters.hasOwnProperty('language_id')
        ? 'language_id=' + filters.language_id
        : '';
      window.axios
        .get(context.state.api.baseUrl + 'routes?' + params)
        .then(function(response) {
          context.commit('setPagesList', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getPage(context, id) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'pages/' + id)
        .then(function(response) {
          context.commit('appendPage', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  searchPages(context, search) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'pages-suggest/', { params: { term: search } })
        .then(function(response) {
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  copyPage(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'pages/' + payload.page.id + '/copy', payload.data)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: payload.data.title + ' has been copied from ' + payload.page.title + '.'
          });
          context.commit('createPage', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  translatePage(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'pages/' + payload.page.id + '/copy', payload.data)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message:
              payload.data.title +
              ' has been copied for translation from ' +
              payload.page.title +
              '.'
          });
          context.commit('createPage', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  createPage(context, page) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'pages/', page)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: page.title + ' has been created.'
          });
          context.commit('createPage', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  updatePage(context, payload) {
    return new Promise((resolve, reject) => {
      // TODO - Sanitize data
      // const data = commonUtils.sanitizePageData(payload.data);
      window.axios
        .put(context.state.api.baseUrl + 'pages/' + payload.data.id, payload.data)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: payload.data.title + ' has been saved.'
          });
          context.commit('updatePage', { page: payload.data, data: response.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  deletePage(context, page) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'pages/' + page.id)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: page.title + ' has been deleted.'
          });
          context.commit('deletePage', page);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  // This is the save used from the page editor
  savePage(context, page) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'pages/' + page.id, page)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: page.title + ' has been saved.'
          });
          context.commit('updatePage', { page: page, data: response.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  // Page versions
  copyPageVersion(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'page-versions', {
          page_version_id: payload.version.id,
          name: payload.version.name + ' Copy'
        })
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: payload.version.name + ' has been copied.'
          });
          context.commit('createPageVersion', { page: payload.page, data: response.data.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  deletePageVersion(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'page-versions/' + payload.version.id)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: payload.version.name + ' has been deleted.'
          });
          context.commit('deletePageVersion', { page: payload.page, version: payload.version });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  updatePageVersion(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'page-versions/' + payload.version.id, payload.version)
        .then(function(response) {
          context.commit('updatePageVersion', {
            page: payload.page,
            version: payload.version,
            data: response.data
          });
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: payload.version.name + ' has been saved.'
          });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  setPreviewModeInCurrentPage(context, payload) {
    context.commit('setPreviewModeInCurrentPage', payload);
  },

  // Mothership

  syncSites(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${
        context.state.mothership['api-key']
      }`;
      window.axios
        .post(`https://mothership.app/api/v1/sites/sync`, { sites: payload })
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Sync Complete!',
            message: 'All sites are registred with Mothership!'
          });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getSiteAnalytics(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${
        context.state.mothership['api-key']
      }`;
      window.axios
        .get(
          `https://mothership.app/api/v1/analytics/site?site_id=${payload.site}&start_date=${
            payload.dates.start
          }&end_date=${payload.dates.end}`
        )
        .then(function(response) {
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getPageAnalytics(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${
        context.state.mothership['api-key']
      }`;
      window.axios
        .get(
          `https://mothership.app/api/v1/analytics/page?site_id=${
            context.state.currentPage.site_id
          }&slug=${payload.slug}&start_date=${payload.dates.start}&end_date=${payload.dates.end}`
        )
        .then(function(response) {
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getPageAnalyticsTotals(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${
        context.state.mothership['api-key']
      }`;
      window.axios
        .get(
          `https://mothership.app/api/v1/analytics/page/totals?site_id=${
            context.state.currentPage.site_id
          }&slug=${payload.slug}&date=${payload.date}`
        )
        .then(function(response) {
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  getPendingChanges(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'mothership/pending-changes')
        .then(function(response) {
          context.commit('setChanges', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  // Sites
  getSites(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'sites/')
        .then(function(response) {
          context.commit('setSites', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  createSite(context, site) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'sites/', site)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: site.name + ' has been created.'
          });
          context.commit('createSite', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  updateSite(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'sites/' + payload.site.id, payload.data)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: payload.site.name + ' has been saved.'
          });
          context.commit('updateSite', { site: payload.site, data: response.data.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  deleteSite(context, site) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'sites/' + site.id)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: site.name + ' has been deleted.'
          });
          context.commit('deleteSite', site);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  // Slices
  getSlicesDirectories(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'slices-directories/')
        .then(function(response) {
          context.commit('setSlicesDirectories', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  createSlice(context, slice) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'slices/', slice)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: slice.name + ' has been created.'
          });
          context.commit('createSlice', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  updateSlice(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'slices/' + payload.slice.id, payload.data)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: payload.data.name + ' has been saved.'
          });
          context.commit('updateSlice', { slice: payload.slice, data: response.data.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  deleteSlice(context, slice) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'slices/' + slice.id)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: slice.name + ' has been deleted.'
          });
          context.commit('deleteSlice', slice);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  // Redirects
  getRedirects(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'redirects/')
        .then(function(response) {
          context.commit('setRedirects', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  createRedirect(context, redirect) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'redirects/', redirect)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: 'Redirect has been created.'
          });
          context.commit('createRedirect', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  updateRedirect(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'redirects/' + payload.redirect.id, payload.data)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: 'Redirect has been saved.'
          });
          context.commit('updateRedirect', { redirect: payload, data: response.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  deleteRedirect(context, redirect) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'redirects/' + redirect.id)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: 'Redirect has been deleted.'
          });
          context.commit('deleteRedirect', redirect);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  // Users
  getUsers(context) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(context.state.api.baseUrl + 'users/')
        .then(function(response) {
          context.commit('setUsers', response.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  createUser(context, user) {
    return new Promise((resolve, reject) => {
      window.axios
        .post(context.state.api.baseUrl + 'users/', user)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: user.name + ' has been created.'
          });
          context.commit('createUser', response.data.data);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  updateUser(context, payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .put(context.state.api.baseUrl + 'users/' + payload.user.id, payload.data)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: payload.data.name + ' has been saved.'
          });
          context.commit('updateUser', { user: payload, data: response.data });
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  },

  deleteUser(context, user) {
    return new Promise((resolve, reject) => {
      window.axios
        .delete(context.state.api.baseUrl + 'users/' + user.id)
        .then(function(response) {
          devise.$bus.$emit('showMessage', {
            title: 'Success!',
            message: user.name + ' has been deleted.'
          });
          context.commit('deleteUser', user);
          resolve(response);
        })
        .catch(function(error) {
          devise.$bus.$emit('showError', error);
        });
    }).catch(function(error) {
      devise.$bus.$emit('showError', error);
    });
  }
};

export default actions;
