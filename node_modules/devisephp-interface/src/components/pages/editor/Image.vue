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
      <label class="dvs-mb-2 dvs-block">Image Tool To Use:</label>
      <div class="dvs-flex dvs-mb-2">
        <label>
          <input
            type="radio"
            class="dvs-w-auto dvs-mr-2"
            v-model="localValue.mode"
            value="media"
            v-on:input="updateValue()"
          >
          Media Manager
        </label>
      </div>
      <div class="dvs-flex dvs-mb-8">
        <label>
          <input
            type="radio"
            class="dvs-w-auto dvs-mr-2"
            v-model="localValue.mode"
            value="manual"
            v-on:input="updateValue()"
          >
          Manual URL
        </label>
      </div>
      <fieldset class="dvs-fieldset" v-if="localValue.mode === 'manual'">
        <label>URL</label>
        <div class="dvs-flex dvs-items-center">
          <input type="text" v-model="manualInput" v-on:input="updateValue()">
        </div>
      </fieldset>
      <fieldset class="dvs-fieldset" v-else>
        <div @click="launchMediaManager($event)" class="dvs-mb-8">
          <button class="dvs-btn" :style="theme.actionButton">Select New Media</button>
        </div>
        <div class="dvs-flex dvs-items-center">
          <div v-if="hasMedia">
            <div class="dvs-mb-4 uppercase font-bold text-sm">Media sizes</div>

            <div class="dvs-flex dvs-flex-wrap">
              <div
                v-for="(media, size) in localValue.media"
                :key="size"
                class="dvs-uppercase dvs-text-center dvs-mr-4 dvs-p-4"
                :style="theme.panelCard"
              >
                <img :src="media" class="mb-2" style="width:100px; height:auto">
                <div class="dvs-text-xs">{{ size }} {{ getDimensions(size) }}</div>
              </div>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset class="dvs-fieldset">
        <label class="dvs-mt-4">Alt Tag</label>
        <input type="text" v-model="localValue.alt" v-on:input="updateValue()">
      </fieldset>
    </template>
  </field-editor>
</template>

<script>
export default {
  name: 'ImageEditor',
  data() {
    return {
      localValue: {
        mode: 'media',
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
      if (this.localValue.mode !== 'manual') {
        this.$set(this.localValue, 'mode', 'media');
      }
      this.showEditor = !this.showEditor;
    },
    cancel() {
      this.localValue.url = this.originalValue.url;
      this.localValue.alt = this.originalValue.alt;
      this.toggleEditor();
    },
    updateValue() {
      // Emit the number value through the input event
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    resetValue() {
      this.localValue.enabled = false;
      this.localValue.url = '';
      this.localValue.alt = null;
      this.localValue.media = [];
      this.localValue.settings = {};
      this.localValue.enabled = false;
      this.updateValue();
    },
    launchMediaManager(event) {
      this.options.type = 'image';
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
    },
    getDimensions(size) {
      if (this.localValue.sizes && this.localValue.sizes[size])
        return `(${this.localValue.sizes[size].w} x ${this.localValue.sizes[size].h})`;
    }
  },
  computed: {
    getMaxLength: function() {
      if (typeof this.settings !== 'undefined' && typeof this.settings.maxlength !== 'undefined') {
        return this.settings.maxlength;
      }
      return '';
    },
    manualInput: {
      get() {
        return this.localValue.url;
      },
      set(newValue) {
        delete this.localValue.media;
        delete this.localValue.sizes;
        this.localValue.url = newValue;
        this.localValue.href = newValue;
      }
    },
    hasMedia() {
      return Object.keys(this.localValue.media).length > 0;
    }
  },
  props: ['value', 'options'],
  components: {
    CreateIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-create.vue'),
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field'),
    ImagesIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-images.vue')
  }
};
</script>
