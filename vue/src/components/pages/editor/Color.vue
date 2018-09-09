<template>
  <field-editor :options="options" v-model="localValue" ref="field" :showEditor="showEditor" @toggleShowEditor="toggleEditor" @cancel="cancel">
    <template slot="preview">
      <span v-if="color === null || color === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div class="dvs-flex dvs-items-center" v-else>
        <div class="dvs-w-4 dvs-h-4 dvs-rounded-full dvs-mr-4" :style="{'background-color': color}"></div>
        <div class="dvs-font-bold">{{ color }}</div>
      </div>
    </template>
    <template slot="editor">
      <input type="hidden" v-model="localValue.color" :maxlength="getMaxLength" v-on:input="updateValue()">
      <sketch-picker v-model="color" @input="updateColor(color)" @ok="selectColor(color)" @cancel="cancel" />
    </template>
  </field-editor>
</template>

<script>
var tinycolor = require('tinycolor2')
import { Sketch } from 'vue-color'

import FieldEditor from './Field'

export default {
  name: 'ColorEditor',
  data () {
    return {
      localValue: {},
      originalValue: null,
      color: null,
      showEditor: false
    }
  },
  mounted () {
    this.originalValue = Object.assign({}, this.value)
    this.localValue = this.value
    

    this.setDefault()
  },
  methods: {
    toggleEditor () {
      this.showEditor = !this.showEditor
    },
    cancel () {
      this.localValue.color = this.originalValue.color
      this.updateValue()
      this.toggleEditor()
    },
    setDefault () {
      if (this.localValue.color === null) {
        if (this.options.default) {
          this.color = this.convertColor(this.options.default)
        } else {
          this.color = this.convertColor('#000000')
        }
      } else {
        if (this.localValue.color !== null) {
          this.color = this.convertColor(this.localValue.color)
        } else {
          this.color = this.convertColor('#000000')
        }
      }
    },
    convertColor (color) {
      return tinycolor(color).toRgb()
    },
    updateColor (color) {
      this.color = color.rgba
      this.localValue.color = `rgba(${color.rgba.r},${color.rgba.g},${color.rgba.b},${color.rgba.a})`
    },
    selectColor (color) {
      this.color = color.hex
      this.localValue.color = `rgba(${color.rgba.r},${color.rgba.g},${color.rgba.b},${color.rgba.a})`
      this.updateValue()

      this.$refs.field.showEditor = false
    },
    updateValue () {
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    }
  },
  computed: {
    getMaxLength: function () {
      if (typeof this.settings !== 'undefined' && typeof this.settings.maxlength !== 'undefined') {
        return this.settings.maxlength
      }
      return ''
    }
  },
  props: ['value', 'options'],
  components: {
    FieldEditor,
    'sketch-picker': Sketch
  }
}
</script>
