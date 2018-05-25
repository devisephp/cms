<template>
  <div v-if="dataLoaded">
    <template v-if="template">
      <iframe :src="`/templates/${template.id}`" class="dvs-w-full dvs-relative dvs-z-30" id="devise-preview-iframe"></iframe>
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
      dataLoaded: false,
      localValue: {}
    }
  },
  mounted () {
    let self = this
    this.retrieveAllTemplates()
    this.getSlices().then(function () {
      self.dataLoaded = true
    })
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
          deviseSettings.$bus.$emit('showError', event.data.message)
        }
        if (event.data.type === 'saveSuccessful') {
          deviseSettings.$bus.$emit('showMessage', {title: 'Saving Template', message: 'Template successfully saved'})
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
