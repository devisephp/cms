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
        v-if="localValue.value === null || localValue.value === ''"
        class="dvs-italic"
      >Currently No Value</span>
      <div>{{ label }} ({{localValue.value}})</div>
    </template>
    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <select ref="focusInput" v-model="localValue.value" v-on:change="updateValue()">
          <option :value="null">No Selection</option>
          <option v-for="(option, key) in options.options" :key="key" :value="key">{{ option }}</option>
        </select>
      </fieldset>
    </template>
  </field-editor>
</template>

<script>
import Strings from './../../../mixins/Strings';

export default {
  name: 'SelectEditor',
  data() {
    return {
      localValue: {
        label: null,
        value: null,
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
    cancel() {
      this.localValue.value = this.originalValue.value;
      this.localValue.label = this.originalValue.label;
      this.updateValue();
      this.toggleEditor();
    },
    updateValue: function() {
      this.localValue.label = this.getLabel(this.localValue.value);
      // Emit the number value through the input event
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    resetValue() {
      this.localValue.enabled = false;
      this.localValue.label = null;
      this.localValue.value = null;
      this.updateValue();
    },
    getLabel(value) {
      if (value !== null) {
        return this.options.options[value];
      }
      return 'Select';
    }
  },
  props: ['value', 'options'],
  mixins: [Strings],
  components: {
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field')
  }
};
</script>
