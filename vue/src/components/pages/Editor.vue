<template>
  <div>

    <div class="dvs-flex dvs-flex-col dvs-items-center dvs-px-8 dvs-pb-8 dvs-pt-8">
      <ul class="dvs-list-reset dvs-w-full dvs-pb-8">
        <li class="dvs-collapsable dvs-mb-8" v-if="pageSettingsOpen" :class="{'dvs-open': pageSettingsOpen}">
          <div class="dvs-collapsed">
            <fieldset class="dvs-fieldset dvs-mb-4">
              <label>Page Title</label>
              <input type="text" class="dvs-small dvs-dark" placeholder="Title of the Page">
            </fieldset>

            <fieldset class="dvs-fieldset dvs-mb-4">
              <label>Description</label>
              <textarea class="dvs-h-24 dvs-small dvs-dark" placeholder="Description of the Page - Try to aim for around 150 - 300 characters."></textarea>
            </fieldset>

            <fieldset class="dvs-fieldset">
              <label>Canonical</label>
              <input type="text" class="dvs-small dvs-dark" placeholder="Canonical">
            </fieldset>

            <router-link :to="{ name: 'devise-pages-view', params: { pageId: page.id }}" class="dvs-btn dvs-block dvs-font-bold dvs-text-center dvs-mt-8 dvs-bg-grey-darkest dvs-text-white">
              All Settings
            </router-link>
          </div>
        </li>
        <li class="dvs-collapsable dvs-mb-2 " :class="{'dvs-open': pageContentOpen}">
          <div class="dvs-collapsed">
            <ul class="dvs-list-reset">
              <template v-for="slice in pageSlices">
                <slice-editor @opened="openSlice(slice)" :key="slice.id" :slice="slice" @addSlice="addSlice" />
              </template>
            </ul>

            <button 
              :style="theme.actionButtonGhost"
              class="dvs-btn dvs-block dvs-w-full"
              @click.prevent="requestSavePage()">
              Save Page
            </button>
          </div>
        </li>
      </ul>
    </div>

    <portal to="devise-root">
      <analytic-totals />
    </portal>
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
    },
    addSlice (newSlice, referenceSlice) {
      this.pageSlices.splice(this.pageSlices.indexOf(referenceSlice), 0, newSlice)
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
