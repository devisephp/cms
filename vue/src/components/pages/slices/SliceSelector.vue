<template>
<div class="dvs-flex dvs-pb-8">
  <div class="dvs-w-1/3 dvs-text-sm dvs-font-mono dvs-pr-8">
    <h6 class="dvs-mb-4 dvs-font-sans">Directories</h6>
    <ul class="dvs-list-reset dvs-flex dvs-flex-wrap dvs-mb-8">
      <li class="dvs-cursor-pointer" @click="jumpToTop">
        Back to Top
      </li>
    </ul>
    <ul class="dvs-list-reset">
      <li
        class="dvs-border-b dvs-py-2 dvs-cursor-pointer"
        :style="{borderColor: theme.panel.secondaryColor}"
        v-for="(directory, key) in currentDirectoryInformation['directories']" 
        @click="chooseDirectory(directory)" 
        :key="key">
        {{ directory.name }}
      </li>
    </ul>
  </div>
  <ul class="dvs-list-reset dvs-w-2/3">
    <li 
      class="dvs-cursor-pointer dvs-border-b dvs-py-2 dvs-flex dvs-justify-between dvs-align-items " 
      :style="{borderColor: theme.panel.secondaryColor}"
      @click="selectSlice(file)" 
      v-for="(file, key) in currentDirectoryInformation['files']" 
      :key="key">
        <div class="dvs-cursor-pointer" :style="isSelected(file)">{{ file.name }}</div>
        <div class="dvs-font-mono dvs-text-sm">({{ file.value }})</div>
    </li>
  </ul>
</div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      directoryStack: []
    }
  },
  methods: {
    chooseDirectory (directory) {
      this.directoryStack.push(directory.path)
    },
    jumpToTop () {
      this.directoryStack = []
    },
    getDirectoryContents (directories, directory) {
      return directories.find(dir => dir.path === directory)
    },
    selectSlice (slice) {
      this.$emit('input', slice)
    },
    isSelected (file) {
      if (this.value !== null) {
        if (file.value === this.value.value) {
          return {color: this.theme.actionButton.backgroundColor}
        }
      }
    }
  },
  computed: {
    ...mapGetters('devise', [
      'slicesDirectories'
    ]),
    currentDirectoryInformation () {
      let self = this
      var directoryContents = this.slicesDirectories

      this.directoryStack.forEach(function (dir) {
        directoryContents = self.getDirectoryContents(directoryContents['directories'], dir)
      })

      return directoryContents
    }
  },
  props: {
    value: {
      type: Object
    }
  }
}
</script>
