<template>
<div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar" :style="sidebarTheme" data-simplebar>
      <sidebar-header title="Mothership" back-text="Back to Administration" back-page="devise-index" />

      <ul class="dvs-list-reset dvs-mb-10">
        <li class="dvs-mb-6 dvs-text-lg dvs-cursor-pointer" @click="goToPage('devise-ms-analytics-index')">
          Analytics
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click.prevent="goToPage('devise-ms-changes-index')">
          Changes
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click.prevent="goToPage('devise-ms-releases-index')">
          Releases
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click.prevent="goToPage('devise-ms-healthreports-index')">
          Health Report
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click.prevent="goToPage('devise-ms-backups-index')">
          Backups
        </li>
      </ul>
    </div>
</div>
</template>

<script>


import { mapGetters, mapActions } from 'vuex'
import Dates from './../../mixins/Dates'
import SidebarHeader from './../utilities/SidebarHeader'
// import StatBlockDoughnut from './analytics/StatBlockDoughnut'

export default {
  name: 'MothershipIndex',
//   data () {
//     return {
//       analytics: null,
//       minimized: false
//     }
//   },
//   mounted () {

//   },
//   methods: {
//     ...mapActions('devise', [
//       'getPageAnalyticsTotals'
//     ]),
//     retrieveAnalytics () {
//       let self = this
//       if (this.mothership) {

//         var yesterday = new Date()
//         yesterday.setDate(yesterday.getDate() - 1)
// // http://104.236.153.6/api/v1/analytics/site?start_date=2018-04-01&end_date=2018-04-29
//         this.getSiteAnalytics({slug: this.currentPage.slug, date: this.formatDate(yesterday)}).then(function (response) {
//           self.$set(self, 'analytics', response.data)
//         })
//       }
//     },
//   },
//   computed: {
//     ...mapGetters('devise', [
//       'mothership',
//       'currentPage'
//     ])
//   },
  components: {
    SidebarHeader
  },
//   mixins: [Dates]
}
</script>