<template>
<div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar" :style="sidebarTheme" data-simplebar>
      <sidebar-header title="Network Analytics" back-text="Back to Mothership" back-page="devise-mothership-index" />
    </div>

    <div id="devise-admin-content" >
        It's time to make some changes
    </div>
</div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'
import SidebarHeader from './../utilities/SidebarHeader'

export default {
    name: 'MothershipChanges',
    data () {
      return {
        analytics: null,
        minimized: false,
        localValue: null
      }
    },
    mounted () {
      this.retrieveChanges()
    },
    methods: {
      ...mapActions('devise', [
        'getPendingChanges'
      ]),
      retrieveChanges () {
        let self = this
        this.getPendingChanges().then(function (response) {
          self.$set(self, 'localValue', response.data)
        })
      },
    },
    computed: {
      ...mapGetters('devise', [
        'changes'
      ])
    },
    components: {
      SidebarHeader
    }
}
</script>