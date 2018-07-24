<template>
  <!-- We pass in the config to simplify what the template needs to traverse -->
  <component v-bind:is="currentView" :devise="deviseForSlice" :slices="devise.slices" :models="pageData" :responsive-breakpoint="breakpoint"></component>
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
      let fields = this.sliceConfig(this.devise).fields

      if (fields) {
        // Loop through the fields for this slice and check to see that all the
        // fields are present. If they aren't it's just because they haven't been
        // hydrated via the editor yet.
        for (var field in fields) {
          // Ok, so the property is missing from the slice.fields object so we're
          // going to add in a stub for the render.
          if (!this.devise.hasOwnProperty(field)) {
            this.addMissingProperty(field)
            this.addFieldConfigurations(fields, field)

            // If defaults are set then set them on top of the placeholder missing properties
            if (fields[field].default) {
              this.setDefaults(field, fields[field].default)
            }
          } else {
            // The property is present but we need to make sure all the custom set properties are moved over
            this.addFieldConfigurations(fields, field)
          }
        }
      }
    },
    addMissingProperty (field) {
      // We just add all the properties because.... why not?
      this.$set(this.devise, field, {
        text: null,
        url: null,
        target: null,
        color: null,
        checked: null,
        enabled: true
      })
    },
    addFieldConfigurations (fields, field) {
      for (var pp in fields[field]) {
        if (!this.devise[field].hasOwnProperty(pp)) {
          this.$set(this.devise[field], pp, fields[field][pp])
        }
      }
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
      'sliceConfig',
      'breakpoint'
    ]),
    deviseForSlice () {
      if (this.devise.config) {
        return this.devise.config
      }
      return this.devise
    },
    pageData () {
      if (deviseSettings.$page && deviseSettings.$page.data) {
        return deviseSettings.$page.data
      }
      return null
    },
    currentView () {
      if (this.devise.config) {
        return deviseSettings.$deviseComponents[this.devise.name]
      }
      return deviseSettings.$deviseComponents[this.devise.metadata.name]
    }
  },
  components: {
    Slice
  }
}
</script>
