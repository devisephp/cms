<template>
  <devise-installer-item :item="item" id="nav-site" title="First Site and Language (required)">
    <template slot="instructions">
      <p>Devise works as a multi-tenant system out of the box meaning that you can run multiple sites under the same code base. Even if you are running only one domain Devise needs to know about it. Use the form to the right to set this up.</p>
      <p>
        Each site also needs a language. You can assign any number of languages once you have completed installation. The language should be the
        <a
          href="https://www.loc.gov/standards/iso639-2/php/code_list.php"
        >ISO Code</a> of that language
      </p>

      <help>
        <p>The domain should not include the http or https:// protocol identifier. So your site entry could be "my-super-awesome-site.com" or "sub-domain.my-super-awesome-site.com". To Support development environments you can override these values in your .env file in the root of your project with something like "SITE_1_DOMAIN=my-super-awesome-site.test" for your local development or staging.</p>
        <p>
          <strong>Important:</strong> The domain should be the
          <em>final</em> domain name. If you're working on this site locally you will need to add an override in your .env file like the example to the right.
        </p>
      </help>
    </template>

    <template slot="example">
      <h3 class="dvs-mb-4">Create Your first Site
        <template v-if="item">(Already Created)</template>
      </h3>
      <form class="dvs-mb-8" :class="{'dvs-opacity-50': item}">
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Site Name</label>
          <input type="text" v-model="newSite.name" :disabled="item">
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Site's Actual Domain (See below)</label>
          <input type="text" v-model="newSite.domain" :disabled="item">
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-6" v-if="languages.count">
          <label>Default Language</label>
          <select v-model="newSite.selectedLanguage" :disabled="item">
            <option :value="null">Select a Language</option>
            <option
              v-for="language in languages"
              :key="language.id"
              :value="language.id"
            >{{ language.code }}</option>
          </select>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-6" v-else>
          <label>Default Language</label>
          <input type="text" v-model="newSite.code" :disabled="item">
        </fieldset>
        <button
          type="submit"
          class="dvs-btn dvs-bg-green dvs-text-white"
          @click.prevent="attemptCreateSite()"
          :disabled="item"
        >Create Site</button>
      </form>

      <h3 class="dvs-mb-4">A note on the domain during development</h3>
      <p>If you're working locally using something like Larvel's Valet or Homestead make sure you provide the acutal domain name above and add a development override in your local .env file. Since this is the first site it needs to have a "1" (which will be the ID of the site)</p>
      <pre class="lang-bash" data-start="1">
        <code>
          SITE_1_DOMAIN=project-name.test 
        </code>
      </pre>
    </template>
  </devise-installer-item>
</template>

<script>
import { mapActions, mapState } from 'vuex';

import Item from './../Item';

export default {
  data() {
    return {
      newSite: {
        name: '',
        domain: '',
        code: 'en',
        selectedLanguage: null,
        languages: [],
        settings: {}
      }
    };
  },
  methods: {
    ...mapActions(['createSite', 'createLanguage']),
    attemptCreateSite() {
      // If a language hasn't been created yet
      if (!this.languages.count) {
        this.createLanguage(this.newSite).then(response => {
          this.newSite.languages = [];
          this.newSite.languages.push({ id: response.data.data.id, default: 1 });
          this.createSite(this.newSite);
        });
      } else {
        // If a language was created but the site failed we will end up here
        this.newSite.languages = [];
        this.newSite.languages.push({ id: this.newSite.selectedLanguage, default: 1 });
        this.createSite(this.newSite);
      }
    }
  },
  computed: {
    ...mapState({
      languages: state => state.languages.data
    })
  },
  components: {
    Item
  },
  props: {
    item: {
      required: true
    }
  }
};
</script>
