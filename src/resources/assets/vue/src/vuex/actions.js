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
      window.axios.get(context.state.api.baseUrl + 'media-manager/folder/' + context.state.currentDirectory).then(function (response) {
        console.log('adfasdasdf', response)
        context.commit('setFiles', response.data.data)
        resolve(response)
      })
    }).catch(function (error) {
      eventbus.$emit('showError', error)
    })
  }
}

export default actions
