<template>
  <administration>
    <sidebar title="Settings" :menu-items="settingsMenu" />
  </administration>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
  name: 'SettingsIndex',
  computed: {
    ...mapGetters('devise', [
      'settingsMenu'
    ])
  }
}
</script>
