<template>
  <field-editor :options="options" v-model="localValue" :showEditor="showEditor" @toggleShowEditor="toggleEditor" @cancel="cancel">
    <template slot="preview">
      <span v-if="localValue.value === null || localValue.value === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div>{{ label }} ({{localValue.value}})</div>
    </template>
    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <select v-model="localValue.value" v-on:input="updateValue()">
          <option :value="null">No Selection</option>
          <option v-for="(option, key) in options.options" :key="key" :value="key">{{ option }}</option>
        </select>
      </fieldset>
    </template>
  </field-editor>
</template>

<script>
import Strings from './../../../mixins/Strings'
import FieldEditor from './Field'

export default {
  name: 'SelectEditor',
  data () {
    return {
      localValue: {
        label: null,
        value: null,
        settings: {}
      },
      originalValue: null,
      showEditor: false
    }
  },
  mounted () {
    this.originalValue = Object.assign({}, this.value)
    this.localValue = this.value
  },
  methods: {
    toggleEditor () {
      this.showEditor = !this.showEditor
    },
    cancel () {
      this.localValue.value = this.originalValue.value
      this.localValue.label = this.originalValue.label
      this.updateValue()
      this.toggleEditor()
    },
    updateValue: function () {
      this.localValue.label = this.label
      // Emit the number value through the input event
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    }
  },
  computed: {
    label () {
      return this.options.options[this.localValue.value]
    }
  },
  props: ['value', 'options'],
  mixins: [Strings],
  components: {
    FieldEditor
  }
}
</script>
