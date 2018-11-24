<template>
  <div class="dvs-min-h-screen dvs-fixed dvs-pin dvs-z-60 dvs-text-grey-darker" :class="{'dvs-pointer-events-none': !loaded}" v-if="show">
    <div class="dvs-blocker dvs-z-30" @click="show = false"></div>
    <div class="media-manager dvs-min-w-4/5">
      <div v-if="!loaded" class="media-manager-interface">
        <div class="dvs-absolute dvs-absolute-center dvs-w-1/2">
          <loadbar :percentage="0.5"/>
        </div>
      </div>

      <div v-else-if="loaded && selectedFile === null" class="media-manager-interface">
        <div style="min-height:70px" class="dvs-py-4 dvs-px-8 dvs-rounded-tl dvs-rounded-tr dvs-flex dvs-justify-between dvs-items-center dvs-bg-grey-lighter dvs-border-b dvs-border-lighter dvs-relative">
          <div>
            <div class="dvs-font-bold">Media Manager</div>
            <div class="dvs-flex dvs-mt-2 dvs-justify-between dvs-items-center dvs-font-mono dvs-text-sm dvs-tracking-tight"  v-if="currentDirectory !== ''">
              <breadcrumbs :currentDirectory="currentDirectory" @chooseDirectory="changeDirectories"></breadcrumbs>
            </div>
          </div>
          <div class="dvs-flex dvs-items-center">
            <vue-dropzone
              ref="myVueDropzone"
              id="dropzone"
              @vdropzone-success="uploadSuccess()"
              @vdropzone-error="uploadError"
              class="dvs-mr-8 dvs-uppercase dvs-font-bold dvs-text-xs dvs-p-4 dvs-rounded-sm"
              :style="theme.actionButton"
              includeStyling: false
              :options="dropzoneOptions" />
            <fieldset class="dvs-fieldset dvs-mr-8">
              <div class="dvs-flex dvs-items-center">
                <label class="dvs-mr-2 dvs-my-2">Contact Sheet</label>
                <input class="dvs-my-2" type="radio" value="contactSheet" v-model="mode">
              </div>
            </fieldset>
            <fieldset class="dvs-fieldset dvs-mr-8">
              <div class="dvs-flex dvs-items-center">
                <label class="dvs-mr-2 dvs-my-2">Thumbnails</label>
                <input class="dvs-my-2" type="radio" value="thumbnails" v-model="mode">
              </div>
            </fieldset>
            <fieldset class="dvs-fieldset">
              <div class="dvs-flex dvs-items-center">
                <label class="dvs-mr-2 dvs-my-2">List</label>
                <input class="dvs-my-2" type="radio" value="list" v-model="mode">
              </div>
            </fieldset>

          </div>
        </div>

        <div class="dvs-flex dvs-items-stretch dvs-h-full">

          <div data-simplebar class=" dvs-min-w-1/3">
            <div class="dvs-h-full dvs-p-8 dvs-bg-grey-lightest dvs-flex dvs-flex-col dvs-justify-between dvs-border-r dvs-border-lighter">

              <form @submit.prevent="requestSearch">
                <div class="mb-8 flex">
                    <fieldset class="dvs-fieldset mr-2">
                      <input type="text" placeholder="Search" v-model="searchTerms" class="mr-2">
                    </fieldset>
                    <button type="submit" class="dvs-btn dvs-btn-sm" @click="requestSearch" :style="theme.actionButton">Search</button>
                </div>
              </form>

              <ul class="dvs-list-reset dvs-mb-10 dvs-font-mono dvs-text-sm dvs-tracking-tight">
                <li v-for="directory in directories" :key="directory.id" class="dvs-cursor-pointer dvs-mt-2 dvs-text-bold" @click="changeDirectories(directory.path)">
                  <folder-icon class="dvs-mr-2"></folder-icon>
                  {{ directory.name }}
                </li>
                <li v-if="directories.length < 1">
                  No directories within this directory
                </li>
              </ul>
              
              <div class="dvs-flex dvs-flex-col">
                <fieldset class="dvs-fieldset dvs-mb-4">
                  <input type="text" placeholder="New Directory" v-model="directoryToCreate" class="mr-2">
                </fieldset>
                <button class="dvs-btn dvs-btn-sm" @click="requestCreateDirectory()" :style="theme.actionButton">Create</button>
              </div>
            </div>
          </div>


          <div class="dvs-flex-grow dvs-relative dvs-overflow-y-scroll" :class="{'w-full': directories.length < 1}">

            <div class="dvs-p-8 dvs-flex" v-if="searchResults.length > 0">
              <h4>Showing up to {{ searchResultsLimit }} results for: <strong>{{ searchTerms }}</strong></h4>
              <div @click="closeSearch">
                <close-icon class="dvs-ml-2 dvs-cursor-pointer" w="30" h="30" />
              </div>
            </div>

            <div class="dvs-p-8 dvs-flex" v-else-if="searchableMedia.data.length > 0 && searchTerms !== null && searchTerms !== ''">
              <h4>Hit "Search" for results of: <strong>{{ searchTerms }}</strong></h4>
              <div @click="closeSearch">
                <close-icon class="dvs-ml-2 dvs-cursor-pointer" w="30" h="30" />
              </div>
            </div>

            <!-- Delete Directory -->
            <div v-if="currentFiles.length < 1 && directories.length < 1 && currentDirectory !== ''" class="dvs-flex dvs-justify-center dvs-items-center dvs-absolute dvs-absolute-center">
              <div class="dvs-bg-white dvs-text-grey-dark dvs-rounded dvs-p-8 dvs--mt-15 dvs-text-center dvs-shadow dvs-cursor-pointer" @click="requestDeleteDirectory()">
                <trash-icon h="40" w="40" :style="{color: theme.panel.color}" />
                <h6 class="dvs-mt-2 dvs-text-sm">
                  Delete this directory
                </h6>
              </div>
            </div>

            <!-- Directories but no files -->
            <div v-if="currentFiles.length < 1 && directories.length > 0 && currentDirectory !== ''" class="dvs-flex dvs-justify-center dvs-items-center dvs-absolute dvs-absolute-center">
              <div class="dvs-bg-white dvs-rounded dvs-p-8 dvs--mt-15 dvs-text-center dvs-shadow">
                <folder-icon h="40" w="40" :style="{color: theme.panel.color}" />
                <h6 class="dvs-mt-2 dvs-text-sm"><span>No files in this directory</span></h6>
              </div>
            </div>

            <!-- Files -->
            <ul class="dvs-list-reset dvs-flex dvs-justify-center dvs-flex-wrap" v-else>
              <li v-for="file in currentFiles" :key="file.id" class="dvs-relative dvs-bg-white dvs-card dvs-mt-2"
                :class="{
                  'dvs-cursor-pointer': !file.on,
                  'dvs-border-b dvs-border-lighter dvs-p-2 dvs-mx-4': mode === 'thumbnails',
                  'dvs-m-4 dvs-p-0': mode !== 'thumbnails',
                  'dvs-w-full': mode === 'list'
                }"
                @click="openFile(file)">

                <!-- Close File if On -->
                <div v-if="file === currentlyOpenFile" @click.stop.prevent="closeFile(file)">
                  <close-icon class="dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-4 dvs-mr-4 dvs-cursor-pointer" w="30" h="30" />
                </div>

                <!-- Closed File -->
                <div v-if="file !== currentlyOpenFile">
                  <!-- Contact Sheet -->
                  <div 
                    class="dvs-overflow-hidden dvs-text-center" 
                    style="width:100px;height:105px" 
                    v-if="mode === 'contactSheet'">
                    <img :src="`/styled/preview/${file.url}?w=100&h=100`" style="min-width:75px;height:75px">
                    <div class="dvs-text-xs dvs-font-bold">
                      {{ file.name }}
                    </div>
                  </div>

                  <!-- Thumbnails Mode -->
                  <div 
                    class="dvs-grid-preview dvs-font-bold dvs-relative" 
                    :style="`background-size:cover;background-image:url('${`/styled/preview/${file.url}?w=300&h=300`}')`" 
                    v-else-if="mode === 'thumbnails'">
                    <div class="dvs-text-center dvs-absolute dvs-pin-b dvs-pin-l dvs-pin-r dvs-text-white dvs-p-4"
                    style="text-shadow:2px 2px 2px rgba(0,0,0,0.5);background-color:rgba(0,0,0,0.4)">
                      {{ file.name }}
                    </div>
                  </div>

                  <!-- List Mode -->
                  <div 
                    class="dvs-w-full dvs-flex dvs-items-center"
                    v-else>
                    <img :src="`/styled/preview/${file.url}?w=100&h=100`" style="min-width:75px;height:75px">
                    <div class="dvs-ml-4 dvs-font-bold">
                      {{ file.name }}
                    </div>
                  </div>
                </div>

                <!-- Open File -->
                <div v-else class="dvs-flex dvs-p-4">
                  <div class="dvs-w-1/2 dvs-mr-8 dvs-flex dvs-flex-col dvs-justify-between">
                    <img :src="`/styled/preview/${file.url}?w=500&h=500`" class="dvs-cursor-pointer dvs-mb-4" @click="selectSourceFile(file)">
                    <div class="dvs-flex">
                      <div class="dvs-mr-4 dvs-cursor-pointer" v-devise-alert-confirm="{callback: confirmedDeleteFile, arguments: file, message: 'Are you sure you want to delete this media?'}">
                        <trash-icon h="20" w="20" :style="{color: theme.panel.color}" />
                      </div>
                      <a href="file.url" target="_blank" :style="{color: theme.panel.color}">
                        <link-icon h="20" w="20" />
                      </a>
                    </div>
                  </div>
                  <div class="dvs-w-1/2">
                    <h6 class="dvs-text-xs dvs-uppercase dvs-mb-1">Filename</h6>
                    <p class="dvs-text-sm">{{ file.name }}</p>

                    <fieldset class="dvs-fieldset dvs-mb-4">
                      <label class="dvs-text-xs dvs-uppercase dvs-mb-1">URL</label>
                      <input type="text" :value="file.url">
                    </fieldset>

                    <p><button @click="selectSourceFile(file)" class="dvs-btn" :style="theme.actionButton">Select</button></p>

                    <template v-if="isActive(file)">
                      <h6 class="dvs-my-2 dvs-text-sm">Appears On</h6>
                      <ul class="dvs-list-reset">
                        <li v-for="field in file.fields" :key="field.id" class="dvs-py-2">
                          <a href="field.page_slug" target="_blank" class="dvs-btn dvs-btn-sm">{{ field.page_title }} - {{ field.field_name }}</a>
                        </li>
                      </ul>
                    </template>

                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>

      </div>


      <div v-else-if="typeof options !== 'undefined' && options.sizes">
        <media-editor :source="selectedFile.url" :sizes="options.sizes" @cancel="selectedFile = null" @done="generateAndSetFile" />
      </div>

      <div v-else>
        <media-editor :source="selectedFile.url" @cancel="selectedFile = null" @done="generateAndSetFile" />
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  import Loadbar from './../utilities/Loadbar'
  import MediaEditor from './MediaEditor'
  import Breadcrumbs from './Breadcrumbs'
  import vue2Dropzone from 'vue2-dropzone'

  import FolderIcon from 'vue-ionicons/dist/ios-folder.vue'
  import TrashIcon from 'vue-ionicons/dist/md-trash.vue'
  import CloseIcon from 'vue-ionicons/dist/ios-close.vue'
  import AttachIcon from 'vue-ionicons/dist/md-attach.vue'
  import LinkIcon from 'vue-ionicons/dist/ios-link.vue'

  export default {
    data () {
      return {
        show: false,
        loaded: false,
        mode: 'list',
        directoryToCreate: '',
        target: null,
        callback: null,
        searchTerms: null,
        searchResults: [],
        selectedFile: null,
        searchResultsLimit: 100,
        currentlyOpenFile: null,
        options: null
      }
    },
    mounted () {
      this.startOpenerListener()
    },
    methods: {
      ...mapActions('devise', [
        'setCurrentDirectory',
        'generateImages',
        'getCurrentFiles',
        'getCurrentDirectories',
        'getSearchableMedia',
        'deleteFile',
        'createDirectory',
        'deleteDirectory',
      ]),
      startOpenerListener () {
        var self = this

        deviseSettings.$bus.$on('devise-launch-media-manager', function ({target, callback, options}) {
          self.callback = callback
          self.target = target,
          self.options = options,
          self.changeDirectories('')
          self.show = true
        })
      },
      changeDirectories (directory) {
        let self = this
        self.loaded = false
        this.searchTerms = null
        this.$set(this, 'searchResults', [])

        self.setCurrentDirectory(directory).then(function () {
          self.getCurrentFiles().then(function () {
            self.getCurrentDirectories().then(function () {
              self.loaded = true
            })
          })
        })
      },
      isActive (file) {
        return file.used_count > 0
      },
      uploadSuccess () {
        deviseSettings.$bus.$emit('showMessage', {title: 'Upload Complete', message: 'Your upload has been successfully completed'})
        this.changeDirectories(this.currentDirectory)
      },
      uploadError (file, message) {
        deviseSettings.$bus.$emit('showError', {title: 'Upload Error', message: 'There was a problem uploading your file. Either the file was too large or it has been uploaded too many times.'})
      },
      getUrlParam (paramName) {
        var reParam = new RegExp('(?:[?&]|&)' + paramName + '=([^&]+)', 'i')
        var match = window.location.search.match(reParam)

        return (match && match.length > 1) ? match[1] : null
      },
      openFile (file) {
        this.$set(this, 'currentlyOpenFile', file)
      },
      closeFile (file) {
        this.$set(this, 'currentlyOpenFile', null)
      },
      selectSourceFile (file) {
        this.selectedFile = file

        // Originally we simply kicked to the callback 
        // in the event there were no sizes. This may need
        // to be an option in the future but for now you just
        // go to the media editor where you set sizes

        // if (!this.options || !this.options.sizes) {
        //   if (typeof this.target !== 'undefined') {
        //     this.target.value = this.selectedFile.url
        //   }
        //   if (typeof this.callback !== 'undefined') {
        //     this.callback(this.selectedFile.url)
        //   }

        //   this.show = false
        //   this.$set(this, 'selectedFile', null)
        // }
      },
      generateAndSetFile (edits) {
        let self = this

        if (this.options && this.options.sizes) {
          edits.sizes = this.options.sizes
        }

        this.generateImages({original: this.selectedFile.url, settings: edits}).then(function (response) {
          if (typeof self.target !== 'undefined') {
            self.target.value = response.data
          }
          if (typeof self.callback !== 'undefined') {
            self.callback(response.data)
          }
          return true
        })
        
        this.show = false
        this.$set(this, 'selectedFile', null)
      },
      confirmedDeleteFile (file) {
        var self = this
        this.deleteFile(file).then(function () {
          self.changeDirectories(self.currentDirectory)
        })
      },
      requestCreateDirectory () {
        var self = this

        // check to see if the directory already exists in the current location
        var existingMatches = this.directories.filter(function (dir) {
          return dir.name === self.directoryToCreate
        })

        if (existingMatches.length === 0) {
          this.createDirectory({directory: self.currentDirectory, name: self.directoryToCreate}).then(function () {
            self.changeDirectories(self.currentDirectory)
            self.directoryToCreate = ''
          })
        } else {
          deviseSettings.$bus.$emit('showError', {title: 'Duplicate Name', message: 'There was already a directory with this name created in the current location.'})
        }
      },
      requestDeleteDirectory () {
        var self = this
        this.deleteDirectory(self.currentDirectory).then(function () {
          self.changeDirectories('')
        })
      },
      requestSearch () {
        if (this.searchTerms !== '') {
          // If we don't have the searchable Media yet then let's go get it
          // this means that the browser will require a refresh for this to be
          // updated. We are fine with that for now
          if (this.searchableMedia.data.length < 1) {
            this.getSearchableMedia().then(() => {
              this.search()
            })

          // Else lets go ahead with the search
          } else {
            this.search()
          }
        } 
      },
      search () {
        let terms = this.searchTerms.split(' ')
        let results = this.searchableMedia.data.filter((media) => {
          if (terms.every(function(v) { return media.search.toLowerCase().indexOf(v.toLowerCase()) >= 0; })) {
            return true
          }
        })

        this.searchResults = results.slice(0,this.searchResultsLimit)
      },
      closeSearch () {
        this.searchTerms = null
        this.$set(this, 'searchResults', [])
      }
    },
    computed: {
      ...mapGetters('devise', [
        'files',
        'directories',
        'currentDirectory',
        'searchableMedia'
      ]),
      currentFiles () {
        if (this.searchResults.length > 0) {
          return this.searchResults
        } 
        return this.files
      },
      dropzoneOptions () {

        let token = document.head.querySelector('meta[name="csrf-token"]');
        
        return {
          url: '/api/devise/media?directory=' + this.currentDirectory,
          dictDefaultMessage: "<span class='dvs-cursor-pointer'>Upload New File</span>",
          method: 'post',
          createImageThumbnails: false,
          headers: {
            'X-CSRF-TOKEN': token.content
          }
        }
      }
    },
    components: {
      Loadbar,
      Breadcrumbs,
      MediaEditor,
      vueDropzone: vue2Dropzone,
      AttachIcon,
      FolderIcon,
      LinkIcon,
      TrashIcon,
      CloseIcon
    }
  }
</script>
