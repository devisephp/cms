<template>
  <div>
    <transition name="dvs-fade">
      <div v-if="show" class="dvs-fixed dvs-pin">
        <div class="dvs-fixed dvs-pin dvs-blocker"></div>
        <div
          class="dvs-absolute dvs-absolute-center dvs-bg-white dvs-z-50 dvs-p-8 dvs-rounded dvs-shadow dvs-text-sm dvs-uppercase dvs-font-bold dvs-text-center"
        >
          <img src="/devise/images/loader.gif" class="dvs-mb-2">
          <div class="dvs-text-black">{{ message }}</div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      message: null
    };
  },
  mounted() {
    deviseSettings.$bus.$on('showLoadScreen', message => {
      this.message = message;
      this.show = true;

      setTimeout(() => {
        this.message = 'We had issues loading';
        this.show = false;
      }, 15000);
    });

    deviseSettings.$bus.$on('hideLoadScreen', () => {
      this.show = false;
      this.message = null;
    });
  }
};
</script>