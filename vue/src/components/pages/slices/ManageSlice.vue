<template>
<div>

  <portal to="devise-root" v-if="action === 'selectAction'">
    <div class="dvs-blocker" @click="cancelManageSlice"></div>
    <panel class="dvs-fixed dvs-absolute-center dvs-mx-8 dvs-mb-8 dvs-z-40 dvs-w-4/5" :panel-style="theme.panel">
      
      <div class="dvs-p-8">
        <h3 class="dvs-mb-8">What would you like to do?</h3>
        
        <div class="dvs-flex dvs-justify-between dvs-items-stretch">
            <div class="dvs-btn dvs-text-base dvs-mr-4 dvs-p-8 dvs-w-1/3" :style="theme.actionButtonGhost" @click="action = 'insert'">
              <h4 class="dvs-border-b dvs-pb-2 dvs-mb-6 dvs-mx-4"  :style="{borderColor: theme.actionButtonGhost.borderColor}">Insert New Slice</h4>

              <p class="normal-case dvs-font-normal">Inserts a new slice below the current slice</p>
            </div>

            <div class="dvs-btn dvs-text-base dvs-mx-4 dvs-p-8 dvs-w-1/3" v-if="typeof slice !== 'undefined'" :style="theme.actionButtonGhost" @click="action = 'edit'">
              <h4 class="dvs-border-b dvs-pb-2 dvs-mb-6 dvs-mx-4"  :style="{borderColor: theme.actionButtonGhost.borderColor}">Edit This Slice</h4>

              <p class="normal-case dvs-font-normal">Edit the settings of this slice.</p>
            </div>

            <div class="dvs-btn dvs-text-base dvs-ml-4 dvs-p-8 dvs-w-1/3" v-if="typeof slice !== 'undefined'" :style="theme.actionButtonGhost" @click="removeSlice">
              <h4 class="dvs-border-b dvs-pb-2 dvs-mb-6 dvs-mx-4"  :style="{borderColor: theme.actionButtonGhost.borderColor}">Remove This Slice</h4>

              <p class="normal-case dvs-font-normal">Deletes the current slice from the page.</p>
            </div>
          </div>
      </div>

    </panel>
  </portal>

  <portal to="devise-root" v-if="action === 'insert'">
    <div class="dvs-blocker" @click="cancelManageSlice"></div>
    <panel class="dvs-fixed dvs-absolute-center dvs-mx-8 dvs-mb-8 dvs-z-40 dvs-w-4/5" :panel-style="theme.panel">
      
      <div class="dvs-p-8">
        <!-- Choose the type of the slice -->
        <h3 class="dvs-mb-8" v-if="insertSlice.type === null">Choose Type of New Slice</h3>
        <!-- Slice Settings -->
        <h3 class="dvs-mb-8" v-else>Slice Settings</h3>
        
        <transition name="dvs-fade">
          <!-- Choose the type of the slice -->
          <div class="dvs-flex dvs-justify-between dvs-items-stretch" v-if="insertSlice.type === null">
            <div class="dvs-btn dvs-text-base dvs-mr-4 dvs-p-8" :style="theme.actionButtonGhost" @click="insertSlice.type = 'single'">
              <h4 class="dvs-border-b dvs-pb-2 dvs-mb-6 dvs-mx-8"  :style="{borderColor: theme.actionButtonGhost.borderColor}">Single</h4>

              <p class="normal-case dvs-font-normal">A single slice-type is just one instance of the slice you're choosing to insert</p>
            </div>

            <div class="dvs-btn dvs-text-base dvs-mx-4 dvs-p-8" :style="theme.actionButtonGhost" @click="insertSlice.type = 'repeats'">
              <h4 class="dvs-border-b dvs-pb-2 dvs-mb-6 dvs-mx-8"  :style="{borderColor: theme.actionButtonGhost.borderColor}">Repeatable</h4>

              <p class="normal-case dvs-font-normal">Repeatables allow content editors to insert multiple instances of a slice.</p>
            </div>

            <div class="dvs-btn dvs-text-base dvs-ml-4 dvs-p-8" :style="theme.actionButtonGhost" @click="insertSlice.type = 'model'">
              <h4 class="dvs-border-b dvs-pb-2 dvs-mb-6 dvs-mx-8"  :style="{borderColor: theme.actionButtonGhost.borderColor}">Model</h4>

              <p class="normal-case dvs-font-normal">Model slices will insert instances on the page based data you define in the next steps.</p>
            </div>
          </div>

          <!-- Slice Settings -->
          <div v-else>

            <fieldset class="dvs-fieldset dvs-mb-4">
              <label>Select a Slice</label>
              <select v-model="insertSlice.slice">
                <option :value="null">Select a Slice</option>
                <optgroup v-for="(group, name) in sliceDirectoriesOptions" :key="name" :label="name">
                  <option v-for="option in group" :key="option.id" :value="option">
                    {{ option.name }}
                  </option>
                </optgroup>
              </select>
            </fieldset>

            <div class="dvs-mb-4" v-if="insertSlice.type === 'model'">
              <query-builder v-model="insertSlice.data"></query-builder>
            </div>

            <div>
              <button class="dvs-btn" :style="theme.actionButton" @click="addSlice">Insert</button>
              <button class="dvs-btn" :style="theme.actionButtonGhost" @click="cancelManageSlice">Cancel</button>
            </div>
          </div>
        </transition>
      </div>

    </panel>
  </portal>
  

  <portal to="devise-root" v-if="action === 'edit'">
    <div class="dvs-blocker" @click="cancelManageSlice"></div>
    <panel class="dvs-fixed dvs-absolute-center dvs-mx-8 dvs-mb-8 dvs-z-40 dvs-w-4/5" :panel-style="theme.panel">
      
      <div class="dvs-p-8">
        <h3 class="dvs-mb-8">Edit Slice Settings</h3>
        
        <div>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Type of Slice</label>
            <select @change="updateSliceType" v-model="editingSlice.metadata.type">
              <option value="single">Single</option>
              <option value="repeats">Repeats</option>
              <option value="model">Model</option>
            </select>
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Select a Slice</label>
            <select v-model="editingSlice.metadata.view">
              <option :value="null">Select a Slice</option>
              <optgroup v-for="(group, name) in sliceDirectoriesOptions" :key="name" :label="name">
                <option v-for="option in group" :key="option.id" :value="`slices.${option.value}`">
                  {{ option.name }}
                </option>
              </optgroup>
            </select>
          </fieldset>

          <div class="dvs-mb-4" v-if="editingSlice.type === 'model'">
            <query-builder v-model="editingSlice.data"></query-builder>
          </div>

          <div>
            <button class="dvs-btn" :style="theme.actionButton" @click="editSlice">Edit</button>
            <button class="dvs-btn" :style="theme.actionButtonGhost" @click="cancelManageSlice">Cancel</button>
          </div>
        </div>
      </div>

    </panel>
  </portal>
