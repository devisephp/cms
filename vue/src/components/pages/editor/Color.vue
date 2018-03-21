<template>
  <field-editor :options="options" v-model="localValue" ref="field">
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
      <input type="hidden" v-model="localValue.text" :maxlength="getMaxLength" v-on:input="updateValue()">
      <photoshop-picker v-model="color" @input="updateColor(color)" @ok="selectColor(color)" @cancel="cancel" />
    </template>
  </field-editor>
</template>

<script>
import { Photoshop } from 'vue-color'

import FieldEditor from './Field'

export default {
  name: 'ColorEditor',
  data () {
    return {
      originalColor: null,
      localValue: {},
      color: '#296BE9'
    }
  },
  mounted () {
    this.originalColor = Object.assign({}, this.value)
    this.localValue = this.value
    this.setDefault()
  },
  methods: {
    setDefault () {
      if (this.localValue.color === null) {
        if (this.options.default) {
          this.color = this.options.default
        }
      } else {
        this.color = this.localValue.color
      }
    },
    updateColor (color) {
      this.color = color.hex
      this.localValue.color = color.hex
    },
    cancel () {
      this.$emit('cancel')
      this.$refs.field.showEditor = false
    },
    selectColor (color) {
      this.color = color.hex
      this.localValue.color = color.hex
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
    'photoshop-picker': Photoshop
  }
}
</script>
