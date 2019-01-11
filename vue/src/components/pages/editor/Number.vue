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
        <input
          ref="focusInput"
          type="number"
          v-model="localValue.text"
          :maxlength="getMaxLength"
          v-on:input="updateValue()"
        >
      </fieldset>
    </template>
  </field-editor>
</template>

<script>
export default {
  name: 'NumberEditor',
  data() {
    return {
      localValue: {},
      showEditor: false
    };
  },
  mounted() {
    this.localValue = this.value;
  },
  methods: {
    toggleEditor() {
      this.originalValue = Object.assign({}, this.value);
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
      this.localValue.enabled = false;
      this.localValue.text = null;
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
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field')
  }
};
</script>
