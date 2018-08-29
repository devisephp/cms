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
            <draggable v-model="page.slices" element="ul" class="dvs-list-reset" :options="{handle: '.handle'}">
              <template v-for="slice in page.slices">
                <slice-editor @opened="openSlice(slice)" :key="slice.id" :slice="slice" @addSlice="addSlice" @removeSlice="removeSlice" />
              </template>
            </draggable>

            <manage-slice v-if="createFirstSlice === true" @addSlice="addSlice" />

            <button 
              :style="theme.actionButtonGhost"
              class="dvs-btn dvs-block dvs-w-full dvs-mb-4"
              @click.prevent="createFirstSlice = true">
              Add Slice
            </button>

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
import draggable from 'vuedraggable'

import { mapGetters, mapActions } from 'vuex'

import ManageSlice from './slices/ManageSlice'
import AnalyticTotals from './AnalyticTotals'

export default {
  name: 'PageEditor',
  data () {
    return {
      createFirstSlice: false,
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
      this.page.slices.map(s => this.closeSlice(s))
      this.$set(sliceToOpen.metadata, 'open', true)
    },
    closeSlice (slice) {
      this.$set(slice.metadata, 'open', false)
    },
    addSlice (newSlice, referenceSlice) {
      if (typeof referenceSlice !== 'undefined') {
        this.page.slices.splice(this.page.slices.indexOf(referenceSlice) + 1, 0, newSlice)
      } else {
        this.page.slices.push(newSlice)
      }
    },
    editSlice (editedSlice, referenceSlice) {
      this.page.slices.splice(this.page.slices.indexOf(referenceSlice), 1, editedSlice)
    },
    removeSlice (referenceSlice) {
      this.page.slices.splice(this.page.slices.indexOf(referenceSlice), 1)
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
    draggable,
    ManageSlice
  }
}
</script>
