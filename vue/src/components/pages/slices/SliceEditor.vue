<template>
  <li class="dvs-mb-4 dvs-collapsable" :class="{'dvs-open': sliceOpen}">
    <strong
      class="dvs-block dvs-mb-4 dvs-switch-sm dvs-text-sm dvs-flex dvs-justify-between dvs-items-center dvs-w-full"
    >
      <div
        class="dvs-flex dvs-items-center dvs-justify-between dvs-w-full"
        :style="{color: theme.panel.color}"
      >
        <div class="dvs-flex dvs-items-start">
          <menu-icon w="18" h="18" class="dvs-mr-2 handle" :style="theme.panelIcons"/>
          <span
            :class="{'dvs-cursor-pointer': sliceHasFieldsOrSlices, 'dvs-opacity-75': !sliceHasFieldsOrSlices}"
            @click="toggleSlice()"
            @mouseenter="markSlice(true, slice)"
            @mouseleave="markSlice(false, slice)"
            v-html="editorLabel"
          ></span>
        </div>
        <div
          class="dvs-ml-2 dvs-relative dvs-p-2 dvs-rounded-sm dvs-flex dvs-items-center"
          @mouseenter="moreHovered = true"
          @mouseleave="moreHovered = false"
          :style="{backgroundColor: this.theme.panelCard.background}"
        >
          <more-icon
            w="18"
            h="18"
            style="transform:rotate(90deg); height:18px;"
            :style="{color: 'white'}"
          />

          <div
            class="dvs-overflow-hidden dvs-absolute dvs-z-10 dvs-pin-t dvs-pin-r dvs-rounded-sm"
            style="width:175px;"
            :style="{backgroundColor: this.theme.panelCard.background}"
            v-if="moreHovered"
          >
            <div class="dvs-pt-2 dvs-flex dvs-items-end dvs-flex-wrap">
              <div class="dvs-w-1/2">
                <div
                  class="dvs-mr-2 dvs-ml-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2"
                  :class="{'dvs-cursor-pointer': hasChildSlot, 'dvs-cursor-not-allowed dvs-opacity-50': !hasChildSlot}"
                  :style="{ borderColor: theme.panelIcons.color }"
                  @click="requestInsertSlice()"
                >
                  <add-icon w="25" h="25" :style="theme.panelIcons"/>
                  <div class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">Insert Slice</div>
                </div>
              </div>

              <div class="dvs-w-1/2">
                <div
                  class="dvs-cursor-pointer dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2"
                  :style="{ borderColor: theme.panelIcons.color }"
                  @click="jumpToSlice()"
                >
                  <locate-icon w="25" h="25" :style="theme.panelIcons"/>
                  <div class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">Find</div>
                </div>
              </div>

              <div class="dvs-w-1/2">
                <div
                  class="dvs-cursor-pointer dvs-ml-2 dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2"
                  :style="{ borderColor: theme.panelIcons.color }"
                  @click="copySlice(slice, false)"
                >
                  <copy-icon w="25" h="25" :style="theme.panelIcons"/>
                  <div class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">Duplicate</div>
                </div>
              </div>

              <div class="dvs-w-1/2">
                <div
                  class="dvs-cursor-pointer dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2"
                  :style="{ borderColor: theme.panelIcons.color }"
                  @click="sliceSettings()"
                >
                  <cog-icon w="25" h="25" :style="theme.panelIcons"/>
                  <div class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">Settings</div>
                </div>
              </div>

              <div class="dvs-w-1/2">
                <div
                  class="dvs-cursor-pointer dvs-ml-2 dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2"
                  :style="{ borderColor: theme.panelIcons.color }"
                  @click="requestEditSlice()"
                >
                  <create-icon w="25" h="25" :style="theme.panelIcons"/>
                  <div class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">Edit</div>
                </div>
              </div>

              <div class="dvs-w-1/2">
                <div
                  class="dvs-cursor-pointer dvs-mr-2 dvs-items-center dvs-flex dvs-flex-col dvs-mb-2 dvs-border dvs-rounded-sm dvs-p-2"
                  :style="{ borderColor: theme.panelIcons.color }"
                  @click="removeSlice()"
                >
                  <remove-icon w="25" h="25" :style="theme.panelIcons"/>
                  <div class="dvs-text-xs dvs-text-center dvs-leading-none dvs-pt-2">Remove</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </strong>

    <manage-slice
      ref="manageslice"
      v-if="manageSlice === true"
      @cancel="manageSlice = false"
      @addSlice="addSlice"
      @editSlice="editSlice"
      @removeSlice="removeSlice"
      :slice="slice"
    />

    <div class="dvs-collapsed dvs-mb-4" v-if="sliceOpen">
      <fieldset
        v-for="(field, key) in sliceConfig(slice).fields"
        class="dvs-fieldset dvs-mb-1"
        :key="key"
      >
        <div v-if="theFields[key]">
          <color-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'color'"
          ></color-editor>

          <checkbox-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'checkbox'"
          ></checkbox-editor>

          <datetime-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'datetime'"
          ></datetime-editor>

          <image-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'image'"
          ></image-editor>

          <file-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'file'"
          ></file-editor>

          <link-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'link'"
          ></link-editor>

          <number-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'number'"
          ></number-editor>

          <select-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'select'"
          ></select-editor>

          <textarea-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'textarea'"
          ></textarea-editor>

          <text-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            v-if="field.type === 'text'"
          ></text-editor>

          <wysiwyg-editor
            v-model="theFields[key]"
            :options="field"
            :namekey="key"
            :show="slice.metadata.show"
            v-if="field.type === 'wysiwyg'"
          ></wysiwyg-editor>
        </div>
      </fieldset>
    </div>

    <div class="dvs-collapsed">
      <help
        v-if="slice.metadata.type === 'model'"
        :style="theme.panel"
      >Be aware that these entries are model entries. That means they are managed in your database by another tool or by an admin section in your adminitration.</help>
    </div>

    <div class="dvs-collapsed dvs-ml-4" v-if="sliceOpen">
      <draggable
        v-model="slice.slices"
        element="ul"
        class="dvs-list-reset"
        v-if="slice.metadata.type !== 'model'"
        :options="{group:{ name:'g1'}}"
      >
        <template v-for="s in slice.slices">
          <slice-editor
            :key="s.metadata.instance_id"
            :devise="s"
            :child="true"
            @addSlice="addSlice"
            @editSlice="editSlice"
            @removeSlice="removeSlice"
            @copySlice="copySlice"
          />
        </template>
      </draggable>
    </div>
  </li>
