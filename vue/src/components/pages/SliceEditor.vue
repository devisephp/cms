<template>
  <li class="dvs-mb-4 dvs-collapsable" :class="{'dvs-open': slice.metadata.open}">
    <strong class="dvs-block dvs-mb-2 dvs-switch-sm dvs-ml-4 dvs-flex dvs-justify-between" @click="toggleSlice(slice)">
      {{ slice.metadata.label }}
      <i v-if="slice.metadata.placeholder && slice.metadata.type === 'repeats'" class="ion-plus" @click="addInstance(slice)"></i>
    </strong>

    <div class="dvs-collapsed">
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

        <help v-if="slice.metadata.type === 'model'" class="mb-4">
          Be aware that these entries are model entries. That means they are managed in your database by another tool or by an admin section in your adminitration.
        </help>

        <ul class="dvs-list-reset">
          <template v-for="(s, key) in slice.slices">
            <slice-editor :key="key" :slice="s" />
          </template>
        </ul>
      </div>
    </div>
  </li>
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
      pageSlices: []
    }
  },
  mounted () {
    if (this.slice.slices) {
      this.pageSlices = this.slice.slices
    }
  },
  methods: {
    toggleSlice (slice) {
      let sliceOpen = slice.metadata.open
      this.pageSlices.map(s => this.closeSlice(s))
      this.$set(slice.metadata, 'open', !sliceOpen)
    },
    toggleSliceTools() {
      this.slice.metadata.tools = !this.slice.metadata.tools
    },
    closeSlice (slice) {
      this.$set(slice.metadata, 'open', false)
    },
    addInstance () {
      let component = this.component(this.slice.metadata.name)

      if (!this.slice.slices) {
        this.$set(this.slice, 'slices', [])
      }

      var data = {
        metadata: Object.assign({}, this.slice.metadata)
      }
      data.metadata.placeholder = false

      for (var prop in component.config) {
        if (component.config.hasOwnProperty(prop)) {
          data[prop] = component.config[prop]
        }
      }

      this.slice.slices.push(data)

    }
  },
  computed: {
    ...mapGetters('devise', [
      'component',
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
