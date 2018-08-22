<template>
  <div>
    <div class="dvs-absolute dvs-z-50" :style="controlStyles" v-if="editorMode">
      <div @click="toggleEditor()">
        <settings-icon class="dvs-gear-1 dvs-cursor-pointer" w="30px" h="30px" />
      </div>
      <div class="dvs-absolute dvs-p-8 dvs-z-50 dvs-min-w-96" :style="infoBlockFlatTheme" style="top:40px;right:0px;" v-if="showEditor">
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
      :style="styles"
      v-bind:is="currentView" 
      :devise="deviseForSlice" 
      :slices="devise.slices" 
      :models="pageData"
      ref="component"
      :responsive-breakpoint="breakpoint">
    </component>
  </div>
</template>

<script>

import ResizeObserver from 'resize-observer-polyfill';
var tinycolor = require('tinycolor2')
import { Photoshop, Sketch } from 'vue-color'

import Slice from './Slice'
import {mapGetters} from 'vuex'

import Strings from './mixins/Strings'
import SettingsIcon from 'vue-ionicons/dist/ios-settings.vue'

export default {
  name: 'DeviseSlice',
  data () {
    return {
      backgroundColor: null,
      mounted: false,
      showEditor: false,
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
  },
  mounted () {
    let self = this
    this.mounted = true
    this.sliceComponent = this.$refs.component.$el

    if (typeof this.devise.settings === 'undefined') {
      this.$set(this.devise, 'settings', {})
    }

    if (this.devise.settings.length < 1) {
      this.resetStyles()
    }

    if (typeof this.devise.settings.backgroundColor !== 'undefined') {
      this.backgroundColor = tinycolor(this.devise.settings.backgroundColor).toRgb()
    }

    this.resizeObserver = new ResizeObserver( entries => {
      let styles = {}
      for (let entry of entries) {
        let cs = window.getComputedStyle(entry.target);
        let rect = this.sliceComponent.getBoundingClientRect();

        this.controlStyles.right = `${entry.contentRect.right - entry.contentRect.width + 15}px`
        this.controlStyles.top = `${rect.top + window.scrollY + 15}px`

        // console.log('watching element:', entry.target);
        // console.log(entry.contentRect.width,' is ', cs.width);
        // console.log(entry.contentRect.top,' is ', cs.paddingTop);
        if (entry.target.handleResize)
            entry.target.handleResize(entry);
      }
    })

    this.resizeObserver.observe(this.sliceComponent)
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
          if (!this.deviseForSlice.hasOwnProperty(field)) {
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
      // We just add all the properties to ensure there are not undefined props down the line

      let defaultProperties = {
        text: null,
        url: null,
        target: null,
        color: null,
        checked: null,
        enabled: true
      }

      this.$set(this.deviseForSlice, field, defaultProperties)      
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
    setBackground(color) {
      this.$set(this.deviseForSlice.settings, 'backgroundColor', `rgba(${color.rgba.r},${color.rgba.g},${color.rgba.b},${color.rgba.a})`)
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
