<template>
  <div class="dvs-relative dvs-mt-8 dvs-mb-8">
    <div class="dvs-fixed dvs-pin-t dvs-pin-l dvs-pin-r dvs-p-8 z-10" :style="theme.panelCard">
      <fieldset class="dvs-fieldset">
        <label>Filter</label>
        <div class="dvs-flex">
          <input type="text" v-model="filter">
          <button
            class="dvs-btn dvs-ml-2 dvs-min-w-64"
            @click="filter=null"
            :style="theme.actionButton"
          >Clear Filter</button>
        </div>
      </fieldset>
    </div>
    <div class="dvs-flex dvs-pb-8 dvs-py-16">
      <div
        class="dvs-w-full dvs-flex dvs-flex-wrap dvs-items-stretch flex-grow dvs-justify-start dvs-my-4"
        v-if=" this.allDirectories.length > 0"
      >
        <slice-selector-directory
          v-for="(directory, n) in this.allDirectories"
          :key="n"
          :directory="directory"
          :value="value"
          @input="update"
        ></slice-selector-directory>
      </div>
      <div
        class="dvs-cursor-pointer dvs-w-1/3 dvs-flex dvs-flex-col dvs-justify-between dvs-align-items dvs-p-2 dvs-rounded-sm"
        v-else
      >No files in this directory</div>
    </div>
  </div>
</template>

<script>
import SliceSelectorDirectory from './SliceSelectorDirectory';

import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      directoryStack: [],
      filter: null
    };
  },
  methods: {
    getDirectoryFiles(directories, directory) {
      directory = directories.find(dir => dir.dirName === directory);
      return directory;
    },
    getDirectories(directories) {
      let dirs = [];

      directories.map(dir => {
        dirs.push(dir);

        if (dir.directories && dir.directories.length > 0) {
          dirs = dirs.concat(this.getDirectories(dir.directories));
        }
      });

      return dirs;
    },
    filteredFiles(directory) {
      let filter = this.filter.toLowerCase();
      return directory.files.filter(file => {
        if (file.name.toLowerCase().includes(filter)) {
          return true;
        }
      });
    },
    update(newValue) {
      this.$emit('input', newValue);
    }
  },
  computed: {
    ...mapGetters('devise', ['slicesDirectories']),
    allDirectories() {
      if (this.filter !== null && this.filter !== '') {
        return this.filteredDirectories;
      }

      return this.getDirectories(JSON.parse(JSON.stringify(this.slicesDirectories.directories)), 0);
    },
    filteredDirectories() {
      let filter = this.filter.toLowerCase();
      let directories = this.getDirectories(
        JSON.parse(JSON.stringify(this.slicesDirectories.directories)),
        0
      ).filter(directory => {
        if (directory.name.toLowerCase().includes(filter)) {
          return true;
        }
        let files = this.filteredFiles(directory);
        if (files.length > 0) {
          return true;
        }
      });

      return directories;
    }
  },
  props: {
    value: {
      type: Object
    }
  },
  components: {
    SliceSelectorDirectory
  }
};
</script>
