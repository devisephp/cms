<template>
<div class="bg-white text-black">
  <trumbowyg ref="theEditor" v-model="localValue" :config="config" :svg-path="'devise/icons/icons.svg'" @tbw-change="update"></trumbowyg>
</div>
</template>

<script>
// Import this component
import Trumbowyg from 'vue-trumbowyg';
import Table from 'trumbowyg/dist/plugins/table/trumbowyg.table.min.js';

// Import editor css
import 'trumbowyg/dist/ui/icons.svg';
import 'trumbowyg/dist/ui/trumbowyg.css';
import 'trumbowyg/dist/plugins/table/ui/trumbowyg.table.css';
import Strings from './../../mixins/Strings'

export default {
  name: 'Wysiwyg',
  data () {
    return {
      theEditor: null,
      localValue: '',
      config: {
        btns: [
          ['viewHTML'],
          ['strong', 'em', 'del'],
          ['unorderedList', 'orderedList'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['deviseImage'],
          ['formatting'],
          ['removeformat'],
          ['table'],
          ['undo', 'redo']

        ],
        autogrow: true,
        btnsDef: {
          deviseImage: {
            fn: this.launchMediaManager,
            tag: 'whatisthis',
            title: 'Media Manager',
            text: 'Media Manager',
            isSupported: function () { return true; },
            key: 'M',
            param: '' ,
            forceCSS: false,
            ico: 'insert-image',
            hasIcon: true
          }
        }
      },
      plugins: {
        table: {
          rows: 8,
          columns: 8,
          styler: 'table'
        }
      }
    }
  },
  mounted () {
    this.localValue = this.value
    this.theEditor = this.$refs.theEditor
  },
  methods: {
    launchMediaManager (event) {
      devise.$bus.$emit('devise-launch-media-manager', {
        callback: this.mediaSelected
      })
    },
    mediaSelected (imagesAndSettings) {
      if (typeof imagesAndSettings === 'object') {
        let html = this.theEditor.el.trumbowyg('html')
        this.theEditor.el.trumbowyg('html', `${html}<img src="${imagesAndSettings.images.orig_optimized}" width="${imagesAndSettings.settings.w}" height="${imagesAndSettings.settings.h}">`)
        // this.theEditor.insertHTML()
      }
    },
    update (event) {
      this.localValue = this.theEditor.el.trumbowyg('html')
      this.$emit('input', this.localValue)
      this.$emit('change', this.localValue)
    }
  },
  components: {
    Trumbowyg
  },
  mixins: [Strings],
  props: ['id', 'value']
}

</script>
