<template>
  <div>
    <div id="devise-admin-content">
      <div class="devise-admin-action-bar">
        <button
          class="dvs-btn dvs-btn-sm dvs-mx-1"
          :style="theme.actionButton"
          @click.prevent="showCreate = true"
        >Create New Site</button>
        <button
          class="dvs-btn dvs-btn-sm dvs-mx-1"
          :style="theme.actionButton"
          @click.prevent="requestSyncSites"
        >Sync Sites with Mothership</button>
      </div>

      <h2 class="dvs-mb-8" :style="{color: theme.panel.color}">Current Sites</h2>
      <help
        class="dvs-mb-10"
      >Here you can add and manage sites under this application. This means that you can add new domains, change themes for those domains, and add languages to those sites to make them more impacting for your users</help>

      <div class="dvs-flex dvs-flex-wrap">
        <div
          v-for="site in sites.data"
          :key="site.id"
          class="dvs-mb-6 dvs-flex dvs-justify-between dvs-items-center dvs-w-1/2"
        >
          <div class="dvs-p-8 dvs-text-center dvs-rounded" :style="theme.panelCard">
            <div class="dvs-text-base">
              <div class="dvs-mb-2 dvs-text-sm dvs-uppercase">{{ site.name }}</div>
              <div class="dvs-mb-4 dvs-text-sm dvs-opacity-75">Domain: {{ site.domain }}</div>
            </div>
            <div class="dvs-mb-8 dvs-flex dvs-flex-wrap dvs-justify-center">
              <span
                v-for="language in site.languages"
                :key="language.id"
                class="dvs-mb-2 dvs-mr-2 dvs-tag dvs-bg-grey-lighter dvs-text-black"
                :class="{'dvs-bg-green-dark dvs-text-white': language.default}"
              >{{ language.code }}</span>
            </div>
            <div class="dvs-flex dvs-justify-center">
              <a
                class="dvs-btn dvs-mr-2"
                :href="`\/\/${site.domain}`"
                :style="theme.actionButtonGhost"
              >Go</a>
              <button
                class="dvs-btn dvs-mr-2"
                @click="showEditSite(site)"
                :style="theme.actionButtonGhost"
              >Edit</button>
              <button
                class="dvs-btn"
                v-devise-alert-confirm="{callback: requestDeleteSite, arguments: site, message: 'Are you sure you want to delete this site?'}"
                :style="theme.actionButtonGhost"
              >Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <transition name="dvs-fade">
      <portal to="devise-root">
        <devise-modal class="dvs-z-50" v-if="showCreate" @close="showCreate = false">
          <h2 class="dvs-mb-8" :style="{color: theme.panel.color }">Create new site</h2>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Name</label>
            <input type="text" v-model="newSite.name" placeholder="Name of the Site">
          </fieldset>

          <help
            class="dvs-mb-8"
          >The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.</help>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Domain</label>
            <input type="text" v-model="newSite.domain" placeholder="Domain of the Site">
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Language</label>
            <select type="text" v-model="newSite.language_id">
              <option :value="null">Select a Default Language</option>
              <option
                v-for="language in languages"
                :key="language.id"
                :value="null"
              >{{ language.name }}</option>
            </select>
          </fieldset>

          <button
            class="dvs-btn"
            @click="requestCreateSite"
            :disabled="createInvalid"
            :style="theme.actionButton"
          >Create</button>
          <button
            class="dvs-btn"
            @click="showCreate = false"
            :style="theme.actionButtonGhost"
          >Cancel</button>
        </devise-modal>
      </portal>
    </transition>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'SitesIndex',
  data() {
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
        domain: null,
        language_id: null
      }
    };
  },
  mounted() {
    this.retrieveAllSites();
    this.retrieveAllLanguages();
  },
  methods: {
    ...mapActions('devise', [
      'syncSites',
      'getSites',
      'getLanguages',
      'createSite',
      'updateSite',
      'deleteSite'
    ]),
    requestSyncSites() {
      if (this.mothershipApiKey !== null) {
        let self = this;
        this.syncSites(this.sites.data);
      }
    },
    requestCreateSite() {
      let self = this;
      this.createSite(this.newSite).then(function() {
        self.newSite.name = null;
        self.newSite.domain = null;
        self.showCreate = false;
        self.requestSyncSites();
      });
    },
    showEditSite(site) {
      this.$router.push({ name: 'devise-sites-edit', params: { siteId: site.id } });
    },
    requestEditSite() {
      let self = this;
      this.updateSite({ site: this.originalSite(this.editSite.id), data: this.editSite }).then(
        function() {
          self.editSite.id = null;
          self.editSite.name = null;
          self.editSite.domain = null;
          self.showEdit = false;
        }
      );
    },
    requestDeleteSite(site) {
      let self = this;
      this.deleteSite(site).then(function() {
        self.retrieveAllSites();
      });
    },
    retrieveAllSites(loadbar = true) {
      this.getSites().then(function() {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
        }
      });
    },
    retrieveAllLanguages(loadbar = true) {
      this.getLanguages().then(function() {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
        }
      });
    },
    addEditLanguage() {
      this.editAddLanguage.default = 0;
      this.editSite.languages.push(this.editAddLanguage);
      this.editAddLanguage = null;
    },
    setDefaultLanguage(language) {
      // Set them all to off and turn the default to on
      this.editSite.languages.map(l => {
        l.default = 0;
        if (l.id === language.id) {
          l.default = 1;
          return 1;
        }
        return 0;
      });
    },
    originalSite(id) {
      return this.sites.data.find(site => site.id === id);
    }
  },
  computed: {
    ...mapGetters('devise', ['sites', 'languages', 'mothershipApiKey', 'settingsMenu']),
    createInvalid() {
      return this.newSite.name === null || this.newSite.domain === null;
    },
    editInvalid() {
      return this.editSite.name === null || this.editSite.domain === null;
    },
    languagesNotInEditSite() {
      var self = this;
      return this.languages.data.filter(language => {
        var match = self.editSite.languages.filter(l => l.id === language.id);
        return match.length === 0;
      });
    }
  },
  components: {
    DeviseModal: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Modal')
  }
};
</script>
