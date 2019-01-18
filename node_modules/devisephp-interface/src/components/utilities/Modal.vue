<template>
  <div class="dvs-fixed dvs-pin">
    <div class="dvs-blocker dvs-fixed dvs-pin" @click="close"></div>
    <div class="dvs-absolute dvs-absolute-center dvs-z-50 dvs-min-w-2/3 dvs-max-h-screen">
      <panel class="dvs-w-full" :panel-style="theme.panel">
        <div class="dvs-p-8">
          <div @click="close">
            <close-icon
              w="40"
              h="40"
              class="dvs-absolute dvs-pin-t dvs-pin-r dvs-m-6 dvs-cursor-pointer"
              :style="{color: theme.panel.color }"
            />
          </div>
          <slot></slot>
        </div>
      </panel>
    </div>
  </div>
</template>

<script>
import Panel from './Panel';

export default {
  methods: {
    close() {
      this.$emit('close');
    }
  },
  components: {
    CloseIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-close.vue'),
    Panel
  }
};
</script>
