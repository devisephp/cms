<template>
  <div>
    <panel class="dvs-m-8" style="width:300px;" :panel-style="theme.panel">
      <div class="dvs-flex">
        <div :style="theme.panelSidebar" class="dvs-flex dvs-flex-col" >
          <button 
            :style="theme.panelSidebar"
            class="dvs-outline-none dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b dvs-border-grey-darkest"
            @click.prevent="goToPage('devise-index')">
            <back-icon class="dvs-panel-zoom1 dvs-m-4" w="30" h="30" />
          </button>
          <button 
            :style="theme.panelSidebar"
            class="dvs-outline-none dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b"
            @click.prevent="requestSavePage()">
            <save-icon class="dvs-m-4" w="30" h="30" />
          </button>
          <button 
            :style="theme.panelSidebar"
            class="dvs-outline-none dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b"
            @click="openPageContent">
            <create-icon class="dvs-m-4" w="30" h="30" />
          </button>
          <button 
            :style="theme.panelSidebar"
            class="dvs-outline-none dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b"
            @click="openPageSettings">
            <cog-icon class="dvs-m-4" w="30" h="30" />
          </button>
        </div>

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
                    <slice-editor @opened="openSlice(slice)" :key="slice.id" :slice="slice" />
                  </template>
                </ul>
              </div>
            </li>
          </ul>

        </div>
      </div>
    </panel>
    <portal to="devise-root">
      <analytic-totals />
    </portal>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

import AnalyticTotals from './AnalyticTotals'
import Panel from './../utilities/Panel'

import SaveIcon from 'vue-ionicons/dist/md-save.vue'
import CreateIcon from 'vue-ionicons/dist/md-create.vue'
import CogIcon from 'vue-ionicons/dist/md-cog.vue'
import BackIcon from 'vue-ionicons/dist/md-arrow-round-back.vue'

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
    openPageSettings () {
      this.pageSettingsOpen = !this.pageSettingsOpen
      this.pageContentOpen = false
    },
    openPageContent () {
      this.pageContentOpen = true
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
    BackIcon,
    CogIcon,
    CreateIcon,
    Panel,
    SaveIcon,
  }
}
</script>
