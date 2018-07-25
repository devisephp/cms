:<template>

  <div class="dvs-mb-10">

    <!-- Back -->
    <div 
      class="dvs--mt-8 dvs--mx-8 dvs-mb-8 dvs-p-4 dvs-text-left" 
      :style="{backgroundColor: theme.adminBackground.color}"
      v-if="backPage || backCallback">
      <a 
        class="dvs-block dvs-uppercase  dvs-text-xs" 
        href="#" 
        @click.prevent="goToPage(backPage)" 
        :style="{color: theme.sidebarText.color }"
        v-if="backPage">
        <arrow-round-back-icon /> {{ backText }}
      </a>

      <a 
        class="dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" 
        href="#" 
        @click.prevent="backCallback()" 
        :style="{color: theme.sidebarText.color }"
        v-if="backCallback">
        <arrow-round-back-icon /> {{ backText }}
      </a>
    </div>

    <!-- Logo -->
    <div>
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
  props: ['title', 'backPage', 'backText', 'backCallback']
}
</script>