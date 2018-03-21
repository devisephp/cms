<template>
  <field-editor :options="options" v-model="localValue">

    <template slot="preview">
      <span v-if="localValue.text === null || localValue.text === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div><a :href="localValue.href" :target="localValue.target">localValue.text</a></div>
    </template>

    <template slot="editor">
      <label>Label</label>
      <input type="text" class="dvs-mb-4" v-model="localValue.text" v-on:input="updateValue()">

      <label>Link Mode</label>
      <div class="dvs-flex">
        <input type="radio" class="dvs-w-auto dvs-mr-2" v-model="localValue.mode" value="url" v-on:input="updateValue()">
        <label>URL</label>
      </div>
      <div class="dvs-flex dvs-mb-4">
        <input type="radio" class="dvs-w-auto dvs-mr-2" v-model="localValue.mode" value="page" v-on:input="updateValue()">
        <label>Page</label>
      </div>

      <template v-if="localValue.mode === 'url'">
        <label>URL</label>
        <input type="text" v-model="localValue.href" v-on:input="updateValue()">
      </template>
      <template v-if="localValue.mode === 'page'">
        <label>Page</label>
        <input type="text" v-model="localValue.pageId" v-on:input="updateValue()">
      </template>
    </template>

  </field-editor>
</template>

<script>
import FieldEditor from './Field'

export default {
  name: 'LinkEditor',
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
  components: {
    FieldEditor
  }
}
</script>
