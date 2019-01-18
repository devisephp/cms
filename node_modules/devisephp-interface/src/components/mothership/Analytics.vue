<template>
<div>
  <div id="devise-admin-content" class="dvs-relative dvs-full" >
      <div v-if="site !== null" class="dvs-p-8">
        <h2 class="dvs-mb-8" :style="{color: theme.panel.color}">
          {{ site.name }} Analytics
        </h2>
        <div class="dvs-flex dvs-mb-8">
          <fieldset class="dvs-fieldset mr-8">
            <label>Analytics Start Date</label>
            <date-picker v-model="analyticsDateRange.start" :settings="{date: true, time: false}" placeholder="Start Date" @update="retrieveAnalytics()" />
          </fieldset>
          <fieldset class="dvs-fieldset">
            <label>Analytics End Date</label>
            <date-picker v-model="analyticsDateRange.end" :settings="{date: true, time: false}" placeholder="End Date" @update="retrieveAnalytics()" />
          </fieldset>
        </div>

        <template  v-if="analytics !== null">

        <!-- Usage Totals -->
        <div class="dvs-flex dvs-justify-between dvs-text-center dvs-text-xs dvs-mb-8">
          <div class="dvs-rounded-sm dvs-p-4 dvs-w-1/5" :style="theme.actionButton">
            <h2 class="dvs-font-bold" :style="{color: theme.actionButton.color}">
              {{ analytics['usage-totals'].Users }}
            </h2>
            <strong class="dvs-uppercase">Users</strong>
          </div>
          <div class="dvs-rounded-sm dvs-p-4 dvs-w-1/5" :style="theme.actionButton">
            <h2 :style="{color: theme.actionButton.color}">
              {{ analytics['usage-totals'].Sessions }}
            </h2>
            <strong class="dvs-uppercase">Sessions</strong>
          </div>
          <div class="dvs-rounded-sm dvs-p-4 dvs-w-1/5" :style="theme.actionButton">
            <h2 :style="{color: theme.actionButton.color}">
              {{ analytics['usage-totals']['Page Views'] }}
            </h2>
            <strong class="dvs-uppercase">Page Views</strong>
          </div>
          <div class="dvs-rounded-sm dvs-p-4 dvs-w-1/5" :style="theme.actionButton">
            <h2 :style="{color: theme.actionButton.color}">
              {{ analytics['usage-totals']['Bounce Rate'] }}
            </h2>
            <strong class="dvs-uppercase">Bounce Rate</strong>
          </div>
        </div>

        <!-- Main Column Divide -->
        <div class="dvs-flex dvs-flex-col lg:dvs-flex-row dvs-mb-8">
          
          <!-- Left Column -->
          <div class="lg:dvs-w-1/2 lg:dvs-pr-10">

            <div class="dvs-mb-16">
              <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">How are site sessions trending?</h4>
              <line-chart class="dvs-mb-8" :chart-data="analytics.sessions" :options="options" />
            </div>

            <div class="dvs-mb-16">
              <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">Channels</h4>
              <div>
                <bar-chart class="dvs-mb-8" :chart-data="analytics.channels" :options="barOptions" />
              </div>
            </div>

            <div class="dvs-mb-8">
              <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">Channels</h4>
              <div>
                <pie-chart class="dvs-mb-8" :chart-data="analytics.browser" :options="pieOptions" />
              </div>
            </div>

          </div>

          <!-- Right Column -->
          <div class="lg:dvs-w-1/2 dvs-p-8 dvs-rounded dvs-shadow-lg" :style="theme.panelCard">
            
            <div class="dvs-mb-8">
              <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">What are the top countries by sessions?</h4>
              <simple-table
              class="dvs-w-full"
              :data="analytics.countries"
              :columns="[
                {name: 'Country'},
                {name: 'Sessions', property: 'Sessions'}
              ]"
              />
            </div>

            <div class="dvs-mb-8">
              <simple-table
              class="dvs-w-full"
              :data="analytics.regions"
              :columns="[
                {name: 'Region'},
                {name: 'Sessions', property: 'Sessions'}
              ]"
              />
            </div>
            
          </div>

        </div>

        <div class="dvs-mb-8">
          <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">Acquisition Sources</h4>
          <simple-table
          class="dvs-w-full"
          :data="analytics['sources-sessions-pageviews']"
          :columns="[
            {name: 'Acquisition Source'},
            {name: 'Sessions', property: 'Sessions'},
            {name: 'Pages / Sessions', property: 'Pages Per Session'}
          ]"
          />
        </div>

         <div class="dvs-mb-8">
          <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">Date Searched</h4>
          <simple-table
          class="dvs-w-full"
          :data="analytics['date-searched']"
          :columns="[
            {name: 'Date Searched'},
            {name: 'Sessions', property: 'Sessions'}
          ]"
          />
        </div>

        <div class="dvs-mb-8">
          <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">Landing Page</h4>
          <simple-table
          class="dvs-w-full"
          :data="analytics['landing-page']"
          :columns="[
            {name: 'Page'},
            {name: 'Sessions', property: 'Sessions'}
          ]"
          />
        </div>

        <div class="dvs-mb-8">
          <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">Devices</h4>
          <simple-table
          class="dvs-w-full"
          :data="analytics['devices']"
          :columns="[
            {name: 'Date Searched'},
            {name: 'Sessions', property: 'Sessions'}
          ]"
          />
        </div>

        </template>


      </div>
      
      <div class="dvs-p-8" v-else>
        <h2 class="dvs-mb-4" :style="{color: theme.panel.color}">To get started select a Site</h2>
        <fieldset class="dvs-fieldset">
          <select v-model="site" @change="retrieveAnalytics()">
            <option :value="null">Select a site</option>
            <option v-for="site in sites.data" :key="site.id" :value="site">{{ site.name }}</option>
          </select>
        </fieldset>
      </div>

    </div>
