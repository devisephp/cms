<template>
  <div>
    <div class="dvs-w-full dvs-py-4 dvs-px-12 dvs-flex dvs-flex-col dvs-items-center admin-component-first-in">
      <logo class="dvs-my-4 dvs-mt-2 dvs-w-full dvs-flex dvs-justify-center" />
      <a class="dvs-text-2xs dvs-font-normal dvs-uppercase dvs-tracking-wide" href="#" @click.prevent="goToPage('devise-index')" :style="`color:${theme.sidebarText.color}`">
        <i class="ion-arrow-left-c"></i> Full Administration
      </a>
      <h3 :style="`color:${theme.sidebarText.color}`">      
        Edit Page: {{ this.page.title }}
      </h3>
    </div>

    <div class="dvs-flex dvs-flex-col dvs-items-center dvs-px-12 dvs-py-4">
      <button 
        class="dvs-block dvs-btn dvs-btn-sm dvs-mb-8 dvs-btn-success admin-component-third-in"  
        :style="actionButtonTheme"
        @click.prevent="requestSavePage()">
        <i class="ion-checkmark-circled dvs-mr-2"></i> Save this page
      </button>

      <div class="dvs-flex dvs-w-full dvs-justify-center dvs-items-center dvs-mb-8 dvs-w-full admin-component-second-in">
        <i class="ion-android-desktop dvs-text-2xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'desktop'}" @click="setPreviewMode('desktop')"></i>
        <i class="ion-ipad dvs-text-3xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'tablet'}" @click="setPreviewMode('tablet')"></i>
        <i class="ion-android-phone-portrait dvs-text-2xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'mobile-portrait'}" @click="setPreviewMode('mobile-portrait')"></i>
        <i class="ion-android-phone-landscape dvs-text-2xl dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'mobile-landscape'}" @click="setPreviewMode('mobile-landscape')"></i>
      </div>

      <div class="dvs-flex dvs-justify-between dvs-text-sm dvs-font-bold dvs-w-full dvs-border-b"
           :style="`border-color:${theme.sidebarText.color}`">
        <div 
          class="dvs-p-2 dvs-cursor-pointer" 
          :class="{'dvs-border-b-2': pageSettingsOpen}" 
          :style="`border-color:${theme.sidebarText.color}`" 
          @click="togglePageSettings">
          Page Settings
        </div>
        <div 
          class="dvs-p-2 dvs-cursor-pointer"
          :class="{'dvs-border-b-2': pageContentOpen}" 
          :style="`border-color:${theme.sidebarText.color}`" 
          @click="togglePageContent">
          Page Content
        </div>
      </div>

      <ul class="dvs-list-reset dvs-w-full">
        <li class="dvs-collapsable dvs-mb-8" :class="{'dvs-open': pageSettingsOpen}">
          <div class="dvs-collapsed dvs-mt-4">
            <fieldset class="dvs-fieldset mb-8">
              <label>Page Title</label>
              <input type="text" placeholder="Title of the Page">
            </fieldset>

            <fieldset class="dvs-fieldset mb-8">
              <label>Description</label>
              <textarea class="dvs-h-24" placeholder="Description of the Page - Try to aim for around 150 - 300 characters."></textarea>
            </fieldset>

            <fieldset class="dvs-fieldset">
              <label>Canonical</label>
              <input type="text" placeholder="Canonical">
            </fieldset>
          </div>
        </li>
        <li class="dvs-collapsable dvs-mb-2 " :class="{'dvs-open': pageContentOpen}">
          <div class="dvs-collapsed dvs-mt-4">
            <ul class="dvs-list-reset" style="padding-bottom:150px;" >
              <template v-for="(slice, key) in pageSlices">
                <slice-editor @opened="openSlice(slice)" :slice="slice" />
              </template>
            </ul>
          </div>
        </li>
      </ul>

    </div>

    <portal to="devise-field-editor">
      <analytic-totals />
    </portal>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

import AnalyticTotals from './AnalyticTotals'
import SliceEditor from './SliceEditor'

export default {
  name: 'PageEditor',
  data () {
    return {
      previewMode: 'desktop',
      pageSlices: [],
      pageSettingsOpen: false,
      pageContentOpen: true
    }
  },
  mounted () {
    this.pageSlices = this.page.slices
  },
  methods: {
    ...mapActions('devise', [
      'savePage'
    ]),
    requestSavePage () {
      let self = this
      this.savePage(this.page)
    },
    togglePageSettings () {
      this.pageSettingsOpen = !this.pageSettingsOpen
      this.pageContentOpen = false
    },
    togglePageContent () {
      this.pageContentOpen = !this.pageContentOpen
      if (!this.pageContentOpen) {
        this.pageSlices.map(s => this.closeSlice(s))
      }
      this.pageSettingsOpen = false
    },
    toggleSlice (slice) {
      if (slice.metadata.open) {
        this.closeSlice(slice)
      } else {
        this.openSlice(slice)
      }
    },
    openSlice (sliceToOpen) {
      this.pageSlices.map(s => this.closeSlice(s))
      this.$set(sliceToOpen.metadata, 'open', true)
    },
    closeSlice (slice) {
      this.$set(slice.metadata, 'open', false)
    },
    setPreviewMode (mode) {
      this.previewMode = mode
      deviseSettings.$page.previewMode = mode
    }
  },
  computed: {
    ...mapGetters('devise', [
      'sliceConfig',
      'fieldConfig'
    ])
  },
  props: ['page'],
  components: {
    AnalyticTotals,
    SliceEditor
  }
}
</script>
