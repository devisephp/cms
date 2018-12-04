<template>
  <div>
    <div>
      <select @change="chooseDirectory">
        <option>Choose a Directory</option>
        <option
          v-for="(directory, key) in this.allDirectories"
          :value="key"
          :key="key"
        >{{ directory.name }}</option>
      </select>
    </div>
    <div class="dvs-flex dvs-pb-8">
      <div
        class="dvs-w-full dvs-flex dvs-flex-wrap dvs-justify-start dvs-my-4"
        v-if=" currentDirectoryInformation['files'].length > 0"
      >
        <div
          class="dvs-cursor-pointer dvs-w-1/3 dvs-flex dvs-flex-col dvs-justify-between dvs-align-items dvs-p-2 dvs-rounded-sm"
          @click="toggleSelectSlice(file)"
          v-for="(file, key) in currentDirectoryInformation['files']"
          :key="key"
        >
          <div :style="isSelected(file)" class="dvs-p-4">
            <slice-diagram :file="file" :height-of-preview="200"></slice-diagram>
            <div class="dvs-cursor-pointer">{{ file.name }}</div>
            <div class="dvs-font-mono dvs-text-xs">({{ file.value }})</div>
          </div>
        </div>
      </div>
      <div
        class="dvs-cursor-pointer dvs-w-1/3 dvs-flex dvs-flex-col dvs-justify-between dvs-align-items dvs-p-2 dvs-rounded-sm"
        v-else
      >No files in this directory</div>
    </div>
  </div>
</template>

<script>
import SliceDiagram from './SliceDiagram';

import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      directoryStack: []
    };
  },
  methods: {
    chooseDirectory(event) {
      let key = event.target.value;
      let pathString = this.allDirectories[key].path;
      this.directoryStack = pathString.split('.');
    },
    getDirectoryFiles(directories, directory) {
      directory = directories.find(dir => dir.dirName === directory);
      return directory;
    },
    getDirectories(directories, level) {
      let dirs = [];

      directories.map(dir => {
        dir.name = '\xa0'.repeat(level * 3) + dir.name;
        dirs.push(dir);

        if (dir.directories && dir.directories.length > 0) {
          dirs = dirs.concat(this.getDirectories(dir.directories, level + 1));
        }
      });

      return dirs;
    },
    toggleSelectSlice(slice) {
      if (!this.value || slice.value !== this.value.value) {
        this.$emit('input', slice);
      } else {
        this.$emit('input', null);
      }
    },
    isSelected(file) {
      if (this.value !== null) {
        if (file.value === this.value.value) {
          return {
            color: this.theme.panelCard.background,
            backgroundColor: this.theme.actionButton.background
          };
        }
      }

      return { backgroundColor: this.theme.panelCard.background };
    }
  },
  computed: {
    ...mapGetters('devise', ['slicesDirectories']),
    currentDirectoryInformation() {
      let self = this;
      var directoryContents = this.slicesDirectories;

      this.directoryStack.forEach(dir => {
        directoryContents = self.getDirectoryFiles(directoryContents['directories'], dir);
      });

      return directoryContents;
    },
    allDirectories() {
      var directoryTree = this.slicesDirectories;

      return this.getDirectories(directoryTree.directories, 0);
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
};
</script>
