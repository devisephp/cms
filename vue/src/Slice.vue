<template>
  <component v-if="!slice.config" v-bind:is="currentView" :devise="slice"></component>
  <component v-else v-bind:is="currentView" :devise="slice.config"></component>
</template>

<script>

import Slice from './Slice'
import {mapGetters} from 'vuex'

export default {
  name: 'DeviseSlice',
  created () {
    this.hydrateMissingProperties()
  },
  methods: {
    hydrateMissingProperties () {
      let config = this.sliceConfig(this.slice).config

      // Loop through the config for this slice and check to see that all the
      // fields are present. If they aren't it's just because they haven't been
      // hydrated via the editor yet.
      for (var prop in config) {
        // Ok, so the property is missing from the slice.fields object so we're
        // going to add in a stub for the render.
        if (!this.slice.hasOwnProperty(prop)) {
          this.addMissingProperty(prop)
        }
      }
    },
    addMissingProperty (property) {
      // We just add all the properties because.... why not?
      this.$set(this.slice, property, {
        text: null,
        url: null,
        target: null,
        color: null,
        checked: null
      })
    }
  },
  computed: {
    ...mapGetters('devise', [
      'sliceConfig'
    ]),
    currentView () {
      if (this.slice.config) {
        return window.deviseComponents[this.slice.name]
      }
      return window.deviseComponents[this.slice.metadata.name]
    }
  },
  components: {
    Slice
  },
  props: ['slice']
}
</script>
