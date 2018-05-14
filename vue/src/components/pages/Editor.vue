<template>
  <div>
    <div class="dvs-w-full dvs-bg-blue-dark dvs-text-white dvs-py-4 dvs-px-12">
      <a class="dvs-text-white dvs-text-xs dvs-uppercase dvs-tracking-wide" href="#" @click.prevent="goToPage('devise-index')">
        <i class="ion-arrow-left-c"></i> Full Administration
      </a>
      <h4 class="dvs-text-white">      
        Editing {{ this.page.title }}
      </h4>
    </div>

    <div class="dvs-flex dvs-flex-col dvs-items-center dvs-p-12">

      <button class="dvs-block dvs-btn dvs-btn-sm dvs-mb-8 dvs-btn-success"  @click.prevent="requestSavePage()">
        <i class="ion-checkmark-circled dvs-mr-2"></i> Save this page
      </button>

      <div class="dvs-flex dvs-w-full dvs-justify-center dvs-items-center dvs-mb-8 dvs-w-full">
        <i class="ion-android-desktop dvs-text-2xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'desktop'}" @click="setPreviewMode('desktop')"></i>
        <i class="ion-ipad dvs-text-3xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'tablet'}" @click="setPreviewMode('tablet')"></i>
        <i class="ion-android-phone-portrait dvs-text-2xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'mobile-portrait'}" @click="setPreviewMode('mobile-portrait')"></i>
        <i class="ion-android-phone-landscape dvs-text-2xl dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'mobile-landscape'}" @click="setPreviewMode('mobile-landscape')"></i>
      </div>

      <ul class="dvs-list-reset dvs-w-full">
        <li class="dvs-collapsable dvs-mb-8" :class="{'dvs-open': pageSettingsOpen}">
          <div class="dvs-switch" @click="togglePageSettings">
            Page Settings
          </div>

          <div class="dvs-collapsed dvs-mt-4">
            <fieldset class="dvs-fieldset">
              <label>Page Title</label>
              <input type="text" placeholder="Title of the Page">
            </fieldset>

            <fieldset class="dvs-fieldset">
              <label>Description</label>
              <textarea class="dvs-h-24" placeholder="Description of the Page - Try to aim for around 150 - 300 characters."></textarea>
            </fieldset>

            <fieldset class="dvs-fieldset">
              <label>Canonical</label>
              <input type="text" placeholder="Canonical">
            </fieldset>
          </div>
        </li>
        <li class="dvs-collapsable dvs-mb-2" :class="{'dvs-open': pageContentOpen}">
          <div class="dvs-switch" @click="togglePageContent">
            Page Content
          </div>

          <div class="dvs-collapsed dvs-mt-4">
            <ul class="dvs-list-reset">
              <template v-for="(slice, key) in pageSlices">
                <slice-editor :slice="slice" />
              </template>
            </ul>
          </div>
        </li>
      </ul>

    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

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
      let sliceOpen = slice.metadata.open
      this.pageSlices.map(s => this.closeSlice(s))
      this.$set(slice.metadata, 'open', !sliceOpen)
    },
    closeSlice (slice) {
      this.$set(slice.metadata, 'open', false)
    },
    setPreviewMode (mode) {
      this.previewMode = mode
      window.page.previewMode = mode
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
    SliceEditor
  }
}
</script>