</div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'
import Dates from './../../mixins/Dates'

export default {
  name: 'MothershipAnalytics',
  data () {
    return {
      analytics: null,
      site: null,
      analyticsDateRange: {
        start: null,
        end: null
      },
    }
  },
  mounted () {
    this.setDefaultAnalytics()
  },
  methods: {
    ...mapActions('devise', [
      'getSiteAnalytics'
    ]),
    setDefaultAnalytics () {
      var today = new Date()
      var oneWeekAgo = new Date()
      oneWeekAgo.setDate(oneWeekAgo.getDate() - 7)

      this.analyticsDateRange.start = this.formatDate(oneWeekAgo)
      this.analyticsDateRange.end = this.formatDate(today)
    },
    formatColors (dataset, index) {
      dataset.fontColor = this.theme.panel.color

      if (typeof this.theme[`chartColor1`] !== 'undefined') {
        dataset.borderColor = []
        dataset.backgroundColor = []
        dataset.pointBackgroundColor = this.theme[`chartColor1`].color
        dataset.pointBorderColor = this.theme[`chartColor1`].color
        for (let i = 1; i < 7; i++) {
          if (typeof this.theme[`chartColor${i}`] !== 'undefined') {
            dataset.borderColor[i] = this.theme[`chartColor${i}`].color
            dataset.backgroundColor[i] = this.theme[`chartColor${i}`].color
          }
        }
      } else {
        dataset.borderColor = this.theme.panel.color
        dataset.backgroundColor = this.theme.statsLeft.color
        dataset.pointBackgroundColor = this.theme.statsRight.color
        dataset.pointBorderColor = this.theme.statsRight.color
      }

      dataset.pointRadius = 4
      dataset.pointHoverRadius = 4
      dataset.fill = false

      return dataset
    },
    formatColors (dataset, index) {
      dataset.fontColor = this.theme.panel.color

      if (typeof this.theme[`chartColor1`] !== 'undefined') {
        dataset.borderColor = []
        dataset.backgroundColor = []

        dataset.pointBackgroundColor = this.theme[`chartColor1`].color
        dataset.pointBorderColor = this.theme[`chartColor1`].color
        for (let i = 1; i < 7; i++) {
          if (typeof this.theme[`chartColor${i}`] !== 'undefined') {
            dataset.borderColor[i - 1] = this.theme[`chartColor${i}`].color
            dataset.backgroundColor[i - 1] = this.theme[`chartColor${i}`].color
          }
        }
      } else {
        dataset.borderColor = this.theme.panel.color
        dataset.backgroundColor = this.theme.statsLeft.color
        dataset.pointBackgroundColor = this.theme.statsRight.color
        dataset.pointBorderColor = this.theme.statsRight.color
      }

      dataset.pointRadius = 4
      dataset.pointHoverRadius = 4
      dataset.fill = false

      return dataset
    },
    retrieveAnalytics () {
      let self = this
      if (this.mothershipApiKey) {
        if (typeof this.analyticsDateRange.start !== 'string' && this.analyticsDateRange.start[0]) {
          this.analyticsDateRange.start = this.formatDate(new Date(this.analyticsDateRange.start[0]))
        }

        if (typeof this.analyticsDateRange.end !== 'string' && this.analyticsDateRange.end[0]) {
          this.analyticsDateRange.end = this.formatDate(new Date(this.analyticsDateRange.end[0]))
        }
        this.getSiteAnalytics({site: this.site.id, dates: this.analyticsDateRange}).then((response) => {

          response.data.sessions.datasets.map(function (dataset, index) {
            return self.formatColors(dataset, index)
          })

          response.data.channels.datasets.map(function (dataset, index) {
            return self.formatColors(dataset, index)
          })

          response.data.browser.datasets.map(function (dataset, index) {
            return self.formatColors(dataset, index)
          })


          // response.data['date-searched'].map(function (dataset, index) {
            //   console.log(dataset, index)
          // })
          for (var date in response.data['date-searched']) {
            if (response.data['date-searched'].hasOwnProperty(date)) {
              response.data['date-searched'][this.formatDate(date)] = response.data['date-searched'][date]
              delete response.data['date-searched'][date]
            }
          }

          self.$set(self, 'analytics', response.data)
        })
      }
    },
  },
  computed: {
    ...mapGetters('devise', [
      'mothership',
      'mothershipApiKey',
      'sites'
    ]),
    options () {
      return {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          labels: {
              fontColor: this.theme.panel.color,
              fontSize: 14
          }
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: this.theme.panel.color,
                    fontSize: 12
                }
            }],
            xAxes: [{
                ticks: {
                    fontColor: this.theme.panel.color,
                    fontSize: 12
                }
            }]
        }
      }
    },
    barOptions () {
      return {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          labels: {
              fontColor: this.theme.panel.color,
              fontSize: 14
          }
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: this.theme.panel.color,
                    fontSize: 12
                }
            }],
            xAxes: [{
                ticks: {
                    fontColor: this.theme.panel.color,
                    fontSize: 12
                }
            }]
        }
      }
    },
    pieOptions () {
      return {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          labels: {
              fontColor: this.theme.panel.color,
              fontSize: 14
          }
        }
      }
    }
  },
  components: {
    BarChart: () => import(/* webpackChunkName: "js/devise-charts" */ './../pages/analytics/Bar'),
    DoughnutChart: () => import(/* webpackChunkName: "js/devise-charts" */ './../pages/analytics/Doughnut'),
    PieChart: () => import(/* webpackChunkName: "js/devise-charts" */ './../pages/analytics/Pie'),
    LineChart: () => import(/* webpackChunkName: "js/devise-charts" */ './../pages/analytics/Line'),
    DatePicker: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/DatePicker'),
    SimpleTable: () => import(/* webpackChunkName: "js/devise-tables" */ './../utilities/tables/SimpleTable')
  },
  mixins: [Dates]
}
</script>