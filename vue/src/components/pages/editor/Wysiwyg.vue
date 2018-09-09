<template>
  <field-editor :options="options" v-model="localValue" :showEditor="showEditor" @toggleShowEditor="toggleEditor" @cancel="cancel">
    <template slot="preview">
      <span v-if="localValue.text === null || localValue.text === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div v-html="clipString(localValue.text, 200, false)"></div>
    </template>
    <template slot="editor">
      <input type="hidden" :id="theId" v-model="localValue.text" :name="namekey" />
      <trix-editor :input="theId" @trix-change="update" @trix-initialize="editorInitialized" ref="trixeditor"></trix-editor>
    </template>
  </field-editor>
</template>

<script>
import 'trix'

import Strings from './../../../mixins/Strings'
import Toggle from './../../utilities/Toggle'
import FieldEditor from './Field'

export default {
  name: 'WysiwygEditor',
  data () {
    return {
      theId: '',
      theEditor: null,
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

      if (this.showEditor) {
        this.resolveId()
      }
    },
    cancel () {
      this.theEditor.loadHTML(this.originalValue.text)
      this.$emit('input', this.originalValue)
      this.$emit('change', this.originalValue)

      this.toggleEditor()
    },
    resolveId () {
      this.theId = this.id
      if (this.id === '') {
        this.theId = this.randomString(8)
      }
    },
    editorInitialized () {
      let self = this

      this.$nextTick(function () {
        self.resolveEditor()
        self.hydrate()
      })
    },
    resolveEditor () {
      this.theEditor = this.$refs.trixeditor.editor
    },
    hydrate () {
      this.theEditor.loadHTML(this.value.text)
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
    FieldEditor
  }
}
</script>
