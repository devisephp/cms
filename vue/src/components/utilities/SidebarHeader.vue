:<template>
  <div>
    <!-- Logo -->
    <logo class="dvs-my-4 dvs-mt-2 dvs-w-full dvs-flex dvs-justify-center" />

    <!-- Title -->
    <h2 class="dvs-font-bold dvs-mb-2" :style="{color: theme.sidebarText.color }">{{ title }}</h2>

    <!-- Back -->
    <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage(backPage)" :style="{color: theme.sidebarText.color }">
      <i class="ion-arrow-left-c"></i> {{ backText }}
    </a>
  </div>
</template>

<script>
export default {
  props: ['title', 'backPage', 'backText']
}
</script>