</template>

<script>
import { mapGetters, mapState } from 'vuex';

export default {
  name: 'SliceEditor',
  data() {
    return {
      manageSlice: false,
      pageSlices: [],
      moreHovered: false,
      sliceOpen: false
    };
  },
  mounted() {
    if (this.slice.slices) {
      this.pageSlices = this.slice.slices;
    }
  },
  methods: {
    toggleSlice() {
      this.sliceOpen = !this.sliceOpen;
    },
    toggleSliceTools() {
      this.slice.metadata.tools = !this.slice.metadata.tools;
    },
    // Marking Slice
    markSlice(on, slice) {
      window.devise.$bus.$emit('markSlice', this.slice, on);
    },
    jumpToSlice() {
      window.devise.$bus.$emit('jumpToSlice', this.slice);
    },
    sliceSettings() {
      window.devise.$bus.$emit('openSliceSettings', this.slice);
    },

    // Adding, Editing and Removing Slices
    requestInsertSlice() {
      if (this.slice.metadata.has_child_slot) {
        this.manageSlice = true;
        this.$nextTick(function() {
          if (this.$refs.manageSlice) {
            this.$refs.manageslice.action = 'insert';
          }
        });
      }
    },
    addSlice(slice, referringSlice) {
      if (typeof referringSlice === 'undefined') {
        referringSlice = this.slice;
      }
      this.$emit('addSlice', slice, referringSlice);
      this.manageSlice = false;
    },
    requestEditSlice() {
      this.manageSlice = true;
      this.$nextTick(function() {
        if (this.$refs.manageSlice) {
          this.$refs.manageslice.action = 'edit';
        }
      });
    },
    editSlice(slice, referringSlice) {
      if (typeof referringSlice === 'undefined') {
        referringSlice = this.slice;
      }
      this.$emit('editSlice', slice, referringSlice);
      this.manageSlice = false;
    },
    copySlice(slice, referringSlice) {
      if (referringSlice === null) {
        referringSlice = this.slice;
      }

      if (referringSlice === false) {
        referringSlice = null;
      }

      this.$emit('copySlice', slice, referringSlice);
    },
    removeSlice(slice, referringSlice) {
      if (typeof slice === 'undefined') {
        slice = this.slice;
      } else if (typeof referringSlice === 'undefined') {
        referringSlice = this.slice;
      }
      this.$emit('removeSlice', slice, referringSlice);
      this.manageSlice = false;
    }
  },
  computed: {
    ...mapGetters('devise', ['component', 'fieldConfig', 'sliceConfig']),
    ...mapState('devise', ['devMode']),
    slice() {
      return this.devise;
    },
    theFields() {
      var fields = {};
      for (var potentialField in this.slice) {
        if (
          this.slice.hasOwnProperty(potentialField) &&
          potentialField !== 'slices' &&
          potentialField !== 'metadata' &&
          potentialField !== 'settings' &&
          typeof this.slice[potentialField] === 'object'
        ) {
          fields[potentialField] = this.slice[potentialField];
          if (typeof fields[potentialField].enabled === 'undefined') {
            this.$set(fields[potentialField], 'enabled', true);
          }
        }
      }
      return fields;
    },
    sliceHasFieldsOrSlices() {
      let count = Object.keys(this.theFields).length;
      if (this.slice.slices) {
        count += this.slice.slices.length;
      }

      return count > 0;
    },
    hasChildSlot() {
      let component = this.component(this.slice.metadata.name);

      if (component.has_child_slot) {
        return true;
      }

      return false;
    },
    editorLabel() {
      let acceptedFieldTypes = {
        text: 'text',
        number: 'text',
        datetime: 'text',
        image: 'url',
        link: 'text',
        select: 'value'
      };

      let devMode = '';
      if (this.devMode) {
        devMode = `<div class="dvs-text-sm dvs-uppercase dvs-opacity-75">Instance Id: ${
          this.slice.metadata.instance_id
        }</div>`;
      }

      for (const field in this.theFields) {
        if (this.theFields.hasOwnProperty(field)) {
          const f = this.theFields[field];

          if (f.editorLabel && f[acceptedFieldTypes[f.type]]) {
            let label = f[acceptedFieldTypes[f.type]];

            if (f.type === 'image') {
              label = `<div class="dvs-rounded dvs-bg-cover" style="background-image: url('${label}'); height:100px; width:200px;"></div>`;
            } else {
              label = `${label.toLowerCase()}`;
            }

            if (label) {
              return `${devMode}<div class="dvs-capitalize">${label}</div><div class="dvs-text-xs dvs-opacity-25 dvs-uppercase">${
                this.slice.metadata.label
              }</div>`;
            }
          }
        }
      }
      return `${devMode}<div class="dvs-capitalize">${
        this.slice.metadata.label
      }</div><div class="dvs-text-xs dvs-opacity-25 dvs-uppercase">&nbsp;</div>`;
    }
  },
  props: {
    child: {
      default: false
    }
  },
  components: {
    AddIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-add.vue'),
    CheckboxEditor: () =>
      import(/* webpackChunkName: "js/devise-editors" */ './../editor/Checkbox'),
    CogIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-cog.vue'),
    CopyIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-copy.vue'),
    ColorEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../editor/Color'),
    DatetimeEditor: () =>
      import(/* webpackChunkName: "js/devise-editors" */ './../editor/Datetime'),
    CreateIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-create.vue'),
    draggable: () =>
      import(/* webpackChunkName: "js/devise-modules-unsure-where-to-put" */ 'vuedraggable'),
    FileEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../editor/File'),
    ImageEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../editor/Image'),
    LinkEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../editor/Link'),
    LocateIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-locate.vue'),
    ManageSlice: () => import(/* webpackChunkName: "js/devise-editors" */ './ManageSlice'),
    MenuIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-menu.vue'),
    MoreIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-more.vue'),
    NumberEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../editor/Number'),
    RemoveIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-trash.vue'),
    SelectEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../editor/Select'),
    SliceEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './SliceEditor'),
    TextareaEditor: () =>
      import(/* webpackChunkName: "js/devise-editors" */ './../editor/Textarea'),
    TextEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../editor/Text'),
    WysiwygEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './../editor/Wysiwyg')
  }
};
</script>
