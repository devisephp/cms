<template>

    <div>

        <div id="devise-admin-content">
            <action-bar>
                <li class="dvs-btn dvs-btn-sm dvs-mb-2" :style="theme.actionButton" @click="goToPage('devise-pages-create')">
                    Create New Page
                </li>
            </action-bar>

            <h2 class="dvs-mb-10">Current Site Pages</h2>

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
                            :style="theme.actionButtonGhost"
                            @click="loadPage(page.id)">Manage
                    </button>
                    <a
                            class="dvs-btn dvs-btn-xs"
                            :style="theme.actionButtonGhost"
                            :href="page.slug">Go</a>
                </div>
            </div>

            <pagination class="mb-8" v-if="pages.data && pages.data.length" :meta="pages.meta" @changePage="changePage"></pagination>

        </div>
    </div>

</template>

<script>
  import debounce from 'v-debounce'

  import DeviseModal from './../utilities/Modal'
  import PageSearch from './../utilities/PageSearch'
  import Pagination from './../utilities/tables/Pagination'

  import {mapActions, mapGetters} from 'vuex'

  export default {
    name: 'PagesIndex',
    data() {
      return {
        modulesToLoad: 3,
        filters: {
          page: '1'
        },
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
        this.getPages(this.filters).then(function () {
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
      // Pagination Page... not page-page
      changePage (page) {
        this.filters.page = page
        this.retrieveAllPages(false)
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
      PageSearch,
      Pagination
    },
    directives: {
      debounce
    }
  }
</script>
