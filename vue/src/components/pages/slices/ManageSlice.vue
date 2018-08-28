<template>
<div>
  <div 
    class="dvs-cursor-pointer" 
    @click="requestInsertSlice">
      <cog-icon w="18" h="18" class="mt-1 mr-2" :style="theme.panelIcons" /> 
  </div>

  <portal to="devise-root" v-if="showInsert">
    <div class="dvs-blocker" @click="cancelInsertSlice"></div>
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
              <button class="dvs-btn" :style="theme.actionButtonGhost" @click="cancelInsertSlice">Cancel</button>
            </div>
          </div>
        </transition>
      </div>

    </panel>
  </portal>
</div>
</template>

<script>
import Panel from './../../utilities/Panel'
import QueryBuilder from './../../utilities/QueryBuilder'
import SlicesMixin from './../../../mixins/Slices'

import CogIcon from 'vue-ionicons/dist/ios-cog.vue'

import { mapGetters, mapActions } from 'vuex'

export default {
  data () {
    return {
      showInsert: false,
      insertSlice: {
        type: null,
        slice: null,
        data: {
          name: 'modelData',
          model: null,
          modelQuery: null
        }
      }
    }
  },
  mounted () {
    this.getSlicesDirectories()
    this.getSlices()
  },
  methods: {
    ...mapActions('devise', [
      'getSlicesDirectories',
      'getSlices',
      'getModelSettings'
    ]),
    requestInsertSlice () {
      this.showInsert = true
    },
    cancelInsertSlice () {
      this.showInsert = false
    },
    buildSlice () {
      let component = this.componentFromView(this.insertSlice.slice.value)
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
    addSlice () {
      this.$emit('addSlice', this.buildSlice())
      this.showInsert = false
    }
  },
  computed: {
    ...mapGetters('devise', [
      'componentFromView',
      'slicesDirectories'
    ])
  },
  components: {
    CogIcon,
    Panel,
    QueryBuilder
  },
  mixins: [SlicesMixin]
}
</script>
