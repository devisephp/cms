<template>
  <div v-if="localValue.slices">
    <template v-if="template && localValue.slices.length > 0">
      <iframe :src="`/templates/${template.id}`" class="dvs-w-full" id="devise-preview-iframe"></iframe>
    </template>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

import Slice from './../../Slice'

export default {
  name: 'TemplateEdit',
  data () {
    return {
      localValue: {}
    }
  },
  mounted () {
    this.retrieveAllTemplates()
    this.getSlices()
    this.addListeners()
  },
  methods: {
    ...mapActions('devise', [
      'getTemplates',
      'getSlices'
    ]),
    retrieveAllTemplates () {
      let self = this
      this.getTemplates().then(function () {
        self.localValue = self.template
      })
    },
    addListeners () {
      let self = this
      window.addEventListener('message', function (event) {
        if (event.data.type === 'goBack') {
          self.goToPage('devise-templates-index')
        }
        if (event.data.type === 'error') {
          window.bus.$emit('showError', event.data.message)
        }
        if (event.data.type === 'saveSuccessful') {
          window.bus.$emit('showMessage', {title: 'Saving Template', message: 'Template successfully saved'})
        }
      }, false)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'slicesList',
      'template'
    ])
  },
  components: {
    Slice
  }
}
</script>
