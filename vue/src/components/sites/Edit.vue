<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative" v-if="localValue.languages && languages.data">
    
    <div id="devise-sidebar" :style="sidebarTheme">
      <sidebar-header title="Manage Site" back-text="Back to Sites" back-page="devise-sites-index" />
    </div>
    
    <div id="devise-admin-content" :style="adminTheme">
      <h3 class="dvs-mb-8" :style="{color: theme.sidebarText.color }">{{ localValue.name }} Settings</h3>

      <div class="dvs-mb-12">
        <form>
          <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Name</label>
          <input type="text" v-model="localValue.name" placeholder="Name of the Site">
        </fieldset>

        <help class="dvs-mb-10">The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.</help>

        <fieldset class="dvs-fieldset dvs-mb-10">
          <label>Domain</label>
          <input type="text" v-model="localValue.domain" placeholder="Domain of the Site">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-10">
          <label>Languages</label>
          <select v-model="editAddLanguage" @change="addEditLanguage()">
            <option :value="null">Add a Language</option>
            <option v-for="language in languagesNotInEditSite" :value="language">{{ language.code }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-10">
          <label>Current Languages</label>
          <help class="dvs-mb-4">Green indicates the default language. Click on the language tags below to set a new default.</help>
          <span v-for="language in localValue.languages" @click="setDefaultLanguage(language)" class="dvs-mr-2 dvs-tag dvs-bg-grey-darker dvs-cursor-pointer" :class="{'dvs-bg-green-dark dvs-text-white': language.default}">{{ language.name }}</span>
          <span v-if="localValue.languages.length < 1">No Languages</span>
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-10">
          <label>Admin Styles</label>
          <help class="dvs-mb-8">You can change the styles of the admin to more closely match the brand of the site as well as upload a logo for the admin.</help>
          <admin-designer v-model="localValue.settings.colors"></admin-designer>
        </fieldset>

        <div class="dvs-flex">
            <button class="dvs-btn mr-2" @click="requestEditSite" :disabled="editInvalid" :style="actionButtonTheme">Edit</button>
            <button class="dvs-btn dvs-btn-plain" @click="showEdit = false"  :style="regularButtonTheme">Cancel</button>
        </div>
        </form>
      </div>

    </div>

  </div>

</template>

<script>
import DeviseModal from './../utilities/Modal'
import AdminDesigner from './AdminDesigner'
import SidebarHeader from './../utilities/SidebarHeader'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'SitesEdit',
  data () {
    return {
      localValue: {
        settings: {
          colors: {}
        }
      },
      modulesToLoad: 2,
      editAddLanguage: null
    }
  },
  mounted () {
    this.retrieveAllSites()
    this.retrieveAllLanguages()
  },
  methods: {
    ...mapActions('devise', [
      'getLanguages',
      'getSites',
      'updateSite'
    ]),
    requestEditSite () {
      let self = this
      this.updateSite({site: this.site, data: this.localValue}).then(function () {
        var site = self.siteById(self.site.id)
        self.goToPage('devise-sites-index')
      })
    },
    addEditLanguage () {
      this.editAddLanguage.default = 0
      this.localValue.languages.push(this.editAddLanguage)
      this.editAddLanguage = null
    },
    setDefaultLanguage (language) {
      // Set them all to off and turn the default to on
      this.localValue.languages.map(l => {
        l.default = 0
        if (l.id === language.id) {
          l.default = 1
          return 1
        }
        return 0
      })
    },
    retrieveAllSites (loadbar = true) {
      let self = this
      this.getSites().then(function () {
        self.localValue = Object.assign({}, self.localValue, self.site, {settings: {colors: {}}})
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    retrieveAllLanguages (loadbar = true) {
      this.getLanguages().then(function () {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
  },
  computed: {
    ...mapGetters('devise', [
      'languages',
      'site',
      'siteById'
    ]),
    editInvalid () {
      return this.localValue.name === null ||
             this.localValue.domain === null
    },
    languagesNotInEditSite () {
      var self = this
      return this.languages.data.filter(language => {
        var match = self.localValue.languages.filter(l => l.id === language.id)
        return match.length === 0
      })
    }
  },
  components: {
    AdminDesigner,
    DeviseModal,
    SidebarHeader
  }
}
</script>
