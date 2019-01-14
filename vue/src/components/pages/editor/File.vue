<template>
  <field-editor
    :options="options"
    v-model="localValue"
    :showEditor="showEditor"
    @toggleShowEditor="toggleEditor"
    @cancel="cancel"
    @resetvalue="resetValue"
  >
    <template slot="preview">
      <span
        v-if="localValue.url === null || localValue.url === ''"
        class="dvs-italic"
      >Currently No Value</span>
      <img :src="localValue.url" class="dvs-max-w-2xs" :alt="localValue.url">
      <br>
    </template>

    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <div class="dvs-flex dvs-items-center">
          <input
            type="text"
            v-model="localValue.url"
            :maxlength="getMaxLength"
            v-on:input="updateValue()"
          >
          <div @click="launchMediaManager($event)">
            <document-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px"/>
          </div>
        </div>
      </fieldset>
    </template>
  </field-editor>
</template>

<script>
export default {
  name: 'FileEditor',
  data() {
    return {
      localValue: {
        url: '',
        alt: null,
        media: [],
        settings: {}
      },
      originalValue: null,
      showEditor: false
    };
  },
  mounted() {
    this.originalValue = Object.assign({}, this.value);
    this.localValue = this.value;
  },
  methods: {
    toggleEditor() {
      this.showEditor = !this.showEditor;
    },
    cancel() {
      this.localValue.url = this.originalValue.url;
      this.localValue.alt = this.originalValue.alt;
      this.updateValue();
      this.toggleEditor();
    },
    updateValue() {
      // Emit the number value through the input event
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    launchMediaManager(event) {
      devise.$bus.$emit('devise-launch-media-manager', {
        callback: this.mediaSelected,
        options: this.options
      });
    },
    mediaSelected(imagesAndSettings) {
      if (typeof imagesAndSettings === 'object') {
        this.localValue.url = imagesAndSettings.images.orig_optimized;
        this.localValue.media = imagesAndSettings.images;
        this.$set(this.localValue, 'settings', imagesAndSettings.settings);
      } else {
        this.localValue.url = imagesAndSettings;
      }

      this.updateValue();
    },
    resetValue() {
      this.localValue.enabled = false;
      this.localValue.url = '';
      this.updateValue();
    }
  },
  computed: {
    getMaxLength: function() {
      if (typeof this.settings !== 'undefined' && typeof this.settings.maxlength !== 'undefined') {
        return this.settings.maxlength;
      }
      return '';
    }
  },
  props: ['value', 'options'],
  components: {
    CreateIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-create.vue'),
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field'),
    DocumentIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-document.vue')
  }
};
</script>
