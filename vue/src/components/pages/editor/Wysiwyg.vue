<template>
  <div>
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
        <div v-html="clipString(localValue.text, 200, false)"></div>
      </template>
      <template slot="editor">
        <div style="max-height:80vh" data-simplebar>
          <wysiwyg ref="editor" v-model="localValue.text"></wysiwyg>
        </div>
      </template>
    </field-editor>
  </div>
</template>

<script>
import Strings from './../../../mixins/Strings';

export default {
  name: 'WysiwygEditor',
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
      this.localValue.text = this.originalValue.text;
      this.$emit('input', this.originalValue);
      this.$emit('change', this.originalValue);

      this.toggleEditor();
    },
    update(event) {
      this.localValue.text = event.target.value;
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    resetValue() {
      this.localValue.enabled = false;
      this.$refs.editor.empty();
    }
  },
  props: ['value', 'options', 'namekey'],
  mixins: [Strings],
  components: {
    Toggle: () => import(/* webpackChunkName: "js/devise-utilities" */ './../../utilities/Toggle'),
    FieldEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './Field'),
    Wysiwyg: () => import(/* webpackChunkName: "js/devise-utilities" */ './../../utilities/Wysiwyg')
  }
};
</script>
