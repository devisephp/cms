<template>
  <div>

    <!-- Create Slice -->
    <div class="dvs-blocker dvs-blocker-light dvs-z-50" @click="closeManager()" v-if="originSlice"></div>
    <div class="dvs-fixed dvs-pin-b dvs-pin-l dvs-mb-10 dvs-mx-10 dvs-p-8 dvs-bg-white dvs-rounded-sm dvs-min-w-48 dvs-shadow-lg dvs-z-50 dvs-text-grey-darker dvs-font-normal dvs-min-w-1/2" :style="infoBlockTheme" v-if="originSlice">

      <div v-if="mode === 'add' && step === 'type'">
        <h3 class="dvs-font-hairline dvs-mb-8" :style="{ color: theme.statsText.color }">Add Slice to Layout</h3>

        <help class="dvs-mb-8 dvs-max-w-lg">
          These controls allow you to add sub-slices to the slice you selected. You can add as many single slices as you wish or you can add a one model or one repeatable slice. Models and repeatables allow you to generate many of the same slice with dynamic data from your database (models) or via the Devise editor (repeatables).
        </help>

        <div class="dvs-flex dvs-justify-center dvs-mb-4">
          <div class="dvs-card dvs-text-center dvs-cursor-pointer dvs-mx-4 dvs-w-48 dvs-bg-grey-lighter hover:dvs-bg-blue-dark hover:dvs-text-white" @click="chooseTypeToAdd('single')">
            <remove-icon w="40" h="40" />
            <h6 class="dvs-text-sm dvs-uppercase" :style="{ color: theme.statsText.color }">Single</h6>
          </div>
          <div class="dvs-card dvs-text-center dvs-cursor-pointer dvs-mx-4 dvs-w-48 dvs-bg-grey-lighter hover:dvs-bg-blue-dark hover:dvs-text-white" @click="chooseTypeToAdd('repeats')">
            <menu-icon w="40" h="40" />
            <h6 class="dvs-text-sm dvs-uppercase" :style="{ color: theme.statsText.color }">Repeatable</h6>
          </div>
          <div class="dvs-card dvs-text-center dvs-cursor-pointer dvs-mx-4 dvs-w-48 dvs-bg-grey-lighter hover:dvs-bg-blue-dark hover:dvs-text-white" @click="chooseTypeToAdd('model')">
            <cube-icon w="40" h="40" />
            <h6 class="dvs-text-sm dvs-uppercase" :style="{ color: theme.statsText.color }">Model</h6>
          </div>
        </div>
      </div>

      <div class="dvs-mb-4" v-if="mode === 'add' && step === 'view'">
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Select a Slice</label>
          <select v-model="sliceToAdd.slice">
            <option :value="null">Select a Slice</option>
            <optgroup v-for="(group, name) in sliceDirectoriesOptions" :key="name" :label="name">
              <option v-for="option in group" :key="option.id" :value="option">
                {{ option.name }}
              </option>
            </optgroup>
          </select>
        </fieldset>
        <button class="dvs-btn" :disabled="!sliceToAdd" @click="selectSliceToAdd()">Select</button>
      </div>


      <div class="dvs-mb-4" v-if="mode === 'add' && step === 'model'">
        <help class="dvs-mb-8">
          The models below are loaded by Devise by scanning your Laravel application directory for anything that extends the Model class. Ensure it does this for it to appear below.
        </help>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Select a Model</label>
          <select v-model="sliceToAdd.model">
            <option :value="null">Select a Model</option>
            <option :value="model" v-for="model in storeModels" :key="model.id">{{ model.name }}</option>
          </select>
        </fieldset>
        <button class="dvs-btn" :disabled="!sliceToAdd.model" @click="selectModelToAdd()">Select</button>
      </div>

      <div v-if="mode === 'add' && step === 'data'">
        <help>
          This is a model slice and allows you to set the query that will be performed every time it is loaded. Provide the filters and sorting that gives you the data you need, save, and that query will be loaded every time. Need to lean on variables such as URL parameters? No problem. Click here to see variables available to you.

          <!-- TODO: ACCORDIAN VARIABLES LIST / DESCRIPTIONS.  -->
        </help>

        <super-table
          v-model="sliceToAdd.modelQuery"
          :columns="sliceToAdd.model.columns"
          :showLinks="false"
          @cancel="closeManager"
          @done="selectDataToAdd"
          />
      </div>

      <div class="dvs-mb-4" v-if="mode === 'remove'">
        <h6 :style="{color: theme.statsText.color}" class="mb-6">Are you sure you want to delete this slice?</h6>
        <help class="dvs-mb-8">
          If you delete this slice it will effect all pages that implement this template.
        </help>
        <button class="dvs-btn dvs-mr-2" @click="closeManager()" :style="actionButtonTheme">Cancel</button>
        <button class="dvs-btn dvs-btn-danger" @click="removeSlice()">Confirm</button>
      </div>
    </div>

    <!-- Model Controls -->

  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  import SuperTable from '../utilities/tables/SuperTable'
  import SlicesMixin from '../../mixins/Slices'

  import RemoveIcon from 'vue-ionicons/dist/ios-remove.vue'
  import MenuIcon from 'vue-ionicons/dist/ios-menu.vue'
  import CubeIcon from 'vue-ionicons/dist/ios-cube.vue'

  /*
  Manage Slices

  This component manages the following:

    * Adding new slices to the origin slice
      1. Choose the type
      2. Choose the view
      3. If the type is modal set the data

    * Removing slices

    * Modifying modal data of a slice

  */
  export default {
    data () {
      return {
        modelEditor: null,
        localValue: null,
        step: 'type',
        sliceToAdd: {
          show: false,
          type: 'single',
          slice: null,
          model: null,
          modelQuery: null
        }
      }
    },
    mounted () {
      this.localValue = this.value
      this.getSlicesDirectories()
      this.getSlices()
    },
    methods: {
      ...mapActions('devise', [
        'getSlicesDirectories',
        'getSlices',
        'getModels',
        'getModelSettings'
      ]),
      updateValue () {
        // Emit the number value through the input event
        this.$emit('input', this.localValue)
        this.$emit('change', this.localValue)
      },
      closeManager () {
        this.resetData()
        this.$emit('closeManager')
      },
      addSlice (finalSlice) {
        this.originSlice.push(finalSlice)
        this.updateValue()
        this.closeManager()
      },
      removeSlice () {
        let parent = this.findParentOfSlice(this.localValue)

        if (parent) {
          parent.splice(parent.indexOf(this.originSlice), 1)
          this.updateValue()
          this.closeManager()
        } else {
          console.warn('Could not find the parent of the slice you are trying to remove. You shouldn\'t see this warning so if you do please submit an issue @ https://github.com/devisephp/cms')
        }
      },
      findParentOfSlice (parent) {
        for (var i = 0; i < parent.length; i++) {
          // Look to see if this slice matches what we're looking for. If so,
          // return the parent array
          if (parent[i] === this.originSlice) {
            return parent
          }

          // It didn't match so check any children of this slice to see if it's
          // in there.
          if (parent[i].slices && parent[i].slices.length) {
            let searchInChild = this.findParentOfSlice(parent[i].slices)
            if (searchInChild) {
              return searchInChild
            }
          }
        }
        return false
      },
      resetData () {
        this.sliceToAdd.show = false,
        this.sliceToAdd.type = 'single'
        this.sliceToAdd.direction = null
        this.sliceToAdd.slice = null
        this.sliceToAdd.model = null
        this.sliceToAdd.modelQuery = null
        this.mode = 'add'
        this.step = 'type'
      },
      chooseTypeToAdd (type) {
        if (type !== 'single' && this.root) {
          window.parent.postMessage({type: 'error', message: 'You cannot add a model or repeatable to the root of a template. You can add these as a child to any component and render them with <slices :slices="slices"/> in the container\'s blade file'}, '*')
          return
        }

        this.sliceToAdd.type = type
        this.step = 'view'

        if (type === 'model') {
          this.getModels()
        }
      },
      selectSliceToAdd (type) {
        if (this.sliceToAdd.type === 'model') {
          this.step = 'model'
        } else {
          let slice = this.buildSlice()
          this.addSlice(slice)
        }
      },
      selectModelToAdd () {
        this.sliceToAdd.modelQuery = this.sliceToAdd.model.class
        this.step = 'data'
      },
      selectDataToAdd () {
        let slice = this.buildSlice()

        if (this.mode === 'add') {
          this.addSlice(slice)
        }
      },
      buildSlice () {
        return {
          config: {},
          id: 0,
          label: this.sliceToAdd.slice.name,
          metadata: {
            open: false,
            tools: false
          },
          model_query: 'class=' + this.sliceToAdd.modelQuery,
          name: this.componentFromView(this.sliceToAdd.slice.value).name,
          slices: [],
          type: this.sliceToAdd.type,
          view: 'slices.' + this.sliceToAdd.slice.value
        }
      }
    },
    computed: {
      ...mapGetters('devise', [
        'componentFromView',
        'storeModels',
        'modelSettings',
        'slicesList',
        'slicesDirectories'
      ])
    },
    components: {
      CubeIcon,
      MenuIcon,
      RemoveIcon,
      SuperTable
    },
    props: ['originSlice', 'value', 'mode', 'root'],
    mixins: [SlicesMixin]
  }
</script>
