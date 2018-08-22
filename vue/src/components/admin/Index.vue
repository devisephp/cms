<template>
<div class="dvs-p-8">
  <h3 class="mb-6">{{ currentMenu.label }}</h3>
  <ul class="dvs-list-reset">
    <transition-group name="dvs-fade">
      <li class="dvs-mb-4" v-for="(menuItem, key) in currentMenu.menu" :key="key">
        <div 
          :style="{color: theme.panel.color}" 
          @click="goToPage(menuItem.routeName, menuItem.parameters)"
          class="dvs-block dvs-mb-4 dvs-switch-sm dvs-flex dvs-justify-between dvs-items-center dvs-cursor-pointer">
            {{ menuItem.label }}
        </div>
      </li>
    </transition-group>
  </ul>
</div>
</template>

<script>
import Administration from './Administration'
import Sidebar from './../utilities/Sidebar'
import { mapState } from 'vuex';

export default {
  name: 'DeviseIndex',
  methods: {
    findMenu (menu) {
      for (let i = 0; i < menu.length; i++) {
        const m = menu[i]
        if (m.routeName === this.$route.name) {
          return m
        }
        if (m.menu) {
          var foundMenu = this.findMenu(m.menu)
          if (foundMenu) {
            return foundMenu
          }
        } 
      }
    }
  },
  computed: {
    ...mapState([
      'adminMenu'
    ]),
    currentMenu () {
      return this.findMenu(this.adminMenu)
    }
  },
  components: {
    Administration,
    Sidebar
  }
}
</script>
