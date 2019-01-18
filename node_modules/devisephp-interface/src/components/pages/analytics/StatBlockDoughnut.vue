<template>
  <div class="dvs-flex dvs-flex-col dvs-items-center">
    <div class="dvs-relative" :style="{width: currentWidth}">
      <doughnut 
        :chart-data="{
          datasets: [{
            data: chartData,
            backgroundColor: [theme.panel.color], 
            borderWidth: 0
          }],
          labels: [``, ``]
        }" 
        :options="doughnutOptions"></doughnut>
      <div class="dvs-absolute dvs-absolute-center dvs-text-lg">{{ yesterday }}</div>
    </div>
    <div class="dvs-mt-4 dvs-text-center dvs-text-xs dvs-uppercase">
      <strong>{{ stat }}</strong>: {{ change }}% <i :class="changeIcon"></i> 
    </div>
  </div>
</template>

<script>
import Doughnut from './Doughnut'

export default {
  computed: {
    doughnutOptions () {
      return {
        cutoutPercentage: 88,
        legend: false
      }
    },
    chartData () {
      let weekAgoKey = Object.keys(this.analytics)[0]
      let yesterdayKey = Object.keys(this.analytics)[1]
      let sumOfSample = this.analytics[yesterdayKey][this.stat] + this.analytics[weekAgoKey][this.stat]
      var yesterday = this.analytics[yesterdayKey][this.stat] / sumOfSample
      var weekAgo = this.analytics[weekAgoKey][this.stat] / sumOfSample

      if (isNaN(yesterday)) {
        yesterday = 0
      }

      if (isNaN(weekAgo)) {
        weekAgo = 1
      }

      if(yesterday / weekAgo > 1) {
        yesterday = 0
        weekAgo = 1
      }

      return [weekAgo, yesterday]
    },
    yesterday () {
      let yesterdayKey = Object.keys(this.analytics)[1]
      return this.analytics[yesterdayKey][this.stat]
    },
    change () {
      let weekAgoKey = Object.keys(this.analytics)[0]
      let yesterdayKey = Object.keys(this.analytics)[1]

      var change = Math.round(((this.analytics[yesterdayKey][this.stat] / this.analytics[weekAgoKey][this.stat]) * 100) - 100)
      
      if (isNaN(change)) {
        change = 0
      }

      return change
    },
    changeIcon () {
      if (this.change < 0) {
        return 'ion-arrow-down-b'
      }

      return 'ion-arrow-up-b'
    },
    currentWidth () {
        return '50px'
    }
  },
  components: {
    Doughnut
  },
  props: ['analytics', 'stat']
}
</script>