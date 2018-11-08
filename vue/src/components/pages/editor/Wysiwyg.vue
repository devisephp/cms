<template>
  <div>
    <field-editor :options="options" v-model="localValue" :showEditor="showEditor" @toggleShowEditor="toggleEditor" @cancel="cancel">
      <template slot="preview">
        <span v-if="localValue.text === null || localValue.text === ''" class="dvs-italic">
          Currently No Value
        </span>
        <div v-html="clipString(localValue.text, 200, false)"></div>
      </template>
      <template slot="editor">
        <wysiwyg ref="editor" v-model="localValue.text"></wysiwyg>
      </template>
    </field-editor>
  </div>
</template>

<script>
import Strings from './../../../mixins/Strings'
import Toggle from './../../utilities/Toggle'
import Wysiwyg from './../../utilities/Wysiwyg'
import FieldEditor from './Field'

export default {
  name: 'WysiwygEditor',
  data () {
    return {
      localValue: {},
      originalValue: null,
      showEditor: false
    }
  },
  mounted () {
    this.originalValue = Object.assign({}, this.value)
    this.localValue = this.value
  },
  methods: {
    toggleEditor () {
      this.showEditor = !this.showEditor
    },
    cancel () {
      this.localValue.text = this.originalValue.text
      this.$emit('input', this.originalValue)
      this.$emit('change', this.originalValue)

      this.toggleEditor()
    },
    update (event) {
      this.localValue.text = event.target.value
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    }
  },
  props: ['value', 'options', 'namekey'],
  mixins: [Strings],
  components: {
    Toggle,
    FieldEditor,
    Wysiwyg
  }
}
</script>
