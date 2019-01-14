<template>
  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-admin-content">It's time to back up!</div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Dates from './../../mixins/Dates';
// import StatBlockDoughnut from './analytics/StatBlockDoughnut'

export default {
  name: 'MothershipBackups'
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
  //   mixins: [Dates]
};
</script>