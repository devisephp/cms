<template>
  <div>
    <devise-logo style="width:120px;" v-if="!deviseInterface || !deviseInterface.logo" />
    <img :src="deviseInterface.logo" v-else>
  </div>
</template>

<script>
import DeviseLogo from './DeviseLogo'

import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters('devise', [
      'deviseInterface'
    ])
  },
  components: {
    DeviseLogo
  }
}
</script>