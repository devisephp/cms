<template>
  <div class="dvs-fixed dvs-pin">
    <div class="dvs-blocker dvs-fixed dvs-pin" @click="close"></div>
    <div class="dvs-absolute dvs-absolute-center dvs-z-50 dvs-rounded dvs-min-w-2/3 dvs-max-h-screen" data-simplebar :style="adminTheme">
      <div class="dvs-p-8"> 
        <div @click="close">
          <close-circle-icon w="20" h="20" class="dvs-absolute dvs-pin-t dvs-pin-r dvs-m-8 dvs-cursor-pointer"  :style="{color: theme.adminText.color }" />
        </div>
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>

import CloseCircleIcon from 'vue-ionicons/dist/md-close-circle.vue'

export default {
  methods: {
    close () {
      this.$emit('close')
    }
  },
  components: {
    CloseCircleIcon
  }
}
</script>
