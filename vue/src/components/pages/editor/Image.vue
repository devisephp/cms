<template>
  <field-editor :options="options" v-model="localValue" :showEditor="showEditor" @toggleShowEditor="toggleEditor" @cancel="cancel">

    <template slot="preview">
      <span v-if="localValue.url === null || localValue.url === ''" class="dvs-italic">
        Currently No Value
      </span>
      <img :src="localValue.url" class="dvs-max-w-2xs" :alt="localValue.url"><br>
    </template>

    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <label class="dvs-mt-4 dvs-large-label">Image</label>
        <div class="dvs-flex dvs-items-center">
          <input type="text" v-model="localValue.url" :maxlength="getMaxLength" v-on:input="updateValue()">
          <div @click="launchMediaEditor($event)">
            <create-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px" />
          </div>
          <div @click="launchMediaManager($event)">
            <images-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px" />
          </div>
        </div>
      </fieldset>
      <fieldset class="dvs-fieldset">
        <label class="dvs-mt-4 dvs-large-label">Alt Tag</label>
        <input type="text" v-model="localValue.alt" v-on:input="updateValue()">
      </fieldset>
    </template>

  </field-editor>
</template>

<script>
import FieldEditor from './Field'
import ImagesIcon from 'vue-ionicons/dist/ios-images.vue'
import CreateIcon from 'vue-ionicons/dist/ios-create.vue'

export default {
  name: 'ImageEditor',
  data () {
    return {
      localValue: {},
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
      this.localValue.url = this.originalValue.url
      this.localValue.alt = this.originalValue.alt
      this.updateValue()
      this.toggleEditor()
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
    launchMediaEditor (event) {
      devise.$bus.$emit('devise-launch-media-editor', {
        source: this.localValue.url,
        callback: this.mediaEdited
      })
    },
    mediaSelected (media) {
      console.log('here', media)
      this.localValue.url = media.url
      this.updateValue()
    },
    mediaSelected (urlString) {
      console.log(urlString)
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
    CreateIcon,
    FieldEditor,
    ImagesIcon
  }
}
</script>
