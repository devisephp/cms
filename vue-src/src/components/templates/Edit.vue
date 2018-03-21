<template>
  <div>
    <template v-if="template && slices.data.length > 0">
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
    this.$nextTick(function () {
      window.bus.$emit('devise-wide-admin')
    })
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
        if (event.data === 'goBack') {
          self.goToPage('devise-templates-index')
        }
      }, false)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'slices',
      'template'
    ])
  },
  components: {
    Slice
  }
}
</script>
