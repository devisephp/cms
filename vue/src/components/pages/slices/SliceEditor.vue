<template>
  <li class="dvs-mb-4 dvs-collapsable" :class="{'dvs-open': sliceOpen}">

    <strong class="dvs-block dvs-mb-4 dvs-switch-sm dvs-text-sm dvs-flex dvs-justify-between dvs-items-center dvs-w-full">
      <div class="dvs-flex dvs-items-center dvs-justify-between dvs-w-full" :style="{color: theme.panel.color}">
        <div class="dvs-flex dvs-items-center">
          <menu-icon w="18" h="18" class="dvs-mr-2 handle" :style="theme.panelIcons" /> 
          <span class="dvs-cursor-pointer" @click="toggleSlice()"  @mouseenter="markSlice(true, slice)"  @mouseleave="markSlice(false, slice)">{{ slice.metadata.label }}</span>
        </div>
        <div class="dvs-cursor-pointer dvs-ml-2 dvs-relative dvs-p-2 dvs-rounded-sm dvs-flex dvs-items-center" @mouseenter="moreHovered = true" @mouseleave="moreHovered = false" :style="{backgroundColor: this.theme.panelCard.backgroundColor}">
          <more-icon w="18" h="18" style="transform:rotate(90deg)" :style="{color: 'white'}" />
          <div class="dvs-overflow-hidden dvs-absolute dvs-z-10 dvs-pin-t dvs-pin-r dvs-rounded-sm dvs-mt-8" style="width:250px;transition:height 500ms" :style="moreContainerStyles">
            <div class="dvs-py-2 dvs-flex dvs-items-end dvs-flex-wrap ">
              
              <div class="dvs-w-1/3">              
                <div class="dvs-cursor-pointer dvs-ml-2 dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2" 
                    :style="{ borderColor: theme.panelIcons.color }" 
                    @click="jumpToSlice()">
                  <locate-icon w="25" h="25" :style="theme.panelIcons" /> 
                  <div 
                    class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">
                      Find
                  </div>
                </div>
              </div>

              <div class="dvs-w-1/3">              
                <div class="dvs-cursor-pointer dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2" 
                    :style="{ borderColor: theme.panelIcons.color }" 
                    @click="requestInsertSlice()">
                  <add-icon w="25" h="25" :style="theme.panelIcons" /> 
                  <div 
                    class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">
                      Insert Slice
                  </div>
                </div>
              </div>

              <div class="dvs-w-1/3">
                <div class="dvs-cursor-pointer dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2" 
                    :style="{ borderColor: theme.panelIcons.color }" 
                    @click="copySlice(slice, false)">
                  <copy-icon w="25" h="25" :style="theme.panelIcons" /> 
                  <div 
                    class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">
                      Duplicate
                  </div>
                </div>
              </div>

              <div class="dvs-w-1/3">
                <div class="dvs-cursor-pointer dvs-ml-2 dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2" 
                    :style="{ borderColor: theme.panelIcons.color }" 
                    @click="sliceSettings()">
                  <cog-icon w="25" h="25" :style="theme.panelIcons" /> 
                  <div 
                    class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">
                      Settings
                  </div>
                </div>
              </div>

              <div class="dvs-w-1/3">
                <div class="dvs-cursor-pointer dvs-mr-2  dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2" 
                    :style="{ borderColor: theme.panelIcons.color }" 
                    @click="requestEditSlice()">
                  <create-icon w="25" h="25" :style="theme.panelIcons" /> 
                  <div 
                    class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">
                      Edit
                  </div>
                </div>
              </div>

              <div class="dvs-w-1/3">
                <div class="dvs-cursor-pointer dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2" 
                    :style="{ borderColor: theme.panelIcons.color }" 
                    @click="removeSlice()">
                  <remove-icon w="25" h="25" :style="theme.panelIcons" /> 
                  <div 
                    class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">
                      Remove
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </strong>

    <manage-slice ref="manageslice" v-if="manageSlice === true" @cancel="manageSlice = false" @addSlice="addSlice" @editSlice="editSlice" @removeSlice="removeSlice" :slice="slice" />

    <div class="dvs-collapsed dvs-mb-4" v-show="sliceOpen">
      <fieldset 
        v-for="(field, key) in sliceConfig(slice).fields" 
        class="dvs-fieldset dvs-mb-1"
        :key="key"
        v-if="theFields[key]">

        <div>

          <color-editor v-model="theFields[key]" :options="field" :namekey="key" v-if="field.type === 'color'">
          </color-editor>

          <checkbox-editor v-model="theFields[key]" :options="field" :namekey="key" v-if="field.type === 'checkbox'">
          </checkbox-editor>

          <image-editor v-model="theFields[key]" :options="field" :namekey="key" v-if="field.type === 'image'">
          </image-editor>

          <link-editor v-model="theFields[key]" :options="field" :namekey="key" v-if="field.type === 'link'">
          </link-editor>

          <number-editor v-model="theFields[key]" :options="field" :namekey="key" v-if="field.type === 'number'">
          </number-editor>

          <select-editor v-model="theFields[key]" :options="field" :namekey="key" v-if="field.type === 'select'">
          </select-editor>

          <textarea-editor v-model="theFields[key]" :options="field" :namekey="key" v-if="field.type === 'textarea'">
          </textarea-editor>

          <text-editor v-model="theFields[key]" :options="field" :namekey="key" v-if="field.type === 'text'">
          </text-editor>

          <wysiwyg-editor v-model="theFields[key]" :options="field" :namekey="key" :show="slice.metadata.show" v-if="field.type === 'wysiwyg'">
          </wysiwyg-editor>
        </div>

      </fieldset>
    </div>

    <div class="dvs-collapsed">
      <help 
        v-if="slice.metadata.type === 'model'" 
        :style="theme.panel" 
        >
        Be aware that these entries are model entries. That means they are managed in your database by another tool or by an admin section in your adminitration.
      </help>
    </div>

    <div class="dvs-collapsed ml-4" v-show="sliceOpen">
      <draggable v-model="slice.slices" element="ul" class="dvs-list-reset" v-if="slice.metadata.type !== 'model'" :options="{group:{ name:'g1'}}">
        <template v-for="s in slice.slices">
          <slice-editor :key="s.metadata.instance_id" :slice="s" :child="true" @addSlice="addSlice" @editSlice="editSlice" @removeSlice="removeSlice" @copySlice="copySlice" />
        </template>
      </draggable>
    </div>

  </li>
