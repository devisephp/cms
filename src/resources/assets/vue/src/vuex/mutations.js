export default {
  /*
  *
  * API and Connection Getters
  */
  setCurrentDirectory (state, directory) {
    state.currentDirectory = directory
  },

  setFiles (state, payload) {
    state.files = payload
  },

  setDirectories (state, payload) {
    state.directories = payload
  }
}
