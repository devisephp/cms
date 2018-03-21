import commonUtils from './utils/common'

const actions = {

  /*
  * Languages
  */
  getLanguages (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'languages/').then(function (response) {
        context.commit('setLanguages', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  createLanguage (context, language) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'languages/', language).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: 'Your new language has been added.'})
        context.commit('createLanguage', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updateLanguage (context, language) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'languages/' + language.id, language).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: 'Your new language has been updated.'})
        context.commit('updateLanguage', {language: language, data: response.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  /*
  * Media Manager
  */

  setCurrentDirectory (context, directory) {
    return new Promise((resolve, reject) => {
      context.commit('setCurrentDirectory', directory)
      resolve()
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  getCurrentFiles (context, directory) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'media/' + context.state.currentDirectory).then(function (response) {
        context.commit('setFiles', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  getCurrentDirectories (context, directory) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'media-directories/' + context.state.currentDirectory).then(function (response) {
        context.commit('setDirectories', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  toggleFile (context, theFile) {
    let match = context.state.files.find(function (file) {
      return file.name === theFile.name
    })

    let onOff = typeof match.on === 'undefined' || match.on === false
    context.commit('toggleFileOnOff', {file: match, on: onOff})
  },

  openFile (context, theFile) {
    let match = context.state.files.find(function (file) {
      return file.name === theFile.name
    })

    context.commit('toggleFileOnOff', {file: match, on: true})
  },

  closeFile (context, theFile) {
    let match = context.state.files.find(function (file) {
      return file.name === theFile.name
    })

    context.commit('toggleFileOnOff', {file: match, on: false})
  },

  deleteFile (context, file) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'media/' + file.id)
        .then(function (response) {
          window.bus.$emit('showMessage', {title: 'File Deleted', message: 'The file was successfully deleted from the server.'})
          resolve(response)
        }).catch(function (error) {
          window.bus.$emit('showError', error)
        })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  createDirectory (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'media-directories', {directory: payload.directory, name: payload.name})
        .then(function (response) {
          window.bus.$emit('showMessage', {title: 'Directory Created', message: 'The directory was successfully created.'})
          resolve(response)
        }).catch(function (error) {
          window.bus.$emit('showError', error)
        })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  deleteDirectory (context, directory) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'media-directories', {params: {directory: directory}})
        .then(function (response) {
          window.bus.$emit('showMessage', {title: 'Directory Deleted', message: 'The directory was successfully deleted from the server.'})
          resolve(response)
        }).catch(function (error) {
          window.bus.$emit('showError', error)
        })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  /*
  * Meta
  */
  getMeta (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'meta/').then(function (response) {
        context.commit('setMeta', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  createMeta (context, meta) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'meta/', meta).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: 'Your new meta has been added.'})
        context.commit('createMeta', response.data.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updateMeta (context, meta) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'meta/' + meta.id, meta).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: 'Your new meta has been updated.'})
        context.commit('updateMeta', {meta: meta, data: response.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  deleteMeta (context, meta) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'meta/' + meta.id).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: 'The meta has been deleted.'})
        context.commit('deleteMeta', meta)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  /*
  * Models
  */
  getModels (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'models/').then(function (response) {
        context.commit('setModels', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  getModelSettings (context, modelQuery) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'models/settings?' + modelQuery).then(function (response) {
        context.commit('setModelSettings', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  getModelRecords (context, {model, filters}) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'models/query?' + model + '&' + commonUtils.buildFilterParams(filters)).then(function (response) {
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  // Pages
  getPages (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'pages/').then(function (response) {
        context.commit('setPages', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  searchPages (context, search) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'pages-suggest/', {params: {term: search}}).then(function (response) {
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  copyPage (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'pages/' + payload.page.id + '/copy', payload.data).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.data.title + ' has been copied from ' + payload.page.title + '.'})
        context.commit('createPage', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  translatePage (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'pages/' + payload.page.id + '/copy', payload.data).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.data.title + ' has been copied for translation from ' + payload.page.title + '.'})
        context.commit('createPage', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  createPage (context, page) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'pages/', page).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: page.title + ' has been created.'})
        context.commit('createPage', response.data.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updatePage (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'pages/' + payload.page.id, payload.data).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.data.title + ' has been saved.'})
        context.commit('updatePage', {page: payload.page, data: response.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  deletePage (context, page) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'pages/' + page.id).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: page.title + ' has been deleted.'})
        context.commit('deletePage', page)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  // Page versions
  copyPageVersion (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'page-versions', {'page_version_id': payload.version.id, name: payload.version.name + ' Copy'}).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.version.name + ' has been copied.'})
        context.commit('createPageVersion', {page: payload.page, data: response.data.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  deletePageVersion (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'page-versions/' + payload.version.id).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.version.name + ' has been deleted.'})
        context.commit('deletePageVersion', {page: payload.page, version: payload.version})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updatePageVersion (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'page-versions/' + payload.version.id, payload.version).then(function (response) {
        context.commit('updatePageVersion', {page: payload.page, version: payload.version, data: response.data})
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.version.name + ' has been saved.'})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  getAnalytics (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.get('http://104.236.153.6/api/v1/analytics').then(function (response) {
        context.commit('updatePageVersionAnalytics', {page: payload.page, version: payload.version, data: response.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  // Sites
  getSites (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'sites/').then(function (response) {
        context.commit('setSites', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  createSite (context, site) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'sites/', site).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: site.name + ' has been created.'})
        context.commit('createSite', response.data.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updateSite (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'sites/' + payload.site.id, payload.data).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.site.name + ' has been saved.'})
        context.commit('updateSite', {site: payload.site, data: response.data.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  deleteSite (context, site) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'sites/' + site.id).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: site.name + ' has been deleted.'})
        context.commit('deleteSite', site)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  // Slices
  getSlices (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'slices/').then(function (response) {
        context.commit('setSlices', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  createSlice (context, slice) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'slices/', slice).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: slice.name + ' has been created.'})
        context.commit('createSlice', response.data.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updateSlice (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'slices/' + payload.slice.id, payload.data).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.data.name + ' has been saved.'})
        context.commit('updateSlice', {slice: payload.slice, data: response.data.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  deleteSlice (context, slice) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'slices/' + slice.id).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: slice.name + ' has been deleted.'})
        context.commit('deleteSlice', slice)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  // Templates
  createTemplate (context, template) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'templates/', template).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: template.name + ' has been created.'})
        context.commit('createTemplate', response.data.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updateTemplate (context, template) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'templates/' + template.id, template).then(function (response) {
        context.commit('updateTemplate', {template: template, data: response.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  deleteTemplate (context, template) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'templates/' + template.id).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: template.name + ' has been deleted.'})
        context.commit('deleteTemplate', template)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updateCurrentTemplate (context, templateId) {
    context.commit('updateCurrentTemplate', templateId)
  },

  getTemplates (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'templates/').then(function (response) {
        context.commit('setTemplates', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  // Users
  getUsers (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'users/').then(function (response) {
        context.commit('setUsers', response.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  createUser (context, user) {
    return new Promise((resolve, reject) => {
      window.axios.post(context.state.api.baseUrl + 'users/', user).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: user.name + ' has been created.'})
        context.commit('createUser', response.data.data)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  updateUser (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.put(context.state.api.baseUrl + 'users/' + payload.user.id, payload.data).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: payload.data.name + ' has been saved.'})
        context.commit('updateUser', {user: payload, data: response.data})
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  },

  deleteUser (context, user) {
    return new Promise((resolve, reject) => {
      window.axios.delete(context.state.api.baseUrl + 'users/' + user.id).then(function (response) {
        window.bus.$emit('showMessage', {title: 'Success!', message: user.name + ' has been deleted.'})
        context.commit('deleteUser', user)
        resolve(response)
      }).catch(function (error) {
        window.bus.$emit('showError', error)
      })
    }).catch(function (error) {
      window.bus.$emit('showError', error)
    })
  }
}

export default actions
