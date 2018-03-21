<template>
  <div class="dvs-p-8">
    <h2 class="dvs-font-bold dvs-mb-2">Edit Page</h2>
    <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-index')">Go to Administration</a>

    <button class="dvs-btn dvs-btn-ghost dvs-w-full dvs-mb-8">Save This Page</button>

    <div class="dvs-flex dvs-w-full dvs-justify-center dvs-items-center dvs-mb-8">
      <i class="ion-android-desktop dvs-text-2xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green-dark': previewMode === 'desktop'}" @click="setPreviewMode('desktop')"></i>
      <i class="ion-ipad dvs-text-3xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green-dark': previewMode === 'tablet'}" @click="setPreviewMode('tablet')"></i>
      <i class="ion-android-phone-portrait dvs-text-2xl dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green-dark': previewMode === 'mobile-portrait'}" @click="setPreviewMode('mobile-portrait')"></i>
      <i class="ion-android-phone-landscape dvs-text-2xl dvs-cursor-pointer" :class="{'dvs-text-green-dark': previewMode === 'mobile-landscape'}" @click="setPreviewMode('mobile-landscape')"></i>
    </div>

    <ul class="dvs-list-reset">
      <li class="dvs-collapsable dvs-mb-2" :class="{'dvs-open': pageSettingsOpen}">
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
            <li v-for="(slice, key) in slices" class="dvs-mb-4 dvs-collapsable" :class="{'dvs-open': slice.metadata.open}">
              <strong class="dvs-block dvs-mb-2 dvs-switch-sm dvs-ml-4" @click="toggleSlice(slice)">{{ slice.metadata.label }}</strong>
              <div class="dvs-collapsed">
                <slice-editor :slice="slice" />
              </div>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import SliceEditor from './SliceEditor'

export default {
  name: 'PageEditor',
  data () {
    return {
      previewMode: 'desktop',
      slices: [],
      pageSettingsOpen: false,
      pageContentOpen: true
    }
  },
  mounted () {
    this.slices = this.page.slices
  },
  methods: {
    togglePageSettings () {
      this.pageSettingsOpen = !this.pageSettingsOpen
      this.pageContentOpen = false
    },
    togglePageContent () {
      this.pageContentOpen = !this.pageContentOpen
      if (!this.pageContentOpen) {
        this.slices.map(s => this.closeSlice(s))
      }
      this.pageSettingsOpen = false
    },
    toggleSlice (slice) {
      this.slices.map(s => this.closeSlice(s))
      this.$set(slice.metadata, 'open', !slice.metadata.open)
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
