<template>
  <div class="dvs-flex dvs-flex-col dvs-items-center">
    <div class="dvs-relative" :style="{width: currentWidth}">
      <doughnut 
        :chart-data="{
          datasets: [{
            data: chartData,
            backgroundColor: [infoBlockTheme.color, 'rgba(255,255,255,0.4)'], 
            borderWidth: 0
          }],
          labels: [``, ``]
        }" 
        :options="doughnutOptions"></doughnut>
      <div class="dvs-absolute dvs-absolute-center" :class="{'dvs-text-4xl': !minimized, 'dvs-text-lg': minimized}">{{ yesterday }}</div>
    </div>
    <div class="dvs-mt-4 dvs-text-center" :class="{'dvs-text-xs dvs-uppercase': minimized}">
      <strong>{{ stat }}</strong>: {{ Math.abs(change) }}% <i :class="changeIcon"></i> 
    </div>
  </div>
</template>

<script>
import Doughnut from './Doughnut'

export default {
  computed: {
    doughnutOptions () {
      return {
        cutoutPercentage: !this.minimized ? 97 : 88,
        legend: false
      }
    },
    chartData () {
      let weekAgoKey = Object.keys(this.analytics)[0]
      let yesterdayKey = Object.keys(this.analytics)[1]
      let sumOfSample = this.analytics[yesterdayKey][this.stat] + this.analytics[weekAgoKey][this.stat]
      let yesterday = this.analytics[yesterdayKey][this.stat] / sumOfSample
      let weekAgo = this.analytics[weekAgoKey][this.stat] / sumOfSample

      return [yesterday, weekAgo]
    },
    yesterday () {
      let yesterdayKey = Object.keys(this.analytics)[1]
      return this.analytics[yesterdayKey][this.stat]
    },
    change () {
      let weekAgoKey = Object.keys(this.analytics)[0]
      let yesterdayKey = Object.keys(this.analytics)[1]

      return Math.round(((this.analytics[yesterdayKey][this.stat] / this.analytics[weekAgoKey][this.stat]) * 100) - 100)
    },
    changeIcon () {
      if (this.change < 0) {
        return 'ion-arrow-down-b'
      }

      return 'ion-arrow-up-b'
    },
    currentWidth () {
      if (this.minimized) {
        return '50px'
      }
      return '100px'
    }
  },
  components: {
    Doughnut
  },
  props: ['analytics', 'stat', 'minimized']
}
</script>