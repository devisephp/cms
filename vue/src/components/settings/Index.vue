<template>

  <div class="dvs-flex dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar" :style="sidebarTheme" data-simplebar>
      
      <sidebar-header title="Settings" back-text="Back to Administration" back-page="devise-index" />

      <ul class="dvs-list-reset dvs-mb-10">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click="goToPage('devise-meta-manage')">
          Global Meta
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click="goToPage('devise-languages-manage')">
          Languages
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click.prevent="goToPage('devise-sites-index')">
          Sites
        </li>
      </ul>
    </div>
  </div>

</template>

<script>
import SidebarHeader from './../utilities/SidebarHeader'

export default {
  name: 'SettingsIndex',
  components: {
    SidebarHeader
  }
}
</script>
