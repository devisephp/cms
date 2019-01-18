<template>
  <div>
    <div id="devise-admin-content">
      <h3 class="dvs-mb-4" :style="{'color': theme.panel.color}">Create new page</h3>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>Page Title</label>
        <input type="text" v-model="newPage.title" placeholder="Title of the Page">
      </fieldset>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>Copy Look of existing page</label>
        <div class="dvs-flex dvs-mb-2">
          <input type="checkbox" v-model="newPage.copy_page">
        </div>
        <div v-if="newPage.copy_page">
          <page-search @selected="setCopyPage" :placeholder="newPage.copy_page_title"></page-search>
          <help class="dvs-mt-4">
            <p>Will copy layout, slices, and field values from selected page.</p>
          </help>
        </div>
      </fieldset>

      <fieldset class="dvs-fieldset dvs-mb-4" v-if="!newPage.copy_page">
        <label>Layout</label>
        <select v-model="newPage.layout">
          <option v-for="(path, name) in layouts" :key="path" :value="path">{{ name }}</option>
        </select>
      </fieldset>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>Language</label>
        <select v-model="newPage.language_id">
          <option :value="null">Please select a language</option>
          <option v-for="language in languages.data" :key="language.id" :value="language.id">
            {{
            language.code }}
          </option>
        </select>
      </fieldset>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>Slug</label>
        <div class="dvs-flex">
          <input type="text" v-model="newPage.slug" placeholder="Url of the Page">
        </div>
      </fieldset>

      <fieldset class="dvs-fieldset dvs-mb-4">
        <label>Published?</label>
        <div class="dvs-flex">
          <input type="checkbox" v-model="newPage.published">
        </div>
      </fieldset>

      <button
        class="dvs-btn"
        :style="theme.actionButton"
        @click="requestCreatePage"
        :disabled="createInvalid"
      >Create</button>
      <button class="dvs-btn" :style="theme.actionButtonGhost" @click="showCreate = false">Cancel</button>
    </div>
  </div>
</template>

<script>
import debounce from 'v-debounce';

import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'PagesCreate',
  data() {
    return {
      newPage: {
        layout: '',
        language_id: null,
        translated_from_page_id: 0,
        title: null,
        slug: null,
        canonical: null,
        head: null,
        footer: null,
        middleware: 'web',
        published: false,
        copy_page: false,
        copy_page_id: 0,
        copy_page_title: 'Search Page'
      }
    };
  },
  mounted() {
    if (deviseSettings.$page.site.settings.hasOwnProperty('defaultLayout')) {
      this.newPage.layout = deviseSettings.$page.site.settings.defaultLayout;
    }
  },
  methods: {
    ...mapActions('devise', ['getPages', 'searchPages', 'getLanguages', 'createPage']),
    requestCreatePage() {
      let self = this;
      this.createPage(this.newPage).then(function() {
        self.goToPage('devise-pages-index');
      });
    },
    retrieveAllLanguages() {
      let self = this;
      this.getLanguages().then(function() {
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    },
    setCopyPage(page) {
      this.newPage.copy_page_id = page.id;
      this.newPage.copy_page_title = page.title;
    },
    loadPage(id) {
      this.$router.push({ name: 'devise-pages-view', params: { pageId: id } });
    }
  },
  computed: {
    ...mapGetters('devise', ['languages']),
    createInvalid() {
      return (
        this.newPage.title === null ||
        (this.newPage.layout === null &&
          !this.newPage.copy_page &&
          this.newPage.copy_page_id === 0) ||
        this.newPage.language_id === null ||
        this.newPage.slug === null
      );
    },
    layouts() {
      return deviseSettings.$config.layouts;
    }
  },
  components: {
    DeviseModal: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Modal'),
    PageSearch: () =>
      import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/PageSearch'),
    Pagination: () =>
      import(/* webpackChunkName: "js/devise-tables" */ './../utilities/tables/Pagination')
  },
  directives: {
    debounce
  }
};
</script>
