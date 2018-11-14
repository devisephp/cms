<template>

  <div>
    <div id="devise-admin-content">
      <h3 class="dvs-mb-8" :style="{color: theme.panel.color}">Add Global Meta</h3>

      <help class="dvs-mb-8">Global Meta are the meta tags that will be attached to every page of this site. They can be overridden on a page level but this gives you to the opportunity to set the <span class="dvs-fonts-mono">&lt;meta&gt;</span> across <strong>all</strong> pages.</help>

      <meta-form v-model="localValue.data" @request-create-meta="requestCreateMeta" @request-update-meta="requestUpdateMeta" @request-delete-meta="requestDeleteMeta" />
    </div>
  </div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex'

import MetaForm from './MetaForm'

export default {
  name: 'MetaManage',
  data () {
    return {
      localValue: {
        data: []
      },
      modulesToLoad: 1
    }
  },
  mounted () {
    this.retrieveAllMeta()
  },
  methods: {
    ...mapActions('devise', [
      'getMeta',
      'createMeta',
      'updateMeta',
      'deleteMeta'
    ]),
    requestCreateMeta (newMeta) {
      this.createMeta(newMeta)
    },
    requestUpdateMeta (meta) {
      this.updateMeta(meta).then(function () {
        meta.edit = false
      })
    },
    requestDeleteMeta (meta) {
      this.deleteMeta(meta)
    },
    retrieveAllMeta () {
      let self = this
      this.getMeta().then(function () {
        self.localValue = Object.assign({}, self.localValue, self.meta)
        self.localValue.data.map(meta => {
          self.$set(meta, 'edit', false)
        })
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    }
  },
  computed: {
    ...mapGetters('devise', [
      'meta'
    ])
  },
  components: {
    MetaForm
  }
}
</script>
