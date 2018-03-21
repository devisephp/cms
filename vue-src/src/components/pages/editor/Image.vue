<template>
  <field-editor :options="options" v-model="localValue">

    <template slot="preview">
      <span v-if="localValue.url === null || localValue.url === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div>{{ localValue.url }}</div>
    </template>

    <template slot="editor">
      <label class="dvs-mt-4 dvs-large-label">Image</label>
      <input type="text" v-model="localValue.url" :maxlength="getMaxLength" v-on:input="updateValue()" @focus="launchMediaManager($event)">
      <label class="dvs-mt-4 dvs-large-label">Alt Tag</label>
      <input type="text" v-model="localValue.alt" v-on:input="updateValue()">
    </template>

  </field-editor>
</template>

<script>
import FieldEditor from './Field'

export default {
  name: 'TextEditor',
  data () {
    return {
      localValue: {}
    }
  },
  mounted () {
    this.localValue = this.value
  },
  methods: {
    updateValue () {
      // Emit the number value through the input event
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    },
    launchMediaManager (event) {
      window.bus.$emit('devise-launch-media-manager', {
        callback: this.mediaSelected
      })
    },
    mediaSelected (media) {
      this.localValue.url = media.url
      this.updateValue()
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
