<template>
  <field-editor
    :options="options"
    v-model="localValue"
    :showEditor="showEditor"
    @toggleShowEditor="toggleEditor"
    @cancel="cancel"
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
        <date-picker v-model="localValue.text" :settings="settings" @update="updateValue()"/>
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
      localValue: {},
      showEditor: false,
      settings: { date: true, time: false, format: 'YYYY' }
    };
  },
  mounted() {
    this.localValue = this.value;

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
        } else {
          if (this.settings.date) {
            this.format += 'dddd MMMM D YYYY';
          }

          if (this.settings.time) {
            this.format += 'h:mm a';
          }
        }
      }
    },
    toggleEditor() {
      this.originalValue = Object.assign({}, this.value);
      this.showEditor = !this.showEditor;
    },
    cancel() {
      this.localValue.text = this.originalValue.text;
      this.updateValue();
      this.toggleEditor();
    },
    updateValue: function() {
      // Emit the number value through the input event
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
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
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field'),
    DatePicker
  }
};
</script>
