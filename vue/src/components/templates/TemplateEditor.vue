<template>
  <div v-if="dataLoaded">

    <div id="devise-sidebar" class="devise-iframe-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Edit Template</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToTemplates">Back to Templates</a>
      <ul class="dvs-list-reset">
        <li class="dvs-collapsable dvs-mb-2" :class="{'dvs-open': templateSettingsOpen}">
          <div class="dvs-switch" @click="toggleTemplateSettings">
            Template Settings
          </div>

          <div class="dvs-collapsed dvs-mt-4">
            <fieldset class="dvs-fieldset">
              <label>Template Name</label>
              <input type="text" v-model="localValue.name" placeholder="Name of the Template">
            </fieldset>

            <fieldset class="dvs-fieldset">
              <label>Template Layout</label>
              <input type="text" v-model="localValue.layout" disabled placeholder="Blade File Name">
            </fieldset>
          </div>
        </li>
        <li class="dvs-collapsable dvs-mb-2" :class="{'dvs-open': templateLayoutOpen}">
          <div class="dvs-switch" @click="toggleTemplateLayout">
            Template Layout
          </div>
          <div class="dvs-collapsed dvs-mt-4">

            <div v-if="localValue.slices" class="dvs-flex dvs-flex-col dvs-items-center">
              <draggable v-model="localValue.slices" element="ul" class="dvs-list-reset dvs-mb-2 dvs-w-full" :options="{handle: '.handle'}">
                <li v-for="(slice, key) in localValue.slices" class="dvs-mb-2 dvs-template-editor-collapsable dvs-w-full" :class="{'dvs-open': slice.metadata.open}">

                  <template-slice-editor
                    v-model="localValue.slices[key]"
                    @addSlice="requestAddSlice"
                    @removeSlice="requestRemoveSlice"
                    @manageSlice="requestManageSlice">
                  </template-slice-editor>

                </li>
              </draggable>
              <button class="dvs-btn dvs-btn-sm mx-2 dvs-btn-ghost dvs-w-4/5" v-if="!anySliceOpen" @click="requestAddSlice(localValue.slices, true)">Add Slice to Layout</button>
            </div>

          </div>
        </li>
      </ul>
    </div>

    <!-- Preview Pane - Duplicates what is happening at Devise.vue -->
    <div id="devise-preview-content" v-if="localValue.slices.length && dataLoaded">

      <slot name="on-top"></slot>
      <slot name="static-content"></slot>

      <template v-if="localValue.slices">
        <slices :slices="localValue.slices"></slices>
      </template>

      <slot name="static-content-bottom"></slot>
      <slot name="on-bottom"></slot>

    </div>

    <!-- Slice Management for adding, modifying data, removing slices -->
    <manage-slices
      v-model="localValue.slices"
      :origin-slice="manageSlice.origin"
      :mode="manageSlice.mode"
      :root="manageSlice.root"
      @closeManager="manageSlice.origin = null"
      />

    <!-- Save Controls -->
    <div class="dvs-fixed dvs-pin-b dvs-pin-r dvs-mr-8 dvs-rounded-sm dvs-shadow-lg dvs-bg-white dvs-p-4 dvs-z-40">
      <h6 class="mb-4">Template Controls</h6>
      <button class="dvs-btn dvs-mr-2" @click="requestSaveTemplate">Save Template</button>
      <button class="dvs-btn dvs-btn-plain" @click="goToTemplates">Cancel</button>
    </div>

  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import draggable from 'vuedraggable'

  import ManageSlices from './ManageSlices'
  import Slices from '../../Slices'
  import SuperTable from '../utilities/tables/SuperTable'
  import TemplateSliceEditor from './TemplateSliceEditor'

  export default {
    data () {
      return {
        templateSettingsOpen: false,
        templateLayoutOpen: true,
        dataLoaded: false,
        localValue: {},
        manageSlice: {
          parent: null,
          origin: null,
          mode: 'add',
          root: true
        }
      }
    },
    mounted () {
      let self = this
      self.getTemplates().then(function () {
        self.localValue = window.template
        self.getSlicesDirectories()
        self.getSlices().then(function () {
          self.prepareSlices()
          self.dataLoaded = true
        })
      })
    },
    methods: {
      ...mapActions('devise', [
        'getTemplates',
        'updateTemplate',
        'getSlices',
        'getSlicesDirectories'
      ]),
      requestSaveTemplate () {
        var self = this

        this.updateTemplate(this.localValue).then(function () {
          window.parent.postMessage({type: 'saveSuccessful'}, '*')
        })
      },

      updateValue () {
        window.template = this.localValue
      },
      requestAddSlice (origin, isRoot) {
        this.manageSlice.mode = 'add'
        this.manageSlice.root = isRoot ? isRoot : false
        this.manageSlice.origin = origin
      },
      requestRemoveSlice (slice) {
        this.manageSlice.mode = 'remove'
        this.manageSlice.origin = slice
      },
      requestManageSlice (slice) {
        this.manageSlice.mode = 'manage'
        this.manageSlice.origin = slice
      },
      // Prepare the slices data to contain information necessary for the editor
      prepareSlices (sliceSlices) {
        let self = this

        if (sliceSlices === undefined) {
          sliceSlices = this.localValue.slices
        }

        sliceSlices.map(function (slice) {

          self.$set(slice, 'metadata', {
            open: false
          })

          if (slice.slices !== undefined && slice.slices.length > 0) {
            self.prepareSlices(slice.slices)
          }
        })
      },

      // When a User clicks on template settings open it and close other options
      toggleTemplateSettings () {
        this.templateSettingsOpen = !this.templateSettingsOpen
        this.templateLayoutOpen = false
      },

      // When a user clicks template layout open it and close other options
      toggleTemplateLayout () {
        this.templateLayoutOpen = !this.templateLayoutOpen
        this.templateSettingsOpen = false
      },

      goToTemplates () {
        window.parent.postMessage({type: 'goBack'}, '*')
      }
    },
    computed: {
      ...mapGetters('devise', [
        'component',
        'slicesList',
        'slicesDirectories',
        'template'
      ]),
      anySliceOpen () {
        for (var i = 0; i < this.localValue.slices.length; i++) {
          if (this.localValue.slices[i].metadata.open) {
            return true
          }
        }

        return false
      }
    },
    watch: {
      localValue: {
        handler(newValue) {
          this.showSave = true
        },
        deep: true
      }
    },
    components: {
      draggable,
      ManageSlices,
      SuperTable,
      TemplateSliceEditor
    }
  }
</script>
