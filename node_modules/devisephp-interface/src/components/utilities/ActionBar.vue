<template>
  <div class="devise-admin-action-bar">
    <button
      @click="show = !show"
      class="dvs-rounded-full dvs-outline-none"
      style="width:50px;height:50px;"
      :style="theme.actionButtonGhost"
    >
      <flash-icon w="30" h="30"/>
    </button>

    <transition name="dvs-fade">
      <ul
        v-if="show"
        @click="show = false"
        class="dvs-list-reset dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-4 dvs-z-10"
        style="width:200px; margin-right:80px;"
      >
        <slot></slot>
      </ul>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false
    };
  },
  components: {
    FlashIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-flash.vue')
  }
};
</script>
