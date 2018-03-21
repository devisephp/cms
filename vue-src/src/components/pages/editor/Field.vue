<template>
  <div class="dvs-relative">
    <div class="dvs-flex dvs-justify-between dvs-items-center">
      <div class="dvs-large-label dvs-flex dvs-items-center dvs-mr-2 dvs--ml-4">
        <div class="dvs-badge dvs-badge-empty dvs-mr-2" :class="{'dvs-bg-green-dark': localValue.enabled, 'dvs-bg-grey-light': !localValue.enabled}" :title="enabledTip(localValue.enabled)" v-tippy="tippyConfiguration"></div>
        {{ options.label }}
      </div>
      <button class="dvs-btn dvs-btn-ghost dvs-btn-xs dvs-min-w-24" @click="showEditor = !showEditor">Edit Field</button>
    </div>
    <div class="dvs-bg-grey-lighter dvs-p-4 dvs-mt-2 dvs-text-xs dvs-rounded-sm">
      <slot name="preview"></slot>
    </div>
    <div v-show="showEditor" class="dvs-modal dvs-fixed dvs-pin-b dvs-pin-l dvs-mx-8 dvs-mb-8 dvs-z-10 dvs-min-w-3/5">
      <slot name="editor"></slot>

      <div class="dvs-flex dvs-items-center dvs-mt-4 dvs-justify-between">
        <div>
          <button class="dvs-btn dvs-mr-2" @click="showEditor = false">Done</button>
          <button class="dvs-btn" @click="cancel">Cancel</button>
        </div>
        <div class="dvs-flex dvs-items-center dvs-justify-between">
          <label class="dvs-mr-2">Field Enabled</label>
          <toggle v-model="localValue.enabled" :id="randomString(8)"></toggle>
        </div>
      </div>
    </div>
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
      showEditor: false
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
