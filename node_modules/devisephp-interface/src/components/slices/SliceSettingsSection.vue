<template>
  <div>
    <h3 class="dvs-uppercase dvs-mb-2" :style="{color: theme.panelCard.color}">{{ responsiveMode }}</h3>
    <fieldset class="dvs-fieldset">
      <label>Margins and Padding</label>
    </fieldset>

    <div class="dvs-flex dvs-justify-center dvs-my-4" id="dvs-slice-manager-margins-padding">
      <div :style="theme.panelCard">
        <div class="dvs-flex dvs-p-2 dvs-pb-0">
          <div class="dvs-text-xs dvs-uppercase dvs-w-1/3">Margin</div>
          <div class="dvs-w-1/3 dvs-text-center">
            <input
              type="number"
              :value="getStyle('margin', 'top')"
              @keyup="setMargin('top', $event)"
              @click="setMargin('top', $event)"
            >
          </div>
        </div>
        <div class="dvs-flex dvs-items-center dvs-px-2">
          <div>
            <input
              type="number"
              :value="getStyle('margin', 'left')"
              @keyup="setMargin('left', $event)"
              @click="setMargin('left', $event)"
            >
          </div>
          <div class="dvs-p-2">
            <div :style="theme.actionButton">
              <div class="dvs-flex dvs-p-2 dvs-pb-0">
                <div class="dvs-text-xs dvs-uppercase dvs-w-1/3">Padding</div>
                <div class="dvs-w-1/3 dvs-text-center">
                  <input
                    type="number"
                    :value="getStyle('padding', 'top')"
                    @keyup="setPadding('top', $event)"
                    @click="setPadding('top', $event)"
                  >
                </div>
              </div>
              <div class="dvs-flex dvs-items-center dvs-px-2">
                <div>
                  <input
                    type="number"
                    :value="getStyle('padding', 'left')"
                    @keyup="setPadding('left', $event)"
                    @click="setPadding('left', $event)"
                  >
                </div>
                <div class="dvs-p-2">
                  <div class="dvs-bg-white dvs-w-24 dvs-h-24">&nbsp;</div>
                </div>
                <div>
                  <input
                    type="number"
                    :value="getStyle('padding', 'right')"
                    @keyup="setPadding('right', $event)"
                    @click="setPadding('right', $event)"
                  >
                </div>
              </div>
              <div class="dvs-flex dvs-justify-center dvs-p-2 dvs-pt-0">
                <div class="dvs-text-center">
                  <input
                    type="number"
                    :value="getStyle('padding', 'bottom')"
                    @keyup="setPadding('bottom', $event)"
                    @click="setPadding('bottom', $event)"
                  >
                </div>
              </div>
            </div>
          </div>
          <div>
            <input
              type="number"
              :value="getStyle('margin', 'right')"
              @keyup="setMargin('right', $event)"
              @click="setMargin('right', $event)"
            >
          </div>
        </div>
        <div class="dvs-flex dvs-justify-center dvs-p-2 dvs-pt-0">
          <div class="dvs-text-center">
            <input
              type="number"
              :value="getStyle('margin', 'bottom')"
              @keyup="setMargin('bottom', $event)"
              @click="setMargin('bottom', $event)"
            >
          </div>
        </div>
      </div>
    </div>

    <fieldset class="dvs-fieldset dvs-mt-8">
      <label>Background Color</label>
      <p class="dvs-mb-4 dvs-text-xs">Note: Background color effects all responsive sizes</p>
    </fieldset>
    <div v-show="showBackgroundColor">
      <sketch-picker v-model="bg"/>
    </div>
    <button
      v-show="!showBackgroundColor"
      class="dvs-btn"
      :style="theme.actionButton"
      @click="showBackgroundColor = true"
    >Set Background Color</button>
    <button
      class="dvs-btn dvs-mt-8 dvs-rounded-full dvs-w-full"
      :style="theme.actionButtonGhost"
      @click="resetStyles"
    >Reset</button>
  </div>
</template>

<script>
import { Photoshop, Sketch } from 'vue-color';

export default {
  data() {
    return {
      showBackgroundColor: false
    };
  },
  props: ['value', 'responsiveMode', 'backgroundColor'],
  computed: {
    bg: {
      get() {
        return this.backgroundColor;
      },
      set(color) {
        this.$emit('setbackground', color);
      }
    }
  },
  methods: {
    setMargin(position, event) {
      let value = event.target.value;
      this.$emit('setmarginpadding', {
        responsiveMode: this.responsiveMode,
        type: 'margin',
        position: position,
        value: value
      });
    },
    setPadding(position, event) {
      let value = event.target.value;
      this.$emit('setmarginpadding', {
        responsiveMode: this.responsiveMode,
        type: 'padding',
        position: position,
        value: value
      });
    },

    getStyle(type, position) {
      if (type === 'margin' || type === 'padding') {
        let prefix = '';
        if (this.responsiveMode !== 'desktop') {
          prefix = this.responsiveMode + '_';
        }

        if (typeof this.value[prefix + type] !== 'undefined') {
          if (typeof this.value[prefix + type][position] !== 'undefined') {
            return this.value[prefix + type][position];
          }
        }
        return 0;
      }
    },
    resetStyles() {
      this.$emit('resetstyles', this.responsiveMode);
    }
  },
  components: {
    'sketch-picker': Sketch
  }
};
</script>
