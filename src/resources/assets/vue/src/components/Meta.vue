<style lang="scss" scoped>
  @import "./../sass/app.scss";
</style>

<template>
  <div class="text-ptext min-h-screen">
    <div class="bg-lighter p-8 m-8 rounded flex items-start flex-col">
      <div class="flex justify-between items-center">
        <div class="text-center font-xl font-mono p-4 rounded bg-lighter text-white font-bold flex-grow mr-8">
          &lt;meta {{ newMeta.property }}="{{newMeta.key}}" content="{{ newMeta.value }}"&gt;
        </div>
        <button class="btn btn-action mt-4" @click="requestCreate()">Create New Meta</button>
      </div>
      <div class="flex justify-stretch pt-4 w-full">
        <fieldset class="mt-0 mr-4 flex-grow">
          <label>Property</label>
          <input type="text" v-model="newMeta.property" placeholder="Property">
        </fieldset>
        <fieldset class="mt-0 mr-4 flex-grow">
          <label>Key</label>
          <input type="text" v-model="newMeta.key" placeholder="Key">
        </fieldset>
        <fieldset class="mt-0 flex-grow">
          <label>Value</label>
          <input type="text" v-model="newMeta.value" placeholder="Value">
        </fieldset>
      </div>
    </div>
    <ul class="list-reset px-8">
      <li v-for="m in meta" class="p-8 my-8 border-b border-border">
        <div class="flex justify-between items-center">
          <div class="text-center font-xl font-mono p-4 rounded bg-lighter text-white font-bold flex-grow mr-8">
            &lt;meta {{ m.property }}="{{m.key}}" content="{{ m.value }}"&gt;
          </div>
          <button class="btn btn-action btn-sm" @click="requestUpdate(m)">update</button>
          <button class="btn btn-sm" @click="requestRemove(m)">Remove</button>
        </div>
        <div class=" flex justify-between pt-4">
          <fieldset class="mt-0">
            <label>Property</label>
            <input type="text" v-model="m.property" placeholder="Property">
          </fieldset>
          <fieldset class="mt-0 flex-">
            <label>Key</label>
            <input type="text" v-model="m.key" placeholder="Key">
          </fieldset>
          <fieldset class="mt-0">
            <label>Value</label>
            <input type="text" v-model="m.value" placeholder="Value">
          </fieldset>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
  import eventbus from './../event-bus/event-bus'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    data () {
      return {
        pageId: null,
        newMeta: {
          property: '',
          value: '',
          key: ''
        }
      }
    },
    mounted () {
      if (this.isGlobal) {
        this.getGlobalMeta()
      } else {
        this.getPageMeta(window.pageId)
      }
    },
    methods: {
      ...mapActions([
        'getGlobalMeta',
        'getPageMeta',
        'createMeta',
        'updateMeta',
        'deleteMeta'
      ]),
      requestCreate () {
        let self = this

        this.createMeta({meta: this.newMeta, pageId: this.pageId}).then(function () {
          self.newMeta.property = ''
          self.newMeta.value = ''
          self.newMeta.key = ''

          eventbus.$emit('showMessage', {title: 'Meta Created', message: 'Your meta record has been successfully created.'})
        })
      },
      requestUpdate (m) {
        this.updateMeta({meta: m, pageId: this.pageId}).then(function () {
          eventbus.$emit('showMessage', {title: 'Meta Updated', message: 'Your meta record has been successfully updated.'})
        })
      },
      requestRemove (meta) {
        if (window.confirm('Are you sure you wish to remove this meta tag??')) {
          this.deleteMeta(meta).then(function () {
            eventbus.$emit('showMessage', {title: 'Meta Deleted', message: 'Your meta record has been successfully deleted.'})
          })
        }
      }
    },
    computed: {
      ...mapGetters([
        'meta'
      ]),
      isGlobal () {
        return typeof window.pageId === 'undefined'
      }
    }
  }
</script>
