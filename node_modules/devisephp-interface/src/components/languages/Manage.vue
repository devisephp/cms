<template>
  <div v-if="languages.data.length">
    <div id="devise-admin-content">
      <h3 class="dvs-mb-8 dvs-pr-16" :style="{color: theme.panel.color}">Add Language</h3>

      <help class="dvs-mb-8">
        When you add a language to this site it is immediately enabled. Afterwards you can create translated versions of pages that will be linked to one another allowing you to provide ways to switch languages on your front-end. We
        <a
          href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes"
          class="dvs-font-bold"
          target="_blank"
        >highly suggest using the ISO 639-1 2 letter codes</a> but you can technically use whatever you want.
      </help>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>New Language Code</label>
        <input type="text" maxlength="2" v-model="newLanguage.code">
      </fieldset>

      <button
        class="dvs-btn dvs-mb-8"
        :disabled="newLanguage.code === null"
        @click="requestCreateLanguage"
        :style="theme.actionButton"
      >Save New Language</button>

      <h3 class="dvs-mb-8 dvs-pr-16" :style="{color: theme.panel.color}">Existing Languages</h3>

      <div class="dvs-mb-12 dvs-flex dvs-flex-col">
        <div
          v-for="(language, key) in localValue.data"
          :key="key"
          class="dvs-flex dvs-justify-between dvs-items-center dvs-mb-2"
        >
          <div class="dvs-text-xl dvs-font-bold dvs-mb-4">
            <template v-if="!language.editCode">{{ language.code }}</template>
            <fieldset class="dvs-fieldset">
              <input v-show="language.editCode" type="text" v-model="localValue.data[key].code">
            </fieldset>
          </div>

          <div class="dvs-flex dvs-justify-between dvs-items-center">
            <button
              v-if="!language.editCode"
              class="dvs-btn dvs-btn-xs dvs-ml-4"
              :style="theme.actionButtonGhost"
              @click="language.editCode = !language.editCode"
            >
              <CreateIcon/>
            </button>
            <button
              class="dvs-btn dvs-mr-2"
              v-if="language.editCode"
              :style="theme.actionButton"
              @click="requestUpdateLanguage(localValue.data[key])"
            >Save Language Code</button>
            <button
              class="dvs-btn"
              v-if="language.editCode"
              :style="theme.actionButtonGhost"
              @click="language.editCode = false"
            >Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Administration from './../admin/Administration';

import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'LanguagesManage',
  data() {
    return {
      localValue: {
        data: []
      },
      modulesToLoad: 1,
      newLanguage: {
        code: null
      }
    };
  },
  mounted() {
    this.retrieveAllLanguages();
  },
  methods: {
    ...mapActions('devise', ['getLanguages', 'createLanguage', 'updateLanguage']),
    requestCreateLanguage() {
      this.createLanguage(this.newLanguage);
    },
    requestUpdateLanguage(language) {
      this.updateLanguage(language).then(function() {
        language.editCode = false;
      });
    },
    retrieveAllLanguages() {
      let self = this;
      this.getLanguages().then(function() {
        self.localValue = Object.assign({}, self.localValue, self.languages);
        self.localValue.data.map(language => {
          self.$set(language, 'editCode', false);
        });
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    }
  },
  computed: {
    ...mapGetters('devise', ['languages', 'settingsMenu'])
  },
  components: {
    Administration: () =>
      import(/* webpackChunkName: "js/devise-administration" */ './../admin/Administration.vue'),
    CreateIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-create.vue')
  }
};
</script>
