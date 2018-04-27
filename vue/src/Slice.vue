<template>
  <!-- We pass in the config to simplify what the template needs to traverse -->
  <component v-bind:is="currentView" :devise="deviseForSlice" :slices="devise.slices" :models="pageData"></component>
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
      let config = this.sliceConfig(this.devise).config

      if (config) {
        // Loop through the config for this slice and check to see that all the
        // fields are present. If they aren't it's just because they haven't been
        // hydrated via the editor yet.
        for (var prop in config) {
          // Ok, so the property is missing from the slice.fields object so we're
          // going to add in a stub for the render.
          if (!this.devise.hasOwnProperty(prop)) {
            this.addMissingProperty(prop)

            // If defaults are set then set them on top of the placeholder missing properties
            if (config[prop].default) {
              this.setDefaults(prop, config[prop].default)
            }
          }
        }
      }
    },
    addMissingProperty (property) {
      // We just add all the properties because.... why not?
      this.$set(this.devise, property, {
        text: null,
        url: null,
        target: null,
        color: null,
        checked: null,
        enabled: false
      })
    },
    setDefaults (property, defaults) {
      // loop through the defaults and apply them to the field
      for (var d in defaults) {
        this.$set(this.devise[property], d, defaults[d])
      }
    }
  },
  computed: {
    ...mapGetters('devise', [
      'sliceConfig'
    ]),
    deviseForSlice () {
      if (this.devise.config) {
        return this.devise.config
      }
      return this.devise
    },
    pageData () {
      if (window.page && window.page.data) {
        return window.page.data
      }
      return null
    },
    currentView () {
      if (this.devise.config) {
        return window.deviseComponents[this.devise.name]
      }
      return window.deviseComponents[this.devise.metadata.name]
    }
  },
  components: {
    Slice
  }
}
</script>
