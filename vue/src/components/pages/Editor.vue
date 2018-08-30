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

            <manage-slice v-if="createSlice === true" @addSlice="addSlice" @cancel="createSlice = false" />

            <div class="dvs-flex dvs-justify-center">
              <button 
                :style="theme.actionButtonGhost"
                class="dvs-rounded-full dvs-mb-4 dvs-flex dvs-justify-center dvs-items-center dvs-p-2 dvs-pr-4 dvs-uppercase dvs-text-xs dvs-font-bold"
                @click.prevent="createSlice = true">
                <add-icon w="20" h="20" /> Add Slice
              </button>
            </div>

            <button 
              :style="theme.actionButton"
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
import AddIcon from 'vue-ionicons/dist/ios-add.vue'

export default {
  name: 'PageEditor',
  data () {
    return {
      createSlice: false,
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
        let parentSlice = this.page.slices[this.page.slices.indexOf(referenceSlice)]
        let config = this.sliceConfig(parentSlice)
        if (config.has_child_slot === true) {
          if (typeof parentSlice.slices === 'undefined') {
            this.$set(parentSlice, 'slices', [])
          }
          parentSlice.slices.push(newSlice)
        }
      } else {
        this.page.slices.push(newSlice)
      }

      this.createSlice = false
    },
    editSlice (editedSlice, referenceSlice) {
      this.page.slices.splice(this.page.slices.indexOf(referenceSlice), 1, editedSlice)
    },
    removeSlice (deletingSlice,referenceSlice) {
      if (typeof referenceSlice === 'undefined') {
        referenceSlice = this.page
      }
      referenceSlice.slices.splice(referenceSlice.slices.indexOf(deletingSlice), 1)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'sliceConfig'
    ])
  },
  props: ['page'],
  components: {
    AddIcon,
    AnalyticTotals,
    draggable,
    ManageSlice
  }
}
</script>
