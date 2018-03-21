<template>

  <div class="dvs-flex dvs-items-stretch dvs-min-h-screen dvs-relative" v-if="page">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Pages</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-pages-index')">Back to Pages</a>
      <ul class="dvs-list-reset dvs-mb-10">
        <li class="dvs-mb-6 dvs-text-lg">
          <a :href="page.slug" class="dvs-text-grey-darker">Go To Page</a>
        </li>
        <li class="dvs-mb-6 dvs-text-lg">
          <a :href="page.slug + '/#/devise/edit-page'" class="dvs-text-grey-darker">Edit Page Content</a>
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="showCopy = true">
          Copy This Page
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click="showTranslate = true">
          Translate This Page
        </li>
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" v-devise-alert-confirm="{callback: requestDeletePage, message: 'Are you sure you want to delete this page?'}">
          Delete This Page
        </li>
      </ul>
    </div>
    <div id="devise-admin-content">
      <h3 class="dvs-mb-8">{{ localValue.title }} Page Versions</h3>

      <help class="dvs-mb-8">Page versions allow your team to create alternate versions of a page for devlopment, historical purposes, and for A/B testing which allow you to run two pages at once to test user success rates</help>

      <div class="dvs-mb-12 dvs--m8">
        <div v-for="(version, key) in localValue.versions" class="dvs-flex-grow dvs-p-8 dvs-rounded-sm dvs-bg-grey-lightest dvs-shadow-sm dvs-mb-8">
          <div class="dvs-text-xl dvs-font-bold dvs-mb-4 dvs-flex dvs-justify-between">
            <div>
              <template v-if="!version.editName">
                {{ version.name }}
                <i v-if="version.showSettings" @click="version.editName = !version.editName" class="ion-edit" />
              </template>
              <fieldset class="dvs-fieldset">
                <input v-show="version.editName" type="text" v-model="localValue.versions[key].name" />
              </fieldset>
            </div>
            <div>
              <button class="dvs-btn dvs-btn-xs" @click="closeVersionSettings(version)">Analytics</button>
              <button class="dvs-btn dvs-btn-xs" @click="openVersionSettings(version)">Settings</button>
            </div>
          </div>
          <div v-if="version.showSettings">
            <div class="dvs-mb-4">
              <fieldset class="dvs-fieldset mb-8">
                <label>Start Date</label>
                <date-picker v-model="localValue.versions[key].start_date" :settings="{date: true, time: true}" placeholder="Start Date" title="The date in which this version will begin appearing." v-tippy="tippyConfiguration" />
              </fieldset>

              <fieldset class="dvs-fieldset mb-8">
                <label>End Date</label>
                <date-picker v-model="localValue.versions[key].end_date" :settings="{date: true, time: true}" placeholder="End Date" title="The date when this page version will stop appearing. This page will either fall back to another page version or produce a 404: Page Not Found if a user attempts to load it." v-tippy="tippyConfiguration" />
              </fieldset>

              <fieldset class="dvs-fieldset mb-8" v-if="localValue.ab_testing_enabled">
                <label>A/B Testing Amount</label>
                <input type="number" v-model.number="localValue.versions[key].ab_testing_amount" title="This is the weight in which a page will show up. The number can be any number you want and is divided by the total weights of all other page versions." v-tippy="tippyConfiguration">
              </fieldset>
            </div>

            <div class="dvs-flex dvs-justify-between">
              <button class="dvs-btn dvs-btn-plain dvs-btn-xs dvs-mr-2 dvs-w-1/4"
                      @click="requestSaveVersion(version)" title="Save Version Settings" v-tippy="tippyConfiguration">
                <i class="ion-checkmark dvs-text-xl"/>
              </button>
              <button class="dvs-btn dvs-btn-plain dvs-btn-xs dvs-mr-2 dvs-w-1/4" @click="requestCopyVersion(version)" title="Copy Version" v-tippy="tippyConfiguration">
                <i class="ion-ios-copy dvs-text-xl" />
              </button>
              <button class="dvs-btn dvs-btn-plain dvs-btn-xs dvs-mr-2 dvs-w-1/4" v-tippy="tippyConfiguration" v-devise-alert-confirm="{callback: requestDeleteVersion, arguments:version, message: 'Are you sure you want to delete this version?'}">
                <i class="ion-trash-b dvs-text-xl" />
              </button>
            </div>
          </div>
          <div v-else>
            Analytics

            <line-chart :data="theData" />
          </div>
        </div>
      </div>

      <h3 class="dvs-mb-8">Global Page Settings</h3>

      <help class="dvs-mb-8">These settings effect all of the page versions of this page.</help>

      <div class="dvs-mb-12">
        <fieldset class="dvs-fieldset mb-4">
          <label>Page Title</label>
          <input type="text" v-model="localValue.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Slug</label>
          <input type="text" v-model="localValue.slug" placeholder="Url of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset mb-8">
          <label>Canonical</label>
          <input type="text" v-model="localValue.canonical" placeholder="Canonical">
        </fieldset>

        <fieldset class="dvs-fieldset mb-8">
          <label>A/B Testing Enabled</label>
          <input type="checkbox" v-model="localValue.ab_testing_enabled">
        </fieldset>

        <div class="dvs-flex">
          <button @click="requestSavePage" class="dvs-btn dvs-mr-2">Save</button>
          <button @click="goToPage" class="dvs-btn dvs-btn-plain dvs-mr-4">Cancel</button>
        </div>
      </div>

    </div>

    <transition name="fade">
      <devise-modal @close="showCopy = false" class="dvs-z-50" v-if="showCopy">
        <h4 class="dvs-mb-4">Copy this page</h4>
        <help class="dvs-mb-4">This will create a whole new page based on this page copying all settings and values associated with it.</help>
        <fieldset class="dvs-fieldset mb-4">
          <label>Page Title</label>
          <input type="text" v-model="pageToCopy.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
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

        <fieldset class="dvs-fieldset mb-4">
          <label>Page Title</label>
          <input type="text" v-model="pageToTranslate.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Languages</label>
          <select v-model="translateLanguage">
            <option :value="null">Please select a language</option>
            <option v-for="language in languages.data" :value="language">{{ language.code }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
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
import LineChart from './analytics/Line'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'PagesView',
  data () {
    return {
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
      theData: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
          label: '# of Visitors',
          data: [12, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      }
    }
  },
  mounted () {
    this.retrieveAllPages()
    this.retrieveAllTemplates()
    this.retrieveAllLanguages()
  },
  methods: {
    ...mapActions('devise', [
      'copyPage',
      'copyPageVersion',
      'deletePage',
      'deletePageVersion',
      'getAnalytics',
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
          // self.$set(version, 'analytics', retrieveAnalytics(version))
        })
        self.pageToTranslate.slug = self.page.slug
        window.bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    },
    retrieveAllTemplates () {
      let self = this
      this.getTemplates().then(function () {
        window.bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    },
    retrieveAllLanguages () {
      let self = this
      this.getLanguages().then(function () {
        window.bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    },
    retrieveAnalytics (version) {
      this.getAnalytics(version).then(function (response) {
        version.analytics = response
      })
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
      'languages'
    ])
  },
  components: {
    DatePicker,
    DeviseModal,
    LineChart
  }
}
</script>
