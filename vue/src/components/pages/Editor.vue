<template>
  <div>

    <div class="dvs-flex dvs-flex-col dvs-items-center dvs-px-8 dvs-pb-8 dvs-pt-8">
        <draggable v-model="page.slices" element="ul" class="dvs-list-reset dvs-w-full" :options="{group:{ name:'g1'}}">
          <template v-for="slice in page.slices">
            <slice-editor @opened="openSlice(slice)" :key="slice.id" :slice="slice" @addSlice="addSlice" @removeSlice="removeSlice" @copySlice="copySlice" />
          </template>
        </draggable>

        <manage-slice ref="manageSlice" v-if="createSlice === true" @addSlice="addSlice" @cancel="createSlice = false" />

        <div class="dvs-flex dvs-justify-center">
          <button 
            :style="theme.actionButtonGhost"
            class="dvs-rounded-full dvs-my-4 dvs-flex dvs-justify-center dvs-items-center dvs-p-2 dvs-pr-4 dvs-uppercase dvs-text-xs dvs-font-bold"
            @click.prevent="requestAddSlice">
            <add-icon w="20" h="20" /> Add Slice
          </button>
        </div>

        <button 
          :style="theme.actionButton"
          class="dvs-btn dvs-mt-8 dvs-block dvs-w-full"
          @click.prevent="requestSavePage()">
          Save Page
        </button>
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
      createSlice: false
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
      this.savePage(this.page).then(() => {
        window.onbeforeunload = null
      })
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
    requestAddSlice () {
      let self = this
      this.createSlice = true
      this.$nextTick(function () {
        this.$refs.manageSlice.action = 'insert'
      })
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
    copySlice (sliceToCopy, referenceSlice) {
      if (referenceSlice === null) {
        referenceSlice = this.page
      }
      
      var newSlice = JSON.parse(JSON.stringify(sliceToCopy))
      newSlice.metadata.instance_id = 0

      referenceSlice.slices.push(newSlice)
    },
    removeSlice (deletingSlice, referenceSlice) {
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
