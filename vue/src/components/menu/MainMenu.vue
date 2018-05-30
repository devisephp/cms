<template>
  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar" :style="sidebarTheme">

      <sidebar-header title="Administration" />

      <ul class="dvs-list-reset">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-page-editor')">
          Edit this page
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-pages-index')">
          Pages
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-industries-index')">
          Industries
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-products-index')">
          Products
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-users-index')">
          Users
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-mothership-index')" v-if="mothership !== null">
          Mothership
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-templates-index')">
          Templates
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-settings-index')">
          Settings
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import SidebarHeader from './../utilities/SidebarHeader'

export default {
  name: 'MainMenu',
  data () {
    return {
    }
  },
  computed: {
    ...mapGetters('devise', [
      'mothership'
    ])
  },
  components: {
    SidebarHeader
  }
}
</script>
