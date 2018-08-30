<template>
  <div>
    <div class="dvs-absolute dvs-z-9999" :style="controlStyles" v-if="editorMode">
      <div @click="toggleEditor()" class="dvs-flex dvs-items-center">
        <settings-icon class="dvs-gear-1 dvs-cursor-pointer" w="30px" h="30px" />
      </div>
      <div class="dvs-absolute dvs-p-8 dvs-z-50 dvs-min-w-96 dvs-z-50 dvs-pin-r dvs-mr-8 dvs-rounded" :style="theme.panelCard" v-if="showEditor">
        <fieldset class="dvs-fieldset">
          <label>Margins</label>
        </fieldset>
        <div class="dvs-flex">
          <fieldset class="dvs-fieldset dvs-mr-1 dvs-text-center">
            <label>T</label>
            <input type="number" :value="getStyle('margin', 'top')" @keyup="setMargin('top', $event)" @click="setMargin('top', $event)">
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mr-1 dvs-text-center">
            <label>R</label>
            <input type="number" :value="getStyle('margin', 'right')" @keyup="setMargin('right', $event)" @click="setMargin('right', $event)">
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mr-1 dvs-text-center">
            <label>B</label>
            <input type="number" :value="getStyle('margin', 'bottom')" @keyup="setMargin('bottom', $event)" @click="setMargin('bottom', $event)">
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mr-1 dvs-text-center">
            <label>L</label>
            <input type="number" :value="getStyle('margin', 'left')" @keyup="setMargin('left', $event)" @click="setMargin('left', $event)">
          </fieldset>
        </div>

        <fieldset class="dvs-fieldset dvs-mt-8">
          <label>Padding</label>
        </fieldset>
        <div class="dvs-flex">
          <fieldset class="dvs-fieldset dvs-mr-1 dvs-text-center">
            <label>T</label>
            <input type="number" :value="getStyle('padding', 'top')" @keyup="setPadding('top', $event)" @click="setPadding('top', $event)">
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mr-1 dvs-text-center">
            <label>R</label>
            <input type="number" :value="getStyle('padding', 'right')" @keyup="setPadding('right', $event)" @click="setPadding('right', $event)">
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mr-1 dvs-text-center">
            <label>B</label>
            <input type="number" :value="getStyle('padding', 'bottom')" @keyup="setPadding('bottom', $event)" @click="setPadding('bottom', $event)">
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mr-1 dvs-text-center">
            <label>L</label>
            <input type="number" :value="getStyle('padding', 'left')" @keyup="setPadding('left', $event)" @click="setPadding('left', $event)">
          </fieldset>
        </div>

        <fieldset class="dvs-fieldset dvs-mt-8">
          <label>Background Color</label>
        </fieldset>
        <sketch-picker v-model="backgroundColor" @input="setBackground(backgroundColor)" @ok="setBackground(backgroundColor)" />

        <div class="dvs-mt-8 dvs-flex">
          <button class="dvs-btn dvs-mr-4" :style="theme.actionButton" @click="toggleEditor">
            Done
          </button>
          <button class="dvs-btn dvs-mr-4" :style="theme.actionButtonGhost" @click="resetStyles">
            Reset All Values
          </button>

        </div>
      </div>

    </div>
    <component 
      v-if="sliceComponent !== null"
      :style="styles"
      :is="currentView" 
      :devise="deviseForSlice"
      :breakpoint="breakpoint"
      :slices="devise.slices" 
      :models="pageData"
      :component="sliceComponent"
      ref="component">
    </component>
  </div>
</template>

<script>

import ResizeObserver from 'resize-observer-polyfill';
var tinycolor = require('tinycolor2')
import { Photoshop, Sketch } from 'vue-color'

import Slice from './Slice'
import {mapGetters, mapActions} from 'vuex'

import Strings from './mixins/Strings'
import SettingsIcon from 'vue-ionicons/dist/ios-settings.vue'

