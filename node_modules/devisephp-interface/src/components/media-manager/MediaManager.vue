<template>
  <div
    class="dvs-min-h-screen dvs-fixed dvs-pin dvs-z-60 dvs-text-grey-darker"
    :class="{'dvs-pointer-events-none': !loaded}"
    v-if="show"
  >
    <div class="dvs-blocker dvs-z-30" @click="show = false"></div>
    <div class="media-manager dvs-min-w-4/5">
      <div v-if="!loaded" class="media-manager-interface">
        <div class="dvs-absolute dvs-absolute-center dvs-w-1/2">
          <loadbar :percentage="0.5"/>
        </div>
      </div>

      <div v-else-if="loaded && selectedFile === null" class="media-manager-interface">
        <div
          style="min-height:70px"
          class="dvs-py-4 dvs-px-8 dvs-rounded-tl dvs-rounded-tr dvs-flex dvs-justify-between dvs-items-center dvs-bg-grey-lighter dvs-border-b dvs-border-lighter dvs-relative"
        >
          <div>
            <div class="dvs-font-bold">Media Manager</div>
            <div
              class="dvs-flex dvs-mt-2 dvs-justify-between dvs-items-center dvs-font-mono dvs-text-sm dvs-tracking-tight"
              v-if="currentDirectory !== ''"
            >
              <breadcrumbs
                :currentDirectory="currentDirectory"
                @chooseDirectory="changeDirectories"
              ></breadcrumbs>
            </div>
          </div>
          <div class="dvs-flex dvs-items-center">
            <fieldset class="dvs-fieldset dvs-mr-8">
              <div class="dvs-flex dvs-items-center">
                <label class="dvs-mr-2 dvs-my-2">Remember Location?</label>
                <input class="dvs-my-2" type="checkbox" v-model="cookieSettings">
              </div>
            </fieldset>
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
          <div data-simplebar class="dvs-min-w-1/3">
            <div
              class="dvs-h-full dvs-p-8 dvs-bg-grey-lightest dvs-flex dvs-flex-col dvs-justify-between dvs-border-r dvs-border-lighter"
            >
              <form @submit.prevent="search">
                <div class="mb-8 flex">
                  <fieldset class="dvs-fieldset mr-2">
                    <input type="text" placeholder="Search" v-model="searchTerms" class="mr-2">
                  </fieldset>
                  <button
                    type="submit"
                    class="dvs-btn dvs-btn-sm"
                    :style="theme.actionButton"
                  >Search</button>
                </div>
              </form>

              <ul class="dvs-list-reset dvs-mb-10 dvs-font-mono dvs-text-sm dvs-tracking-tight">
                <li
                  v-for="directory in directories"
                  :key="directory.id"
                  class="dvs-cursor-pointer dvs-mt-2 dvs-text-bold"
                  @click="changeDirectories(directory.path)"
                >
                  <folder-icon class="dvs-mr-2"></folder-icon>
                  {{ directory.name }}
                </li>
                <li v-if="directories.length < 1">No directories within this directory</li>
              </ul>

              <div class="dvs-flex dvs-flex-col">
                <fieldset class="dvs-fieldset dvs-mb-4">
                  <input
                    type="text"
                    placeholder="New Directory"
                    v-model="directoryToCreate"
                    class="mr-2"
                  >
                </fieldset>
                <button
                  class="dvs-btn dvs-btn-sm"
                  @click="requestCreateDirectory()"
                  :style="theme.actionButton"
                >Create</button>
              </div>
            </div>
          </div>

          <div
            class="dvs-flex-grow dvs-relative dvs-overflow-y-scroll dvs-p-4"
            :class="{'w-full': directories.length < 1}"
          >
            <div class="dvs-p-8 dvs-flex" v-if="searchResults.length > 0">
              <h4>
                Showing up to {{ searchResultsLimit }} results for:
                <strong>{{ searchTerms }}</strong>
              </h4>
              <div @click="closeSearch">
                <close-icon class="dvs-ml-2 dvs-cursor-pointer" w="30" h="30"/>
              </div>
            </div>

            <div
              class="dvs-p-8 dvs-flex"
              v-else-if="searchableMedia.data.length > 0 && searchTerms !== null && searchTerms !== ''"
            >
              <h4>
                Hit "Search" for results of:
                <strong>{{ searchTerms }}</strong>
              </h4>
              <div @click="closeSearch">
                <close-icon class="dvs-ml-2 dvs-cursor-pointer" w="30" h="30"/>
              </div>
            </div>

            <!-- File uploader -->
            <uploader :current-directory="currentDirectory" @all-files-uploaded="refreshDirectory"></uploader>

            <!-- Delete Directory -->
            <div
              v-if="currentFiles.length < 1 && directories.length < 1 && currentDirectory !== ''"
              class="dvs-flex dvs-justify-center dvs-items-center dvs-absolute dvs-absolute-center"
            >
              <div
                class="dvs-bg-white dvs-text-grey-dark dvs-rounded dvs-p-8 dvs--mt-15 dvs-text-center dvs-shadow dvs-cursor-pointer"
                @click="requestDeleteDirectory()"
              >
                <trash-icon h="40" w="40" :style="{color: theme.panel.color}"/>
                <h6 class="dvs-mt-2 dvs-text-sm">Delete this directory</h6>
              </div>
            </div>

            <!-- Directories but no files -->
            <div
              v-if="currentFiles.length < 1 && directories.length > 0 && currentDirectory !== ''"
              class="dvs-flex dvs-justify-center dvs-items-center dvs-absolute dvs-absolute-center"
            >
              <div class="dvs-bg-white dvs-rounded dvs-p-8 dvs--mt-15 dvs-text-center dvs-shadow">
                <folder-icon h="40" w="40" :style="{color: theme.panel.color}"/>
                <h6 class="dvs-mt-2 dvs-text-sm">
                  <span>No files in this directory</span>
                </h6>
              </div>
            </div>

            <!-- Files -->
            <ul class="dvs-list-reset dvs-flex dvs-justify-center dvs-flex-wrap" v-else>
              <li
                v-for="file in currentFiles"
                :key="file.id"
                class="dvs-relative dvs-bg-white dvs-card"
                :class="{
                  'dvs-cursor-pointer': !file.on,
                  'dvs-border-b dvs-border-lighter dvs-p-0 dvs-mx-0 w-1/2': mode === 'thumbnails',
                  'dvs-p-0 dvs-mb-4 dvs-mt-2': mode !== 'thumbnails',
                  'dvs-mx-2': mode === 'contactSheet',
                  'dvs-w-full': mode === 'list'
                }"
                @click="openFile(file)"
              >
                <!-- Close File if On -->
                <div v-if="file === currentlyOpenFile" @click.stop.prevent="closeFile(file)">
                  <close-icon
                    class="dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-4 dvs-mr-4 dvs-cursor-pointer"
                    w="30"
                    h="30"
                  />
                </div>

                <!-- Closed File -->
                <div class="dvs-overflow-hidden" v-if="file !== currentlyOpenFile">
                  <!-- Contact Sheet -->
                  <div
                    class="dvs-overflow-hidden dvs-text-center"
                    style="width:100px;height:105px"
                    v-if="mode === 'contactSheet'"
                  >
                    <img
                      :src="`/styled/preview/${file.url}?w=100&h=100`"
                      style="min-width:75px;height:75px"
                    >
                    <div class="dvs-text-xs dvs-font-bold dvs-px-2">{{ file.name }}</div>
                  </div>

                  <!-- Thumbnails Mode -->
                  <div
                    class="dvs-grid-preview dvs-relative"
                    :style="`background-size:cover;background-image:url('${`/styled/preview/${file.url}?w=600&h=300&q=100&sharp=2`}')`"
                    v-else-if="mode === 'thumbnails'"
                  ></div>

                  <!-- List Mode -->
                  <div class="dvs-w-full dvs-flex dvs-items-center" v-else>
                    <img
                      :src="`/styled/preview/${file.url}?w=100&h=100`"
                      style="min-width:75px;height:75px"
                    >
                    <div class="dvs-px-4 dvs-font-bold">{{ file.name }}</div>
                  </div>
                </div>

                <!-- Open File -->
                <div v-else class="dvs-flex dvs-p-4 dvs-overflow-hidden">
                  <div class="dvs-w-1/2 dvs-mr-8 dvs-flex dvs-flex-col dvs-justify-between">
                    <img
                      :src="`/styled/preview/${file.url}?w=500&h=500`"
                      class="dvs-cursor-pointer dvs-mb-4"
                    >
                    <div class="dvs-flex">
                      <div
                        class="dvs-mr-4 dvs-cursor-pointer"
                        :style="{color: theme.actionButton.background}"
                        v-devise-alert-confirm="{callback: confirmedDeleteFile, arguments: file, message: 'Are you sure you want to delete this media?'}"
                      >
                        <trash-icon h="20" w="20"/>
                      </div>
                      <a
                        class="dvs-mr-4"
                        href="file.url"
                        target="_blank"
                        :style="{color: theme.actionButton.background}"
                      >
                        <link-icon h="20" w="20"/>
                      </a>
                      <a
                        :href="file.url"
                        target="_blank"
                        :style="{color: theme.actionButton.background}"
                        download
                      >
                        <download-icon h="20" w="20"/>
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

                    <p v-if="callback">
                      <button
                        @click="selectSourceFile(file)"
                        class="dvs-btn"
                        :style="theme.actionButton"
                      >Select</button>
                    </p>

                    <template v-if="isActive(file)">
                      <h6 class="dvs-my-2 dvs-text-sm">Appears On</h6>
                      <ul class="dvs-list-reset">
                        <li v-for="field in file.fields" :key="field.id" class="dvs-py-2">
                          <a
                            href="field.page_slug"
                            target="_blank"
                            class="dvs-btn dvs-btn-sm"
                          >{{ field.page_title }} - {{ field.field_name }}</a>
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

      <template v-else-if="selectedFile && selectedFile.type === 'image'">
        <div v-if="typeof options !== 'undefined' && options.sizes">
          <media-editor
            :source="selectedFile.url"
            :sizes="options.sizes"
            @cancel="selectedFile = null"
            @done="generateAndSetFile"
          />
        </div>

        <div v-else>
          <media-editor
            :source="selectedFile.url"
            @cancel="selectedFile = null"
            @done="generateAndSetFile"
          />
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

