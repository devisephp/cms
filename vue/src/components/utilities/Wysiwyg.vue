<template>
  <trix-editor :input="theId" @trix-change="update" ref="trixeditor"></trix-editor>
</template>

<script>
import trix from 'trix'
import Strings from './../../mixins/Strings'

export default {
  name: 'Wysiwyg',
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
        self.theEditor.insertHTML(self.localValue)
      })
    },
    update (event) {
      this.localValue = event.target.value
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    }
  },
  watch: {
    value (newValue, oldValue) {
      if (oldValue === null) {
        this.theEditor.insertHTML(newValue)
      }
    }
  },
  mixins: [Strings],
  props: ['id', 'value']
}

</script>