export default {
  name: 'DeviseSlice',
  data () {
    return {
      backgroundColor: null,
      mounted: false,
      showEditor: false,
      sliceEl: null,
      sliceComponent: null,
      resizeObserver: null,
      controlStyles: {
        right: null,
        top: null
      }
    }
  },
  created () {
    this.hydrateMissingProperties()
    this.backgroundColor = tinycolor('#fff').toRgb()
    this.sliceComponent = this.component(this.devise.metadata.name)
  },
  mounted () {
    let self = this
    this.mounted = true
    this.sliceEl = this.$refs.component.$el

    if (typeof this.devise.settings === 'undefined') {
      this.$set(this.devise, 'settings', {})
    }

    if (this.devise.settings.length < 1) {
      this.resetStyles()
    }

    if (typeof this.devise.settings.backgroundColor !== 'undefined') {
      this.backgroundColor = tinycolor(this.devise.settings.backgroundColor).toRgb()
    }

    this.addListeners ()

    if (this.editorMode) {
      this.checkMediaSizesForRegeneration ()
    }
  },
  methods: {
    ...mapActions('devise', [
      'regenerateMedia'
    ]),
    addListeners () {
      let self = this

      this.resizeObserver = new ResizeObserver( entries => {
        let styles = {}
        for (let entry of entries) {
          let cs = window.getComputedStyle(entry.target);
          let rect = this.sliceEl.getBoundingClientRect();

          this.controlStyles.right = `${entry.contentRect.right - entry.contentRect.width + 15}px`
          this.controlStyles.top = `${rect.top + window.scrollY + 15}px`

          if (entry.target.handleResize)
              entry.target.handleResize(entry);
        }
      })

      this.resizeObserver.observe(this.sliceEl)
    },
    hydrateMissingProperties () {
      let fields = this.sliceConfig(this.devise).fields

      if (fields) {
        // Loop through the fields for this slice and check to see that all the
        // fields are present. If they aren't it's just because they haven't been
        // hydrated via the editor yet.
        for (var field in fields) {
          // Ok, so the property is missing from the slice.fields object so we're
          // going to add in a stub for the render.
            this.addMissingProperty(field)
          if (!this.deviseForSlice.hasOwnProperty(field)) {
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
      // We just add all the properties to ensure there are not undefined props down the line
      let defaultProperties = {
        text: null,
        url: null,
        media: {},
        target: null,
        color: null,
        checked: null,
        enabled: true
      }
      
      let mergedData = Object.assign({}, defaultProperties, this.deviseForSlice[field])
      this.$set(this.deviseForSlice, field, mergedData)     
    },
    addFieldConfigurations (fields, field) {
      for (var pp in fields[field]) {
        if (!this.deviseForSlice[field].hasOwnProperty(pp)) {
          this.$set(this.deviseForSlice[field], pp, fields[field][pp])
        }
      }
    },
    setDefaults (property, defaults) {
      // loop through the defaults and apply them to the field
      for (var d in defaults) {
        this.$set(this.deviseForSlice[property], d, defaults[d])
      }
    },
    toggleEditor () {
      this.showEditor = !this.showEditor
    },
    resetStyles () {
      this.$set(this.deviseForSlice, 'settings', {})
      this.backgroundColor = tinycolor('#fff').toRgb()
      this.showEditor = false
    },
    setMargin (position, event) {
      let value = event.target.value

      if (typeof this.deviseForSlice.settings.margin === 'undefined') {
        this.$set(this.deviseForSlice.settings, 'margin', {})
      }

      this.$set(this.deviseForSlice.settings.margin, position, value)
    },
    setPadding (position, event) {
      let value = event.target.value

      if (typeof this.deviseForSlice.settings.padding === 'undefined') {
        this.$set(this.deviseForSlice.settings, 'padding', {})
      }

      this.$set(this.deviseForSlice.settings.padding, position, value)
    },
    getStyle (type, position) {
      if (type === 'margin' || type === 'padding') {
        if (typeof this.deviseForSlice.settings[type] !== 'undefined') {
          if (typeof this.deviseForSlice.settings[type][position] !== 'undefined') {
            return this.deviseForSlice.settings[type][position]
          }
        }
        return 0
      }
    },
    setBackground (color) {
      this.$set(this.deviseForSlice.settings, 'backgroundColor', `rgba(${color.rgba.r},${color.rgba.g},${color.rgba.b},${color.rgba.a})`)
    },
    checkMediaSizesForRegeneration () {
      // If the current slice even has fields
      if (typeof this.currentView.fields !== 'undefined') {
        for (var fieldName in this.currentView.fields) {
          const field = this.currentView.fields[fieldName]

          // If the field is an image
          if (field.type === 'image') {

            // If sizes are defined on the image configuration and an image has already been selected
            if (typeof field.sizes !== 'undefined' && typeof this.devise[fieldName].media === 'object') {
              
              // Build the sizes needed
              let mediaRequest = {"sizes": {}}

              // Check if all the sizes in the configuration are present in the media property
              for (var sizeName in field.sizes) {
                if (typeof this.devise[fieldName].media[sizeName] === 'undefined') {
                  mediaRequest.sizes[sizeName] = field.sizes[sizeName]
                }
              }


              // If there are any sizes needed
              if (Object.keys(mediaRequest.sizes).length > 0) {
                // Build the request payload
                let payload = {
                  sizes: mediaRequest,
                  instanceId: this.devise.metadata.instance_id,
                  fieldName: fieldName,
                }
                
                this.regenerateMedia(payload).then(function () {
                  devise.$bus.$emit('showMessage', {
                    title: 'New Images Generated',
                    message: 'Pro tip: Some new sizes were generated for a slice you were working on. You may need to refresh.'
                  })
                })
              }
            }
          }
        }
      }
    }
  },
  computed: {
    ...mapGetters('devise', [
      'component',
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
    styles () {
      var styles = {}

      if (typeof this.deviseForSlice.settings === 'undefined') {
        this.$set(this.deviseForSlice, 'settings', {})
      }

      let backgroundColor = this.deviseForSlice.settings.backgroundColor
      let margin = this.deviseForSlice.settings.margin
      let padding = this.deviseForSlice.settings.padding

      if (typeof backgroundColor !== 'undefined') {
        styles.backgroundColor = backgroundColor
      }

      if (typeof margin !== 'undefined') {
        
        if (typeof margin.top !== 'undefined') {
          styles.marginTop = `${margin.top}px`
        }
        if (typeof margin.right !== 'undefined') {
          styles.marginRight = `${margin.right}px`
        }
        if (typeof margin.bottom !== 'undefined') {
          styles.marginBottom = `${margin.bottom}px`
        }
        if (typeof margin.left !== 'undefined') {
          styles.marginLeft = `${margin.left}px`
        }
      }

      if (typeof padding !== 'undefined') {

        if (typeof padding.top !== 'undefined') {
          styles.paddingTop = `${padding.top}px`
        }
        if (typeof padding.right !== 'undefined') {
          styles.paddingRight = `${padding.right}px`
        }
        if (typeof padding.bottom !== 'undefined') {
          styles.paddingBottom = `${padding.bottom}px`
        }
        if (typeof padding.left !== 'undefined') {
          styles.paddingLeft = `${padding.left}px`
        }
      }

      return styles
    },
    currentView () {
      if (this.devise.config) {
        return deviseSettings.$deviseComponents[this.devise.name]
      }
      return deviseSettings.$deviseComponents[this.devise.metadata.name]
    }
  },
  props: [
    'editorMode'
  ],
  mixins: [Strings],
  components: {
    Slice,
    SettingsIcon,
    'sketch-picker': Sketch
  }
}
</script>
