<template>
  <div class="dvs-p-8">
    <h3 class="dvs-mb-6" :style="{color: theme.panel.color}">{{ currentMenu.label }}</h3>
    <ul class="dvs-list-reset">
      <li class="dvs-mb-4" v-for="menuItem in currentMenu.menu" :key="menuItem.id">
        <div
          :style="{color: theme.panel.color}"
          @click="goToPage(menuItem.routeName, menuItem.parameters)"
          class="dvs-block dvs-mb-4 dvs-switch-sm dvs-flex dvs-justify-between dvs-items-center dvs-cursor-pointer"
        >{{ menuItem.label }}</div>
      </li>
    </ul>
  </div>
</template>

<script>
import Administration from './Administration';
import { mapState } from 'vuex';

export default {
  name: 'DeviseIndex',
  methods: {
    findMenu(menu) {
      if (typeof menu === 'object') {
        var safeMenu = Object.keys(menu).map(i => menu[i]);
      } else {
        var safeMenu = menu;
      }

      for (let i = 0; i < safeMenu.length; i++) {
        const m = safeMenu[i];
        if (m.routeName === this.$route.name) {
          return m;
        }
        if (m.menu) {
          var foundMenu = this.findMenu(m.menu);
          if (foundMenu) {
            return foundMenu;
          }
        }
      }
    }
  },
  computed: {
    ...mapState('devise', ['adminMenu']),
    currentMenu() {
      return this.findMenu(this.adminMenu);
    }
  },
  components: {
    Administration: () =>
      import(/* webpackChunkName: "js/devise-administration" */ './/Administration.vue')
  }
};
</script>
