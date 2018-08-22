<template>

    <administration>
        <sidebar title="Manage Pages"/>

        <div id="devise-admin-content" :style="adminTheme">
            <action-bar>
                <li class="dvs-btn dvs-btn-sm dvs-mb-2" :style="actionButtonTheme" @click.prevent="showCreate = true">
                    Create New Page
                </li>
            </action-bar>

            <h2 class="dvs-mb-10" :style="{color: theme.sidebarText.color}">Current Site Pages</h2>

            <fieldset class="dvs-fieldset dvs-mb-8">
                <label>Search Pages</label>
                <input type="text" v-model.lazy="searchTerm" v-debounce="searchDelay">

                <div class="dvs-relative">
                    <ul class="dvs-list-reset dvs-bg-white dvs-text-black dvs-absolute dvs-shadow-lg">
                        <li v-for="(suggestion, key) in autosuggest.data" :key="key"
                            class="dvs-border-b dvs-border-grey-lighter dvs-p-4 dvs-cursor-pointer"
                            @click="loadPage(key)">
                            {{ suggestion }}
                        </li>
                    </ul>
                </div>
            </fieldset>

            <div v-for="page in pages.data" :key="page.id"
                 class="dvs-mb-6 dvs-flex dvs-justify-between dvs-items-center">
                <div class="dvs-min-w-2/5 dvs-font-bold dvs-pr-8">
                    {{ page.title }}
                </div>
                <div class="dvs-min-w-1/5 dvs-text-sm dvs-px-8 dvs-font-mono">
                    {{ page.slug }}
                </div>
                <div class="dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end">
                    <button
                            class="dvs-btn dvs-btn-xs dvs-mr-2"
                            :style="regularButtonTheme"
                            @click="loadPage(page.id)">Manage
                    </button>
                    <a
                            class="dvs-btn dvs-btn-plain dvs-btn-xs"
                            :style="regularButtonTheme"
                            :href="page.slug">Go</a>
                </div>
            </div>
        </div>

        <transition name="dvs-fade">
            <devise-modal @close="showCreate = false" class="dvs-z-50" v-if="showCreate">
                <h3 class="dvs-mb-4" :style="{color: theme.sidebarText.color}">Create new page</h3>

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
                        <page-search @selected="setPage" :placeholder="newPage.copy_page_title"></page-search>
                        <help class="dvs-mt-4">
                            <p>Will copy layout, slices, and field values from selected page.</p>
                        </help>
                    </div>
                </fieldset>

                <fieldset class="dvs-fieldset dvs-mb-4" v-if="!newPage.copy_page">
                    <label>Layout</label>
                    <input type="text" v-model="newPage.layout" placeholder="Layout template">
                </fieldset>

                <fieldset class="dvs-fieldset dvs-mb-4">
                    <label>Language</label>
                    <select v-model="newPage.language_id">
                        <option :value="null">Please select a language</option>
                        <option v-for="language in languages.data" :key="language.id" :value="language.id">{{
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

                <button class="dvs-btn" :style="actionButtonTheme" @click="requestCreatePage" :disabled="createInvalid">
                    Create
                </button>
                <button class="dvs-btn" :style="regularButtonTheme" @click="showCreate = false">Cancel</button>
            </devise-modal>
        </transition>
    </administration>

</template>

<script>
  import debounce from 'v-debounce'

  import DeviseModal from './../utilities/Modal'
  import PageSearch from './../utilities/PageSearch'

  import {mapActions, mapGetters} from 'vuex'

  export default {
    name: 'PagesIndex',
    data() {
      return {
        modulesToLoad: 3,
        showCreate: false,
        searchDelay: 1000,
        searchTerm: '',
        autosuggest: {
          data: []
        },
        newPage: {
          layout: null,
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
      }
    },
    mounted() {
      this.retrieveAllPages()
      this.retrieveAllLanguages()
    },
    methods: {
      ...mapActions('devise', [
        'getPages',
        'searchPages',
        'getLanguages',
        'createPage'
      ]),
      requestCreatePage() {
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
      retrieveAllPages(loadbar = true) {
        this.getPages().then(function () {
          if (loadbar) {
            devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
          }
        })
      },
      retrieveAllLanguages() {
        let self = this
        this.getLanguages().then(function () {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
        })
      },
      loadPage(id) {
        this.$router.push({name: 'devise-pages-view', params: {pageId: id}})
      },
      requestSearch(term) {
        let self = this
        if (term !== '') {
          this.searchPages(term).then((data) => {
            self.autosuggest = data
            if (data.data.length < 1) {
              devise.$bus.$emit('showMessage', {
                title: 'No Suggestions Found',
                message: 'We couldn\'t find any pages with the term: "' + term + '".'
              })
            }
          })
        } else {
          this.autosuggest = Object.assign({}, {})
        }
      },
      setPage(page) {
        this.newPage.copy_page_id = page.id
        this.newPage.copy_page_title = page.title
      },
    },
    watch: {
      searchTerm(newValue) {
        this.requestSearch(newValue)
      }
    },
    computed: {
      ...mapGetters('devise', [
        'pages',
        'languages'
      ]),
      createInvalid() {
        return this.newPage.title === null ||
          (this.newPage.layout === null && !this.newPage.copy_page && this.newPage.copy_page_id === 0) ||
          this.newPage.language_id === null ||
          this.newPage.slug === null
      }
    },
    components: {
      DeviseModal,
      PageSearch
    },
    directives: {
      debounce
    }
  }
</script>
