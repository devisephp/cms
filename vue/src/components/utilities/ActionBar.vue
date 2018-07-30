<template>
  <div class="devise-admin-action-bar" style="width:200px;" >
    <button @click="show = !show" class="dvs-rounded-full dvs-outline-none" :style="actionButtonTheme" style="width:75px;height:75px;">
      <flash-icon w="30" h="30" />
    </button>

    <transition name="fade">
      <ul v-if="show" class="dvs-min-w-full dvs-list-reset dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-8" style="margin-right:100px">
        <slot></slot>
      </ul>
    </transition>

  </div>
</template>

<script>
import FlashIcon from 'vue-ionicons/dist/ios-flash.vue'

export default {
  data () {
    return {
      show: false
    }
  },
  components: {
    FlashIcon
  }
}
</script>
