<template>
  <li class="dvs-mb-4 dvs-collapsable" :class="{'dvs-open': slice.metadata.open}">
    <strong class="dvs-block dvs-mb-4 dvs-switch-sm dvs-text-sm dvs-ml-2 dvs-flex dvs-justify-between dvs-cursor-pointer" @click="toggleSlice(slice)">
      <template v-if="slice.metadata.placeholder && slice.metadata.type === 'repeats'">
        <div>
          {{ slice.metadata.label }} 
        </div>
        <div @click.stop="addInstance(slice)">
          <add-icon /> Add New
        </div>
      </template>
      <template v-else>
        <div class="dvs-flex dvs-items-center">
          {{ slice.metadata.label }}
        </div>
        <template v-if="repeatableChild">
          <div @click.stop="requestRemoveInstance(slice)">
            Remove
          </div>
        </template>
      </template>
      
    </strong>

    <div class="dvs-collapsed dvs-mb-8" v-if="slice.metadata.open">
      <div v-if="!slice.metadata.placeholder">
        <fieldset v-for="(field, key) in fields" class="dvs-fieldset dvs-mb-4 dvs-pl-4" :key="key">
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

            <wysiwyg-editor v-model="fields[key]" :options="fieldConfig({fieldKey: key, slice})" :namekey="key" :show="slice.metadata.show" v-if="fieldConfig({fieldKey: key, slice}).type === 'wysiwyg'">
            </wysiwyg-editor>
          </div>

        </fieldset>
      </div>

      <div class="dvs-collapsed dvs-pl-4">

        <help 
          v-if="slice.metadata.type === 'model'" 
          class="dvs-mb-4"
          :style="`
            border-color:${theme.buttonsActionLeft.color};
            background:${theme.buttonsActionRight.color};
            color:${theme.buttonsActionText.color};
          `" 
          >
          Be aware that these entries are model entries. That means they are managed in your database by another tool or by an admin section in your adminitration.
        </help>

        <ul class="dvs-list-reset" v-if="slice.metadata.type !== 'model'" >
          <template v-for="(s, key) in slice.slices">
            <slice-editor :key="key" :slice="s" :repeatable-child="true" @removeInstance="removeInstance" />
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

import AddIcon from 'vue-ionicons/dist/ios-add.vue'

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
      this.$emit('opened')
    },
    closeSlice (slice) {
      this.$set(slice.metadata, 'open', false)
    },
    toggleSliceTools() {
      this.slice.metadata.tools = !this.slice.metadata.tools
    },
    addInstance () {
      this.$set(this.slice.metadata, 'open', true)

      // Setup the slice data
      var data = {
        metadata: Object.assign({}, this.slice.metadata)
      }
      data.metadata.placeholder = false
      data.metadata.instance_id = 0

      // Set the slices prop if it isn't there
      if (!this.slice.slices) {
        this.$set(this.slice, 'slices', [])
      }

      // Hydrate missing properties which also sets the defaults
      this.hydrateMissingProperties(data)

      // Push the slice into the slices array
      this.slice.slices.push(data)
    },
    requestRemoveInstance (slice) {
      this.$emit('removeInstance', slice)
    },
    removeInstance(slice) {
      this.slice.slices.splice(this.slice.slices.indexOf(slice), 1)
    },
    hydrateMissingProperties (data) {
      let config = this.component(this.slice.metadata.name).config

      if (config) {
        // Loop through the config for this slice and check to see that all the
        // fields are present. If they aren't it's just because they haven't been
        // hydrated via the editor yet.
        for (var prop in config) {
          // Ok, so the property is missing from the slice.fields object so we're
          // going to add in a stub for the render.
          if (!data.hasOwnProperty(prop)) {
            this.addMissingProperty(data, prop)

            // If defaults are set then set them on top of the placeholder missing properties
            if (config[prop].default) {
              this.setDefaults(data, prop, config[prop].default)
            }
          }
        }
      }

      return data
    },
    addMissingProperty (data, property) {
      // We just add all the properties because.... why not?
      this.$set(data, property, {
        text: null,
        url: null,
        target: null,
        color: null,
        checked: null,
        enabled: false
      })
    },
    setDefaults (data, property, defaults) {
      // loop through the defaults and apply them to the field
      for (var d in defaults) {
        this.$set(data[property], d, defaults[d])
      }
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
  props: ['slice', 'repeatableChild'],
  components: {
    AddIcon,
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
