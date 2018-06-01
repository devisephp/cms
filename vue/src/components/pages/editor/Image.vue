<template>
  <field-editor :options="options" v-model="localValue" :showEditor="showEditor" @toggleShowEditor="toggleEditor">

    <template slot="preview">
      <span v-if="localValue.url === null || localValue.url === ''" class="dvs-italic">
        Currently No Value
      </span>
      <img :src="localValue.url" class="dvs-max-w-2xs" :alt="localValue.url"><br>
    </template>

    <template slot="editor">
      <label class="dvs-mt-4 dvs-large-label">Image</label>
      <div class="dvs-flex dvs-items-center">
        <input type="text" v-model="localValue.url" :maxlength="getMaxLength" v-on:input="updateValue()">
        <i class="ion-images dvs-text-3xl dvs-ml-4 dvs-cursor-pointer" @click="launchMediaManager($event)"></i>
      </div>
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
      localValue: {},
      showEditor: false
    }
  },
  mounted () {
    this.localValue = this.value
  },
  methods: {
    toggleEditor () {
      this.showEditor = !this.showEditor
    },
    updateValue () {
      // Emit the number value through the input event
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    },
    launchMediaManager (event) {
      devise.$bus.$emit('devise-launch-media-manager', {
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
