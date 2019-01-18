export default {
  methods: {
    buildSliceDirectoryOptions (options, directory) {
      if (directory.files.length > 0) {
        options[directory.name] = []
        options[directory.name] = directory.files
      }

      for (var i = 0; i < directory.directories.length; i++) {
        options = Object.assign(
          {},
          options,
          this.buildSliceDirectoryOptions(options, directory.directories[i])
        )
      }

      return options
    }
  },
  computed: {
    sliceDirectoriesOptions () {
      var options = {}
      if (this.slicesDirectories.files && (this.slicesDirectories.files.length > 0 || this.slicesDirectories.directories.length > 0)) {
        options = this.buildSliceDirectoryOptions(options, this.slicesDirectories)
      }
      return options
    }
  }
}
