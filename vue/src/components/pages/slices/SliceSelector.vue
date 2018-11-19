<template>
<div>
  <div>
    <a class="dvs-btn inline-block mb-4" :style="theme.actionButton" @click="jumpToTop">
      Back to Top
    </a>
    <select @change="chooseDirectory">
      <option>Choose a Directory</option>
      <option
        v-for="(directory, key) in currentDirectoryInformation['directories']" 
        :key="key">
        {{ directory.name }}
      </option>
    </select>
  </div>
  <div class="dvs-flex dvs-pb-8">

    <ul class="dvs-list-reset dvs-w-2/3 dvs-flex dvs-flex-wrap">
      <li 
        class="dvs-cursor-pointer dvs-py-2 dvs-flex dvs-flex-col dvs-justify-between dvs-align-items dvs-w-2/5 dvs-m-4 dvs-p-8 dvs-rounded-sm" 
        :class="{'dvs-w-full': isSelected(file)}"
        :style="{backgroundColor: theme.panelCard.background}"
        @click="toggleSelectSlice(file)" 
        v-for="(file, key) in currentDirectoryInformation['files']" 
        :key="key">
          <slice-diagram :file="file" :height-of-preview="200"></slice-diagram>
          <div class="dvs-cursor-pointer" :style="isSelected(file)">{{ file.name }}</div>
          <div class="dvs-font-mono dvs-text-xs">({{ file.value }})</div>
      </li>
    </ul>
  </div>
</div>
</template>

<script>

import SliceDiagram from './SliceDiagram'

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
    getDirectoryFiles (directories, directory) {
      directory = directories.find(dir => dir.path === directory)
      return directory['files']
    },
    toggleSelectSlice (slice) {
      if (!this.isSelected(slice)) {
        this.$emit('input', slice)
      } else {
        this.$emit('input', null)
      }
    },
    isSelected (file) {
      if (this.value !== null) {
        if (file.value === this.value.value) {
          return {color: this.theme.actionButton.background}
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
        directoryContents['files'] = self.getDirectoryFiles(directoryContents['directories'], dir)
      })

      return directoryContents
    }
  },
  props: {
    value: {
      type: Object
    }
  },
  components: {
    SliceDiagram
  }
}
</script>
