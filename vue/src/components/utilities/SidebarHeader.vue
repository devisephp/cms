:<template>
  <div class="dvs-mt-8">
    <!-- Logo -->
    <logo class="dvs-my-4 dvs-mt-2 dvs-w-full dvs-flex dvs-justify-center" />

    <!-- Title -->
    <h2 class="dvs-mb-2 dvs-font-hairline" :style="{color: theme.sidebarText.color }">{{ title }}</h2>

    <!-- Back -->
    <a 
      class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" 
      href="#" 
      @click.prevent="goToPage(backPage)" 
      :style="{color: theme.sidebarText.color }"
      v-if="backPage">
      <i class="ion-arrow-left-c"></i> {{ backText }}
    </a>

    <a 
      class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" 
      href="#" 
      @click.prevent="backCallback()" 
      :style="{color: theme.sidebarText.color }"
      v-if="backCallback">
      <i class="ion-arrow-left-c"></i> {{ backText }}
    </a>

  </div>
</template>

<script>
export default {
  props: ['title', 'backPage', 'backText', 'backCallback']
}
</script>