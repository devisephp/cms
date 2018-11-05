<template>
  <li v-if="show" @click="clickedLink" class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold">
    {{ item.label }}
  </li>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  methods: {
    clickedLink() {
      if (typeof this.item.routeName !== 'undefined' && this.item.routeName !== null) {
        if (typeof this.item.parameters !== 'undefined' && this.item.parameters !== null) {
          this.goToPage(this.item.routeName, this.item.parameters)
        } else {
          this.goToPage(this.item.routeName)
        }
      }
      else if (typeof this.item.url !== 'undefined' && this.item.url !== null) {
        if (typeof this.item.target !== 'undefined' && this.item.target !== null) {
          window.open(this.item.url, this.item.target)
        } else {
          window.open(this.item.url)
        }
      }
    }
  },
  computed: {
    ...mapGetters('devise', [
      'adminMenu',
      'mothershipApiKey'
    ]),
    show () {
      // Page Editor
      if (this.item.routeName === 'devise-page-editor') {
        if (!this.editablePage) {
          return false
        }
      }

      // Mothership
      if (this.item.routeName === 'devise-mothership-index') {
        if (this.mothershipApiKey === null) {
          return false
        }
      }

      // Check Permissions
      if(this.item.permissions){
        return this.can(this.item.permissions)
      }

      return true
    },
    editablePage () {
      return typeof deviseSettings !== 'undefined' && typeof deviseSettings.$page !== 'undefined'
    }
  },
  props: ['item']
}
</script>