</template>

<script>
import draggable from 'vuedraggable'

import { mapGetters } from 'vuex'

import CheckboxEditor from './../editor/Checkbox'
import ColorEditor from './../editor/Color'
import ImageEditor from './../editor/Image'
import LinkEditor from './../editor/Link'
import NumberEditor from './../editor/Number'
import SelectEditor from './../editor/Select'
import TextareaEditor from './../editor/Textarea'
import TextEditor from './../editor/Text'
import WysiwygEditor from './../editor/Wysiwyg'

import ManageSlice from './ManageSlice'

import AddIcon from 'vue-ionicons/dist/ios-add.vue'
import CogIcon from 'vue-ionicons/dist/ios-cog.vue'
import CopyIcon from 'vue-ionicons/dist/ios-copy.vue'
import LocateIcon from 'vue-ionicons/dist/md-locate.vue'
import MoreIcon from 'vue-ionicons/dist/ios-more.vue'
import MenuIcon from 'vue-ionicons/dist/ios-menu.vue'
import CreateIcon from 'vue-ionicons/dist/md-create.vue'
import RemoveIcon from 'vue-ionicons/dist/ios-trash.vue'

export default {
  name: 'SliceEditor',
  data () {
    return {
      manageSlice: false,
      pageSlices: [],
      moreHovered: false,
      sliceOpen: false
    }
  },
  mounted () {
    if (this.slice.slices) {
      this.pageSlices = this.slice.slices
    }
  },
  methods: {
    toggleSlice () {
      this.sliceOpen = !this.sliceOpen
    },
    toggleSliceTools() {
      this.slice.metadata.tools = !this.slice.metadata.tools
    },
    hydrateMissingProperties (data) {
      let fields = this.component(this.slice.metadata.name).fields

      if (fields) {
        // Loop through the fields for this slice and check to see that all the
        // fields are present. If they aren't it's just because they haven't been
        // hydrated via the editor yet.
        for (var prop in fields) {
          // Ok, so the property is missing from the slice.fields object so we're
          // going to add in a stub for the render.
          if (!data.hasOwnProperty(prop)) {
            this.addMissingProperty(data, prop)

            // If defaults are set then set them on top of the placeholder missing properties
            if (fields[prop].default) {
              this.setDefaults(data, prop, fields[prop].default)
            }
          }
        }
      }

      return data
    },
    addMissingProperty (data, property) {
      // We just add all the properties because.... why not?
      this.$set(data, property, {
        text: null,
        url: null,
        sizemedia: {},
        target: null,
        color: null,
        checked: null,
        enabled: false
      })
    },
    setDefaults (data, property, defaults) {
      // loop through the defaults and apply them to the field
      for (var d in defaults) {
        this.$set(data[property], d, defaults[d])
      }
    },

    // Marking Slice
    markSlice (on, slice) {
      window.devise.$bus.$emit('markSlice', this.slice, on)
    },
    jumpToSlice () {
      window.devise.$bus.$emit('jumpToSlice', this.slice)
    },
    sliceSettings () {
      window.devise.$bus.$emit('openSliceSettings', this.slice)
    },

    // Adding, Editing and Removing Slices
    requestInsertSlice () {
      this.manageSlice = true
      this.$nextTick(function () {
        this.$refs.manageslice.action = 'insert'
      })
    },
    addSlice (slice, referringSlice) {
      if (typeof referringSlice === 'undefined') {
        referringSlice = this.slice
      }

      console.log('here - addSlice 1', slice, referringSlice)
      this.$emit('addSlice', slice, referringSlice)
      this.manageSlice = false
    },
    requestEditSlice () {
      this.manageSlice = true
      this.$nextTick(function () {
        this.$refs.manageslice.action = 'edit'
      })
    },
    editSlice (slice, referringSlice) {
      if (typeof referringSlice === 'undefined') {
        referringSlice = this.slice
      }
      this.$emit('editSlice', slice, referringSlice)
      this.manageSlice = false
    },
    copySlice (slice, referringSlice) {      
      if (referringSlice === null) {
        referringSlice = this.slice
      }

      if (referringSlice === false) {
        referringSlice = null
      }

      this.$emit('copySlice', slice, referringSlice)
    },
    removeSlice (slice, referringSlice) {
      if (typeof slice === 'undefined') {
        slice = this.slice
      }
      else if (typeof referringSlice === 'undefined') {
        referringSlice = this.slice
      }
      this.$emit('removeSlice', slice, referringSlice)
      this.manageSlice = false
    }
  },
  computed: {
    ...mapGetters('devise', [
      'component',
      'fieldConfig',
      'sliceConfig'
    ]),
    theFields () {
      var fields = {}
      for (var potentialField in this.slice) {
        if (
          this.slice.hasOwnProperty(potentialField) &&
          potentialField !== 'slices' &&
          potentialField !== 'metadata' &&
          typeof this.slice[potentialField] === 'object'
        ) {
          fields[potentialField] = this.slice[potentialField]
          if (typeof fields[potentialField].enabled === 'undefined') {
            this.$set(fields[potentialField], 'enabled', true)
          }
        }
      }
      return fields
    },
    moreContainerStyles () {
      if (this.moreHovered) {
        return {
          height: '170px',
          backgroundColor: this.theme.panelCard.backgroundColor
        }
      }
      return {
        height: '0',
        backgroundColor: this.theme.panelCard.backgroundColor
      }
    }
  },
  props: {
    'slice': {}, 
    'child': {
      default: false
    }
  },
  components: {
    AddIcon,
    CheckboxEditor,
    CogIcon,
    CopyIcon,
    ColorEditor,
    CreateIcon,
    draggable,
    ImageEditor,
    LinkEditor,
    LocateIcon,
    ManageSlice,
    MenuIcon,
    MoreIcon,
    NumberEditor,
    RemoveIcon,
    SelectEditor,
    TextareaEditor,
    TextEditor,
    WysiwygEditor
  }
}
</script>
