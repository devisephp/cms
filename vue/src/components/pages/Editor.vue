<template>
  <div>
    <div class="dvs-items-center dvs-text-center dvs-py-4">
      <sidebar-header :title="`Editing: ${page.title}`" back-text="Back to Administration" back-page="devise-index" />
    </div>

    <div class="dvs-flex dvs-flex-col dvs-items-center dvs-px-12 dvs-py-4">
      <button 
        class="dvs-block dvs-btn dvs-btn-sm dvs-mb-8 dvs-btn-success admin-component-third-in"  
        :style="actionButtonTheme"
        @click.prevent="requestSavePage()">
        <checkmark-circle-icon class="dvs-mr-2" />Save this page
      </button>

      <div class="dvs-flex dvs-w-full dvs-justify-center dvs-items-center dvs-mb-8 dvs-w-full admin-component-second-in">
        <div class="dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'desktop'}"  @click="setPreviewMode('desktop')">
          <desktop-icon w="25" h="25" />
        </div>
        <div class="dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'tablet'}"  @click="setPreviewMode('tablet')">
          <tablet-icon w="25" h="25" />
        </div>
        <div class="dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'mobile-portrait'}"  @click="setPreviewMode('mobile-portrait')">
          <phone-portrait-icon w="25" h="25" />
        </div>
        <div class="dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'mobile-landscape'}"  @click="setPreviewMode('mobile-landscape')">
          <phone-landscape-icon w="25" h="25" />
        </div>
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
            <fieldset class="dvs-fieldset dvs-mb-8">
              <label>Page Title</label>
              <input type="text" placeholder="Title of the Page">
            </fieldset>

            <fieldset class="dvs-fieldset dvs-mb-8">
              <label>Description</label>
              <textarea class="dvs-h-24" placeholder="Description of the Page - Try to aim for around 150 - 300 characters."></textarea>
            </fieldset>

            <fieldset class="dvs-fieldset">
              <label>Canonical</label>
              <input type="text" placeholder="Canonical">
            </fieldset>

            <router-link :to="{ name: 'devise-pages-view', params: { pageId: page.id }}" class="dvs-btn dvs-block dvs-font-bold dvs-text-center dvs-mt-8" :style="actionButtonTheme">
              All Settings
            </router-link>
          </div>
        </li>
        <li class="dvs-collapsable dvs-mb-2 " :class="{'dvs-open': pageContentOpen}">
          <div class="dvs-collapsed dvs-mt-4">
            <ul class="dvs-list-reset" style="padding-bottom:150px;" >
              <template v-for="slice in pageSlices">
                <slice-editor @opened="openSlice(slice)" :key="slice.id" :slice="slice" />
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
import SidebarHeader from './../utilities/SidebarHeader'

import CheckmarkCircleIcon from 'vue-ionicons/dist/ios-checkmark-circle-outline.vue'
import DesktopIcon from 'vue-ionicons/dist/md-desktop.vue'
import TabletIcon from 'vue-ionicons/dist/md-tablet-portrait.vue'
import PhonePortraitIcon from 'vue-ionicons/dist/md-phone-portrait.vue'
import PhoneLandscapeIcon from 'vue-ionicons/dist/md-phone-landscape.vue'

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
      console.log(this.page)
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
    CheckmarkCircleIcon,
    DesktopIcon,
    PhonePortraitIcon,
    PhoneLandscapeIcon,
    TabletIcon,
    SidebarHeader,
    SliceEditor
  }
}
</script>
