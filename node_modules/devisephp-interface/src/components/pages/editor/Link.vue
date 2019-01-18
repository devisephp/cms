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
        v-if="localValue.text === null || localValue.text === ''"
        class="dvs-italic"
      >Currently No Value</span>
      <div>
        <a :href="localValue.href" :target="localValue.target">{{localValue.text}}</a>
      </div>
    </template>

    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <label>Label</label>
        <input
          ref="focusInput"
          type="text"
          class="dvs-mb-4"
          v-model="localValue.text"
          v-on:input="updateValue()"
        >
      </fieldset>

      <label>Link Mode</label>
      <div class="dvs-flex">
        <label>
          <input
            type="radio"
            class="dvs-w-auto dvs-mr-2"
            v-model="localValue.mode"
            value="url"
            v-on:input="updateValue()"
          >
          URL
        </label>
      </div>
      <div class="dvs-flex dvs-mb-4">
        <label>
          <input
            type="radio"
            class="dvs-w-auto dvs-mr-2"
            v-model="localValue.mode"
            value="page"
            v-on:input="updateValue()"
          >
          Page
        </label>
      </div>

      <template v-if="localValue.mode === 'url'">
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>URL</label>
          <input type="text" v-model="localValue.url" v-on:input="updateUrl()">
        </fieldset>
      </template>
      <template v-if="localValue.mode === 'page'">
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Page</label>
          <select v-model="localValue.routeName" @change="selectPage()">
            <option :value="0">Select a Page</option>
            <option
              :value="page.route_name"
              v-for="page in pagesList.data"
              :key="page.id"
            >{{page.title}}</option>
          </select>
        </fieldset>
      </template>

      <fieldset class="dvs-fieldset">
        <label>Target</label>
        <select v-model="localValue.target" @change="updateValue()">
          <option value="_self">Same Window</option>
          <option value="_blank">New Tab / Window</option>
          <option value="_parent">Parent</option>
          <option value="_top">Top</option>
        </select>
      </fieldset>
    </template>
  </field-editor>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'LinkEditor',
  data() {
    return {
      localValue: {
        href: '',
        url: '',
        text: '',
        routeName: '',
        target: '_self'
      },
      showEditor: false
    };
  },
  mounted() {
    this.originalValue = Object.assign({}, this.value);
    this.localValue = this.value;
    if (!this.localValue.target) {
      this.localValue.target = '_self';
    }

    this.retrieveAllPagesList();
  },
  methods: {
    ...mapActions('devise', ['getPagesList']),
    toggleEditor() {
      this.showEditor = !this.showEditor;
      this.focusForm();
    },
    focusForm() {
      if (this.showEditor) {
        this.$nextTick(() => {
          setTimeout(() => {
            this.$refs.focusInput.focus();
          }, 200);
        });
      }
    },
    retrieveAllPagesList(loadbar = true) {
      let filters = { language_id: deviseSettings.$page.language.id };
      this.getPagesList(filters).then(function() {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
        }
      });
    },
    cancel() {
      this.localValue.mode = this.originalValue.mode;
      this.localValue.text = this.originalValue.text;
      this.localValue.href = this.originalValue.href;
      this.localValue.routeName = this.originalValue.routeName;
      this.updateValue();
      this.toggleEditor();
    },
    updateUrl() {
      this.localValue.href = this.localValue.url;
      this.updateValue();
    },
    selectPage(e) {
      let page = this.pagesList.data.find(page => {
        return page.route_name === this.localValue.routeName;
      });

      this.localValue.href = page.url;
      this.updateValue();
    },
    updateValue: function() {
      // Emit the number value through the input event
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    resetValue() {
      this.localValue.enabled = false;
      this.localValue.href = null;
      this.localValue.url = null;
      this.localValue.mode = null;
      this.localValue.text = null;
      this.localValue.routeName = null;
      this.updateValue();
    }
  },
  computed: {
    ...mapGetters('devise', ['pagesList'])
  },
  props: ['value', 'options'],
  components: {
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field')
  }
};
</script>
