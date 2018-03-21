<template>
  <field-editor :options="options" v-model="localValue">
    <template slot="preview">
      <span v-if="localValue.text === null || localValue.text === ''" class="dvs-italic">
        Currently No Value
      </span>
      <div v-html="clipString(localValue.text, 200, true)"></div>
    </template>
    <template slot="editor">
      <input type="hidden" :id="theId" v-model="localValue.text" :name="namekey" />
      <trix-editor :input="theId" @trix-change="update" ref="trixeditor"></trix-editor>
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
      localValue: {}
    }
  },
  mounted () {
    this.localValue = this.value
    this.resolveId()
    this.resolveEditor()
    this.hydrate()
  },
  methods: {
    resolveId () {
      this.theId = this.id
      if (this.id === '') {
        this.theId = this.randomString(8)
      }
    },
    resolveEditor () {
      let self = this
      this.$nextTick(function () {
        self.theEditor = self.$refs.trixeditor.editor
      })
    },
    hydrate () {
      let self = this
      this.$nextTick(function () {
        self.theEditor.insertHTML(self.value.text)
      })
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
