<template>
  <div
    class="dvs-relative dvs-px-1 dvs-py-1 dvs-rounded-sm dvs-text-xs dvs-cursor-pointer"
    :style="theme.panelSidebar"
  >
    <div class="dvs-flex dvs-justify-between dvs-items-center">
      <div class="dvs-large-label dvs-flex dvs-items-center dvs-mr-2 dvs-font-bold dvs-w-full">
        <div
          class="dvs-rounded-full dvs-mr-2 dvs-w-2 dvs-h-2 dvs-mr-2"
          @click="value.enabled = !value.enabled"
          :class="{'dvs-bg-green': value.enabled, 'dvs-bg-white': !value.enabled, 'dvs-invisible': !value.enabler}"
        ></div>
        <div
          class="dvs-flex dvs-items-center dvs-justify-start dvs-w-full"
          @click="toggleShowEditor"
        >
          <!-- Swatch -->
          <div
            v-if="options.swatch && value.color"
            :style="`background-color:${value.color}`"
            class="dvs-rounded-sm dvs-mr-2"
            style="width:10px; height:10px;"
          ></div>
          {{devLabel}} {{ options.label }}
        </div>
      </div>
    </div>

    <template v-if="showEditor">
      <portal to="devise-root">
        <div
          class="dvs-blocker"
          :style="{backgroundColor: 'transparent'}"
          @click="toggleShowEditor"
        ></div>
        <panel
          id="field-panel"
          class="dvs-fixed dvs-pin-b dvs-pin-r dvs-mx-8 dvs-mb-8 dvs-z-40 dvs-max-w-full"
          :panel-style="theme.panel"
        >
          <div class="dvs-p-8">
            <h6 class="dvs-text-base dvs-mb-2" :style="{color: theme.panel.color}">
              <span>{{ value.label }}</span>
              <br>
              <small class="dvs-text-xs" v-if="value.instructions">
                Hint from Developer:
                <span
                  class="dvs-italic dvs-font-normal"
                >{{ value.instructions }}</span>
              </small>
            </h6>

            <slot name="editor"></slot>

            <div class="dvs-flex dvs-items-center dvs-mt-4 dvs-mb-4 dvs-justify-between">
              <div class="dvs-flex dvs-items-center">
                <button
                  class="dvs-btn dvs-mr-2"
                  @click="toggleShowEditor"
                  :style="theme.actionButton"
                >Done</button>
                <button
                  class="dvs-btn dvs-mr-2"
                  @click="cancel"
                  :style="theme.actionButtonGhost"
                >Cancel</button>
              </div>
              <div class="dvs-flex dvs-items-center dvs-justify-between" v-if="value.enabler">
                <label class="dvs-mr-2">Field Enabled</label>
                <toggle v-model="value.enabled" :id="randomString(8)"></toggle>
              </div>
            </div>
            <div
              @click="showErase = true"
              v-if="!showErase && !noReset"
              class="dvs-absolute dvs-pin-b dvs-pin-l dvs-pin-r dvs-uppercase dvs-text-center dvs-text-xs dvs-p-2 dvs-opacity-50 hover:dvs-opacity-100 dvs-cursor-pointer"
              style="height:30px;"
              :style="{backgroundColor: theme.panelCard.background}"
            >reset</div>
            <div v-if="showErase" class="dvs--mb-8 dvs--ml-8 dvs--mr-8" :style="theme.actionButton">
              <button
                class="dvs-btn dvs-w-full"
                :style="theme.actionButton"
                @click="resetValue"
              >Reset Value to Nothing</button>
            </div>
          </div>
        </panel>
      </portal>
    </template>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import Strings from './../../../mixins/Strings';

export default {
  name: 'FieldEditor',
  data() {
    return {
      showErase: false
    };
  },
  mounted() {
    let self = this;
  },
  methods: {
    toggleShowEditor() {
      this.showErase = false;
      this.$emit('toggleShowEditor');
    },
    cancel() {
      this.$emit('cancel');
    },
    enabledTip(enabled) {
      if (enabled) {
        return 'This field is enabled';
      }
      return 'This field is not enabled. Edit the field and toggle the enable switch to turn it on.';
    },
    resetValue() {
      this.showErase = false;
      this.$emit('resetvalue');
    }
  },
  computed: {
    ...mapGetters('devise', ['fieldConfig']),
    ...mapState('devise', ['devMode']),
    devLabel() {
      if (this.devMode) {
        //TO DO - NEED THE INSTANCE ID OF THE FIELD
        // return ``;
      }
    }
  },
  props: ['value', 'options', 'showEditor', 'noReset'],
  mixins: [Strings],
  components: {
    Panel: () => import(/* webpackChunkName: "js/devise-utilities" */ './../../utilities/Panel'),
    Toggle: () => import(/* webpackChunkName: "js/devise-utilities" */ './../../utilities/Toggle')
  }
};
</script>
