<template>
  <div class="dvs-w-full dvs-flex dvs-flex-wrap dvs-items-center">
    <template v-if="currentDirectory !== ''">
      <span class="dvs-cursor-pointer dvs-mr-1 dvs-mb-1" @click="goToHome()">Home</span>
      <template v-for="(dir, key) in directoriesObj">
      <span class="dvs-mr-1 dvs-mb-1">&gt;</span> <span class="dvs-cursor-pointer dvs-mr-1 dvs-mb-1" @click="chooseDirectory(key)">{{ dir }}</span>
      </template>
    </template>
  </div>
</template>

<script>
export default {
  methods: {
    chooseDirectory (directory) {
      this.$emit('chooseDirectory', directory)
    },
    goToHome () {
      this.chooseDirectory('')
    }
  },
  computed: {
    directoriesObj () {
      var directoriesObj = {}
      var directoriesStr = ''
      var directoriesArr = this.currentDirectory.split('.')

      for (var i = 0; i < directoriesArr.length; i++) {
        directoriesStr += directoriesArr[i]
        directoriesObj[directoriesStr] = directoriesArr[i]
        directoriesStr += '.'
      }

      return directoriesObj
    }
  },
  props: [
    'currentDirectory'
  ]
}
</script>
