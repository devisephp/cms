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
      <div>{{localValue.text}}</div>
    </template>

    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <date-picker ref="datepicker" v-model="localValue.text" :settings="settings"/>
      </fieldset>
    </template>
  </field-editor>
</template>

<script>
import DatePicker from './../../utilities/DatePicker';

export default {
  name: 'DatetimeEditor',
  data() {
    return {
      showEditor: false,
      settings: { date: true, time: false },
      originalValue: {}
    };
  },
  mounted() {
    this.setSettings();
  },
  methods: {
    setSettings() {
      if (this.options && this.options.settings) {
        let settings = this.options.settings;
        if (settings.date) {
          this.settings.date = settings.date;
        }

        if (settings.time) {
          this.settings.time = settings.time;
        }

        if (settings.format) {
          this.settings.format = settings.format;
        }
      }
    },
    toggleEditor() {
      this.originalValue = Object.assign({}, this.value);
      this.showEditor = !this.showEditor;
    },
    cancel() {
      this.localValue.text = this.originalValue.text;
      this.toggleEditor();
    },
    resetValue() {
      this.localValue.enabled = false;
      this.$refs.datepicker.resetPicker();
      this.localValue = Object.assign(this.localValue, { text: null });
    }
  },
  computed: {
    localValue: {
      set: function(value) {
        console.log(value);
        this.$emit('input', value);
        this.$emit('change', value);
      },
      get: function() {
        return this.value;
      }
    },
    getMaxLength: function() {
      if (typeof this.settings !== 'undefined' && typeof this.settings.maxlength !== 'undefined') {
        return this.settings.maxlength;
      }
      return '';
    }
  },
  props: ['value', 'options'],
  components: {
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field'),
    DatePicker
  }
};
</script>
