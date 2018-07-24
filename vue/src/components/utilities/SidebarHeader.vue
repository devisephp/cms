:<template>
  <div class="dvs-mt-8">
    <!-- Logo -->
    <logo class="dvs-my-4 dvs-mt-2 dvs-mb-10 dvs-w-full dvs-flex dvs-justify-center" />

    <!-- Title -->
    <h3 class="dvs-mb-2 dvs-font-thin" :style="{color: theme.sidebarText.color }">{{ title }}</h3>

    <!-- Back -->
    <a 
      class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" 
      href="#" 
      @click.prevent="goToPage(backPage)" 
      :style="{color: theme.sidebarText.color }"
      v-if="backPage">
      <arrow-round-back-icon /> {{ backText }}
    </a>

    <a 
      class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" 
      href="#" 
      @click.prevent="backCallback()" 
      :style="{color: theme.sidebarText.color }"
      v-if="backCallback">
      <arrow-round-back-icon /> {{ backText }}
    </a>

  </div>
</template>

<script>

import ArrowRoundBackIcon from 'vue-ionicons/dist/ios-arrow-round-back.vue'

export default {
  components: {
    ArrowRoundBackIcon
  },
  props: ['title', 'backPage', 'backText', 'backCallback']
}
</script>