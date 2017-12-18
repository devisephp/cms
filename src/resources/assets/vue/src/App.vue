<style lang="scss" scoped>
  @import "sass/app.scss";
</style>

<template>
  <div id="app">
    <messages></messages>
    <router-view/>
  </div>
</template>

<script>
import store from './vuex/store'

import Messages from './components/Messages'

export default {
  store: store,
  name: 'app',
  mounted () {
    if (window.mode === 'media') {
      this.$router.push({name: 'MediaManager'})
    } else {
      this.$router.push({name: 'Meta'})
    }
  },
  components: {
    Messages
  }
}
</script>
