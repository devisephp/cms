<template>
  <div class="dvs-fixed dvs-z-9999" style="top:30px; right:30px;">
    <div class="dvs-absolute dvs-p-8 dvs-z-50 dvs-min-w-96 dvs-z-50 dvs-pin-r dvs-mr-8 dvs-rounded shadow-lg" :style="theme.panelCard" v-if="showEditor">
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
        <button class="dvs-btn dvs-mr-4" :style="theme.actionButton" @click="closeEditor">
          Done
        </button>
        <button class="dvs-btn dvs-mr-4" :style="theme.actionButtonGhost" @click="resetStyles">
          Reset All Values
        </button>

      </div>
    </div>

  </div>
</template>

<script>
var tinycolor = require('tinycolor2')
import { Photoshop, Sketch } from 'vue-color'

import {mapGetters, mapActions} from 'vuex'

import Strings from './mixins/Strings'

export default {
  name: 'SliceSettings',
  data () {
    return {
      showEditor: false,
      backgroundColor: null,
      slice: {},
      controlStyles: {
        right: null,
        top: null
      }
    }
  },
  created () {
    this.backgroundColor = tinycolor('#fff').toRgb()
  },
  mounted () {
    let self = this

    // if (typeof this.devise.settings.backgroundColor !== 'undefined') {
    //   this.backgroundColor = tinycolor(this.devise.settings.backgroundColor).toRgb()
    // }

    this.addListeners ()

    if (this.editorMode) {
      this.checkMediaSizesForRegeneration ()
    }
  },
  methods: {
    addListeners () {
      let self = this
      deviseSettings.$bus.$on('open-slice-settings', function (slice) {
        self.showEditor = true
        Vue.set(self, 'slice', slice)
          // this.sliceComponent = this.component(this.devise.metadata.name)
      })
    },
    closeEditor () {
      this.showEditor = false
      Vue.set(this, 'slice', {})
    },
    resetStyles () {
      this.$set(this.slice, 'settings', {})
      this.backgroundColor = tinycolor('#fff').toRgb()
    },
    setMargin (position, event) {
      let value = event.target.value

      if (typeof this.slice.settings.margin === 'undefined') {
        this.$set(this.slice.settings, 'margin', {})
      }

      this.$set(this.slice.settings.margin, position, value)
    },
    setPadding (position, event) {
      let value = event.target.value

      if (typeof this.slice.settings.padding === 'undefined') {
        this.$set(this.slice.settings, 'padding', {})
      }

      this.$set(this.slice.settings.padding, position, value)
    },
    getStyle (type, position) {
      if (type === 'margin' || type === 'padding') {
        if (typeof this.slice.settings[type] !== 'undefined') {
          if (typeof this.slice.settings[type][position] !== 'undefined') {
            return this.slice.settings[type][position]
          }
        }
        return 0
      }
    },
    setBackground (color) {
      this.$set(this.slice.settings, 'backgroundColor', `rgba(${color.rgba.r},${color.rgba.g},${color.rgba.b},${color.rgba.a})`)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'component',
      'sliceConfig'
    ])
  },
  mixins: [Strings],
  components: {
    'sketch-picker': Sketch
  }
}
</script>

