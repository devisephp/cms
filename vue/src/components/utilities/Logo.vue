<template>
  <div>
    <devise-logo style="width:120px;" :color="theme.sidebarText.color" v-if="!interface || !interface.logo" />
    <img :src="interface.logo" v-else>
  </div>
</template>

<script>
import DeviseLogo from './DeviseLogo'

import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters('devise', [
      'interface'
    ])
  },
  components: {
    DeviseLogo
  }
}
</script>