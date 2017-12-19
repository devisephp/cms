import eventbus from './../event-bus/event-bus'

const actions = {

  /*
  * Media Manager
  */

  setCurrentDirectory (context, directory) {
    return new Promise((resolve, reject) => {
      context.commit('setCurrentDirectory', directory)
      resolve()
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  getCurrentFiles (context, directory) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'media-manager/files/' + context.state.currentDirectory).then(function (response) {
        context.commit('setFiles', response.data)
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  getCurrentDirectories (context, directory) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'media-manager/directories/' + context.state.currentDirectory).then(function (response) {
        context.commit('setDirectories', response.data)
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
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
      window.axios.delete('/admin/media-manager/remove', {params: {id: file.id}})
      .then(function (response) {
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  createDirectory (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.post('/admin/media-manager/category/store', {category: payload.directory, name: payload.name})
      .then(function (response) {
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  deleteDirectory (context, directory) {
    return new Promise((resolve, reject) => {
      window.axios.get('/admin/media-manager/category/destroy', {params: {category: directory}})
      .then(function (response) {
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  /*
  * Meta Manager
  */

  getGlobalMeta (context) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'meta/global').then(function (response) {
        context.commit('setMeta', response.data)
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  getPageMeta (context, pageId) {
    return new Promise((resolve, reject) => {
      window.axios.get(context.state.api.baseUrl + 'meta/page/' + pageId).then(function (response) {
        context.commit('setMeta', response.data)
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  createMeta (context, payload) {
    return new Promise((resolve, reject) => {
      console.log(payload)
      window.axios.post('/admin/api/meta/store', {meta: payload.meta, pageId: payload.pageId})
      .then(function (response) {
        context.commit('appendMeta', response.data)
        resolve(response)
      }).catch(function (error) {
        eventbus.$emit('showError', error.response.data)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  updateMeta (context, payload) {
    return new Promise((resolve, reject) => {
      window.axios.put('/admin/api/meta/update/' + payload.meta.id, {meta: payload.meta, pageId: payload.pageId})
      .then(function (response) {
        context.commit('updateMeta', response.data)
        resolve(response)
      }).catch(function (error) {
        eventbus.$emit('showError', error.response.data)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  },

  deleteMeta (context, meta) {
    return new Promise((resolve, reject) => {
      window.axios.delete('/admin/api/meta/delete/' + meta.id)
      .then(function (response) {
        context.commit('deleteMeta', meta)
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  }

}

export default actions
