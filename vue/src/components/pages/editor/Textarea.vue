<template>
  <field-editor :options="options" v-model="localValue">

    <template slot="preview">
      <span v-if="localValue.text === null || localValue.text === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div>{{ clipString(localValue.text, 200, true) }}</div>
    </template>

    <template slot="editor">
      <textarea type="text" v-model="localValue.text" :maxlength="getMaxLength" v-on:input="updateValue()"></textarea>
    </template>

  </field-editor>
</template>

<script>
import FieldEditor from './Field'
import Strings from './../../../mixins/Strings'

export default {
  name: 'TextAreaEditor',
  data () {
    return {
      localValue: {}
    }
  },
  mounted () {
    this.localValue = this.value
  },
  methods: {
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
  mixins: [Strings],
  components: {
    FieldEditor
  }
}
</script>
