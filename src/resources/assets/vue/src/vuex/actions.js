import eventbus from './../event-bus/event-bus'

const actions = {

  // getAttributes (context) {
  //   return new Promise((resolve, reject) => {
  //     window.axios.get(context.state.api.baseUrl + 'attributes').then(function (response) {
  //       context.commit('updateAttributes', response.data.data)
  //       resolve(response)
  //     })
  //   }).catch(function (error) {
  //     eventbus.$emit('showError', error)
  //   })
  // },

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
  }
}

export default actions
