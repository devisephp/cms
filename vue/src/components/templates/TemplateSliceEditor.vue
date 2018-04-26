<template>
  <div v-if="loaded" class="dvs-ml-2">
    <!-- Label / Button -->
    <div class="dvs-flex dvs-justify-between dvs-block dvs-mb-2 dvs-template-switch-sm" @click="toggleSlice()">
      <div>
        <i class="handle ion-navicon-round mr-2"></i>
        <i class="ion-gear-b" @click="toggleSliceTools"></i>

        <!-- Menu for manipulating this slice -->
        <div class="dvs-blocker dvs-blocker-light" @click="localValue.metadata.tools = false" v-if="localValue.metadata.tools"></div>
        <div class="dvs-cn-wrapper" :class="{'dvs-opened-nav': localValue.metadata.tools}">
          <button class="cn-close-button" @click="localValue.metadata.tools = false">
            <i class="ion-close-round"></i>
          </button>
          <ul class="dvs-list-reset">
            <li><a class="disabled">&nbsp;</a></li>
            <li><a class="disabled">&nbsp;</a></li>
            <li><a @click.prevent="addSlice()" class="dvs-cursor-pointer" :title="`Create new child slice under ${localValue.label}`" v-tippy="tippyConfiguration" data-tippy-followcursor="true">
              <i class="ion-plus"></i>
            </a></li>
            <li><a @click.prevent="modifySlice()" class="dvs-cursor-pointer" :title="`Modify the data that drives ${localValue.label}`" v-tippy="tippyConfiguration" data-tippy-followcursor="true">
              <i class="ion-cube"></i>
            </a></li>
            <li><a @click.prevent="removeSlice()" class="dvs-cursor-pointer" :title="`Remove ${localValue.label}`" v-tippy="tippyConfiguration" data-tippy-followcursor="true">
              <i class="ion-trash-a"></i>
            </a></li>
            <li><a class="disabled">&nbsp;</a></li>
            <li><a class="disabled">&nbsp;</a></li>
          </ul>
        </div>

      </div>
      {{ localValue.label }}
    </div>

    <!-- Collapsed Section -->
    <div class="dvs-collapsed dvs-mb-8">
      <div class=" dvs-flex dvs-flex-col dvs-items-center">

        <!-- Number of Demo Instances -->
        <fieldset v-if="localValue.type === 'repeats'" class="dvs-fieldset dvs-mb-8 dvs-w-full">
          <div>
            <label class="dvs-font-bold dvs-mb-1 dvs-block dvs-uppercase"><strong>Amount of Demo "{{ localValue.label }}" Instances</strong></label>
            <div class="dvs-flex">
              <input type="number" min="0" max="50" class="dvs-mr-4 dvs-min-w-1/4 dvs-max-w-1/4" v-model.number="localValue.config.numberOfInstances" @keyup="updateValue">
              <input type="range" v-model.number="localValue.config.numberOfInstances" max="50" class="dvs-w-3/4" @change="updateValue">
            </div>
          </div>
        </fieldset>

        <!-- Controls -->
        <template v-if="componentConfiguration">
          <template v-for="(field, fieldKey) in componentConfiguration" v-if="field.type">
            <div class="dvs-w-full">
              <div class="dvs-mb-4" :key="fieldKey">
                <fieldset class="dvs-fieldset">
                  <label class="dvs-font-bold dvs-mb-1 dvs-block dvs-uppercase">{{ field.label }}</label>
                </fieldset>
                <component v-bind:is="field.type.charAt(0).toUpperCase() + field.type.slice(1) + 'Controls'" v-model="localValue.config[fieldKey]" @change="updateValue()"></component>
              </div>
            </div>
          </template>
        </template>

        <!-- Child Slices -->
        <div class="dvs-mt-4 dvs-w-full" v-if="localValue.slices">
          <draggable v-model="localValue.slices" element="ul" :options="{handle: '.handle'}" class="dvs-list-reset dvs-ml-4">
            <li v-for="(slice, key) in localValue.slices" class="item dvs-mb-2 dvs-template-editor-collapsable" :class="{'dvs-open': slice.metadata.open}">
              <template-slice-editor v-model="localValue.slices[key]" :key="key"></template-slice-editor>
            </li>
          </draggable>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import faker from 'faker/locale/en'
import draggable from 'vuedraggable'

