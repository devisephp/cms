<template>
  <administration>
    <sidebar title="Administration" :backPage="null" />
  </administration>
</template>

<script>
import Administration from './Administration'
import Sidebar from './../utilities/Sidebar'

export default {
  name: 'DeviseIndex',
  components: {
    Administration,
    Sidebar
  }
}
</script>
