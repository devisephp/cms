<template>
  <div>
    <div class="dvs-blocker dvs-blocker-light" @click="modelEditor = null" v-if="modelEditor && modelSettings.columns"></div>
    <div class="dvs-fixed dvs-pin-b dvs-pin-l dvs-mb-10 dvs-mx-10 dvs-p-4 dvs-bg-white dvs-rounded-sm dvs-min-w-48 dvs-shadow-lg dvs-z-50 dvs-text-grey-darker dvs-font-normal" v-if="modelEditor && modelSettings.columns">
      <help>
        This is a model slice and allows you to set the query that will be performed every time it is loaded. Provide the filters and sorting that gives you the data you need, save, and that query will be loaded every time. Need to lean on variables such as URL parameters? No problem. Click here to see variables available to you.

        <!-- TODO: ACCORDIAN VARIABLES LIST / DESCRIPTIONS.  -->
      </help>

      <super-table
         v-model="modelEditor.model_query"
         :columns="modelSettings.columns"
         :showLinks="false"
         @cancel="modelEditor = null"
         @done="modelEditorDone"
        />
    </div>

    <div class="dvs-blocker dvs-blocker-light" @click="createChildren = null" v-if="createChildren"></div>
    <div class="dvs-fixed dvs-pin-b dvs-pin-l dvs-mb-10 dvs-mx-10 dvs-p-4 dvs-bg-white dvs-rounded-sm dvs-min-w-48 dvs-shadow-lg dvs-z-50 dvs-text-grey-darker dvs-font-normal dvs-min-w-1/2" v-if="createChildren">

      <div v-if="!createChildren.childToCreate">
        <help class="dvs-mb-8">
          These controls allow you to add sub-slices to the slice you selected. You can add as many single slices as you wish or you can add a one model or one repeatable slice. Models and repeatables allow you to generate many of the same slice with dynamic data from your database (models) or via the Devise editor (repeatables).
        </help>

        <div class="dvs-flex dvs-justify-center dvs-mb-4">
          <div class="dvs-card dvs-text-center dvs-cursor-pointer dvs-mx-4 dvs-w-48 dvs-bg-grey-lighter hover:dvs-bg-blue-dark hover:dvs-text-white" @click="addSubSliceToCreate('single')">
            <i class="ion-android-remove dvs-text-4xl"></i>
            <h6>Single</h6>
          </div>
          <div class="dvs-card dvs-text-center dvs-cursor-pointer dvs-mx-4 dvs-w-48 dvs-bg-grey-lighter hover:dvs-bg-blue-dark hover:dvs-text-white">
            <i class="ion-android-menu dvs-text-4xl"></i>
            <h6>Repeatable</h6>
          </div>
          <div class="dvs-card dvs-text-center dvs-cursor-pointer dvs-mx-4 dvs-w-48 dvs-bg-grey-lighter hover:dvs-bg-blue-dark hover:dvs-text-white" @click="addSubSliceToCreate('model')">
            <i class="ion-cube dvs-text-4xl"></i>
            <h6>Model</h6>
          </div>
        </div>
      </div>

      <div class="dvs-mb-4" v-if="createChildren.childToCreate && !createChildren.childToCreate.slice">
        <fieldset class="dvs-fieldset mb-4">
          <label>Select a Slice</label>
          <select v-model="sliceToAdd">
            <option :value="null">Select a Slice</option>
            <option :value="slice" v-for="slice in slices.data">{{ slice.name }}</option>
          </select>
        </fieldset>
        <button class="dvs-btn" :disabled="!sliceToAdd" @click="selectSliceForNewChild()">Select</button>
      </div>

      <div class="dvs-mb-4" v-if="createChildren.childToCreate && createChildren.childToCreate.type === 'model' && createChildren.childToCreate.slice">
        <help class="dvs-mb-8">
          The models below are loaded by Devise by scanning your Laravel application directory for anything that extends the Model class. Ensure it does this for it to appear below.
        </help>
        <fieldset class="dvs-fieldset mb-4">
          <label>Select a Model</label>
          <select v-model="childModelToAdd">
            <option :value="null">Select a Model</option>
            <option :value="model" v-for="model in models">{{ model.name }}</option>
          </select>
        </fieldset>
        <button class="dvs-btn" :disabled="!childModelToAdd" @click="pushNewChildSlice()">Select</button>
      </div>

    </div>

    <div id="devise-sidebar" class="devise-iframe-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Edit Template</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToTemplates">Back to Templates</a>
      <ul class="dvs-list-reset">
        <li class="dvs-collapsable dvs-mb-2" :class="{'dvs-open': templateSettingsOpen}">
          <div class="dvs-switch" @click="togglePageSettings">
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
          <div class="dvs-switch" @click="togglePageContent">
            Template Layout
          </div>
          <div class="dvs-collapsed dvs-mt-4">

            <div v-if="localValue.slices">
              <ul class="dvs-list-reset">
                <li v-for="(slice, key) in localValue.slices" v-if="theSlice(slice) && slice.metadata" class="dvs-mb-2 dvs-template-editor-collapsable" :class="{'dvs-open': slice.metadata.open}">
                  <template-preview-settings v-model="localValue.slices[key]" @addSlice="requestAddSlice" @toggleSlice="toggleSlice(slice)" @toggleModelControls="toggleModelControls" @toggleCreateChildrenSlices="toggleCreateChildrenSlices"></template-preview-settings>
                </li>
              </ul>
            </div>

            <div v-if="localValue.slices && localValue.slices.length < 1">
              <button class="dvs-btn dvs-btn-lg dvs-font-bold dvs-w-full" @click="requestAddSlice({direction: 'below', slice: null})">Add first slice</button>

            </div>

          </div>
        </li>
      </ul>
    </div>

    <div id="devise-preview-content" v-if="slices.data.length && dataLoaded">

      <slot name="on-top"></slot>

      <template v-if="localValue.slices">
        <div v-for="(slice, key) in localValue.slices" class="dvs-slot">
          <template v-if="slice.metadata.type === 'single'">
            <component v-bind:is="getComponent(theSlice(slice).component)" :devise="localValue.slices[key].config" :key="key"></component>
          </template>
          <template v-if="slice.metadata.type === 'multiple'" v-for="s in slice.metadata.settings.numberOfInstances">
            <component v-bind:is="getComponent(theSlice(s).component)" :devise="localValue.slices[key].config" :key="key"></component>
          </template>
        </div>
      </template>

      <slot name="on-bottom"></slot>

    </div>

    <div class="dvs-fixed dvs-pin-b dvs-pin-r dvs-mr-8 dvs-rounded-sm dvs-shadow-lg dvs-bg-white dvs-p-4 dvs-z-40">
      <h6 class="mb-4">Template Controls</h6>
      <button class="dvs-btn dvs-mr-2" @click="requestSaveTemplate">Save Template</button>
      <button class="dvs-btn dvs-btn-plain" @click="goToTemplates">Cancel</button>
    </div>

    <div class="dvs-fixed dvs-pin dvs-z-50" v-show="addSlice.show">
      <div class="dvs-blocker"></div>
      <div class="dvs-fixed dvs-z-50 dvs-min-w-1/2 dvs-absolute-center dvs-mb-12 dvs-rounded-sm dvs-shadow-lg dvs-bg-white dvs-p-4">
        <h4 class="mb-4">Select a Slice to Insert {{ addSlice.direction }}</h4>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Slice</label>
          <select v-model="addSlice.slice">
            <option :value="null">Select a Slice</option>
            <option :value="slice" v-for="slice in slices.data">{{ slice.name }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Type</label>
          <select v-model="addSlice.type">
            <option value="single">Single</option>
            <option value="repeatable">Repeatable</option>
            <option value="model">Model</option>
          </select>
        </fieldset>
        <button class="dvs-btn dvs-mr-2" :disabled="addSlice.slice === null" @click="confirmAddSlice">Add Slice</button>
        <button class="dvs-btn dvs-btn-plain" @click="addSlice.show = false">Cancel</button>
      </div>
    </div>

  </div>
</template>

<script>
import faker from 'faker/locale/en'

import { mapGetters, mapActions } from 'vuex'
import SuperTable from '../utilities/tables/SuperTable'

export default {
  name: 'TemplatePreview',
  data () {
    return {
      localValue: {},
      addSlice: {
        show: false,
        type: 'single',
        direction: null,
        slice: null,
        referenceSlice: null
      },
      modelEditor: null,
      createChildren: null,
      childModelToAdd: null,
      sliceToAdd: null,
      templateSettingsOpen: false,
      templateLayoutOpen: true,
      dataLoaded: false
    }
  },
  mounted () {
    let self = this
    self.getTemplates().then(function () {
      self.localValue = window.template
      self.getSlices().then(function () {
        self.localValue.slices = self.buildTemplateForPreview()
        self.dataLoaded = true
      })
    })
  },
  methods: {
    ...mapActions('devise', [
      'getTemplates',
      'updateTemplate',
      'getSlices',
      'getModels',
      'getModelSettings'
    ]),
    requestSaveTemplate () {
      var self = this

      this.updateTemplate(this.localValue).then(function () {
        self.goToTemplates()
      })
    },
    goToTemplates () {
      window.parent.postMessage('goBack', '*')
    },
    theSlice (s) {
      if (!s.hasOwnProperty('slice_id')) {
        s.slice_id = s.id
      }
      return this.slices.data.find(slice => {
        return slice.id === s.slice_id
      })
    },
    requestAddSlice ({direction, slice}) {
      this.addSlice.direction = direction
      this.addSlice.show = true
      this.addSlice.referenceSlice = slice
    },
    confirmAddSlice () {
      this.addSlice.show = false
      let position = this.localValue.slices.indexOf(this.addSlice.referenceSlice)
      if (position < 0) {
        position = 0
      }

      let newSlice = this.buildSliceForPreview(this.addSlice.slice)
      newSlice.type = this.addSlice.type

      if (this.addSlice.direction === 'above') {
        this.localValue.slices.splice(position, 0, newSlice)
      } else {
        this.localValue.slices.splice(position + 1, 0, newSlice)
      }
    },
    togglePageSettings () {
      this.templateSettingsOpen = !this.templateSettingsOpen
      this.templateLayoutOpen = false
    },
    togglePageContent () {
      this.templateLayoutOpen = !this.templateLayoutOpen
      this.templateSettingsOpen = false
    },
    toggleSlice (slice) {
      this.localValue.slices.map(s => this.closeSlice(s))
      this.$set(slice.metadata, 'open', !slice.metadata.open)
    },
    toggleModelControls (component) {
      if (this.modelEditor === null) {
        this.modelEditor = component
        this.getModelSettings(component.model_query)
      } else {
        this.modelEditor = null
      }
    },
    toggleCreateChildrenSlices (component) {
      if (this.createChildren === null) {
        this.createChildren = component
      } else {
        this.createChildren = null
      }
    },
    addSubSliceToCreate (type) {
      this.$set(this.createChildren, 'childToCreate', {
        type: type
      })

      if (type === 'model') {
        this.getModels()
      }
    },
    selectSliceForNewChild () {
      this.$set(this.createChildren.childToCreate, 'slice', this.sliceToAdd)

      if (
        this.createChildren.childToCreate.type === 'single' ||
        this.createChildren.childToCreate.type === 'repeatable'
      ) {
        this.pushNewChildSlice()
      }
    },
    pushNewChildSlice () {
      let modelQuery = (this.childModelToAdd) ? 'class=' + this.childModelToAdd.class : null

      this.createChildren.slices.push({
        id: 0,
        label: this.createChildren.childToCreate.slice.name,
        metadata: {
          open: true,
          settings: {
            numberOfInstances: 1
          }
        },
        config: {},
        type: this.createChildren.childToCreate.type,
        model_query: modelQuery,
        name: this.createChildren.childToCreate.slice.component,
        slice_id: this.createChildren.childToCreate.slice.id,
        slices: []
      })

      this.childModelToAdd = null
      this.createChildren = null
    },
    modelEditorDone () {
      this.modelEditor.update()
      this.modelEditor = null
    },
    closeSlice (slice) {
      this.$set(slice.metadata, 'open', false)
    },
    buildTemplateForPreview () {
      let self = this
      return this.localValue.slices.map(slice => {
        return self.buildSliceForPreview(slice)
      })
    },
    buildSliceForPreview (slice) {
      let self = this
      let sliceInfo = this.theSlice(slice)
      let component = window.deviseComponents[sliceInfo.component]

      // Set the metadata object if it isn't present
      if (typeof slice.metadata === 'undefined') {
        this.$set(slice, 'metadata', {'open': false})
      }

      // Create the settings if they don't exist
      if (typeof slice.metadata.settings === 'undefined') {
        this.$set(slice.metadata, 'settings', {
          numberOfInstances: 1
        })
      }

      // Set the type to single if it isn't present
      if (typeof slice.metadata.type === 'undefined') {
        this.$set(slice.metadata, 'type', 'single')
      }

      // Set the slices proprety if it isn't there yet
      if (typeof slice.slices === 'undefined') {
        this.$set(slice, 'slices', [])
      }

      // Set the label property if it isn't present
      if (typeof slice.label === 'undefined') {
        this.$set(slice, 'label', sliceInfo.name)
      }

      // Set the model_query property if it isn't present
      if (typeof slice.model_query === 'undefined') {
        this.$set(slice, 'model_query', '')
      }

      // Set the model_query property if it isn't present
      if (typeof slice.config === 'undefined' || slice.config === null) {
        this.$set(slice, 'config', {})
      }

      // Hydrate those fields if they don't exist
      Object.keys(component.config).forEach(function (key, index) {
        if (
          typeof slice.config[key] === 'undefined'
        ) {
          if (component.config[key].type === 'text') {
            self.$set(slice.config, key, {enabled: true, text: faker.lorem.words(5)})
          }
          if (component.config[key].type === 'wysiwyg') {
            self.$set(slice.config, key, {enabled: true, text: '<div>' + faker.lorem.words(15) + '</div>'})
          }
          if (component.config[key].type === 'color') {
            self.$set(slice.config, key, {enabled: true, color: '#f66d9b'})
          }
          if (component.config[key].type === 'number') {
            self.$set(slice.config, key, {enabled: true, text: '1000'})
          }
          if (component.config[key].type === 'textarea') {
            self.$set(slice.config, key, {enabled: true, text: faker.lorem.words(15)})
          }
          if (component.config[key].type === 'link') {
            self.$set(slice.config, key, {enabled: true, text: 'A Link', url: faker.internet.url(), target: '_self'})
          }
          if (component.config[key].type === 'image') {
            self.$set(slice.config, key, {enabled: true, url: faker.image.cats()})
          }
        }
      })

      //
      slice = this.buildParentSliceForPreview(slice)

      self.$set(slice.config, 'slices', slice.slices)

      slice.name = this.theSlice(slice).component

      console.log(slice)

      return slice
    },
    buildParentSliceForPreview (slice) {
      let self = this

      slice.slices = slice.slices.map(s => {
        return self.buildSliceForPreview(s)
      })

      return slice
    },
    getComponent (component) {
      return window.deviseComponents[component]
    }
  },
  computed: {
    ...mapGetters('devise', [
      'slices',
      'template',
      'models',
      'modelSettings'
    ])
  },
  components: {
    SuperTable
  }
}
</script>