import Loadbar from './../utilities/Loadbar';
import Uploader from './../utilities/Uploader';
import MediaEditor from './MediaEditor';
import Breadcrumbs from './Breadcrumbs';

let Cookies = require('js-cookie');

export default {
  data() {
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
      options: null,
      cookieSettings: false
    };
  },
  mounted() {
    this.startOpenerListener();
  },
  methods: {
    ...mapActions('devise', [
      'setCurrentDirectory',
      'generateImages',
      'getCurrentFiles',
      'getCurrentDirectories',
      'mediaSearch',
      'deleteFile',
      'createDirectory',
      'deleteDirectory'
    ]),
    startOpenerListener() {
      var self = this;

      deviseSettings.$bus.$on('devise-launch-media-manager', function({
        target,
        callback,
        options
      }) {
        self.callback = callback;
        self.target = target;
        self.options = options;

        let cookieLocation = Cookies.get('devise-mediamanager-location');
        if (cookieLocation) {
          self.changeDirectories(cookieLocation);
          self.cookieSettings = true;
        } else {
          self.changeDirectories('');
        }

        let cookieMode = Cookies.get('devise-mediamanager-mode');
        if (cookieMode) {
          self.mode = cookieMode;
        }

        self.show = true;
      });
    },
    changeDirectories(directory) {
      let self = this;
      self.loaded = false;
      this.searchTerms = null;
      this.$set(this, 'searchResults', []);

      self.setCurrentDirectory(directory).then(function() {
        self.getCurrentFiles(self.options).then(function() {
          self.getCurrentDirectories().then(function() {
            self.loaded = true;

            if (self.cookieSettings) {
              Cookies.set('devise-mediamanager-location', directory);
            }
          });
        });
      });
    },
    isActive(file) {
      return file.used_count > 0;
    },
    refreshDirectory() {
      this.changeDirectories(this.currentDirectory);
    },
    uploadError(file, message) {
      deviseSettings.$bus.$emit('showError', {
        title: 'Upload Error',
        message:
          'There was a problem uploading your file. The file may be too large to be uploaded.'
      });
    },
    getUrlParam(paramName) {
      var reParam = new RegExp('(?:[?&]|&)' + paramName + '=([^&]+)', 'i');
      var match = window.location.search.match(reParam);

      return match && match.length > 1 ? match[1] : null;
    },
    openFile(file) {
      this.$set(this, 'currentlyOpenFile', file);
    },
    closeFile(file) {
      this.$set(this, 'currentlyOpenFile', null);
    },
    selectSourceFile(file) {
      this.selectedFile = file;

      if ((this.options && this.options.type === 'file') || (file && file.type === 'file')) {
        if (typeof this.target !== 'undefined') {
          this.target.value = this.selectedFile.url;
        }
        if (typeof this.callback !== 'undefined') {
          this.callback(this.selectedFile.url);
        }

        this.show = false;
        this.$set(this, 'selectedFile', null);
      }
    },
    generateAndSetFile(edits) {
      let self = this;

      if (this.options && this.options.sizes) {
        edits.sizes = this.options.sizes;
      }

      devise.$bus.$emit('showLoadScreen', 'Images being generated');

      this.generateImages({ original: this.selectedFile.url, settings: edits }).then(function(
        response
      ) {
        if (typeof self.target !== 'undefined') {
          self.target.value = response.data;
        }
        if (typeof self.callback !== 'undefined') {
          self.callback(response.data);
        }
        devise.$bus.$emit('hideLoadScreen');
        return true;
      });

      this.show = false;
      this.$set(this, 'selectedFile', null);
    },
    confirmedDeleteFile(file) {
      var self = this;
      this.deleteFile(file).then(function() {
        self.changeDirectories(self.currentDirectory);
      });
    },
    requestCreateDirectory() {
      var self = this;

      // check to see if the directory already exists in the current location
      var existingMatches = this.directories.filter(function(dir) {
        return dir.name === self.directoryToCreate;
      });

      if (existingMatches.length === 0) {
        this.createDirectory({
          directory: self.currentDirectory,
          name: self.directoryToCreate
        }).then(function() {
          self.changeDirectories(self.currentDirectory);
          self.directoryToCreate = '';
        });
      } else {
        deviseSettings.$bus.$emit('showError', {
          title: 'Duplicate Name',
          message: 'There was already a directory with this name created in the current location.'
        });
      }
    },
    requestDeleteDirectory() {
      var self = this;
      this.deleteDirectory(self.currentDirectory).then(function() {
        self.changeDirectories('');
      });
    },
    search() {
      this.mediaSearch(this.searchTerms).then(results => {
        this.searchResults = results;
      });
    },
    closeSearch() {
      this.searchTerms = null;
      this.$set(this, 'searchResults', []);
    }
  },
  computed: {
    ...mapGetters('devise', ['files', 'directories', 'currentDirectory', 'searchableMedia']),
    currentFiles() {
      if (this.searchResults.length > 0) {
        return this.searchResults;
      }
      return this.files;
    },
    uploadHeaders() {
      let token = document.head.querySelector('meta[name="csrf-token"]');
      return {
        'X-CSRF-TOKEN': token.content
      };
    }
  },
  watch: {
    cookieSettings: newValue => {
      if (!newValue) {
        Cookies.remove('devise-mediamanager-location');
        Cookies.remove('devise-mediamanager-mode');
      }
    },
    mode: function(newValue) {
      if (this.cookieSettings) {
        Cookies.set('devise-mediamanager-mode', newValue);
      }
    }
  },
  components: {
    Loadbar,
    Breadcrumbs,
    MediaEditor,
    FolderIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-folder.vue'),
    TrashIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-trash.vue'),
    CloseIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-close.vue'),
    AttachIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-attach.vue'),
    LinkIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-link.vue'),
    DownloadIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-cloud-download.vue'),
    Uploader
  }
};
</script>
