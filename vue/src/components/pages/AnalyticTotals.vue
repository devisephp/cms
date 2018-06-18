<template>
  <div 
    id="devise-in-page-analytics" 
    class="dvs-fixed dvs-pin-b dvs-pin-r dvs-z-30 dvs-mr-8 dvs-mb-8 dvs-p-4 dvs-pb-0" 
    :style="infoBlockTheme" 
    v-if="analytics !== null">
    <div class="dvs-flex" v-if="anlyticsHasData">
      <div class="dvs-flex dvs-flex-wrap dvs-justify-around dvs-w-full">
        <stat-block-doughnut class="dvs-mr-4 dvs-mb-4" :analytics="this.analytics" stat="Sessions" />
        <stat-block-doughnut class="dvs-mr-4 dvs-mb-4" :analytics="this.analytics" stat="Page Views" />
        <stat-block-doughnut class="dvs-mr-4 dvs-mb-4" :analytics="this.analytics" stat="Bounce Rate" />
        <stat-block-doughnut :analytics="this.analytics" stat="Time On Page" />
      </div>
    </div>
    <div v-else class="dvs-p-8 dvs-pt-4 dvs-text-center">
      It appears there is not enough data in Google Analytics yet to present statistics. There needs to be at least one week of data and then we will start showing you how this page is performing!
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Dates from './../../mixins/Dates'
import StatBlockDoughnut from './analytics/StatBlockDoughnut'

export default {
  data () {
    return {
      analytics: null,
      minimized: false
    }
  },
  mounted () {
    this.retrieveAnalytics()
  },
  methods: {
    ...mapActions('devise', [
      'getPageAnalyticsTotals'
    ]),
    retrieveAnalytics () {
      let self = this
      if (this.mothership) {

        var yesterday = new Date()
        yesterday.setDate(yesterday.getDate() - 1)

        this.getPageAnalyticsTotals({slug: this.currentPage.slug, date: this.formatDate(yesterday)}).then(function (response) {
          self.$set(self, 'analytics', response.data)
        })
      }
    },
  },
  computed: {
    ...mapGetters('devise', [
      'mothership',
      'currentPage'
    ]),
    anlyticsHasData () {
      for(var date in this.analytics) {
        if (this.analytics[date] === null) {
          return false
        }
      }
      return true
    }
  },
  components: {
    StatBlockDoughnut
  },
  mixins: [Dates]
}
</script>