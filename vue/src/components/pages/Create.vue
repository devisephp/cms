<template>

    <div>

        <h3 class="dvs-mb-4">Create new page</h3>

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

        <button class="dvs-btn" :style="theme.actionButton" @click="requestCreatePage" :disabled="createInvalid">
            Create
        </button>
        <button class="dvs-btn" :style="regularButtonTheme" @click="showCreate = false">Cancel</button>
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
          self.goToPage('devise-pages-index')
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
    },
    computed: {
      ...mapGetters('devise', [
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
