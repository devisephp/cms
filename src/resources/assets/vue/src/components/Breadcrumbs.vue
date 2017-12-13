<template>
  <div class="w-full flex items-center">
    <template v-if="currentDirectory !== ''">
      <span class="cursor-pointer pr-2" @click="goToHome()">Home</span>
      <template v-for="(dir, key) in directoriesObj">
        &gt; <span class="cursor-pointer px-2" @click="chooseDirectory(key)">{{ dir }}</span>
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
