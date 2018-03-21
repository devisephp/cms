<template>
  <div>
    <div class="dvs-pt-4">
      <fieldset v-for="(field, key) in fields" class="dvs-fieldset dvs-mb-8 dvs-pl-4" :key="key">
        <div>

          <color-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" v-if="fieldConfig({fieldKey: key, slice}).type === 'color'">
          </color-editor>

          <checkbox-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" v-if="fieldConfig({fieldKey: key, slice}).type === 'checkbox'">
          </checkbox-editor>

          <image-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" v-if="fieldConfig({fieldKey: key, slice}).type === 'image'">
          </image-editor>

          <link-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" v-if="fieldConfig({fieldKey: key, slice}).type === 'link'">
          </link-editor>

          <number-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" v-if="fieldConfig({fieldKey: key, slice}).type === 'number'">
          </number-editor>

          <textarea-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" v-if="fieldConfig({fieldKey: key, slice}).type === 'textarea'">
          </textarea-editor>

          <text-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" v-if="fieldConfig({fieldKey: key, slice}).type === 'text'">
          </text-editor>

          <wysiwyg-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" v-if="fieldConfig({fieldKey: key, slice}).type === 'wysiwyg'">
          </wysiwyg-editor>
        </div>

      </fieldset>
    </div>
    <div class="dvs-collapsed dvs-pl-4">
      <ul class="dvs-list-reset">
        <li v-for="(s, key) in slice.slices" class="dvs-mb-4 dvs-collapsable" :class="{'dvs-open': s.metadata.open}">
          <strong class="dvs-block dvs-mb-2 dvs-switch-sm dvs-ml-4" @click="toggleSlice(s)">{{ s.metadata.label }}</strong>
          <div class="dvs-collapsed">
            <slice-editor :key="key" :slice="s" />
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import SliceEditor from './SliceEditor'
import CheckboxEditor from './editor/Checkbox'
import ColorEditor from './editor/Color'
import ImageEditor from './editor/Image'
import LinkEditor from './editor/Link'
import NumberEditor from './editor/Number'
import TextareaEditor from './editor/Textarea'
import TextEditor from './editor/Text'
import WysiwygEditor from './editor/Wysiwyg'

export default {
  name: 'SliceEditor',
  data () {
    return {
      slices: []
    }
  },
  mounted () {
    this.slices = this.slice.slices
  },
  methods: {
    toggleSlice (slice) {
      this.slices.map(s => this.closeSlice(s))
      this.$set(slice.metadata, 'open', !slice.metadata.open)
    },
    closeSlice (slice) {
      this.$set(slice.metadata, 'open', false)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'fieldConfig'
    ]),
    fields () {
      var fields = {}
      for (var potentialField in this.slice) {
        if (
          this.slice.hasOwnProperty(potentialField) &&
          potentialField !== 'slices' &&
          potentialField !== 'metadata' &&
          typeof this.slice[potentialField] === 'object'
        ) {
          fields[potentialField] = this.slice[potentialField]
          if (typeof fields[potentialField].enabled === 'undefined') {
            this.$set(fields[potentialField], 'enabled', true)
          }
        }
      }
      return fields
    }
  },
  props: ['slice'],
  components: {
    SliceEditor,
    CheckboxEditor,
    ColorEditor,
    ImageEditor,
    LinkEditor,
    NumberEditor,
    TextareaEditor,
    TextEditor,
    WysiwygEditor
  }
}
</script>
