:<template>

  <div class="dvs-mb-10">

    <!-- Back -->
    <div 
      class="dvs-p-4 dvs-text-left" 
      :style="{backgroundColor: theme.adminBackground.color}"
      v-if="theBackPage || backCallback">
      <a 
        class="dvs-block dvs-uppercase  dvs-text-xs" 
        href="#" 
        @click.prevent="goToPage(theBackPage)" 
        :style="{color: theme.sidebarText.color }"
        v-if="theBackPage && !backCallback">
        <arrow-round-back-icon /> {{ theBackText }}
      </a>

      <a 
        class="dvs-block dvs-uppercase dvs-text-xs" 
        href="#" 
        @click.prevent="backCallback()" 
        :style="{color: theme.sidebarText.color }"
        v-if="backCallback">
        <arrow-round-back-icon /> {{ theBackText }}
      </a>
    </div>

    <!-- Logo -->
    <div class="dvs-mt-8">
      <logo class="dvs-w-full mb-2 dvs-flex dvs-justify-center" />
    </div>

    <!-- Title -->
    <p class="dvs-mb-2 dvs-font-thin uppercase dvs-text-xl" :style="{color: theme.sidebarText.color }">{{ title }}</p>

  </div>
</template>

<script>

import ArrowRoundBackIcon from 'vue-ionicons/dist/ios-arrow-round-back.vue'

export default {
  components: {
    ArrowRoundBackIcon
  },
  computed: {
    theBackPage () {
      if (typeof this.backPage === 'undefined') {
        return 'devise-index'
      } else {
        if (this.backPage !== null) {
          return this.backPage
        }
      }
    },
    theBackText () {
      if (typeof this.backText === 'undefined') {
        return 'Back to Administration'
      } else {
        if (this.backText !== null) {
          return this.backText
        }
      }
    }
  },
  props: ['title', 'backPage', 'backText', 'backCallback']
}
</script>