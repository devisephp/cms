<template>
  <field-editor :options="options" v-model="localValue" :showEditor="showEditor" @toggleShowEditor="toggleEditor" @cancel="cancel">

    <template slot="preview">
      <span v-if="localValue.text === null || localValue.text === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div><a :href="localValue.href" :target="localValue.target">localValue.text</a></div>
    </template>

    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <label>Label</label>
        <input type="text" class="dvs-mb-4" v-model="localValue.text" v-on:input="updateValue()">
      </fieldset>

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
        <fieldset class="dvs-fieldset">
          <label>URL</label>
          <input type="text" v-model="localValue.href" v-on:input="updateValue()">
        </fieldset>
      </template>
      <template v-if="localValue.mode === 'page'">
        <fieldset class="dvs-fieldset">
          <label>Page</label>
          <input type="text" v-model="localValue.pageId" v-on:input="updateValue()">
        </fieldset>
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
      localValue: {},
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
      this.localValue.mode = this.originalValue.mode
      this.localValue.text = this.originalValue.text
      this.localValue.href = this.originalValue.href
      this.localValue.pageId = this.originalValue.pageId
      this.updateValue()
      this.toggleEditor()
    },
    updateValue: function () {
      // Emit the number value through the input event
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    }
  },
  props: ['value', 'options'],
  components: {
    FieldEditor
  }
}
</script>
