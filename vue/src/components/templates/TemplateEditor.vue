<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative" v-if="dataLoaded">
    <div id="devise-sidebar" :style="sidebarTheme" data-simplebar>
      <sidebar-header title="Edit Template" back-text="Back to Templates" :back-callback="goToTemplates" />

      <div class="dvs-flex dvs-justify-between dvs-text-sm dvs-font-bold dvs-w-full dvs-border-b px-8"
        :style="`border-color:${theme.sidebarText.color}`">
        <div 
          class="dvs-p-2 dvs-cursor-pointer" 
          :class="{'dvs-border-b-2': templateSettingsOpen}" 
          :style="`border-color:${theme.sidebarText.color}`" 
          @click="toggleTemplateSettings">
          Template Settings
        </div>
        <div 
          class="dvs-p-2 dvs-cursor-pointer"
          :class="{'dvs-border-b-2': templateLayoutOpen}" 
          :style="`border-color:${theme.sidebarText.color}`" 
          @click="toggleTemplateLayout">
          Template Layout
        </div>
      </div>

      <ul class="dvs-list-reset m-8">
        <li class="dvs-collapsable dvs-mb-2" :class="{'dvs-open': templateSettingsOpen}">
          <div class="dvs-collapsed dvs-mt-4 dvs-text-left">
            <fieldset class="dvs-fieldset dvs-mb-8">
              <label>Template Name</label>
              <input type="text" v-model="localValue.name" placeholder="Name of the Template">
            </fieldset>

            <fieldset class="dvs-fieldset dvs-mb-8">
              <label>Template Layout</label>
              <input type="text" v-model="localValue.layout" disabled placeholder="Blade File Name">
            </fieldset>

            <fieldset class="dvs-fieldset">
              <label>Manage Data</label>
              <help v-if="localValue.model_queries.length < 1">Currently you don't have any data assigned to this template. Data you add will be available whenever this template is applied to a page</help>
              <div 
                class="dvs-flex dvs-justify-between dvs-items-center dvs-text-sm dvs-mb-2 dvs-font-bold dvs-p-4 dvs-rounded dvs-relative" 
                :style="regularButtonTheme" 
                v-for="(query, key) in localValue.model_queries" 
                :key="key"  
                v-else>
                {{ key }}
                <div @click="removeData(key)" class="dvs-absolute dvs-mt-3 dvs-pin-t dvs-pin-r dvs-pin-b dvs-mr-4">
                  <trash-icon class="dvs-cursor-pointer" w="25" h="25" />
                </div>
              </div>
              <fieldset class="dvs-fieldset dvs-mt-8">
                <label>Add New Data</label>
                <div class="relative">
                  <input type="text" placeholder="Variable Name" :value="newData.name" @input="newData.name = slugify($event.target.value)">
                  <div class="dvs-absolute dvs-mt-2 dvs-pin-t dvs-pin-r dvs-pin-b dvs-mr-4" @click="showAddData = true">
                    <add-icon class="dvs-cursor-pointer" w="25" h="25" />
                  </div>
                </div>
              </fieldset>
            </fieldset>
          </div>
        </li>
        <li class="dvs-collapsable dvs-mb-2" :class="{'dvs-open': templateLayoutOpen}">
          <div class="dvs-collapsed dvs-mt-4">

            <div v-if="localValue.slices" class="dvs-flex dvs-flex-col dvs-items-center dvs-text-left">
              <draggable v-model="localValue.slices" element="ul" class="dvs-list-reset dvs-mb-2 dvs-w-full" :options="{handle: '.handle'}">
                <li v-for="(slice, key) in localValue.slices" :key="key" class="dvs-mb-4 dvs-w-full">

                  <template-slice-editor
                    v-model="localValue.slices[key]"
                    @addSlice="requestAddSlice"
                    @removeSlice="requestRemoveSlice"
                    @manageSlice="requestManageSlice"
                    :class="{'dvs-open': slice.metadata.open}">
                  </template-slice-editor>

                </li>
              </draggable>
              <button class="dvs-btn dvs-btn-sm dvs-mx-2 dvs-w-4/5 dvs-mt-8" v-if="!anySliceOpen" @click="requestAddSlice(localValue.slices, true)"  :style="actionButtonTheme">Add Slice to Layout</button>
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
    <div class="dvs-fixed dvs-pin-b dvs-pin-r dvs-mr-8 dvs-rounded-sm dvs-p-4 dvs-mb-2 dvs-z-40" :style="infoBlockTheme">
      <h6 class="dvs-mb-4 dvs-text-base" :style="{color: theme.statsText.color}">Template Controls</h6>
      <button class="dvs-btn dvs-mr-2" @click="requestSaveTemplate" :style="actionButtonTheme">Save Template</button>
      <button class="dvs-btn dvs-btn-plain" @click="goToTemplates" :style="regularButtonTheme">Cancel</button>
    </div>

    <portal to="devise-root">
      <devise-modal @close="showAddData = false" v-if="showAddData" class="dvs-z-50">
        <query-builder v-model="newData" @save="addNewData" @close="showAddData = false"></query-builder>
      </devise-modal>
    </portal>

  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import draggable from 'vuedraggable'

  import Strings from './../../mixins/Strings'

  import DeviseModal from './../utilities/Modal'
  import ManageSlices from './ManageSlices'
  import QueryBuilder from './../utilities/QueryBuilder'
  import Slices from './../../Slices'
  import SuperTable from './../utilities/tables/SuperTable'
  import SidebarHeader from './../utilities/SidebarHeader'
  import TemplateSliceEditor from './TemplateSliceEditor'

  import TrashIcon from 'vue-ionicons/dist/md-trash.vue'
  import AddIcon from 'vue-ionicons/dist/ios-add-circle.vue'

  export default {
    name: 'TemplateEditor',
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
        },
        showAddData: false,
        newData: {
          name: null,
          model: null,
          modelQuery: null
        }
      }
    },
    mounted () {
      let self = this
      self.getTemplates().then(function () {
        self.localValue = deviseSettings.$template
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
        deviseSettings.$template = this.localValue
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

          self.$set(slice, 'settings', {})

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
      },

      removeData (key) {
        this.$delete(this.localValue.model_queries, key)
      },

      addData () {
        if (this.newData.name !== null && this.newData.name !== '') {
          this.addDataOpen = true
          this.newData.model = null
          this.newData.modelQuery = null
        }
      },

      addNewData () {
        this.localValue.model_queries[this.newData.name] = this.newData.modelQuery
        this.showAddData = false

        this.newData = {
          name: null,
          model: null,
          modelQuery: null
        }
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
    mixins: [Strings],
    components: {
      DeviseModal,
      draggable,
      ManageSlices,
      QueryBuilder,
      SidebarHeader,
      SuperTable,
      TemplateSliceEditor,
      AddIcon,
      TrashIcon
    }
  }
</script>
