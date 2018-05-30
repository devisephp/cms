<template>
  <div 
    id="devise-in-page-analytics" 
    class="dvs-fixed dvs-pin-b dvs-pin-r dvs-z-30 dvs-mr-8 dvs-mb-8 dvs-pb-0" 
    :style="infoBlockTheme" 
    :class="{'dvs-p-8': !minimized, 'dvs-p-4': minimized}"
    v-if="analytics !== null">
    <div class="dvs-mb-8 dvs-mx-8 dvs-max-w-xs" v-show="!minimized">
      <strong>{{ currentPage.title }} Analytics</strong><br>
      <p class="dvs-mb-0">
        Analytics for yesterday as compared with analytics from the same time a week ago.
      </p>
    </div>
    <div class="dvs-flex">
      <div class="dvs-flex dvs-flex-wrap dvs-justify-around dvs-w-full">
        <stat-block-doughnut class="dvs-mr-4 dvs-mb-4" :analytics="this.analytics" stat="Sessions" :minimized="minimized" />
        <stat-block-doughnut class="dvs-mr-4 dvs-mb-4" :analytics="this.analytics" stat="Page Views" :minimized="minimized" />
        <stat-block-doughnut class="dvs-mr-4 dvs-mb-4" :analytics="this.analytics" stat="Bounce Rate" :minimized="minimized" />
        <stat-block-doughnut :analytics="this.analytics" stat="Time On Page" :minimized="minimized" />
      </div>
    </div>

    <i 
      :class="{
        'ion-minus-round': !minimized,
        'ion-plus-round': minimized
      }"
      class="dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-4 dvs-mr-4 dvs-cursor-pointer"
      @click="minimized = !minimized">
    </i>
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
    ])
  },
  components: {
    StatBlockDoughnut
  },
  mixins: [Dates]
}
</script>