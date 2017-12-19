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
  },

  toggleFileOnOff (state, payload) {
    payload.file.on = payload.on
    state.files.splice(state.files.indexOf(payload.file), 1, payload.file)
  },

  setMeta (state, payload) {
    state.meta = payload
  },

  deleteMeta (state, meta) {
    state.meta.splice(state.meta.indexOf(meta), 1)
  },

  appendMeta (state, meta) {
    state.meta.push(meta)
  },

  updateMeta (state, meta) {
    state.meta.splice(state.meta.indexOf(meta), 1, meta)
  }
}