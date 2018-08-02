<template>
  <field-editor :options="options" v-model="localValue" :showEditor="showEditor" @toggleShowEditor="toggleEditor" @cancel="cancel">
asdfasdf
    <template slot="preview">
      <span v-if="localValue.text === null || localValue.text === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div>{{localValue.text}}</div>
    </template>

    <template slot="editor">
      <input type="number" v-model="localValue.text" :maxlength="getMaxLength" v-on:input="updateValue()">
    </template>

  </field-editor>
</template>

<script>
import FieldEditor from './Field'

export default {
  name: 'NumberEditor',
  data () {
    return {
      localValue: {},
      showEditor: false
    }
  },
  mounted () {
    this.localValue = this.value
  },
  methods: {
    toggleEditor () {
      this.originalValue = Object.assign({}, this.value)
      this.showEditor = !this.showEditor
    },
    cancel () {
      this.localValue.text = this.originalValue.text
      this.updateValue()
      this.toggleEditor()
    },
    updateValue: function () {
      // Emit the number value through the input event
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
    FieldEditor
  }
}
</script>
