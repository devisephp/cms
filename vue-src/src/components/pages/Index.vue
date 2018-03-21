<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Pages</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-index')">Back to Main Menu</a>
      <ul class="dvs-list-reset">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg dvs-cursor-pointer" @click.prevent="showCreate = true">
          Create New Page
        </li>
      </ul>
    </div>
    <div id="devise-admin-content">
      <h2 class="dvs-mb-10">Current Site Pages</h2>

      <fieldset class="dvs-fieldset dvs-mb-8">
        <label>Search Pages</label>
        <input type="text" v-model.lazy="searchTerm" v-debounce="searchDelay">

        <div class="dvs-relative">
          <ul class="dvs-list-reset dvs-bg-white dvs-absolute dvs-shadow-lg">
            <li v-for="(suggestion, key) in autosuggest.data" class="dvs-border-b dvs-border-grey-lighter dvs-p-4 dvs-cursor-pointer" @click="loadPage(key)">
              {{ suggestion }}
            </li>
          </ul>
        </div>
      </fieldset>

      <div v-for="page in pages.data" class="dvs-mb-6 dvs-rounded-sm dvs-bg-white dvs-shadow-sm dvs-flex dvs-justify-between dvs-items-center">
        <div class="dvs-min-w-2/5 dvs-text-xl dvs-font-bold dvs-pr-8">
          {{ page.title }}
        </div>
        <div class="dvs-min-w-1/5 dvs-text-normal dvs-px-8 dvs-font-mono">
          {{ page.slug }}
        </div>
        <div class="dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end">
          <a class="dvs-btn dvs-btn-plain dvs-btn-xs dvs-mr-2" :href="page.slug">Go</a>
          <button class="dvs-btn dvs-btn-xs" @click="loadPage(page.id)">Manage</button>
        </div>
      </div>
    </div>

    <transition name="fade">
      <devise-modal @close="showTranslate = false" class="dvs-z-50" v-if="showCreate">
        <h4 class="dvs-mb-4">Create new page</h4>

        <fieldset class="dvs-fieldset mb-4">
          <label>Page Title</label>
          <input type="text" v-model="newPage.title" placeholder="Title of the Page">
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Template</label>
          <select v-model="newPage.template_id">
            <option :value="null">Please select a template</option>
            <option v-for="template in templates.data" :value="template.id">{{ template.name }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Language</label>
          <select v-model="newPage.language_id">
            <option :value="null">Please select a language</option>
            <option v-for="language in languages.data" :value="language.id">{{ language.code }}</option>
          </select>
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Slug</label>
          <div class="dvs-flex">
            <input type="text" v-model="newPage.slug" placeholder="Url of the Page">
          </div>
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Published?</label>
          <div class="dvs-flex">
            <input type="checkbox" v-model="newPage.published">
          </div>
        </fieldset>

        <button class="dvs-btn" @click="requestCreatePage" :disabled="createInvalid">Create</button>
        <button class="dvs-btn dvs-btn-plain" @click="showCreate = false">Cancel</button>
      </devise-modal>
    </transition>
  </div>

</template>

<script>
import debounce from 'v-debounce'

import DeviseModal from './../utilities/Modal'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'PagesIndex',
  data () {
    return {
      modulesToLoad: 3,
      showCreate: false,
      searchDelay: 1000,
      searchTerm: '',
      autosuggest: {
        data: []
      },
      newPage: {
        template_id: null,
        language_id: null,
        translated_from_page_id: 0,
        title: null,
        slug: null,
        canonical: null,
        head: null,
        footer: null,
        middleware: 'web',
        published: false
      }
    }
  },
  mounted () {
    this.retrieveAllPages()
    this.retrieveAllTemplates()
    this.retrieveAllLanguages()
  },
  methods: {
    ...mapActions('devise', [
      'getPages',
      'searchPages',
      'getLanguages',
      'getTemplates',
      'createPage'
    ]),
    requestCreatePage () {
      let self = this
      this.createPage(this.newPage).then(function () {
        self.newPage.template_id = null
        self.newPage.language_id = null
        self.newPage.title = null
        self.newPage.slug = null
        self.newPage.published = false
        self.showCreate = false
      })
    },
    retrieveAllPages (loadbar = true) {
      this.getPages().then(function () {
        if (loadbar) {
          window.bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    retrieveAllTemplates () {
      let self = this
      this.getTemplates().then(function () {
        window.bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    },
    retrieveAllLanguages () {
      let self = this
      this.getLanguages().then(function () {
        window.bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    },
    loadPage (id) {
      this.$router.push({name: 'devise-pages-view', params: { pageId: id }})
    },
    requestSearch (term) {
      let self = this
      if (term !== '') {
        this.searchPages(term).then((data) => {
          self.autosuggest = data
          if (data.data.length < 1) {
            window.bus.$emit('showMessage', {title: 'No Suggestions Found', message: 'We couldn\'t find any pages with the term: "' + term + '".'})
          }
        })
      } else {
        this.autosuggest = Object.assign({}, {})
      }
    }
  },
  watch: {
    searchTerm (newValue) {
      this.requestSearch(newValue)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'templates',
      'pages',
      'languages',
      'templates'
    ]),
    createInvalid () {
      return this.newPage.title === null ||
             this.newPage.template_id === null ||
             this.newPage.language_id === null ||
             this.newPage.slug === null
    }
  },
  components: {
    DeviseModal
  },
  directives: {
    debounce
  }
}
</script>
