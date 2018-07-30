<template>
  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar" :style="sidebarTheme" data-simplebar>
      <sidebar-header :title="title" :backPage="backPage" :backText="backText" :backCallback="backCallback" />
      <main-menu :menu-items="menuItems" />
    </div>
  </div>
</template>

<script>
import SidebarHeader from './../utilities/SidebarHeader'
import MainMenu from './../menu/MainMenu'

export default {
  name: 'Sidebar',
  components: {
    SidebarHeader,
    MainMenu
  },
  props: ['title', 'backPage', 'backText', 'backCallback', 'menuItems']
}
</script>
