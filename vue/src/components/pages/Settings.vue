<template>
  <div class="dvs-p-8">
    <fieldset class="dvs-fieldset dvs-mb-4">
      <label>Page Title</label>
      <input type="text" class="dvs-small" placeholder="Title of the Page">
    </fieldset>

    <fieldset class="dvs-fieldset dvs-mb-4">
      <label>Description</label>
      <textarea class="dvs-h-24 dvs-small" placeholder="Description of the Page - Try to aim for around 150 - 300 characters."></textarea>
    </fieldset>

    <fieldset class="dvs-fieldset dvs-mb-4">
      <label>Canonical</label>
      <input type="text" class="dvs-small" placeholder="Canonical">
    </fieldset>


    <button 
      :style="theme.actionButton"
      class="dvs-btn dvs-block dvs-w-full dvs-mb-2"
      @click.prevent="requestSavePage()">
      Save Page
    </button>

    <router-link 
      :to="{ name: 'devise-pages-view', params: { pageId: page.id }}" 
      class="dvs-btn dvs-block" 
      :style="theme.actionButtonGhost">
      All Settings
    </router-link>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

import AnalyticTotals from './AnalyticTotals'

export default {
  name: 'PageEditor',
  data () {
    return {
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
      this.savePage(this.page)
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
    AnalyticTotals
  }
}
</script>
