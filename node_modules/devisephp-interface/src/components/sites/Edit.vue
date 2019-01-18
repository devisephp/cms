<template>
  <div>
    <div id="devise-admin-content">
      <h3 class="dvs-mb-8">
        <span class="dvs-uppercase">{{ localValue.name }}</span> Settings
      </h3>

      <div class="dvs-mb-12" v-if="loadedSettings">
        <form>
          <div class="dvs-flex dvs-mb-4">
            <fieldset class="dvs-fieldset dvs-mr-4">
              <label>Name</label>
              <input type="text" v-model="localValue.name" placeholder="Name of the Site">
            </fieldset>

            <fieldset class="dvs-fieldset dvs-mr-4">
              <label>Domain</label>
              <input type="text" v-model="localValue.domain" placeholder="Domain of the Site">
            </fieldset>

            <fieldset class="dvs-fieldset">
              <label>Google Analytics UA ID. Include the "UA-" in your entry</label>
              <input
                type="text"
                v-model="localValue.settings.googleAnalytics"
                placeholder="UA-XXXXXXX"
              >
            </fieldset>
          </div>

          <help
            class="dvs-mb-10"
          >The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.</help>

          <fieldset
            class="dvs-fieldset dvs-mb-4"
            v-if="languages.data && languages.data.length > 0 && localValue.languages"
          >
            <label>Languages</label>
            <select v-model="editAddLanguage" @change="addEditLanguage()">
              <option :value="null">Add a Language</option>
              <option
                v-for="language in languagesNotInEditSite"
                :key="language.id"
                :value="language"
              >{{ language.code }}</option>
            </select>
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-10" v-if="localValue.languages">
            <label>Current Languages</label>
            <help
              class="dvs-mb-4"
            >Green indicates the default language. Click on the language tags below to set a new default.</help>
            <span
              v-for="language in localValue.languages"
              :key="language.id"
              @click="setDefaultLanguage(language)"
              class="dvs-mr-2 dvs-tag dvs-bg-grey-darker dvs-cursor-pointer"
              :class="{'dvs-bg-green-dark dvs-text-white': language.default}"
            >{{ language.name }}</span>
            <span v-if="localValue.languages.length < 1">No Languages</span>
          </fieldset>

          <fieldset
            class="dvs-fieldset dvs-mb-4"
            v-if="languages.data && languages.data.length > 0 && localValue.languages"
          >
            <label>Default Layout</label>
            <select v-model="localValue.settings.defaultLayout">
              <option v-for="(path, name) in layouts" :value="path">{{ name }}</option>
            </select>
          </fieldset>

          <query-builder-interface v-model="localValue.model_queries"/>

          <fieldset class="dvs-fieldset dvs-mb-10">
            <label>Admin Styles</label>
            <help
              class="dvs-mb-8"
            >You can change the styles of the admin to more closely match the brand of the site.</help>
            <admin-designer v-if="localValue.settings.colors" v-model="localValue.settings.colors"></admin-designer>
          </fieldset>

          <div class="dvs-flex">
            <button
              class="dvs-btn mr-2"
              @click="requestEditSite"
              :disabled="editInvalid"
              :style="theme.actionButton"
            >Edit</button>
            <button
              class="dvs-btn"
              @click="showEdit = false"
              :style="theme.actionButtonGhost"
            >Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Strings from './../../mixins/Strings';

import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'SitesEdit',
  data() {
    return {
      localValue: {
        languages: [],
        model_queries: null,
        settings: {
          defaultLayout: '',
          colors: {},
          googleAnalytics: ''
        }
      },
      loadedSettings: false,
      modulesToLoad: 2,
      editAddLanguage: null
    };
  },
  mounted() {
    this.retrieveAllSites();
    this.retrieveAllLanguages();
  },
  methods: {
    ...mapActions('devise', ['getLanguages', 'getSites', 'updateSite']),
    requestEditSite() {
      let self = this;
      this.updateSite({ site: this.site, data: this.localValue }).then(function() {
        // var site = self.siteById(self.site.id)
        // self.goToPage('devise-sites-index')
      });
    },
    addEditLanguage() {
      this.editAddLanguage.default = 0;
      this.localValue.languages.push(this.editAddLanguage);
      this.editAddLanguage = null;
    },
    setDefaultLanguage(language) {
      // Set them all to off and turn the default to on
      this.localValue.languages.map(l => {
        l.default = 0;
        if (l.id === language.id) {
          l.default = 1;
          return 1;
        }
        return 0;
      });
    },
    retrieveAllSites(loadbar = true) {
      this.getSites().then(() => {
        var colors = {};
        var googleAnalytics = '';

        if (this.site.settings === null) {
          this.$set(this.site, 'settings', {});
        }

        if (typeof this.site.settings.colors !== 'undefined') {
          colors = this.site.settings.colors;
        }
        if (typeof this.site.settings.googleAnalytics !== 'undefined') {
          googleAnalytics = this.site.settings.googleAnalytics;
        }
        this.localValue = Object.assign({}, this.localValue, this.site, {
          settings: {
            colors: colors,
            googleAnalytics: googleAnalytics
          }
        });

        this.loadedSettings = true;

        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', this.modulesToLoad);
        }
      });
    },
    retrieveAllLanguages(loadbar = true) {
      this.getLanguages().then(() => {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', this.modulesToLoad);
        }
      });
    }
  },
  computed: {
    ...mapGetters('devise', ['languages', 'site', 'siteById', 'settingsMenu']),
    editInvalid() {
      return this.localValue.name === null || this.localValue.domain === null;
    },
    languagesNotInEditSite() {
      var self = this;
      return this.languages.data.filter(language => {
        var match = self.localValue.languages.filter(l => l.id === language.id);
        return match.length === 0;
      });
    },
    layouts() {
      return deviseSettings.$config.layouts;
    }
  },
  mixins: [Strings],
  components: {
    AdminDesigner: () => import(/* webpackChunkName: "js/devise-sites" */ './AdminDesigner'),
    QueryBuilderInterface: () =>
      import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/QueryBuilderInterface')
  }
};
</script>
