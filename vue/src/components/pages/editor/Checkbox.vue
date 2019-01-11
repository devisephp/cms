<template>
  <field-editor
    :no-reset="true"
    :options="options"
    v-model="localValue"
    :showEditor="showEditor"
    @toggleShowEditor="toggleEditor"
    @cancel="cancel"
  >
    <template slot="preview">
      <span
        v-if="localValue.checked === null || localValue.checked === ''"
        class="dvs-italic"
      >Currently No Value</span>
      <div>{{ localValue.checked ? 'On' : 'Off' }}</div>
    </template>

    <template slot="editor">
      <div class="dvs-flex dvs-items-center">
        <toggle v-model="localValue.checked" :id="randomString(8)"></toggle>
      </div>
    </template>
  </field-editor>
</template>

<script>
import Strings from './../../../mixins/Strings';

export default {
  name: 'CheckboxEditor',
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
    },
    cancel() {
      this.localValue.checked = this.originalValue.checked;
      this.updateValue();
      this.toggleEditor();
    },
    updateValue: function() {
      // Emit the number value through the input event
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    }
  },
  props: ['value', 'options'],
  mixins: [Strings],
  components: {
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field'),
    Toggle: () => import(/* webpackChunkName: "js/devise-utilities" */ './../../utilities/Toggle')
  }
};
</script>
