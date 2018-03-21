<template>
  <field-editor :options="options" v-model="localValue">

    <template slot="preview">
      <span v-if="localValue.checked === null || localValue.checked === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div>{{ localValue.checked ? 'On' : 'Off' }}</div>
    </template>

    <template slot="editor">
      <div class="dvs-flex dvs-items-center">
        <label class="dvs-mr-4">{{ options.label }}</label>
        <toggle v-model="localValue.checked" :id="randomString(8)"></toggle>
      </div>
    </template>

  </field-editor>
</template>

<script>
import FieldEditor from './Field'
import Strings from './../../../mixins/Strings'
import Toggle from './../../utilities/Toggle'

export default {
  name: 'CheckboxEditor',
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
  props: ['value', 'options'],
  mixins: [Strings],
  components: {
    FieldEditor,
    Toggle
  }
}
</script>
