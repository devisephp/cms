<template>

  <div v-if="slices.data.length > 0 && localValue.name">

    <div class="dvs-flex dvs-justify-between dvs-block dvs-mb-2 dvs-template-switch-sm dvs-ml-4">
      <strong>{{ theSlice().name }}</strong>
      <div class="dvs-relative">
        <i class="ion-arrow-expand dvs-absolute dvs-pin-r dvs-pin-t mr-6 dvs-rounded-sm" @click="toggleSlice()" />
        <i class="ion-gear-a dvs-absolute dvs-pin-r dvs-pin-t dvs-rounded-sm" @click="toggleShowControls()" />
        <div class="dvs-blocker dvs-blocker-light" @click="toggleShowControls()" v-if="showControls"></div>
        <div class="dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-10 dvs-bg-white dvs-rounded-sm dvs-min-w-64 dvs-text-center dvs-shadow-lg dvs-z-40" v-if="showControls">
          <div class="dvs-bg-grey-lighter dvs-text-grey-darker dvs-p-4 dvs-font-normal dvs-relative">
            <i class="ion-android-close dvs-absolute dvs-pin-t dvs-pin-r dvs-m-4 dvs-text-lg" @click="toggleShowControls()"></i>
            <strong>Managing</strong> <br>{{ theSlice().name }}
          </div>
          <div class="dvs-p-8 dvs-py-6">
            <button class="dvs-btn dvs-btn-xs dvs-w-full dvs-btn-ghost dvs-mb-2" @click="toggleModelControls(localValue)" v-if="localValue.type === 'model'">Set Data</button>
            <button class="dvs-btn dvs-btn-xs dvs-w-full dvs-btn-ghost dvs-mb-2" @click="move(-1)" v-if="localValue.type !== 'model'">Move Up</button>
            <button class="dvs-btn dvs-btn-xs dvs-w-full dvs-btn-ghost dvs-mb-2" @click="move(1)" v-if="localValue.type !== 'model'">Move Down</button>
            <button class="dvs-btn dvs-btn-xs dvs-w-full dvs-btn-ghost dvs-mb-2" @click="addSlice({direction: 'above', slice: value})" v-if="localValue.type !== 'model'">Insert Slice Above</button>
            <button class="dvs-btn dvs-btn-xs dvs-w-full dvs-btn-ghost dvs-mb-2" @click="addSlice({direction: 'below', slice: value})" v-if="localValue.type !== 'model'">Insert Slice Below</button>
            <button class="dvs-btn dvs-btn-xs dvs-w-full dvs-btn-ghost dvs-mb-2" @click="removeSlice">Delete</button>
          </div>
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
            <template-preview-settings v-model="localValue.slices[key]" @addSlice="addSlice" @removeSlice="requestRemoveChildSlice" @toggleSlice="toggleSlice(subSlice)" @toggleModelControls="toggleModelControls" @toggleCreateChildrenSlices="toggleCreateChildrenSlices"></template-preview-settings>
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
      this.showControls = !this.showControls
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
    move (delta) {
      this.$emit('move', {delta: delta, slice: this.value})
      this.showControls = false
    },
    addSlice (data) {
      this.$emit('addSlice', data)
      this.showControls = false
    },
    removeSlice () {
      this.$emit('removeSlice')
      this.showControls = false
    },
    requestRemoveChildSlice (slice) {
      this.localValue.slices.splice(this.localValue.slices.indexOf(slice), 1)
    },
    requestAddSubSlice (params) {
      this.$set(this.createChildren, 'childToCreate', {
        type: type
      })

      if (type === 'model') {
        this.getModels()
      }
      this.showControls = false
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
