<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative" v-if="page">
    <div id="devise-sidebar">
      <sidebar-header title="Manage Page" back-text="Back to Pages" back-page="devise-pages-index" />

      <ul class="dvs-list-reset dvs-mb-10">
        <li class="dvs-mb-6 dvs-text-lg">
          <a :href="page.slug" :style="{color: theme.sidebarText.color}">Go To Page</a>
        </li>
        <li class="dvs-mb-6 dvs-text-lg">
          <a :href="page.slug + '/#/devise/edit-page'" :style="{color: theme.sidebarText.color}">Edit Page Content</a>
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click="showCopy = true">
          Copy This Page
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" @click="showTranslate = true">
          Translate This Page
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" v-devise-alert-confirm="{callback: requestDeletePage, message: 'Are you sure you want to delete this page?'}">
          Delete This Page
        </li>
      </ul>
    </div>

    <div id="devise-admin-content"  :style="adminTheme">
      <template v-if="analytics.data">
        <h3 class="dvs-mb-8" :style="{color: theme.statsText.color}">{{ localValue.title }} Analytics</h3>
        <div class="flex dvs-mb-8">
          <fieldset class="dvs-fieldset mr-8">
            <label>Analytics Start Date</label>
            <date-picker v-model="analyticsDateRange.start" :settings="{date: true, time: false}" placeholder="Start Date" @update="retrieveAnalytics()" />
          </fieldset>
          <fieldset class="dvs-fieldset">
            <label>Analytics End Date</label>
            <date-picker v-model="analyticsDateRange.end" :settings="{date: true, time: false}" placeholder="End Date" @update="retrieveAnalytics()" />
          </fieldset>
        </div>
        <div class="dvs-mb-12" v-if="mothership">
          <line-chart class="dvs-mb-8" :chart-data="analytics.data" :options="options" :width="800" :height="200" />
        </div>
      </template>

      <h3 class="dvs-mb-8" :style="{color: theme.sidebarText.color}">{{ localValue.title }} Page Versions</h3>

      <help class="dvs-mb-4">Page versions allow your team to create alternate versions of a page for devlopment, historical purposes, and for A/B testing which allow you to run two pages at once to test user success rates</help>

      <div class="dvs-mb-12 dvs--m8">
        <div v-for="(version, key) in localValue.versions" :key="key" class="dvs-flex-grow dvs-p-8 dvs-rounded-sm dvs-shadow-sm dvs-mb-8">
          <div class="dvs-text-xl dvs-font-bold dvs-mb-4 dvs-flex dvs-justify-between">
            <div>
              <template v-if="!version.editName">
                {{ version.name }}
                <div class="dvs-cursor-pointer" v-if="version.showSettings" @click="version.editName = !version.editName">
                  <edit-icon />
                </div>
              </template>
              <fieldset class="dvs-fieldset">
                <input v-show="version.editName" type="text" v-model="localValue.versions[key].name" />
              </fieldset>
            </div>
          </div>
          <div>
            <div class="dvs-mb-4">
              <fieldset class="dvs-fieldset dvs-mb-8">
                <label>Template</label>
                <select v-model="localValue.versions[key].template_id">
                  <option :value="null">Please select a template</option>
                  <option v-for="template in templates.data" :key="template.id" :value="template.id">{{ template.name }}</option>
                </select>
              </fieldset>

              <fieldset class="dvs-fieldset dvs-mb-8">
                <label>Start Date</label>
                <date-picker v-model="localValue.versions[key].starts_at" :settings="{date: true, time: true}" placeholder="Start Date" title="The date in which this version will begin appearing." v-tippy="tippyConfiguration" />
              </fieldset>

              <fieldset class="dvs-fieldset dvs-mb-8">
                <label>End Date</label>
                <date-picker v-model="localValue.versions[key].ends_at" :settings="{date: true, time: true}" placeholder="End Date" title="The date when this page version will stop appearing. This page will either fall back to another page version or produce a 404: Page Not Found if a user attempts to load it." v-tippy="tippyConfiguration" />
              </fieldset>

              <fieldset class="dvs-fieldset dvs-mb-8" v-if="localValue.ab_testing_enabled">
                <label>A/B Testing Amount</label>
                <input type="number" v-model.number="localValue.versions[key].ab_testing_amount" title="This is the weight in which a page will show up. The number can be any number you want and is divided by the total weights of all other page versions." v-tippy="tippyConfiguration">
              </fieldset>
            </div>

            <div class="dvs-flex dvs-justify-start">
              <button 
                class="dvs-btn dvs-mr-4 dvs-px-8"
                @click="requestSaveVersion(version)" 
                title="Save Version Settings" 
                v-tippy="tippyConfiguration"
                :style="actionButtonTheme"
                >
                <checkmark-icon w="30" h="30" />
              </button>
              <button 
                class="dvs-btn dvs-mr-4 dvs-px-8" 
                @click="requestCopyVersion(version)" 
                title="Copy Version" 
                v-tippy="tippyConfiguration"
                :style="regularButtonTheme"
                >
                <copy-icon w="30" h="30" />
              </button>
              <button 
                class="dvs-btn dvs-mr-2 dvs-px-8" 
                v-tippy="tippyConfiguration" 
                v-devise-alert-confirm="{callback: requestDeleteVersion, arguments:version, message: 'Are you sure you want to delete this version?'}"
                :style="regularButtonTheme">
                <trash-icon w="30" h="30" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <h3 class="dvs-mb-8" :style="{color: theme.sidebarText.color}">Global Page Settings</h3>

      <help class="dvs-mb-8">These settings effect all of the page versions of this page.</help>

      <div class="dvs-mb-12">
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Page Title</label>
          <input type="text" v-model="localValue.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Slug</label>
          <input type="text" v-model="localValue.slug" placeholder="Url of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-8">
          <label>Canonical</label>
          <input type="text" v-model="localValue.canonical" placeholder="Canonical">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-8">
          <label>A/B Testing Enabled</label>
          <input type="checkbox" v-model="localValue.ab_testing_enabled">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-8">
          <h4 :style="{color: theme.sidebarText.color}" class="dvs-mb-4">Page Specific Meta Tags</h4>
          <meta-form v-model="localValue.meta" @request-create-meta="requestCreateMeta" @request-update-meta="requestUpdateMeta" @request-delete-meta="requestDeleteMeta" />
        </fieldset>

        <div class="dvs-flex">
          <button @click="requestSavePage" class="dvs-btn dvs-mr-2" :style="actionButtonTheme">Save</button>
          <button @click="goToPage" class="dvs-btn dvs-btn-plain dvs-mr-4" :style="regularButtonTheme">Cancel</button>
        </div>
      </div>

    </div>

    <transition name="fade">
      <devise-modal @close="showCopy = false" class="dvs-z-50" v-if="showCopy">
        <h4 class="dvs-mb-4">Copy this page</h4>
        <help class="dvs-mb-4">This will create a whole new page based on this page copying all settings and values associated with it.</help>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Page Title</label>
          <input type="text" v-model="pageToCopy.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Slug</label>
          <input type="text" v-model="pageToCopy.slug" placeholder="Url of the Page">
        </fieldset>

        <button class="dvs-btn" @click="requestCopyPage" :disabled="pageToCopy.title === null || pageToCopy.slug === null">Create</button>
        <button class="dvs-btn dvs-btn-plain" @click="showCopy = false">Cancel</button>
      </devise-modal>
    </transition>

    <transition name="fade">
      <devise-modal @close="showTranslate = false" class="dvs-z-50" v-if="showTranslate">
        <h4 class="dvs-mb-4">Translate this page</h4>
        <help class="dvs-mb-4">This will create a translated page associated with this page. While the pages are connected to allow users to switch between translations they do have their own settings and versions.</help>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Page Title</label>
          <input type="text" v-model="pageToTranslate.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Languages</label>
          <select v-model="translateLanguage">
            <option :value="null">Please select a language</option>
            <option v-for="language in languages.data" :key="language.id" :value="language">{{ language.code }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Slug</label>
          <div class="dvs-flex">
            <input type="text" disabled="disabled" v-model="translateLanguage.code" class="dvs-max-w-3xs">
            <input type="text" v-model="pageToTranslate.slug" placeholder="Url of the Page">
          </div>
        </fieldset>

        <button class="dvs-btn" @click="requestTranslatePage" :disabled="pageToTranslate.title === null || pageToTranslate.slug === null || translateLanguage === null">Translate</button>
        <button class="dvs-btn dvs-btn-plain" @click="showTranslate = false">Cancel</button>
      </devise-modal>
    </transition>

  </div>

</template>

<script>
import DatePicker from './../utilities/DatePicker'
import DeviseModal from './../utilities/Modal'
import SidebarHeader from './../utilities/SidebarHeader'
import LineChart from './analytics/Line'
import MetaForm from './../meta/MetaForm'

import Dates from './../../mixins/Dates'

import EditIcon from 'vue-ionicons/dist/md-create.vue'
import CheckmarkIcon from 'vue-ionicons/dist/md-checkmark.vue'
import CopyIcon from 'vue-ionicons/dist/ios-copy.vue'
import TrashIcon from 'vue-ionicons/dist/md-trash.vue'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'PagesView',
  data () {
    return {
      analytics: {},
      analyticsDateRange: {
        start: null,
        end: null
      },
      localValue: {},
      modulesToLoad: 3,
      showCopy: false,
      showTranslate: false,
      pageToCopy: {
        title: null,
        slug: null
      },
      translateLanguage: {},
      pageToTranslate: {
        title: null,
        slug: null,
        language_id: null
      },
      colors: [
        {
          background:'rgba(54, 162, 235, 0.5)',
          border: 'rgba(54, 162, 235, 1)'
        },
        {
          background:'rgba(75, 192, 192, 0.2)',
          border: 'rgba(75, 192, 192, 1)'
        },
        {
          background:'rgba(255, 206, 86, 0.2)',
          border: 'rgba(255, 206, 86, 1)'
        },
        {
          background:'rgba(255, 99, 132, 0.2)',
          border: 'rgba(255,99,132,1)'
        },
        {
          background:'rgba(153, 102, 255, 0.2)',
          border: 'rgba(153, 102, 255, 1)',
        },
        {
          background:'rgba(255, 159, 64, 0.2)',
          border: 'rgba(255, 159, 64, 1)'
        }
      ]
    }
  },
  mounted () {
    this.retrieveAllPages()
    this.retrieveAllTemplates()
    this.retrieveAllLanguages()
    this.setDefaultAnalytics()
  },
  methods: {
    ...mapActions('devise', [
      'copyPage',
      'copyPageVersion',
      'deletePage',
      'deletePageVersion',
      'getPageAnalytics',
      'getPages',
      'getLanguages',
      'getTemplates',
      'translatePage',
      'updatePage',
      'updatePageVersion'
    ]),
    requestSavePage () {
      this.updatePage({page: this.page, data: this.localValue})
    },
    requestCopyPage () {
      let self = this
      this.copyPage({page: this.page, data: this.pageToCopy}).then(function () {
        self.pageToCopy.title = null
        self.pageToCopy.slug = null
        self.showCopy = false
      })
    },
    requestTranslatePage () {
      let self = this

      // set the language id
      this.pageToTranslate.language_id = this.translateLanguage.id

      // Append the language code to the front of the slug
      this.pageToTranslate.slug = '/' + this.translateLanguage.code + this.pageToTranslate.slug

      this.translatePage({page: this.page, data: this.pageToTranslate}).then(function () {
        self.pageToTranslate.title = null
        self.pageToTranslate.slug = null
        self.pageToTranslate.language_id = null
        self.showTranslate = false
      })
    },
    requestSaveVersion (version) {
      this.updatePageVersion({page: this.page, version: version})
    },
    requestCopyVersion (version) {
      this.copyPageVersion({page: this.page, version: version})
    },
    requestDeleteVersion (version) {
      this.deletePageVersion({page: this.page, version: version})
    },
    requestCreateMeta (newMeta) {
      this.localValue.meta.push(newMeta)
    },
    requestUpdateMeta (meta) {
      let theMeta = this.localValue.meta.indexOf(meta)
      theMeta = meta
      meta.edit = false
    },
    requestDeleteMeta (meta) {
      console.log(this.localValue.meta.indexOf(meta))
      this.localValue.meta.splice(this.localValue.meta.indexOf(meta), 1)
    },
    requestDeletePage () {
      let self = this
      this.deletePage(this.page).then(function () {
        self.goToPage('devise-pages-index')
      })
    },
    retrieveAllPages () {
      let self = this
      this.getPages().then(function () {
        self.localValue = Object.assign({}, self.localValue, self.page)

        self.localValue.versions.map(version => {
          self.$set(version, 'editName', false)
        })
        self.pageToTranslate.slug = self.page.slug
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
        
        self.retrieveAnalytics()
      })
    },
    retrieveAllTemplates () {
      let self = this
      this.getTemplates().then(function () {
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    },
    retrieveAllLanguages () {
      let self = this
      this.getLanguages().then(function () {
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    },
    setDefaultAnalytics () {
      var today = new Date()
      var oneWeekAgo = new Date()
      oneWeekAgo.setDate(oneWeekAgo.getDate() - 7)

      this.analyticsDateRange.end = this.formatDate(today)
      this.analyticsDateRange.start = this.formatDate(oneWeekAgo)
    },
    retrieveAnalytics (version) {
      let self = this

      if (this.mothership) {
        if (typeof this.analyticsDateRange.start !== 'string' && this.analyticsDateRange.start[0]) {
          this.analyticsDateRange.start = this.formatDate(new Date(this.analyticsDateRange.start[0]))
        }

        if (typeof this.analyticsDateRange.end !== 'string' && this.analyticsDateRange.end[0]) {
          this.analyticsDateRange.end = this.formatDate(new Date(this.analyticsDateRange.end[0]))
        }

        this.getPageAnalytics({slug: this.page.slug, dates: self.analyticsDateRange}).then(function (response) {

          response.data.data.datasets.map(function (dataset, index) {
            dataset.backgroundColor = [self.colors[index].background]
            dataset.fontColor = self.theme.statsText.color
            dataset.borderColor = [self.colors[index].border]
            dataset.pointRadius = 4
            dataset.pointHoverRadius = 10
            dataset.fill = false

            return dataset
          })

          self.$set(self, 'analytics', response.data)
        })
      }
    },
    openVersionSettings (version) {
      this.$set(version, 'showSettings', true)
    },
    closeVersionSettings (version) {
      this.$set(version, 'showSettings', false)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'templates',
      'page',
      'languages',
      'mothership'
    ]),
    options () {
      return {
        width: '8000px',
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
    }
  },
  components: {
    CopyIcon,
    CheckmarkIcon,
    DatePicker,
    DeviseModal,
    EditIcon,
    SidebarHeader,
    TrashIcon,
    LineChart,
    MetaForm
  },
  mixins: [Dates]
}
</script>
