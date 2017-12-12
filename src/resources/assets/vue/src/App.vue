<style lang="scss">
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
  components: {
    Messages
  }
}
</script>
