:<template>

  <div>
    <!-- Back -->
    <div 
      class="dvs-p-4 dvs-text-left dvs-bg-black dvs-opacity-75 hover:dvs-opacity-100" 
      v-if="theBackPage || backCallback">
      <a 
        class="dvs-block dvs-uppercase dvs-text-grey dvs-text-xs" 
        href="#" 
        @click.prevent="goToPage(theBackPage)" 
        v-if="theBackPage && !backCallback">
        <arrow-round-back-icon /> {{ theBackText }}
      </a>

      <a 
        class="dvs-block dvs-uppercase dvs-text-grey dvs-text-xs" 
        href="#" 
        @click.prevent="backCallback()" 
        v-if="backCallback">
        <arrow-round-back-icon /> {{ theBackText }}
      </a>
    </div>

    <div class="dvs-p-8">
      <!-- Logo -->
      <div class="dvs-mt-8" v-if="showLogo">
        <logo class="dvs-w-full mb-2 fill-current" />
      </div>

      <!-- Title -->
      <p 
        class="dvs-mb-2 dvs-font-thin uppercase dvs-text-xl" 
        :style="{color: theme.adminText.color }"
        v-if="title != null">
          {{ title }}
        </p>
    </div>

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
  props: {
    title: {
      default: null,
      type: String
    },
    showLogo: {
      default: true,
      type: Boolean
    },
    backpage: {
      default: null
    },
    backText: {
      default: 'Back to Administration',
      type: String
    },
    backCallback: {
      type: Function
    }
  }
}
</script>