</div>
</template>

<script>
import Panel from './../../utilities/Panel'
import QueryBuilder from './../../utilities/QueryBuilder'
import SlicesMixin from './../../../mixins/Slices'

import { mapGetters, mapActions } from 'vuex'

let defaultInsertSlice = {
        type: null,
        slice: null,
        data: {
          name: 'modelData',
          model: null,
          modelQuery: null
        }
      }

export default {
  data () {
    return {
      action: 'selectAction',
      insertSlice: defaultInsertSlice,
      editingSlice: {}
    }
  },
  mounted () {
    this.editingSlice = Object.assign({}, this.slice)
    this.getSlicesDirectories()
    this.getSlices()
  },
  methods: {
    ...mapActions('devise', [
      'getSlicesDirectories',
      'getSlices',
      'getModelSettings'
    ]),
    cancelManageSlice () {
      this.action = null
      this.insertSlice = defaultInsertSlice
      this.editingSlice = this.slice
      this.showInsert = false
    },
    buildSlice () {
      let component = this.componentFromView('slices.' + this.insertSlice.slice.value)
      console.log('slices.' + this.insertSlice.slice.value, component)
      var finalSlice = {
        settings: {
          enabled: true
        },
        metadata: {
          instance_id: 0,
          label: this.insertSlice.slice.name,
          model_query: null,
          name: component.name,
          placeholder: this.insertSlice.slice.name,
          type: this.insertSlice.type,
          view: component.view
        }
      }
      for (const field in component.fields) {
        if (component.fields.hasOwnProperty(field)) {
          let defaults = component.fields[field].default
          finalSlice[field] = {}
          this.addMissingProperty(finalSlice, field)
          this.setDefaults(finalSlice, field, defaults)
        }
      }

      return finalSlice
    },
    addMissingProperty (slice, field) {
      // We just add all the properties because.... why not?
      this.$set(slice, field, {
        text: null,
        url: null,
        target: null,
        color: null,
        checked: null,
        enabled: false
      })
    },
    setDefaults (slice, field, defaults) {
      // loop through the defaults and apply them to the field
      for (var d in defaults) {
        this.$set(slice[field], d, defaults[d])
      }
    },
    updateSliceType () {
      if (this.editingSlice.metadata.type === 'repeats' || this.editingSlice.metadata.type === 'model') {
        this.editingSlice.metadata.placeholder = this.editingSlice.metadata.label
      }
    },
    addSlice () {
      this.$emit('addSlice', this.buildSlice())
      this.action = 'selectAction'
    },
    editSlice () {
      this.$emit('editSlice', this.editingSlice)
      this.action = 'selectAction'
    },
    removeSlice () {
      this.$emit('removeSlice')
      this.action = 'selectAction'
    }
  },
  computed: {
    ...mapGetters('devise', [
      'componentFromView',
      'slicesDirectories'
    ])
  },
  props: {
    slice: {
      type: Object
    }
  },
  components: {
    Panel,
    QueryBuilder
  },
  mixins: [SlicesMixin]
}
</script>
