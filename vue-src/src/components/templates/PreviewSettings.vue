<template>

  <div v-if="slices.data.length > 0 && localValue.name">

    <div class="dvs-flex dvs-justify-between dvs-block dvs-mb-2 dvs-template-switch-sm dvs-ml-4" @click="toggleSlice()">
      <strong>{{ theSlice().name }}</strong>
      <div class="dvs-relative">
        <i class="ion-gear-a dvs-absolute dvs-pin-r dvs-pin-t" @click="toggleShowControls()" />
        <div class="dvs-blocker dvs-blocker-light" @click="toggleShowControls()" v-if="showControls"></div>
        <div class="dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-10 dvs-p-4 dvs-bg-white dvs-rounded-sm dvs-min-w-48 dvs-text-center dvs-shadow-lg dvs-z-40" v-if="showControls && localValue.type !== 'model' && localValue.type !== 'repeats'">
          <button class="dvs-btn dvs-btn-xs dvs-btn-ghost dvs-mb-4" @click="addSlice('above')">Insert Slice Above</button>
          <button class="dvs-btn dvs-btn-xs dvs-btn-ghost" @click="addSlice('below')">Insert Slice Below</button>
        </div>
      </div>
    </div>
    <div class="dvs-collapsed dvs-pl-4">

      <fieldset v-if="localValue.type === 'repeats'" class="dvs-fieldset dvs-mb-4">
        <label class="dvs-font-bold dvs-mb-1 dvs-block dvs-large-label"><strong>Amount of Demo "{{ theSlice().name }}" Instances</strong></label>
        <div class="dvs-flex">
          <input type="number" min="0" max="50" class="dvs-mr-4 dvs-min-w-1/4 dvs-max-w-1/4" v-model.number="localValue.settings.numberOfInstances" @keyup="updateValue">
          <input type="range" v-model.number="localValue.settings.numberOfInstances" max="50" class="dvs-w-3/4" @change="updateValue">
        </div>
      </fieldset>

      <fieldset v-for="(field, fieldKey) in getComponent(theSlice().component).config" class="dvs-mb-4" :key="fieldKey">
        <template v-if="field.type">
          <label class="dvs-font-bold dvs-mb-1 dvs-block dvs-large-label">{{ field.label }}</label>
          <component v-bind:is="field.type.charAt(0).toUpperCase() + field.type.slice(1) + 'Controls'" v-model="localValue.config[fieldKey]" @change="updateValue()"></component>
        </template>
      </fieldset>

      <div v-if="typeof localValue.slices !== 'undefined' && localValue.slices.length > 0">
        <ul class="dvs-list-reset">
          <li v-for="(subSlice, key) in localValue.slices" v-if="theSlice(subSlice) && subSlice.metadata" class="dvs-mb-2 dvs-template-editor-collapsable" :class="{'dvs-open': subSlice.metadata.open}">
            <template-preview-settings v-model="localValue.slices[key]" @addSlice="addSubSlice" @toggleSlice="toggleSlice(subSlice)" @toggleModelControls="toggleModelControls" @toggleCreateChildrenSlices="toggleCreateChildrenSlices"></template-preview-settings>
          </li>
        </ul>
      </div>
      <div v-if="(typeof localValue.slices === 'undefined' || localValue.slices.length < 1) && localValue.type !== 'model'" class="dvs-flex dvs-justify-center">
        <button class="dvs-btn dvs-btn-xs dvs-btn-ghost" @click="toggleShowCreateChildrenSlices()">Create Children Slices</button>
      </div>
    </div>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import ColorControls from './controls/Color'
import CheckboxControls from './controls/Checkbox'
import ImageControls from './controls/Image'
import LinkControls from './controls/Link'
import NumberControls from './controls/Number'
import TextareaControls from './controls/Textarea'
import TextControls from './controls/Text'
import WysiwygControls from './controls/Wysiwyg'
// import SuperTable from './../utilities/tables/SuperTable'

export default {
  name: 'TemplatePreviewSettings',
  data () {
    return {
      showControls: false,
      localValue: {
        update: this.updateValue,
        settings: {
          numberOfInstances: 1
        }
      }
    }
  },
  mounted () {
    this.localValue = Object.assign({}, this.localValue, this.value)
  },
  methods: {
    updateValue () {
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    },
    theSlice () {
      let self = this
      return this.slices.data.find(slice => {
        return slice.id === self.localValue.slice_id
      })
    },
    toggleSlice () {
      this.$emit('toggleSlice')
    },
    toggleShowControls () {
      if (this.localValue.type === 'model') {
        this.$emit('toggleModelControls', this.localValue)
      } else {
        this.showControls = !this.showControls
      }
    },
    toggleModelControls (component) {
      this.$emit('toggleModelControls', component)
    },
    toggleShowCreateChildrenSlices (component) {
      this.$emit('toggleCreateChildrenSlices', this.localValue)
    },
    toggleCreateChildrenSlices (component) {
      this.$emit('toggleCreateChildrenSlices', component)
    },
    addSlice (direction) {
      this.$emit('addSlice', {direction: direction, slice: this.value})
    },
    addSubSlice (params) {
      this.$emit('addSlice', params)
    },
    getComponent (component) {
      return window.deviseComponents[component]
    }
  },
  computed: {
    ...mapGetters('devise', [
      'slices',
      'sliceConfig',
      'fieldConfig',
      'template'
    ])
  },
  watch: {
    value (newValue) {
      this.localValue = Object.assign({}, this.localValue, newValue)
    }
  },
  props: ['value'],
  components: {
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
