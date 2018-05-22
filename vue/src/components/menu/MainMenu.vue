<template>
  <div class="dvs-p-8">
    <h2 class="dvs-font-bold dvs-mb-8" :style="{color: theme.sidebarText.color}">Administration</h2>
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
      <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('Analytics')">
        Analytics
      </li>
      <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-templates-index')">
        Templates
      </li>
      <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('devise-settings-index')">
        Settings
      </li>

      <!-- <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="goToPage('Publishing')">
        Publishing
      </li> -->
    </ul>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'MainMenu',
  data () {
    return {
    }
  },
  methods: {}
}
</script>
