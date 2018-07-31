<template>

  <administration>
    <sidebar title="Manage Languages" :menu-items="settingsMenu" />
    
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

        <fieldset class="dvs-fieldset dvs-mb-10" v-if="languages.data && languages.data.length > 0 && localValue.languages">
          <label>Languages</label>
          <select v-model="editAddLanguage" @change="addEditLanguage()">
            <option :value="null">Add a Language</option>
            <option v-for="language in languagesNotInEditSite" :key="language.id" :value="language">{{ language.code }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-10" v-if="localValue.languages">
          <label>Current Languages</label>
          <help class="dvs-mb-4">Green indicates the default language. Click on the language tags below to set a new default.</help>
          <span v-for="language in localValue.languages" :key="language.id" @click="setDefaultLanguage(language)" class="dvs-mr-2 dvs-tag dvs-bg-grey-darker dvs-cursor-pointer" :class="{'dvs-bg-green-dark dvs-text-white': language.default}">{{ language.name }}</span>
          <span v-if="localValue.languages.length < 1">No Languages</span>
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-10">
          <label>Google Analytics UA ID. Include the "UA-" in your entry</label>
          <input type="text" v-model="localValue.settings.googleAnalytics" placeholder="UA-XXXXXXX">
        </fieldset>

        <fieldset class="dvs-fieldset dvs-mb-10">
          <label>Manage Data</label>
          <help v-if="localValue.model_queries === null || localValue.model_queries.length < 1">Currently you don't have any data assigned to this template. Data you add will be available whenever this template is applied to a page</help>
          <div 
            class="dvs-flex dvs-justify-between dvs-items-center dvs-text-sm dvs-mb-2 dvs-font-bold dvs-p-4 dvs-rounded dvs-relative" 
            :style="regularButtonTheme" 
            v-for="(query, key) in localValue.model_queries" 
            :key="key"  
            v-else>
            {{ key }}
            <div @click="requestEditData(key)" class="dvs-absolute dvs-mt-3 dvs-mr-10 dvs-pin-t dvs-pin-r dvs-pin-b dvs-mr-4">
              <edit-icon class="dvs-cursor-pointer" w="25" h="25" />
            </div>
            <div @click="removeData(key)" class="dvs-absolute dvs-mt-3 dvs-pin-t dvs-pin-r dvs-pin-b dvs-mr-4">
              <trash-icon class="dvs-cursor-pointer" w="25" h="25" />
            </div>
          </div>
          <fieldset class="dvs-fieldset dvs-mt-8">
            <label>Add New Data</label>
            <div class="relative">
              <input type="text" placeholder="Variable Name" :value="newData.name" @input="newData.name = slugify($event.target.value)">
              <div class="dvs-absolute dvs-mt-2 dvs-pin-t dvs-pin-r dvs-pin-b dvs-mr-4" @click="addData">
                <add-icon class="dvs-cursor-pointer" w="25" h="25" />
              </div> 
            </div>
          </fieldset>
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

    <portal to="devise-root">
      <devise-modal @close="showAddData = false" v-if="showAddData" class="dvs-z-50">
        <query-builder v-model="newData" @save="addNewData" @close="showAddData = false"></query-builder>
      </devise-modal>
    </portal>

    <portal to="devise-root">
      <devise-modal @close="showEditData = false" v-if="showEditData" class="dvs-z-50">
        <query-builder v-model="newData" :editData="editData" @save="saveEditData" @close="showEditData = false"></query-builder>
      </devise-modal>
    </portal>

  </administration>

</template>

<script>
var qs = require('qs');

import DeviseModal from './../utilities/Modal'
import AdminDesigner from './AdminDesigner'
import QueryBuilder from './../utilities/QueryBuilder'

import TrashIcon from 'vue-ionicons/dist/md-trash.vue'
import AddIcon from 'vue-ionicons/dist/ios-add-circle.vue'
import EditIcon from 'vue-ionicons/dist/md-create.vue'

import Strings from './../../mixins/Strings'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'SitesEdit',
  data () {
    return {
      localValue: {
        languages: [],
        model_queries: null,
        settings: {
          colors: {},
          googleAnalytics: ''
        }
      },
      modulesToLoad: 2,
      editAddLanguage: null,
      showAddData: false,
      showEditData: false,
      editData: {
        key: null,
        model: null,
        filters: {}
      },
      newData: {
        name: null,
        model: null,
        modelQuery: null
      }
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
        var colors = {}
        var googleAnalytics = ''

        if (self.site.settings === null) {
          self.$set(self.site, 'settings', {})
        }

        if (typeof self.site.settings.colors !== 'undefined') {
          colors = self.site.settings.colors
        }
        if (typeof self.site.settings.googleAnalytics !== 'undefined') {
          googleAnalytics = self.site.settings.googleAnalytics
        }
        self.localValue = Object.assign(
          {}, 
          self.localValue, 
          self.site, 
          {
            settings: {
              colors: colors, 
              googleAnalytics: googleAnalytics
            }
          })
          
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    addData () {
      if (this.newData.name !== null && this.newData.name !== '') {
        this.showAddData = true
        this.newData.model = null
        this.newData.modelQuery = null
      } else {
        devise.$bus.$emit('showError', 'You must provide a variable name')
      }
    },
    addNewData () {
       if (this.localValue.model_queries === null) {
        this.$set(this.localValue, 'model_queries', {})
      }

      this.$set(this.localValue.model_queries, this.newData.name, `class=${this.newData.modelQuery}`)
      this.showAddData = false

      this.newData = {
        name: null,
        model: null,
        modelQuery: null
      }
    },
    requestEditData (key) {
      let modelQuery = qs.parse(this.localValue.model_queries[key])
      this.editData = {
        key: key,
        model: modelQuery.class,
        filters: modelQuery
      }
      this.showEditData = true
    },
    saveEditData () {
      this.showEditData = false
      this.$set(this.localValue.model_queries, this.newData.name, `class=${this.newData.modelQuery}`)

      this.editData = {
        key: null,
        model: null,
        filters: {}
      }

      this.newData = {
        name: null,
        model: null,
        modelQuery: null
      }
    },
    removeData (key) {
      this.$delete(this.localValue.model_queries, key)
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
      'siteById',
      'settingsMenu'
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
  mixins: [Strings],
  components: {
    AddIcon,
    AdminDesigner,
    DeviseModal,
    EditIcon,
    QueryBuilder,
    TrashIcon
  }
}
</script>
