<template>
  <div class="dvs-p-8 dvs-bg-green dvs-text-white">
    <h2>Congratulations!</h2>
    <p>You are finished with the required elements of your Devise install. Click below to complete your install. If you ever want to come back simple delete the "DVS_MODE=active" from your .env file.</p>
    <button
      class="dvs-btn dvs-bg-white dvs-text-green"
      @click.prevent="attemptCompleteInstall()"
    >Complete Install</button>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  methods: {
    ...mapActions(['completeInstall']),
    attemptCompleteInstall() {
      this.completeInstall().then(() => {
        location.reload();
      });
    }
  },
  props: {
    finished: {
      type: Boolean,
      required: true
    }
  }
};
</script>