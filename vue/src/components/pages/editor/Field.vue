<template>
  <div class="dvs-relative">
    <div class="dvs-flex dvs-justify-between dvs-items-center">
      <div class="dvs-large-label dvs-flex dvs-items-center dvs-mr-2 dvs--ml-4 dvs-font-bold dvs-w-full">
        <div class="dvs-badge dvs-badge-empty dvs-mr-2" :class="{'dvs-bg-green-dark': localValue.enabled, 'dvs-bg-grey-light': !localValue.enabled, 'dvs-invisible': !localValue.enabler}" :title="enabledTip(localValue.enabled)" v-tippy="tippyConfiguration"></div>
        <div class="dvs-flex dvs-items-center dvs-justify-between dvs-w-full">
          <span class="dvs-cursor-pointer dvs-text-sm dvs-font-normal" @click="toggleShowEditor">{{ options.label }}</span>
          <i class="ion-eye dvs-text-xl" v-if="!options.hidePreview" @mouseover="showPreview = true" @mouseout="showPreview = false"></i>
          <div 
            v-show="showPreview" 
            class="dvs-absolute dvs-font-normal dvs-p-4 dvs-mt-2 dvs-text-xs dvs-rounded dvs-shadow-lg dvs-pin-t dvs-pin-l dvs-mt-8 dvs-z-20"
            :style="`
              background-color: ${theme.sidebarTop.color};
              color:${theme.sidebarText.color};
            `"
            >
            <slot name="preview"></slot>
            {{ localValue.instructions }}
          </div>
        </div>
      </div>
    </div>

    <template v-if="showEditor">
      <portal to="devise-field-editor">
        <div class="dvs-blocker" :style="{backgroundColor: 'transparent'}" @click="toggleShowEditor"></div>
        <div class="dvs-modal dvs-fixed dvs-pin-b dvs-pin-r dvs-mx-8 dvs-mb-8 dvs-z-40" :style="infoBlockTheme">
          <h6 class="dvs-mb-4">
            <span :style="{color: theme.adminText.color}">{{ localValue.label }}</span><br>
            <small class="dvs-text-xs" v-if="localValue.instructions">
              Hint from Developer: 
              <span class="dvs-italic dvs-font-normal">
                {{ localValue.instructions }}
              </span>
            </small>
          </h6>
          
          <slot name="editor"></slot>

          <div class="dvs-flex dvs-items-center dvs-mt-4 dvs-justify-between">
            <div>
              <button class="dvs-btn dvs-mr-2" @click="toggleShowEditor" :style="regularButtonTheme">Done</button>
            </div>
            <div class="dvs-flex dvs-items-center dvs-justify-between" v-if="typeof options.default !== 'undefined' && typeof options.default.enabled !== 'undefined'">
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
    toggleShowEditor () {
      this.$emit('toggleShowEditor')
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
  props: ['value', 'options', 'showEditor'],
  mixins: [Strings],
  components: {
    Toggle
  }
}
</script>