import ColorControls from './controls/Color'
import CheckboxControls from './controls/Checkbox'
import ImageControls from './controls/Image'
import LinkControls from './controls/Link'
import NumberControls from './controls/Number'
import TextareaControls from './controls/Textarea'
import TextControls from './controls/Text'
import WysiwygControls from './controls/Wysiwyg'

export default {
  data () {
    return {
      loaded: false,
      localValue: {}
    }
  },
  beforeCreate () {
    // Avoids cyclic dependencies: https://github.com/vuejs/vue/issues/4117
    this.$options.components.TemplateSliceEditor = require('./TemplateSliceEditor.vue')
  },
  mounted () {
    this.localValue = this.value
    this.prepareSliceForTemplatePreview()
    this.loaded = true
  },
  methods: {
    updateValue () {
      // Emit the number value through the input event
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    },
    addSlice () {
      this.toggleSliceTools()
      this.$emit('addSlice', this.localValue.slices)
    },
    modifySlice () {
      this.toggleSliceTools()
      this.$emit('modifySlice', this.localValue.slices)
    },
    removeSlice () {
      this.toggleSliceTools()
      this.$emit('removeSlice', this.localValue.slices)
    },
    toggleSlice () {
      this.localValue.metadata.open = !this.localValue.metadata.open
      this.updateValue()
    },
    toggleSliceTools() {
      this.localValue.metadata.tools = !this.localValue.metadata.tools
      this.updateValue()
    },
    prepareSliceForTemplatePreview () {
      let self = this

      // If the config is null let's set it
      if (!self.localValue.config) {
        self.$set(self.localValue, 'config', {})
      }

      if (!self.localValue.slices) {
        self.$set(self.localValue, 'slices', [])
      }

      if (!self.localValue.metadata || !self.localValue.metadata.open) {
        this.$set(self.localValue, 'metadata', {
          open: false,
          tools: false
        })
      }

      // If this slice type is "model" or "repeats" then let's set the number of
      // instances if it doesn't exist and set it to 1
      if ((self.localValue.type === 'model' || self.localValue.type === 'repeats') && !self.localValue.config.numberOfInstances) {
        self.$set(self.localValue.config, 'numberOfInstances', 1)
      }

      // Hydrate those fields if they don't exist
      Object.keys(self.componentConfiguration).forEach(function (key, index) {
        if (
          typeof self.localValue.config[key] === 'undefined'
        ) {
          if (self.componentConfiguration[key].type === 'text') {
            self.$set(self.localValue.config, key, {enabled: true, text: faker.lorem.words(5)})
          }
          if (self.componentConfiguration[key].type === 'wysiwyg') {
            self.$set(self.localValue.config, key, {enabled: true, text: '<div>' + faker.lorem.words(15) + '</div>'})
          }
          if (self.componentConfiguration[key].type === 'color') {
            self.$set(self.localValue.config, key, {enabled: true, color: '#f66d9b'})
          }
          if (self.componentConfiguration[key].type === 'number') {
            self.$set(self.localValue.config, key, {enabled: true, text: '1000'})
          }
          if (self.componentConfiguration[key].type === 'textarea') {
            self.$set(self.localValue.config, key, {enabled: true, text: faker.lorem.words(15)})
          }
          if (self.componentConfiguration[key].type === 'link') {
            self.$set(self.localValue.config, key, {enabled: true, text: 'A Link', url: faker.internet.url(), target: '_self'})
          }
          if (self.componentConfiguration[key].type === 'image') {
            self.$set(self.localValue.config, key, {enabled: true, url: faker.image.cats()})
          }
        }
      })
    }
  },
  computed: {
    ...mapGetters('devise', [
      'component'
    ]),
    componentConfiguration () {
      if (this.component(this.localValue.name)) {
        return this.component(this.localValue.name).config
      }
      return null
    },
    anySliceOpen () {
      if (this.localValue.slices) {
        for (var i = 0; i < this.localValue.slices.length; i++) {
          if (this.localValue.slices[i].metadata.open) {
            return true
          }
        }
      }

      return false
    }
  },
  props: {
    value: {
      required: true
    }
  },
  watch: {
    value (newValue) {
      this.localValue = newValue
    }
  },
  components: {
    draggable,
    CheckboxControls,
    ColorControls,
    ImageControls,
    LinkControls,
    NumberControls,
    TextareaControls,
    TextControls,
    WysiwygControls
  }
}
</script>
