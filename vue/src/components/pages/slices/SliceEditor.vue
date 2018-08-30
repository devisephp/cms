<template>
  <li class="dvs-mb-4 dvs-collapsable" :class="{'dvs-open': slice.metadata.open}">

    <strong class="dvs-block dvs-mb-4 dvs-switch-sm dvs-text-sm dvs-flex dvs-justify-between dvs-items-center dvs-w-full">
      <template v-if="slice.metadata.placeholder && slice.metadata.type === 'repeats'">
        <div class="dvs-flex dvs-items-center dvs-cursor-pointer dvs-capitalize hover:underline">
          <menu-icon w="18" h="18" class="dvs-mr-2 handle" :style="theme.panelIcons" /> 
          <span  @click="toggleSlice(slice)">{{ slice.metadata.label }}</span>
        </div>
        <div class="dvs-cursor-pointer" @click="manageSlice = true">
          <more-icon w="18" h="18" class="mt-1 mr-2" style="transform:rotate(90deg)" :style="theme.panelIcons" /> 
        </div>
        <div class="opacity-75" @click.stop="addInstance(slice)">
          Add New
        </div>
      </template>
      <template v-else>
        <div v-if="slice.metadata.type === 'single'" class="dvs-flex dvs-items-center dvs-justify-between dvs-w-full" :style="{color: theme.panel.color}" :class="{'dvs-pl-4': child}">
          <div class="dvs-flex dvs-items-center">
            <menu-icon w="18" h="18" class="dvs-mr-2 handle" :style="theme.panelIcons" /> 
            <span class="dvs-cursor-pointer" @click="toggleSlice(slice)">{{ slice.metadata.label }}</span>
          </div>
          <div class="dvs-cursor-pointer dvs-ml-2 dvs-relative" style="height:30px;width:30px;" @mouseenter="moreHovered = true" @mouseleave="moreHovered = false">
            <div class="dvs-overflow-hidden dvs-absolute dvs-pin-t dvs-pin-r dvs-flex dvs-flex-row-reverse dvs-pb-2 dvs-rounded-sm" style="transition:width 500ms;" :style="moreContainerStyles">
              <more-icon w="18" h="18" class="mt-1 mr-2" style="transform:rotate(90deg)" :style="{color: 'white'}" />
              <div class="dvs-cursor-pointer" @click="removeSlice()">
                <remove-icon w="20" h="20" class="mt-1 mr-4" :style="theme.panelIcons" />
              </div>
              <div class="dvs-cursor-pointer" @click="requestEditSlice()">
                <create-icon w="20" h="20" class="mt-1 mr-2" :style="theme.panelIcons" />
              </div>
              <div class="dvs-cursor-pointer" @click="requestInsertSlice()">
                <add-icon w="20" h="20" class="mt-1 mr-2" :style="theme.panelIcons" />
              </div>
            </div>
          </div>
        </div>
        <div v-else class="dvs-flex dvs-items-center dvs-w-full dvs-pl-4 dvs-justify-between">
          <div @click="toggleSlice(slice)">Instance</div>
          <div class="dvs-pl-4" @click.stop="requestRemoveInstance(slice)">
            Remove
          </div>
        </div>
      </template>
    </strong>

    <manage-slice ref="manageslice" v-if="manageSlice === true" @cancel="manageSlice = false" @addSlice="addSlice" @editSlice="editSlice" @removeSlice="removeSlice" :slice="slice" />

    <div class="dvs-collapsed" v-if="slice.metadata.open && slice.metadata.type === 'repeats'">
      <fieldset v-for="(field, key) in sliceConfig(slice).fields" class="dvs-fieldset dvs-mb-4 dvs-ml-4" :key="key" v-if="theFields[key]">
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
        class="dvs-mb-4"
        :style="`
          border-color:${theme.buttonsActionLeft.color};
          background:${theme.buttonsActionRight.color};
          color:${theme.buttonsActionText.color};
        `" 
        >
        Be aware that these entries are model entries. That means they are managed in your database by another tool or by an admin section in your adminitration.
      </help>

      <ul class="dvs-list-reset" v-if="slice.metadata.type !== 'model'" >
        <template v-for="(s, key) in slice.slices">
          <slice-editor :key="key" :slice="s" :child="true" @addSlice="addSlice" @editSlice="editSlice" @removeSlice="removeSlice" @removeInstance="removeInstance" />
        </template>
      </ul>
    </div>

  </li>
</template>

<script>
import { mapGetters } from 'vuex'

import CheckboxEditor from './../editor/Checkbox'
import ColorEditor from './../editor/Color'
import ImageEditor from './../editor/Image'
import LinkEditor from './../editor/Link'
import NumberEditor from './../editor/Number'
import TextareaEditor from './../editor/Textarea'
import TextEditor from './../editor/Text'
import WysiwygEditor from './../editor/Wysiwyg'

import ManageSlice from './ManageSlice'

import AddIcon from 'vue-ionicons/dist/ios-add.vue'
import MoreIcon from 'vue-ionicons/dist/ios-more.vue'
import MenuIcon from 'vue-ionicons/dist/ios-menu.vue'
import CreateIcon from 'vue-ionicons/dist/md-create.vue'
import RemoveIcon from 'vue-ionicons/dist/ios-remove.vue'

export default {
  name: 'SliceEditor',
  data () {
    return {
      manageSlice: false,
      pageSlices: [],
      moreHovered: false
    }
  },
  mounted () {
    if (this.slice.slices) {
      this.pageSlices = this.slice.slices
    }
  },
  methods: {
    toggleSlice (slice) {
      if (this.sliceConfig(slice).fields || slice.slices.length > 0) {
        let sliceOpen = Object.assign({}, slice.metadata)
        this.pageSlices.map(s => this.closeSlice(s))
        this.$set(slice.metadata, 'open', !sliceOpen.open)
      }
    },
    closeSlice (slice) {
      this.$set(slice.metadata, 'open', false)
    },
    toggleSliceTools() {
      this.slice.metadata.tools = !this.slice.metadata.tools
    },
    addInstance () {
      this.$set(this.slice.metadata, 'open', true)

      // Setup the slice data
      var data = {
        metadata: Object.assign({}, this.slice.metadata)
      }
      data.metadata.placeholder = false
      data.metadata.instance_id = 0

      // Set the slices prop if it isn't there
      if (!this.slice.slices) {
        this.$set(this.slice, 'slices', [])
      }

      // Hydrate missing properties which also sets the defaults
      this.hydrateMissingProperties(data)

      // Push the slice into the slices array
      this.slice.slices.push(data)
    },
    requestRemoveInstance (slice) {
      this.$emit('removeInstance', slice)
    },
    removeInstance(slice) {
      this.slice.slices.splice(this.slice.slices.indexOf(slice), 1)
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
          backgroundColor: this.theme.panelCard.backgroundColor,
          width: '130px'
        }
      }
      return {
        backgroundColor: this.theme.panelCard.backgroundColor,
        width: '30px'
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
    ColorEditor,
    CreateIcon,
    ImageEditor,
    LinkEditor,
    ManageSlice,
    MenuIcon,
    MoreIcon,
    NumberEditor,
    RemoveIcon,
    TextareaEditor,
    TextEditor,
    WysiwygEditor
  }
}
</script>
