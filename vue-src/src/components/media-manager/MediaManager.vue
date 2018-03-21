<template>
  <div class="dvs-min-h-screen dvs-fixed dvs-pin dvs-z-40 dvs-text-grey-darker" :class="{'dvs-pointer-events-none': !loaded}" v-if="show">
    <div class="dvs-blocker dvs-z-30" @click="show = false"></div>
    <div class="media-manager">
      <div v-if="!loaded" class="media-manager-interface">
        <div class="absolute absolute-center w-1/2">
          <loadbar :percentage="0.5"/>
        </div>
      </div>
      <div v-else class="media-manager-interface">
        <div class="dvs-py-4 dvs-px-8 dvs-rounded-tl dvs-rounded-tr dvs-flex dvs-justify-between dvs-items-center dvs-bg-grey-lighter dvs-border-b dvs-border-lighter dvs-relative">
          Media Manager
          <div class="dvs-flex">
            <fieldset class="dvs-mr-4">
              <label class="dvs-mr-2">List Mode</label>
              <input type="checkbox" v-model="listMode">
            </fieldset>
            <vue-dropzone
              ref="myVueDropzone"
              id="dropzone"
              @vdropzone-success="uploadSuccess()"
              @vdropzone-error="uploadError"
              class="pl-4"
              includeStyling: false
              :options="dropzoneOptions" />
          </div>
        </div>

        <div class="dvs-flex dvs-items-stretch dvs-h-full">

          <div class="dvs-p-8 dvs-bg-grey-lightest dvs-flex dvs-flex-col dvs-justify-between dvs-border-r dvs-border-lighter dvs-min-w-1/3">

            <ul class="list-reset dvs-mb-10 dvs-font-mono dvs-text-sm dvs-tracking-tight">
              <li v-for="directory in directories" class="dvs-cursor-pointer dvs-mt-2 dvs-text-bold" @click="changeDirectories(directory.path)">
                <i class="ion-folder dvs-mr-2"></i>
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
              <button class="dvs-btn dvs-btn-sm" @click="requestCreateDirectory()">Create</button>
            </div>
          </div>
          <div class="dvs-flex-grow dvs-relative dvs-overflow-scroll" :class="{'w-full': directories.length < 1}">

            <!-- Bread Crumbs -->
            <div class="dvs-flex dvs-justify-between dvs-my-4 dvs-items-center dvs-font-mono dvs-text-sm dvs-tracking-tight dvs-px-8 dvs-py-4"  v-if="currentDirectory !== ''">
              <breadcrumbs :currentDirectory="currentDirectory" @chooseDirectory="changeDirectories"></breadcrumbs>
            </div>

            <!-- Delete Directory -->
            <div v-if="files.length < 1 && directories.length < 1" class="dvs-flex dvs-justify-center dvs-items-center dvs-absolute dvs-absolute-center">
              <div class="dvs-bg-white dvs-rounded dvs-p-8 dvs--mt-15 dvs-text-center dvs-shadow dvs-cursor-pointer hover:dvs-bg-blue-dark hover:dvs-text-white" @click="requestDeleteDirectory()">
                <i class="ion-trash-a dvs-text-5xl"></i>
                <h6 class="dvs-mt-2"><span>Delete this directory</span></h6>
              </div>
            </div>

            <!-- Directories but no files -->
            <div v-if="files.length < 1 && directories.length > 1" class="dvs-flex dvs-justify-center dvs-items-center dvs-absolute dvs-absolute-center">
              <div class="dvs-bg-white dvs-rounded dvs-p-8 dvs--mt-15 dvs-text-center dvs-shadow">
                <i class="ion-folder dvs-text-5xl"></i>
                <h6 class="dvs-mt-2"><span>No files in this directory</span></h6>
              </div>
            </div>

            <!-- Files -->
            <ul class="dvs-list-reset"
              :class="{
                'dvs-flex dvs-flex-wrap': !listMode
              }"
             v-else>
              <li v-for="file in files" class="dvs-relative dvs-bg-white dvs-card dvs-p-4 dvs-mt-2 dvs-px`-8"
                :class="{
                  'cursor-pointer': !file.on,
                  'dvs-border-b dvs-border-lighter': listMode
                }"
                @click="openFile(file)">

                <!-- Close File if On -->
                <i class="ion-android-close dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-4 dvs-mr-4 dvs-cursor-pointer" v-if="file.on" @click.stop.prevent="closeFile(file)"></i>

                <!-- Closed File -->
                <div v-if="!file.on">

                  <!-- List Mode -->
                  <div class="dvs-flex dvs-justify-between dvs-items-center" v-if="listMode">
                    <img :src="file.thumb" height="50">
                    <h5>{{ file.name }}</h5>
                    <div class="dvs-rounded-full" :class="{
                      'dvs-bg-green-dark': isActive(file),
                      'dvs-bg-grey': !isActive(file)
                    }" style="height:10px;width:10px;"></div>
                  </div>

                  <!-- Grid Mode -->
                  <div class="dvs-shadow dvs-p-4 dvs-grid-preview" v-else>
                    <div class="dvs-preview" :style="`background-image:url(${file.url})`"></div>
                    <h6>{{ file.name }}</h6>
                  </div>
                </div>

                <!-- Open File -->
                <div v-else class="flex">
                  <!-- List Mode -->
                  <template v-if="listMode">
                    <div class="dvs-w-1/2 dvs-mr-8 dvs-flex dvs-flex-col dvs-justify-between">
                      <a :href="file.url" target="_blank"><img :src="file.url"></a>
                      <i class="ion-trash-a dvs-mt-4 dvs-mr-4 dvs-cursor-pointer dvs-text-xl" v-devise-alert-confirm="{callback: requestDeleteFile, arguments: file, message: 'Are you sure you want to delete this media?'}"></i>
                    </div>
                    <div class="dvs-w-1/2">
                      <h6>Filename</h6>
                      <p>{{ file.name }}</p>

                      <h6 class="dvs-mt-4">Size</h6>
                      <p>{{ file.size }}</p>

                      <p><button @click="selectFile(file)" class="dvs-btn">Select</button></p>

                      <template v-if="isActive(file)">
                        <h6 class="dvs-my-2">Appears On</h6>
                        <ul class="dvs-list-reset">
                          <li v-for="field in file.fields" class="dvs-py-2">
                            <a :href="field.page_slug" target="_blank" class="dvs-btn dvs-btn-sm">{{ field.page_title }} - {{ field.field_name }}</a>
                          </li>
                        </ul>
                      </template>

                    </div>
                  </template>
                  <!-- Grid Mode -->
                  <template v-else>
                    <div class="dvs-w-1/2 dvs-mr-8 dvs-flex dvs-flex-col dvs-justify-between">
                      <a :href="file.url" target="_blank"><img :src="file.url"></a>
                      <i class="ion-trash-a dvs-mt-4 dvs-mr-4 dvs-cursor-pointer dvs-text-xl" v-devise-alert-confirm="{callback: requestDeleteFile, arguments: file, message: 'Are you sure you want to delete this media?'}"></i>
                    </div>
                    <div class="dvs-w-1/2">
                      <h6>Filename</h6>
                      <p>{{ file.name }}</p>

                      <fieldset class="dvs-fieldset">
                        <label>URL</label>
                        <input type="text" :value="file.url">
                      </fieldset>

                      <h6 class="dvs-mt-4">Size</h6>
                      <p>{{ file.size }}</p>

                      <p><button @click="selectFile(file)" class="dvs-btn">Select</button></p>

                      <template v-if="isActive(file)">
                        <h6 class="dvs-my-2">Appears On</h6>
                        <ul class="dvs-list-reset">
                          <li v-for="field in file.fields" class="dvs-py-2">
                            <a :href="field.page_slug" target="_blank" class="dvs-btn dvs-btn-sm">{{ field.page_title }} - {{ field.field_name }}</a>
                          </li>
                        </ul>
                      </template>

                    </div>
                  </template>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  import Loadbar from './../utilities/Loadbar'
  import Breadcrumbs from './Breadcrumbs'
  import vue2Dropzone from 'vue2-dropzone'

  export default {
    data () {
      return {
        show: false,
        loaded: false,
        listMode: true,
        directoryToCreate: '',
        target: null,
        callback: null
      }
    },
    mounted () {
      this.startOpenerListener()
    },
    methods: {
      ...mapActions('devise', [
        'setCurrentDirectory',
        'getCurrentFiles',
        'getCurrentDirectories',
        'openFile',
        'closeFile',
        'deleteFile',
        'createDirectory',
        'deleteDirectory'
      ]),
      startOpenerListener () {
        var self = this

        window.bus.$on('devise-launch-media-manager', function ({target, callback}) {
          self.callback = callback
          self.target = target
          self.changeDirectories('')
          self.show = true
        })
      },
      changeDirectories (directory) {
        let self = this
        self.loaded = false

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
        window.bus.$emit('showMessage', {title: 'Upload Complete', message: 'Your upload has been successfully completed'})
        this.changeDirectories(this.currentDirectory)
      },
      uploadError (file, message) {
        window.bus.$emit('showError', {title: 'Upload Error', message: 'There was a problem uploading your file. Either the file was too large or it has been uploaded too many times.'})
      },
      getUrlParam (paramName) {
        var reParam = new RegExp('(?:[?&]|&)' + paramName + '=([^&]+)', 'i')
        var match = window.location.search.match(reParam)

        return (match && match.length > 1) ? match[1] : null
      },
      selectFile (file) {
        if (this.target) {
          this.target.value = file.url
        }

        if (this.callback) {
          this.callback(file)
        }

        this.show = false
      },
      requestDeleteFile (file) {
        if (this.isActive(file)) {
          if (window.confirm('This file is associated with fields on the site. Are you 100% positive you want to delete it?')) {
            this.confirmedDeleteFile(file)
          }
        } else {
          this.confirmedDeleteFile(file)
        }
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
          window.bus.$emit('showError', {title: 'Duplicate Name', message: 'There was already a directory with this name created in the current location.'})
        }
      },
      requestDeleteDirectory () {
        var self = this
        this.deleteDirectory(self.currentDirectory).then(function () {
          self.changeDirectories('')
        })
      }
    },
    computed: {
      ...mapGetters('devise', [
        'files',
        'directories',
        'currentDirectory'
      ]),
      dropzoneOptions () {
        return {
          url: '/api/devise/media?directory=' + this.currentDirectory,
          dictDefaultMessage: "<span class='dvs-cursor-pointer'><i class='ion-android-attach'></i> Upload</span>",
          method: 'post',
          createImageThumbnails: false,
          headers: {
            'X-XSRF-TOKEN': window.csrfToken
          }
        }
      }
    },
    components: {
      'loadbar': Loadbar,
      'breadcrumbs': Breadcrumbs,
      vueDropzone: vue2Dropzone
    }
  }
</script>
