<template>
<div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar" :style="sidebarTheme" data-simplebar>
      <sidebar-header title="Network Analytics" back-text="Back to Mothership" back-page="devise-mothership-index" />
    </div>

    <div id="devise-admin-content" class="dvs-relative"  :style="adminTheme">
      <div v-if="site !== null">
        <h2 class="dvs-mb-8" :style="{color: theme.sidebarText.color}">
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
          <div>
            <h2 :style="{color: theme.sidebarText.color}">
              {{ analytics['usage-totals'].Users }}
            </h2>
            <strong class="dvs-uppercase">Users</strong>
          </div>
          <div>
            <h2 :style="{color: theme.sidebarText.color}">
              {{ analytics['usage-totals'].Sessions }}
            </h2>
            <strong class="dvs-uppercase">Sessions</strong>
          </div>
          <div>
            <h2 :style="{color: theme.sidebarText.color}">
              {{ analytics['usage-totals']['Page Views'] }}
            </h2>
            <strong class="dvs-uppercase">Page Views</strong>
          </div>
          <div>
            <h2 :style="{color: theme.sidebarText.color}">
              {{ analytics['usage-totals']['Bounce Rate'] }}
            </h2>
            <strong class="dvs-uppercase">Bounce Rate</strong>
          </div>
        </div>

        <!-- Main Column Divide -->
        <div class="dvs-flex dvs-flex-col lg:dvs-flex-row dvs-mb-8">
          
          <!-- Left Column -->
          <div class="lg:dvs-w-1/2 lg:dvs-pr-4">

            <div class="dvs-mb-8">
              <h4 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">How are site sessions trending?</h4>
              <line-chart class="dvs-mb-8" :chart-data="analytics.sessions" :options="options" />
            </div>

            <div class="dvs-mb-8">
              <h4 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">Channels</h4>
              <div>
                <bar-chart class="dvs-mb-8" :chart-data="analytics.channels" :options="barOptions" />
              </div>
            </div>

            <div class="dvs-mb-8">
              <h4 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">Channels</h4>
              <div>
                <pie-chart class="dvs-mb-8" :chart-data="analytics.browser" :options="pieOptions" />
              </div>
            </div>

          </div>

          <!-- Right Column -->
          <div class="lg:dvs-w-1/2 lg:dvs-pl-4">
            
            <div class="dvs-mb-8">
              <h4 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">What are the top countries by sessions?</h4>
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
          <h4 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">Acquisition Sources</h4>
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
          <h4 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">Date Searched</h4>
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
          <h4 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">Landing Page</h4>
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
          <h4 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">Devices</h4>
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
      
      <div class="dvs-absolute dvs-absolute-center dvs-p-8" :style="infoBlockFlatTheme" v-else>
        <h2 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">To get started select a Site</h2>
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
import BarChart from './../pages/analytics/Bar'
import DatePicker from './../utilities/DatePicker'
import Dates from './../../mixins/Dates'
import DoughnutChart from './../pages/analytics/Doughnut'
import PieChart from './../pages/analytics/Pie'
import SidebarHeader from './../utilities/SidebarHeader'
import LineChart from './../pages/analytics/Line'
import SimpleTable from './../utilities/tables/SimpleTable'

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
      dataset.fontColor = this.theme.statsText.color

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
        dataset.borderColor = this.theme.statsText.color
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
      dataset.fontColor = this.theme.statsText.color

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
        dataset.borderColor = this.theme.statsText.color
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
      if (this.mothership) {
        if (typeof this.analyticsDateRange.start !== 'string' && this.analyticsDateRange.start[0]) {
          this.analyticsDateRange.start = this.formatDate(new Date(this.analyticsDateRange.start[0]))
        }

        if (typeof this.analyticsDateRange.end !== 'string' && this.analyticsDateRange.end[0]) {
          this.analyticsDateRange.end = this.formatDate(new Date(this.analyticsDateRange.end[0]))
        }
        this.getSiteAnalytics({site: this.site.id, dates: this.analyticsDateRange}).then(function (response) {

          response.data.sessions.datasets.map(function (dataset, index) {
            return self.formatColors(dataset, index)
          })

          response.data.channels.datasets.map(function (dataset, index) {
            return self.formatColors(dataset, index)
          })

          response.data.browser.datasets.map(function (dataset, index) {
            return self.formatColors(dataset, index)
          })

          self.$set(self, 'analytics', response.data)
        })
      }
    },
  },
  computed: {
    ...mapGetters('devise', [
      'mothership',
      'currentPage',
      'sites'
    ]),
    options () {
      return {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          labels: {
              fontColor: this.theme.statsText.color,
              fontSize: 14
          }
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: this.theme.statsText.color,
                    fontSize: 12
                }
            }],
            xAxes: [{
                ticks: {
                    fontColor: this.theme.statsText.color,
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
              fontColor: this.theme.statsText.color,
              fontSize: 14
          }
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: this.theme.statsText.color,
                    fontSize: 12
                }
            }],
            xAxes: [{
                ticks: {
                    fontColor: this.theme.statsText.color,
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
              fontColor: this.theme.statsText.color,
              fontSize: 14
          }
        }
      }
    }
  },
  components: {
    BarChart,
    DatePicker,
    DoughnutChart,
    PieChart,
    SidebarHeader,
    LineChart,
    SimpleTable
  },
  mixins: [Dates]
}
</script>