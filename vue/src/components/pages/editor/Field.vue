<template>
  <div class="dvs-relative">
    <div class="dvs-flex dvs-justify-between dvs-items-center">
      <div class="dvs-large-label dvs-flex dvs-items-center dvs-mr-2 dvs--ml-4 dvs-font-bold dvs-w-full">
        <div class="dvs-badge dvs-badge-empty dvs-mr-2" :class="{'dvs-bg-green-dark': localValue.enabled, 'dvs-bg-grey-light': !localValue.enabled, 'dvs-invisible': !localValue.enabler}" :title="enabledTip(localValue.enabled)" v-tippy="tippyConfiguration"></div>
        <div class="dvs-flex dvs-items-center dvs-justify-between dvs-w-full">
          <span class="dvs-text-blue-dark dvs-cursor-pointer" @click="showEditor = !showEditor">{{ options.label }}</span>
          <i class="ion-eye dvs-text-xl" @mouseover="showPreview = true" @mouseout="showPreview = false"></i>
          <div v-show="showPreview" class="dvs-bg-grey-lighter dvs-absolute dvs-p-4 dvs-mt-2 dvs-text-xs dvs-rounded dvs-shadow-lg dvs-pin-t dvs-pin-l dvs-mt-8 dvs-z-20">
            <slot name="preview"></slot>
            {{ localValue.instructions }}
          </div>
        </div>
      </div>
    </div>

    <template v-if="showEditor">
    <portal to="devise-field-editor">
      <div class="dvs-modal dvs-fixed dvs-pin-b dvs-pin-r dvs-mx-8 dvs-mb-8 dvs-z-30 dvs-min-w-3/5">
        <h6 class="dvs-text-blue-dark dvs-mb-4">
          {{ localValue.label }}<br>
          <small class="dvs-text-xs">
            Hint from Developer: 
            <span class="dvs-italic dvs-font-normal">
              {{ localValue.instructions }}
            </span>
          </small>
        </h6>
        
        <slot name="editor"></slot>

        <div class="dvs-flex dvs-items-center dvs-mt-4 dvs-justify-between">
          <div>
            <button class="dvs-btn dvs-mr-2" @click="showEditor = false">Done</button>
            <button class="dvs-btn" @click="cancel">Cancel</button>
          </div>
          <div class="dvs-flex dvs-items-center dvs-justify-between" v-if="localValue.enabled">
            <label class="dvs-mr-2">Field Enabled</label>
            <toggle v-model="localValue.enabled" :id="randomString(8)"></toggle>
          </div>
        </div>
      </div>
    </portal>
    </template>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import Strings from './../../../mixins/Strings'
import Toggle from './../../utilities/Toggle'

export default {
  name: 'FieldEditor',
  data () {
    return {
      localValue: {},
      showEditor: false,
      showPreview: false
    }
  },
  mounted () {
    let self = this
    this.$nextTick(function () {
      self.localValue = self.value
    })
  },
  methods: {
    update (event) {
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    },
    cancel () {
      this.$emit('cancel')
      this.showEditor = false
    },
    enabledTip (enabled) {
      if (enabled) {
        return 'This field is enabled'
      }
      return 'This field is not enabled. Edit the field and toggle the enable switch to turn it on.'
    }
  },
  computed: {
    ...mapGetters('devise', [
      'fieldConfig'
    ])
  },
  props: ['value', 'options'],
  mixins: [Strings],
  components: {
    Toggle
  }
}
</script>
