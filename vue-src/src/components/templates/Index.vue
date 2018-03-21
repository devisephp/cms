<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Templates</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-index')">Back to Administration</a>
      <ul class="dvs-list-reset">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg dvs-cursor-pointer" @click.prevent="showCreate = true">
          Create New Template
        </li>
      </ul>
    </div>
    <div id="devise-admin-content">
      <h2 class="dvs-mb-10">Current Templates</h2>

      <div v-for="template in templates.data" class="dvs-mb-6 dvs-rounded-sm dvs-bg-white dvs-shadow-sm dvs-flex dvs-justify-between dvs-items-center">
        <div class="dvs-min-w-2/5 dvs-text-base dvs-font-bold dvs-pr-8">
          {{ template.name }}<br>
          <span class="dvs-font-mono dvs-font-normal">{{ template.domain }}</span>
        </div>
        <div class="dvs-min-w-1/5 dvs-text-sm dvs-font-mono dvs-pr-8">
          {{ template.layout }}
        </div>
        <div class="dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end">
          <button class="dvs-btn dvs-btn-xs dvs-mr-2" @click="goToTemplate(template)">Edit</button>
          <button class="dvs-btn dvs-btn-xs" v-devise-alert-confirm="{callback: requestDeleteTemplate, arguments: template, message: 'Are you sure you want to delete this template?'}">Delete</button>
        </div>
      </div>
    </div>

    <transition name="fade">
      <devise-modal class="dvs-z-50" v-if="showCreate" @close="showCreate = false">
        <h4 class="dvs-mb-4">Create New Template</h4>

        <fieldset class="dvs-fieldset mb-4">
          <label>Name</label>
          <input type="text" v-model="newTemplate.name" placeholder="Name of the Template">
        </fieldset>

        <help class="dvs-mb-8">The view file that you are referencing will be located in the resources/views directory of your project and needs to be referenced through dot notation. For example, if you're referencing "/resources/views/layouts/layout.blade.php" you will need to put "layouts.layout" in this field.</help>

        <fieldset class="dvs-fieldset mb-4">
          <label>Layout</label>
          <input type="text" v-model="newTemplate.layout" placeholder="Layout of the Template">
        </fieldset>

        <button class="dvs-btn" @click="requestCreateTemplate" :disabled="createInvalid">Create</button>
        <button class="dvs-btn dvs-btn-plain" @click="showCreate = false">Cancel</button>
      </devise-modal>
    </transition>
  </div>

</template>

<script>
import DeviseModal from './../utilities/Modal'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'TemplatesIndex',
  data () {
    return {
      modulesToLoad: 1,
      showCreate: false,
      newTemplate: {
        name: null,
        layout: null
      }
    }
  },
  mounted () {
    this.retrieveAllTemplates()
  },
  methods: {
    ...mapActions('devise', [
      'getTemplates',
      'createTemplate',
      'deleteTemplate'
    ]),
    requestCreateTemplate () {
      let self = this
      this.createTemplate(this.newTemplate).then(function () {
        self.newTemplate.name = null
        self.newTemplate.layout = null
        self.showCreate = false
      })
    },
    requestDeleteTemplate (template) {
      let self = this
      this.deleteTemplate(template).then(function () {
        self.retrieveAllTemplates()
      })
    },
    retrieveAllTemplates (loadbar = true) {
      this.getTemplates().then(function () {
        if (loadbar) {
          window.bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    goToTemplate (template) {
      this.$router.push({name: 'devise-templates-edit', params: { templateId: template.id }})
    }
  },
  computed: {
    ...mapGetters('devise', [
      'templates'
    ]),
    createInvalid () {
      return this.newTemplate.name === null ||
             this.newTemplate.layout === null
    }
  },
  components: {
    DeviseModal
  }
}
</script>
