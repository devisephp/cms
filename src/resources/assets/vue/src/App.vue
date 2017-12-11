<style lang="scss">
  @import "sass/app.scss";
</style>

<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
import store from './vuex/store'

export default {
  store: store,
  name: 'app'
}
</script>
