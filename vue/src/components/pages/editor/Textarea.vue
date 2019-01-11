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
      <div>{{ clipString(localValue.text, 300, true) }}</div>
    </template>

    <template slot="editor">
      <fieldset class="dvs-fieldset">
        <textarea
          ref="focusInput"
          type="text"
          v-model="localValue.text"
          :maxlength="getMaxLength"
          v-on:input="updateValue()"
        ></textarea>
      </fieldset>
    </template>
  </field-editor>
</template>

<script>
import Strings from './../../../mixins/Strings';

export default {
  name: 'TextAreaEditor',
  data() {
    return {
      localValue: {},
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
      this.localValue.text = this.originalValue.text;
      this.updateValue();
      this.toggleEditor();
    },
    updateValue: function() {
      // Emit the number value through the input event
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    resetValue() {
      this.localValue.text = null;
      this.localValue.enabled = false;
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
  mixins: [Strings],
  components: {
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field')
  }
};
</script>
