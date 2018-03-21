<template>

  <div class="dvs-flex dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Manage Global Meta</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-settings-index')">Back to Settings</a>
    </div>
    <div id="devise-admin-content">
      <h3 class="dvs-mb-8">Add Meta</h3>

      <help class="dvs-mb-8">Global Meta are the meta tags that will be attached to every page of this site. They can be overridden on a page level but this gives you to the opportunity to set the <span class="dvs-fonts-mono">&lt;meta&gt;</span> across <strong>all</strong> pages.</help>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>Attribute Name</label>
        <input type="text" v-model="newMeta.attribute_name" />
      </fieldset>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>Attribute Value</label>
        <input type="text" v-model="newMeta.attribute_value" />
      </fieldset>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>Content</label>
        <input type="text" v-model="newMeta.content" />
      </fieldset>

      <help class="dvs-mb-4" v-if="anyNewMetaPopulated">
        &lt;meta {{ newMeta.attribute_name }}="{{ newMeta.attribute_value }}" content="{{ newMeta.content }}"&gt;
      </help>

      <button class="dvs-btn dvs-mb-8" :disabled="isInvalid" @click="requestCreateMeta">Save New Meta</button>

      <h3 class="dvs-mb-8">Existing Global Meta</h3>

      <div class="dvs-mb-12 dvs-flex dvs-flex-col">
        <div v-for="(meta, key) in localValue.data" class="dvs-flex dvs-justify-between dvs-items-center dvs-mb-2">
          <div class="dvs-font-mono dvs-pr-8">
            <template v-if="!meta.edit">
              &lt;meta {{ meta.attribute_name }}="{{ meta.attribute_value }}" content="{{ meta.content }}"&gt;
            </template>
            <template v-else>
              <fieldset class="dvs-fieldset">
                <div class="dvs-flex dvs-items-center">
                  &lt;meta
                  <input v-show="meta.edit" type="text" class="dvs-ml-4" v-model="localValue.data[key].attribute_name" />="
                  <input v-show="meta.edit" type="text" v-model="localValue.data[key].attribute_value" />"
                  <span  class="dvs-ml-4"> content="</span>
                  <input v-show="meta.edit" type="text" v-model="localValue.data[key].content" />"&gt;
                </div>
              </fieldset>
            </template>
          </div>

          <div class="dvs-flex dvs-justify-between dvs-items-center">
            <button v-if="!meta.edit" class="dvs-btn dvs-btn-plain dvs-btn-xs dvs-ml-4" @click="meta.edit = !meta.edit">
              <i class="ion-edit" />
            </button>
            <button v-if="!meta.edit" class="dvs-btn dvs-btn-plain dvs-btn-xs dvs-ml-4" v-devise-alert-confirm="{callback: requestDeleteMeta, arguments:meta, message: 'Are you sure you want to delete this meta?'}">
              <i class="ion-trash-b" />
            </button>
            <button class="dvs-btn dvs-mr-2" v-if="meta.edit" @click="requestUpdateMeta(localValue.data[key])">Save</button>
            <button class="dvs-btn dvs-btn-plain" v-if="meta.edit" @click="meta.edit = false">Cancel</button>
          </div>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'MetaManage',
  data () {
    return {
      localValue: {
        data: []
      },
      modulesToLoad: 1,
      newMeta: {
        attribute_name: null,
        attribute_value: null,
        content: null
      }
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
    requestCreateMeta () {
      let self = this
      this.createMeta(this.newMeta).then(function () {
        self.newMeta.attribute_name = null
        self.newMeta.attribute_value = null
        self.newMeta.content = null
      })
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
        window.bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    }
  },
  computed: {
    ...mapGetters('devise', [
      'meta'
    ]),
    isInvalid () {
      return this.newMeta.attribute_name === null ||
             this.newMeta.attribute_value === null ||
             this.newMeta.content === null
    },
    anyNewMetaPopulated () {
      return this.newMeta.attribute_name !== null ||
             this.newMeta.attribute_value !== null ||
             this.newMeta.content !== null
    }
  }
}
</script>
