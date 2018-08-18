<template>
  <div class="dvs-panel" v-tilt>
    <div class="dvs-panel-shine"></div>
    <div style="width:300px;" class="dvs-panel-contents">
      <div class="dvs-text-center dvs-text-white">
        <sidebar-header back-text="Administration" back-page="devise-index" :show-logo="false" />
      </div>

      <div class="dvs-flex">

        <div class="dvs-bg-black dvs-flex dvs-flex-col" >
          <button 
            class="dvs-outline-none dvs-text-grey-darker hover:dvs-text-grey dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b dvs-border-grey-darkest"
            @click.prevent="requestSavePage()">
            <save-icon class="dvs-m-4" w="30" h="30" />
          </button>
          <button 
            class="dvs-outline-none dvs-text-grey-darker hover:dvs-text-grey dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b dvs-border-grey-darkest"
            @click="openPageContent">
            <create-icon class="dvs-m-4" w="30" h="30" />
          </button>
          <button 
            class="dvs-outline-none dvs-text-grey-darker hover:dvs-text-grey dvs-transitions-hover-slow dvs-cursor-pointer dvs-bg-black dvs-border-b dvs-border-grey-darkest dvs-hover-white"
            @click="openPageSettings">
            <cog-icon class="dvs-m-4" w="30" h="30" />
          </button>
        </div>

        <div class="dvs-flex dvs-flex-col dvs-items-center dvs-px-8 dvs-pb-8 dvs-pt-8">
          <ul class="dvs-list-reset dvs-w-full dvs-pb-8">
            <li class="dvs-collapsable dvs-mb-8" v-if="pageSettingsOpen" :class="{'dvs-open': pageSettingsOpen}">
              <div class="dvs-collapsed">
                <fieldset class="dvs-fieldset dvs-mb-4">
                  <label class="dvs-text-grey-darker">Page Title</label>
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
    </div>

    <portal to="devise-root">
      <analytic-totals />
    </portal>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

import AnalyticTotals from './AnalyticTotals'
import SidebarHeader from './../utilities/SidebarHeader'

import SaveIcon from 'vue-ionicons/dist/md-save.vue'
import CreateIcon from 'vue-ionicons/dist/md-create.vue'
import CogIcon from 'vue-ionicons/dist/md-cog.vue'

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
    CogIcon,
    CreateIcon,
    SaveIcon,
    SidebarHeader
  }
}
</script>
