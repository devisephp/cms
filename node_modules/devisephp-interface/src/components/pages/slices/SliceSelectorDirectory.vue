<template>
  <div class="dvs-mb-8 dvs-w-full">
    <h3
      class="dvs-capitalize dvs-ml-2 dvs-mb-2 dvs-border-b dvs-w-full dvs-pb-2"
      :style="{color: theme.panel.color}"
    >
      {{ this.name }}
      <small>({{ this.directory.path }})</small>
    </h3>
    <div class="dvs-flex dvs-flex-wrap dvs-items-stretch">
      <div
        class="dvs-cursor-pointer dvs-w-1/3 dvs-mb-1 dvs-flex dvs-justify-stretch dvs-items-stretch dvs-p-2 dvs-rounded-sm dvs-self-stretch"
        @click="toggleSelectSlice(file)"
        :style="isSelected(file)"
        v-for="(file, key) in currentDirectoryFiles"
        :key="key"
      >
        <slice-selector-slice :file="file"></slice-selector-slice>
      </div>
    </div>
  </div>
</template>

<script>
import SliceSelectorSlice from './SliceSelectorSlice';

import { mapGetters } from 'vuex';

export default {
  methods: {
    isSelected(file) {
      if (this.value !== null) {
        if (file.value === this.value.value) {
          return {
            color: this.theme.panelCard.background,
            backgroundColor: this.theme.actionButton.background
          };
        }
      }

      return {
        backgroundColor: this.theme.panelCard.background
      };
    },
    toggleSelectSlice(slice) {
      if (!this.value || slice.value !== this.value.value) {
        this.$emit('input', slice);
      } else {
        this.$emit('input', null);
      }
    }
  },
  computed: {
    ...mapGetters('devise', ['componentFromView']),
    currentDirectoryFiles() {
      return this.directory.files;
    },
    name() {
      return this.directory.path.trim().replace('.', ' ');
    }
  },
  props: {
    directory: {
      required: true,
      type: Object
    },
    value: {
      required: true
    }
  },
  components: {
    SliceSelectorSlice
  }
};
</script>