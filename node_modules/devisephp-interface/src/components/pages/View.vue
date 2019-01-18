<template>
  <div>
    <div id="devise-admin-content" v-if="localValue.id">
      <div
        id="dvs-admin-sidebar"
        :style="{
          borderColor:theme.panelCard.background, 
          background:theme.panelCard.background
        }"
      >
        <scrollactive
          :offset="80"
          :duration="800"
          bezier-easing-value=".5,0,.35,1"
          scroll-container-selector="#dvs-admin-content-container .simplebar-scroll-content"
          id="dvs-menu"
        >
          <button
            class="dvs-btn dvs-btn-zero dvs-btn-text dvs-mb-8"
            :style="{color: theme.actionButtonGhost.color}"
            @click="historyBack"
          >Back</button>

          <h6 :style="{color: theme.panel.color}" class="dvs-mb-4">Actions</h6>
          <ul>
            <li @click="href(page.slug)">Go To Page</li>
            <li @click="href(page.slug + '/#/devise/edit-page')">Edit Page Content</li>
            <li @click="showCopy = true">Copy This Page</li>
            <li @click="showTranslate = true">Translate This Page</li>
            <li
              v-devise-alert-confirm="{callback: requestDeletePage, message: 'Are you sure you want to delete this page?'}"
            >Delete This Page</li>
          </ul>

          <h6 :style="{color: theme.panel.color}" class="dvs-mb-4">Sections</h6>
          <ul class="dvs-list-reset dvs-mb-10 dvs-text-sm dvs-font-thin">
            <li class="dvs-mb-2">
              <a
                href="#versions"
                class="scrollactive-item"
                :style="{color:theme.panel.color}"
              >Versions of this Page</a>
            </li>
            <li class="dvs-mb-2">
              <a
                href="#settings"
                class="scrollactive-item"
                :style="{color:theme.panel.color}"
              >Global Page Settings</a>
            </li>
            <li class="dvs-mb-2">
              <a
                href="#meta-tags"
                class="scrollactive-item"
                :style="{color:theme.panel.color}"
              >Meta Tags</a>
            </li>
          </ul>
        </scrollactive>
      </div>

      <div id="dvs-admin-main" style="padding-left:250px;">
        <h1
          :style="{color: theme.panel.color}"
          class="dvs-mb-8 dvs-font-hairline"
        >{{ localValue.title }}</h1>

        <template v-if="analytics.data">
          <h3
            class="dvs-mb-8 dvs-pr-16"
            :style="{color: theme.panel.color}"
          >{{ localValue.title }} Analytics</h3>
          <div class="flex dvs-mb-8">
            <fieldset class="dvs-fieldset mr-8">
              <label>Analytics Start Date</label>
              <date-picker
                v-model="analyticsDateRange.start"
                :settings="{date: true, time: false}"
                placeholder="Start Date"
                @update="retrieveAnalytics()"
              />
            </fieldset>
            <fieldset class="dvs-fieldset">
              <label>Analytics End Date</label>
              <date-picker
                v-model="analyticsDateRange.end"
                :settings="{date: true, time: false}"
                placeholder="End Date"
                @update="retrieveAnalytics()"
              />
            </fieldset>
          </div>
          <div class="dvs-mb-12" v-if="mothershipApiKey">
            <line-chart
              class="dvs-mb-8"
              :chart-data="analytics.data"
              :options="options"
              :width="800"
              :height="200"
            />
          </div>
        </template>

        <h3
          class="dvs-mb-8 dvs-pr-16"
          :style="{color: theme.panel.color}"
          id="versions"
        >{{ localValue.title }} Page Versions</h3>

        <help
          class="dvs-mb-8"
        >Page versions allow your team to create alternate versions of a page for devlopment, historical purposes, and for A/B testing which allow you to run two pages at once to test user success rates</help>

        <div class="dvs-mb-16">
          <div
            v-for="(version, key) in localValue.versions"
            :key="key"
            class="dvs-flex-grow dvs-rounded-sm dvs-shadow-sm dvs-mb-4"
          >
            <div class="dvs-text-xl dvs-font-bold dvs-mb-4 dvs-flex dvs-justify-between">
              <div class="dvs-cursor-pointer dvs-flex" @click="toggleVersionSettings(version)">
                <template v-if="!version.editName">
                  <div class="dvs-mr-2">
                    <edit-icon w="25" h="25"/>
                  </div>
                  <div>
                    {{ version.name }}
                    <template v-if="version.is_live">(Currently Live)</template>
                  </div>
                </template>
              </div>
            </div>
            <div class="dvs-mb-16" v-show="version.showSettings">
              <div>
                <fieldset class="dvs-fieldset dvs-mb-8">
                  <label>Version Name</label>
                  <input type="text" v-model="localValue.versions[key].name">
                </fieldset>

                <fieldset class="dvs-fieldset dvs-mb-8">
                  <label>Layout</label>
                  <select v-model="localValue.versions[key].layout">
                    <option :value="layout" v-for="layout in layouts" :key="layout">{{ layout }}</option>
                  </select>
                </fieldset>

                <fieldset class="dvs-fieldset dvs-mb-8">
                  <label>Start Date</label>
                  <date-picker
                    v-model="localValue.versions[key].starts_at"
                    :settings="{date: true, time: true}"
                    placeholder="Start Date"
                    title="The date in which this version will begin appearing."
                    v-tippy="tippyConfiguration"
                  />
                </fieldset>

                <fieldset class="dvs-fieldset dvs-mb-8">
                  <label>End Date</label>
                  <date-picker
                    v-model="localValue.versions[key].ends_at"
                    :settings="{date: true, time: true}"
                    placeholder="End Date"
                    title="The date when this page version will stop appearing. This page will either fall back to another page version or produce a 404: Page Not Found if a user attempts to load it."
                    v-tippy="tippyConfiguration"
                  />
                </fieldset>

                <fieldset class="dvs-fieldset dvs-mb-8" v-if="localValue.ab_testing_enabled">
                  <label>A/B Testing Amount</label>
                  <input
                    type="number"
                    v-model.number="localValue.versions[key].ab_testing_amount"
                    title="This is the weight in which a page will show up. The number can be any number you want and is divided by the total weights of all other page versions."
                    v-tippy="tippyConfiguration"
                  >
                </fieldset>
              </div>

              <div class="dvs-flex dvs-justify-start">
                <button
                  class="dvs-btn dvs-mr-4 dvs-px-8"
                  @click="requestSaveVersion(version)"
                  title="Save Version Settings"
                  v-tippy="tippyConfiguration"
                  :style="theme.actionButton"
                >
                  <checkmark-icon w="30" h="30"/>
                </button>
                <button
                  class="dvs-btn dvs-mr-4 dvs-px-8"
                  @click="requestCopyVersion(version)"
                  title="Copy Version"
                  v-tippy="tippyConfiguration"
                  :style="theme.actionButtonGhost"
                >
                  <copy-icon w="30" h="30"/>
                </button>
                <button
                  class="dvs-btn dvs-mr-2 dvs-px-8"
                  v-tippy="tippyConfiguration"
                  v-devise-alert-confirm="{callback: requestDeleteVersion, arguments:version, message: 'Are you sure you want to delete this version?'}"
                  :style="theme.actionButtonGhost"
                >
                  <trash-icon w="30" h="30"/>
                </button>
              </div>
            </div>
          </div>
        </div>

        <h3
          class="dvs-mb-8 dvs-pr-16"
          id="settings"
          :style="{color: theme.panel.color}"
        >Global Page Settings</h3>

        <help class="dvs-mb-8">These settings effect all of the page versions of this page.</help>

        <div class="dvs-mb-12">
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Title</label>
            <input type="text" v-model="localValue.title" placeholder="Title of the Page">
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Slug</label>
            <input type="text" v-model="localValue.slug" placeholder="Url of the Page">
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Meta Title</label>
            <input type="text" v-model="localValue.meta_title" placeholder="Meta title of the Page">
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-8">
            <label>Canonical</label>
            <input type="text" v-model="localValue.canonical" placeholder="Canonical">
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-8">
            <label>A/B Testing Enabled</label>
            <input type="checkbox" v-model="localValue.ab_testing_enabled">
          </fieldset>

          <h3
            id="meta-tags"
            :style="{color: theme.panel.color}"
            class="dvs-mb-4"
          >Page Specific Meta Tags</h3>

          <fieldset class="dvs-fieldset">
            <meta-form
              v-model="localValue.meta"
              :global-form="false"
              @request-create-meta="requestCreateMeta"
              @request-update-meta="requestUpdateMeta"
              @request-delete-meta="requestDeleteMeta"
            />
          </fieldset>

          <div class="dvs-flex">
            <button
              @click="requestSavePage"
              class="dvs-btn dvs-mr-2"
              :style="theme.actionButton"
            >Save</button>
            <button
              @click="goToPage"
              class="dvs-btn dvs-mr-4"
              :style="theme.actionButtonGhost"
            >Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <transition name="dvs-fade">
      <devise-modal @close="showCopy = false" class="dvs-z-50" v-if="showCopy">
        <h4 class="dvs-mb-4">Copy this page</h4>
        <help
          class="dvs-mb-4"
        >This will create a whole new page based on this page copying all settings and values associated with it.</help>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Page Title</label>
          <input type="text" v-model="pageToCopy.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Slug</label>
          <input type="text" v-model="pageToCopy.slug" placeholder="Url of the Page">
        </fieldset>

        <button
          class="dvs-btn"
          @click="requestCopyPage"
          :disabled="pageToCopy.title === null || pageToCopy.slug === null"
        >Create</button>
        <button class="dvs-btn" @click="showCopy = false">Cancel</button>
      </devise-modal>
    </transition>

    <transition name="dvs-fade">
      <devise-modal @close="showTranslate = false" class="dvs-z-50" v-if="showTranslate">
        <h4 class="dvs-mb-4">Translate this page</h4>
        <help
          class="dvs-mb-4"
        >This will create a translated page associated with this page. While the pages are connected to allow users to switch between translations they do have their own settings and versions.</help>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Page Title</label>
          <input type="text" v-model="pageToTranslate.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Languages</label>
          <select v-model="translateLanguage">
            <option :value="null">Please select a language</option>
            <option
              v-for="language in languages.data"
              :key="language.id"
              :value="language"
            >{{ language.code }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Slug</label>
          <div class="dvs-flex">
            <input
              type="text"
              disabled="disabled"
              v-model="translateLanguage.code"
              class="dvs-max-w-3xs"
            >
            <input type="text" v-model="pageToTranslate.slug" placeholder="Url of the Page">
          </div>
        </fieldset>

        <button
          class="dvs-btn"
          @click="requestTranslatePage"
          :disabled="pageToTranslate.title === null || pageToTranslate.slug === null || translateLanguage === null"
        >Translate</button>
        <button class="dvs-btn" @click="showTranslate = false">Cancel</button>
      </devise-modal>
    </transition>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from 'vuex';

import AdministrationMixin from './../../mixins/Administration';
import Dates from './../../mixins/Dates';

export default {
  name: 'PagesView',
  data() {
    return {
      analytics: {},
      analyticsDateRange: {
        start: null,
        end: null
      },
      localValue: {},
      modulesToLoad: 2,
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
          background: 'rgba(54, 162, 235, 0.5)',
          border: 'rgba(54, 162, 235, 1)'
        },
        {
          background: 'rgba(75, 192, 192, 0.2)',
          border: 'rgba(75, 192, 192, 1)'
        },
        {
          background: 'rgba(255, 206, 86, 0.2)',
          border: 'rgba(255, 206, 86, 1)'
        },
        {
          background: 'rgba(255, 99, 132, 0.2)',
          border: 'rgba(255,99,132,1)'
        },
        {
          background: 'rgba(153, 102, 255, 0.2)',
          border: 'rgba(153, 102, 255, 1)'
        },
        {
          background: 'rgba(255, 159, 64, 0.2)',
          border: 'rgba(255, 159, 64, 1)'
        }
      ]
    };
  },
  mounted() {
    this.retrievePage();
    this.retrieveAllLanguages();
    this.setDefaultAnalytics();
  },
  methods: {
    ...mapActions('devise', [
      'copyPage',
      'copyPageVersion',
      'deletePage',
      'deletePageVersion',
      'getPageAnalytics',
      'getPage',
      'getLanguages',
      'translatePage',
      'updatePage',
      'updatePageVersion'
    ]),
    requestSavePage() {
      this.updatePage({ data: this.localValue });
    },
    requestCopyPage() {
      let self = this;
      this.copyPage({ data: this.pageToCopy }).then(function() {
        self.pageToCopy.title = null;
        self.pageToCopy.slug = null;
        self.showCopy = false;
      });
    },
    requestTranslatePage() {
      let self = this;

      // set the language id
      this.pageToTranslate.language_id = this.translateLanguage.id;

      // Append the language code to the front of the slug
      this.pageToTranslate.slug = '/' + this.translateLanguage.code + this.pageToTranslate.slug;

      this.translatePage({ page: this.localValue, data: this.pageToTranslate }).then(function() {
        self.pageToTranslate.title = null;
        self.pageToTranslate.slug = null;
        self.pageToTranslate.language_id = null;
        self.showTranslate = false;
      });
    },
    requestSaveVersion(version) {
      this.updatePageVersion({ page: this.localValue, version: version });
    },
    requestCopyVersion(version) {
      this.copyPageVersion({ page: this.localValue, version: version });
    },
    requestDeleteVersion(version) {
      this.deletePageVersion({ page: this.localValue, version: version });
    },
    requestCreateMeta(newMeta) {
      this.localValue.meta.push(newMeta);
    },
    requestUpdateMeta(meta) {
      let theMeta = this.localValue.meta.indexOf(meta);
      theMeta = meta;
      meta.edit = false;
    },
    requestDeleteMeta(meta) {
      this.localValue.meta.splice(this.localValue.meta.indexOf(meta), 1);
    },
    requestDeletePage() {
      let self = this;
      this.deletePage(this.localValue).then(function() {
        self.goToPage('devise-pages-index');
      });
    },
    retrievePage() {
      let self = this;
      this.getPage(this.$route.params.pageId).then(function(response) {
        self.localValue = Object.assign({}, self.localValue, response.data.page);

        self.localValue.versions.map(version => {
          self.$set(version, 'editName', false);
        });
        self.pageToTranslate.slug = self.localValue.slug;
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);

        self.retrieveAnalytics();
      });
    },
    retrieveAllLanguages() {
      let self = this;
      this.getLanguages().then(function() {
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    },
    setDefaultAnalytics() {
      var today = new Date();
      var oneWeekAgo = new Date();
      oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);

      this.analyticsDateRange.end = this.formatDate(today);
      this.analyticsDateRange.start = this.formatDate(oneWeekAgo);
    },
    retrieveAnalytics(version) {
      let self = this;

      if (this.mothershipApiKey) {
        if (typeof this.analyticsDateRange.start !== 'string' && this.analyticsDateRange.start[0]) {
          this.analyticsDateRange.start = this.formatDate(
            new Date(this.analyticsDateRange.start[0])
          );
        }

        if (typeof this.analyticsDateRange.end !== 'string' && this.analyticsDateRange.end[0]) {
          this.analyticsDateRange.end = this.formatDate(new Date(this.analyticsDateRange.end[0]));
        }

        this.getPageAnalytics({ slug: this.localValue.slug, dates: self.analyticsDateRange }).then(
          function(response) {
            response.data.data.datasets.map(function(dataset, index) {
              dataset.backgroundColor = [self.colors[index].background];
              dataset.fontColor = self.theme.panel.color;
              dataset.borderColor = [self.colors[index].border];
              dataset.pointRadius = 4;
              dataset.pointHoverRadius = 10;
              dataset.fill = false;

              return dataset;
            });

            self.$set(self, 'analytics', response.data);
          }
        );
      }
    },
    toggleVersionSettings(version) {
      this.$set(version, 'showSettings', !version.showSettings);
    }
  },
  computed: {
    ...mapGetters('devise', ['languages', 'mothershipApiKey']),
    ...mapState('devise', ['layouts']),
    options() {
      return {
        width: '8000px',
        legend: {
          labels: {
            fontColor: this.theme.panel.color,
            fontSize: 14
          }
        },
        scales: {
          yAxes: [
            {
              ticks: {
                fontColor: this.theme.panel.color,
                fontSize: 12
              }
            }
          ],
          xAxes: [
            {
              ticks: {
                fontColor: this.theme.panel.color,
                fontSize: 12
              }
            }
          ]
        }
      };
    }
  },
  components: {
    DatePicker: () =>
      import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/DatePicker'),
    DeviseModal: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Modal'),
    TrashIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-trash.vue'),
    CopyIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-copy.vue'),
    EditIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-create.vue'),
    CheckmarkIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-checkmark.vue'),
    LineChart: () => import(/* webpackChunkName: "js/devise-charts" */ './analytics/Line'),
    MetaForm: () => import(/* webpackChunkName: "js/devise-meta" */ './../meta/MetaForm')
  },
  mixins: [Dates, AdministrationMixin]
};
</script>
