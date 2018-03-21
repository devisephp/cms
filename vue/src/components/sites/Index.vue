<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Sites</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-developers-index')">Back to Developers</a>
      <ul class="dvs-list-reset">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg dvs-cursor-pointer" @click.prevent="showCreate = true">
          Create New Site
        </li>
      </ul>
    </div>
    <div id="devise-admin-content">
      <h2 class="dvs-mb-10">Current Sites</h2>

      <div v-for="site in sites.data" class="dvs-mb-6 dvs-rounded-sm dvs-bg-white dvs-shadow-sm dvs-flex dvs-justify-between dvs-items-center">
        <div class="dvs-min-w-2/5 dvs-text-base dvs-font-bold dvs-pr-8">
          {{ site.name }}<br>
          <span class="dvs-font-mono dvs-font-normal">{{ site.domain }}</span>
        </div>
        <div class="dvs-min-w-1/5 dvs-text-sm dvs-font-mono dvs-pr-8">
          SITE_{{ site.id }}_DOMAIN
        </div>
        <div class="dvs-min-w-1/5 dvs-flex dvs-flex-wrap dvs-pr-8">
          <span v-for="language in site.languages" class="dvs-mb-2 dvs-mr-2 dvs-tag dvs-bg-grey-lighter" :class="{'dvs-bg-green-dark dvs-text-white': language.default}">{{ language.code }}</span>
        </div>
        <div class="dvs-w-1/5 dvs-px-8 dvs-flex dvs-justify-end">
          <button class="dvs-btn dvs-btn-xs dvs-mr-2" @click="showEditSite(site)">Edit</button>
          <button class="dvs-btn dvs-btn-xs" v-devise-alert-confirm="{callback: requestDeleteSite, arguments: site, message: 'Are you sure you want to delete this site?'}">Delete</button>
        </div>
      </div>
    </div>

    <transition name="fade">
      <devise-modal class="dvs-z-50" v-if="showCreate" @close="showCreate = false">
        <h4 class="dvs-mb-4">Create new site</h4>

        <fieldset class="dvs-fieldset mb-4">
          <label>Name</label>
          <input type="text" v-model="newSite.name" placeholder="Name of the Site">
        </fieldset>

        <help class="dvs-mb-8">The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.</help>

        <fieldset class="dvs-fieldset mb-4">
          <label>Domain</label>
          <input type="text" v-model="newSite.domain" placeholder="Domain of the Site">
        </fieldset>

        <button class="dvs-btn" @click="requestCreateSite" :disabled="createInvalid">Create</button>
        <button class="dvs-btn dvs-btn-plain" @click="showCreate = false">Cancel</button>
      </devise-modal>
    </transition>

    <transition name="fade">
      <devise-modal class="dvs-z-50" v-if="showEdit" @close="showEdit = false">
        <h4 class="dvs-mb-4">Edit site</h4>

        <fieldset class="dvs-fieldset mb-4">
          <label>Name</label>
          <input type="text" v-model="editSite.name" placeholder="Name of the Site">
        </fieldset>

        <help class="dvs-mb-8">The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.</help>

        <fieldset class="dvs-fieldset mb-4">
          <label>Domain</label>
          <input type="text" v-model="editSite.domain" placeholder="Domain of the Site">
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Languages</label>
          <select v-model="editAddLanguage" @change="addEditLanguage()">
            <option :value="null">Add a Language</option>
            <option v-for="language in languagesNotInEditSite" :value="language">{{ language.code }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset mb-8">
          <help class="dvs-mb-8">Green indicates the default language. Click on the language tags below to change.</help>
          <label>Current Languages</label>
          <span v-for="language in editSite.languages" @click="setDefaultLanguage(language)" class="dvs-mr-2 dvs-tag dvs-bg-grey-lighter dvs-cursor-pointer" :class="{'dvs-bg-green-dark dvs-text-white': language.default}">{{ language.code }}</span>
          <span v-if="editSite.languages.length < 1">No Languages</span>
        </fieldset>

        <button class="dvs-btn" @click="requestEditSite" :disabled="editInvalid">Edit</button>
        <button class="dvs-btn dvs-btn-plain" @click="showEdit = false">Cancel</button>
      </devise-modal>
    </transition>
  </div>

</template>

<script>
import DeviseModal from './../utilities/Modal'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'SitesIndex',
  data () {
    return {
      modulesToLoad: 2,
      showCreate: false,
      showEdit: false,
      editAddLanguage: null,
      editSite: {
        id: null,
        name: null,
        domain: null,
        languages: []
      },
      newSite: {
        name: null,
        domain: null
      }
    }
  },
  mounted () {
    this.retrieveAllSites()
    this.retrieveAllLanguages()
  },
  methods: {
    ...mapActions('devise', [
      'getSites',
      'getLanguages',
      'createSite',
      'updateSite',
      'deleteSite'
    ]),
    requestCreateSite () {
      let self = this
      this.createSite(this.newSite).then(function () {
        self.newSite.name = null
        self.newSite.domain = null
        self.showCreate = false
      })
    },
    showEditSite (site) {
      this.editSite.id = site.id
      this.editSite.name = site.name
      this.editSite.domain = site.domain
      this.editSite.languages = site.languages
      this.showEdit = true
    },
    requestEditSite () {
      let self = this
      this.updateSite({site: this.originalSite(this.editSite.id), data: this.editSite}).then(function () {
        self.editSite.id = null
        self.editSite.name = null
        self.editSite.domain = null
        self.showEdit = false
      })
    },
    requestDeleteSite (site) {
      let self = this
      this.deleteSite(site).then(function () {
        self.retrieveAllSites()
      })
    },
    retrieveAllSites (loadbar = true) {
      this.getSites().then(function () {
        if (loadbar) {
          window.bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    retrieveAllLanguages (loadbar = true) {
      this.getLanguages().then(function () {
        if (loadbar) {
          window.bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    addEditLanguage () {
      this.editAddLanguage.default = 0
      this.editSite.languages.push(this.editAddLanguage)
      this.editAddLanguage = null
    },
    setDefaultLanguage (language) {
      // Set them all to off and turn the default to on
      this.editSite.languages.map(l => {
        l.default = 0
        if (l.id === language.id) {
          l.default = 1
          return 1
        }
        return 0
      })
    },
    originalSite (id) {
      return this.sites.data.find(site => site.id === id)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'sites',
      'languages'
    ]),
    createInvalid () {
      return this.newSite.name === null ||
             this.newSite.domain === null
    },
    editInvalid () {
      return this.editSite.name === null ||
             this.editSite.domain === null
    },
    languagesNotInEditSite () {
      var self = this
      return this.languages.data.filter(language => {
        var match = self.editSite.languages.filter(l => l.id === language.id)
        return match.length === 0
      })
    }
  },
  components: {
    DeviseModal
  }
}
</script>
