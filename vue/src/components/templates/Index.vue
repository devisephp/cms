<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar" data-simplebar>
      <sidebar-header title="Templates" back-text="Back to Administration" back-page="devise-index" />
      <ul class="dvs-list-reset">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold dvs-cursor-pointer" @click.prevent="showCreate = true">
          Create New Template
        </li>
      </ul>
    </div>
    <div id="devise-admin-content" :style="adminTheme">
      <h3 class="dvs-mb-8" :style="{color: theme.adminText.color}">Current Templates</h3>

      <div v-for="template in templates.data" :key="template.id" class="dvs-mb-6 dvs-flex dvs-justify-between dvs-items-center">
        <div class="dvs-min-w-2/5 dvs-text-base dvs-font-bold dvs-pr-8">
          {{ template.name }}<br>
          <span class="dvs-font-mono dvs-font-normal">{{ template.domain }}</span>
        </div>
        <div class="dvs-min-w-1/5 dvs-text-sm dvs-font-mono dvs-pr-8">
          {{ template.layout }}
        </div>
        <div class="dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end">
          <button class="dvs-btn dvs-btn-xs dvs-mr-2" @click="goToTemplate(template)" :style="regularButtonTheme">Edit</button>
          <button class="dvs-btn dvs-btn-xs" v-devise-alert-confirm="{callback: requestDeleteTemplate, arguments: template, message: 'Are you sure you want to delete this template?'}"  :style="regularButtonTheme">Delete</button>
        </div>
      </div>
    </div>

    <transition name="fade">
      <devise-modal class="dvs-z-50" v-if="showCreate" @close="showCreate = false">
        <h4 class="dvs-mb-4" :style="{color: theme.statsText.color}">Create New Template</h4>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Name</label>
          <input type="text" v-model="newTemplate.name" placeholder="Name of the Template">
        </fieldset>

        <help class="dvs-mb-8">
          The view file that you are referencing will be located in the resources/views directory 
          of your project and needs to be referenced through dot notation. For example, if you're 
          referencing "/resources/views/layouts/layout.blade.php" you will need to put "layouts.layout" 
          in this field.<br><br>
          When getting started on a greenfield project the Devise team typically copies the file from 
          vendor/devisephp/cms/resources/views/introduction.blade.php and copy it to 
          /resources/views/master.blade.php and modify it as our primary template by putting "master" in 
          the field below.

          
        </help>

        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Layout</label>
          <input type="text" v-model="newTemplate.layout" placeholder="Layout of the Template">
        </fieldset>

        <button class="dvs-btn" @click="requestCreateTemplate" :disabled="createInvalid" :style="actionButtonTheme">Create</button>
        <button class="dvs-btn dvs-btn-plain" @click="showCreate = false" :style="regularButtonTheme">Cancel</button>
      </devise-modal>
    </transition>
  </div>

</template>

<script>
import SidebarHeader from './../utilities/SidebarHeader'
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
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
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
    DeviseModal,
    SidebarHeader
  }
}
</script>
