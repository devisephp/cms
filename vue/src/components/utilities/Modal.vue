<template>
  <div class="dvs-fixed dvs-pin">
    <div class="dvs-blocker dvs-fixed dvs-pin" @click="close"></div>
    <div class="dvs-absolute dvs-absolute-center dvs-z-50 dvs-bg-white dvs-p-8 dvs-rounded dvs-shadow-lg">
      <i class="ion-close-round dvs-font-xl dvs-absolute dvs-pin-t dvs-pin-r dvs-m-8 dvs-cursor-pointer" @click="close" />
      <slot></slot>
    </div>
  </div>
</template>

<script>

export default {
  methods: {
    close () {
      this.$emit('close')
    }
  }
}
</script>
