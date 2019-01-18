<template>
  <ul class="dvs-list-reset dvs-mt-8">
    <template v-for="(menuItem, key) in menu">
      <menu-item :item="menuItem" :key="key"></menu-item>
    </template>
  </ul>
</template>

<script>
import { mapGetters } from 'vuex'
import MenuItem from './MenuItem'

export default {
  name: 'MainMenu',
  data () {
    return {
    }
  },
  computed: {
    ...mapGetters('devise', [
      'adminMenu'
    ]),
    menu () {
      if (this.menuItems !== null) {
        return this.menuItems
      }

      return this.adminMenu
    }
  },
  components: {
    MenuItem
  },
  props: {
    menuItems: {
      default: null
    }
  }
}
</script>
