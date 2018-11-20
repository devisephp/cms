<template>
<div>
  <div>
<<<<<<< HEAD
    <a class="dvs-btn inline-block mb-4" :style="theme.actionButton" @click="jumpToTop">
      Back to Top
    </a>
    <select @change="chooseDirectory">
      <option>Choose a Directory</option>
      <option
        v-for="(directory, key) in currentDirectoryInformation['directories']" 
=======
    <select @change="chooseDirectory">
      <option>Choose a Directory</option>
      <option
        v-for="(directory, key) in this.allDirectories" 
        :value="key"
>>>>>>> 9fbca0b37aed2e408c84aa31361e7e953df1abe2
        :key="key">
        {{ directory.name }}
      </option>
    </select>
  </div>
  <div class="dvs-flex dvs-pb-8">

<<<<<<< HEAD
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
=======
    <div class="dvs-w-full dvs-flex dvs-flex-wrap dvs-justify-start dvs-my-4"        v-if=" currentDirectoryInformation['files'].length > 0">
      <div 
        class="dvs-cursor-pointer dvs-w-1/3 dvs-flex dvs-flex-col dvs-justify-between dvs-align-items dvs-p-2 dvs-rounded-sm" 
        @click="toggleSelectSlice(file)" 

        v-for="(file, key) in currentDirectoryInformation['files']"
        :key="key">
          <div :style="isSelected(file)" class="p-4">
            <slice-diagram :file="file" :height-of-preview="200"></slice-diagram>
            <div class="dvs-cursor-pointer">{{ file.name }}</div>
            <div class="dvs-font-mono dvs-text-xs">({{ file.value }})</div>
          </div>
      </div>
    </div>
      <div class="dvs-cursor-pointer dvs-w-1/3 dvs-flex dvs-flex-col dvs-justify-between dvs-align-items dvs-p-2 dvs-rounded-sm"  v-else>
        No files in this directory
      </div>
>>>>>>> 9fbca0b37aed2e408c84aa31361e7e953df1abe2
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
    chooseDirectory (event) {
      let key = event.target.value
      let pathString = this.allDirectories[key].path
      this.directoryStack = pathString.split('.')
    },
    getDirectoryFiles (directories, directory) {
      console.log(directories, directory)
      directory = directories.find(dir => dir.dirName === directory)
      return directory
    },
<<<<<<< HEAD
    getDirectoryFiles (directories, directory) {
      directory = directories.find(dir => dir.path === directory)
      return directory['files']
    },
    toggleSelectSlice (slice) {
      if (!this.isSelected(slice)) {
=======
    getDirectories (directories, level) {
      let dirs = []

      directories.map((dir) => {
        dir.name = '\xa0'.repeat(level * 3) + dir.name
        dirs.push(dir)

        if (dir.directories && dir.directories.length > 0) {
          dirs = dirs.concat(this.getDirectories(dir.directories, level + 1))
        }
      })

      return dirs
    },
    toggleSelectSlice (slice) {
      if (!this.value || slice.value !== this.value.value) {
>>>>>>> 9fbca0b37aed2e408c84aa31361e7e953df1abe2
        this.$emit('input', slice)
      } else {
        this.$emit('input', null)
      }
    },
    isSelected (file) {
      if (this.value !== null) {
        if (file.value === this.value.value) {
          return {
            color: this.theme.panelCard.background,
            backgroundColor: this.theme.actionButton.background
          }
        }
      } 
      
      return {backgroundColor: this.theme.panelCard.background}
    }
  },
  computed: {
    ...mapGetters('devise', [
      'slicesDirectories'
    ]),
    currentDirectoryInformation () {
      let self = this
      var directoryContents = this.slicesDirectories

<<<<<<< HEAD
      this.directoryStack.forEach(function (dir) {
        directoryContents['files'] = self.getDirectoryFiles(directoryContents['directories'], dir)
=======
      this.directoryStack.forEach((dir) => {
        console.log('directoryContents', directoryContents)
        directoryContents = self.getDirectoryFiles(directoryContents['directories'], dir)
>>>>>>> 9fbca0b37aed2e408c84aa31361e7e953df1abe2
      })

      console.log('end', directoryContents)

      return directoryContents
    },
    allDirectories () {
      var directoryTree = this.slicesDirectories

      return this.getDirectories(directoryTree.directories, 0)
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
