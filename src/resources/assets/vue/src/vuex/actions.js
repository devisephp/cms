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
        console.log('directories', response)
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
  }
}

export default actions
