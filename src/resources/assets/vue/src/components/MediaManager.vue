<style lang="scss" scoped>
  @import "./../sass/app.scss";
</style>

<template>
  <div class="text-ptext min-h-screen">
    <div v-if="!loaded" class="absolute absolute-center w-1/2">
      <loadbar :load-percentage=".5"></loadbar>
    </div>
    <div v-else class="min-h-screen">
      <div class="bg-lighter text-light py-4 px-8 flex justify-between items-center">
        Media Manager

        <vue-dropzone
            ref="myVueDropzone"
            id="dropzone"
            @vdropzone-success="uploadSuccess()"
            @vdropzone-error="uploadError"
            class="pl-4"
            includeStyling: false
            :options="dropzoneOptions" />
      </div>

      <div class="flex items-stretch min-h-screen">

        <div class="bg-lighter mt-1 p-8 w-1/4" v-if="directories.length > 0">

          <ul class="list-reset">
            <li v-for="directory in directories" class="cursor-pointer mt-2 text-bold text-white" @click="changeDirectories(directory.path)">
              {{ directory.name }}
            </li>
          </ul>
        </div>
        <div class=" w-3/4 mx-8" :class="{'w-full': directories.length < 1}">

          <div class="flex justify-between my-4 items-center">
            <breadcrumbs :currentDirectory="currentDirectory" @chooseDirectory="changeDirectories"></breadcrumbs>

            <div class="flex">
              <input type="text" placeholder="New Directory" v-model="directoryToCreate" class="mr-2">
              <button class="btn" @click="requestCreateDirectory()">Create</button>
            </div>
          </div>

          <div v-if="files.length < 1 && directories.length < 1" class="flex justify-center items-center min-h-screen">
            <div class="bg-lighter rounded p-8 -mt-15 text-center shadow-lg cursor-pointer" @click="requestDeleteDirectory()">
              <i class="ion-trash-a text-5xl"></i>
              <h6 class="mt-2"><span class="text-ptext">Delete this directory</span></h6>
            </div>
          </div>

          <ul class="list-reset" v-else>
            <li v-for="file in files" class="relative bg-light text-darker card p-4 mt-2 w-full" :class="{'cursor-pointer': !file.on}" @click="openFile(file)">
              <i class="ion-android-close absolute pin-t pin-r mt-4 mr-4 cursor-pointer" v-if="file.on" @click.stop.prevent="closeFile(file)"></i>

              <div v-if="!file.on" class="flex justify-between items-center">
                <img :src="file.thumb" height="50">
                <h5>{{ file.name }}</h5>
                <div class="rounded-full" :class="{
                  'bg-action-light': isActive(file),
                  'bg-darker': !isActive(file)
                }" style="height:10px;width:10px;"></div>
              </div>
              <div v-else class="flex">
                <div class="w-1/2 mr-8 flex flex-col justify-between">
                  <a :href="file.url" target="_blank"><img :src="file.url"></a>
                  <i class="ion-trash-a mt-4 mr-4 cursor-pointer text-xl" @click.stop.prevent="requestDeleteFile(file)"></i>
                </div>
                <div class="w-1/2">
                  <h6 class="text-darker">Filename</h6>
                  <p class="text-darker">{{ file.name }}</p>

                  <h6 class="mt-4 text-darker">Size</h6>
                  <p class="text-darker">{{ file.size }}</p>

                  <p><button @click="selectFile(file)" class="btn action">Select</button></p>

                  <template v-if="isActive(file)">
                    <h6 class="my-2">Appears On</h6>
                    <ul class="list-reset">
                      <li v-for="field in file.fields" class="py-2">
                        <a :href="field.page_slug" target="_blank" class="btn btn-sm">{{ field.page_title }} - {{ field.field_name }}</a>
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
  </div>
</template>

<script>
  import eventbus from './../event-bus/event-bus'
  import { mapGetters, mapActions } from 'vuex'

  import Loadbar from './Loadbar'
  import Breadcrumbs from './Breadcrumbs'
  import vue2Dropzone from 'vue2-dropzone'

  export default {
    data () {
      return {
        loaded: false,
        directoryToCreate: ''
      }
    },
    mounted () {
      this.changeDirectories('')
      this.startOpenerListener()
    },
    methods: {
      ...mapActions([
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
        if (
          opener &&
          opener.document &&
          (!opener.document.hasOwnProperty('onMediaManagerSelect') ||
          opener.document.onMediaManagerSelect == null)
        ) {
          opener.document.onMediaManagerSelect = function (images) {
            var funcNum = self.getUrlParam('CKEditorFuncNum')
            var fileUrl = images
            window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl)

            opener.document.onMediaManagerSelect = null // Let's null it out for the next guy

            window.close()
          }
        }
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
        return file.fields.length > 0 || file.global_fields.length > 0
      },
      uploadSuccess () {
        eventbus.$emit('showMessage', {title: 'Upload Complete', message: 'Your upload has been successfully completed'})
        this.changeDirectories(this.currentDirectory)
      },
      uploadError (file, message) {
        eventbus.$emit('showError', {title: 'Upload Error', message: 'There was a problem uploading your file. Either the file was too large or it has been uploaded too many times.'})
      },
      getUrlParam (paramName) {
        var reParam = new RegExp('(?:[?&]|&)' + paramName + '=([^&]+)', 'i')
        var match = window.location.search.match(reParam)

        return (match && match.length > 1) ? match[1] : null
      },
      selectFile (file) {
        var target = null
        var url = file.url

        opener.document.onMediaManagerSelect(url, target, window.input)

        window.close()
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
          eventbus.$emit('showMessage', {title: 'File Deleted', message: 'The file was successfully deleted from the server.'})
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
            eventbus.$emit('showMessage', {title: 'Directory Created', message: 'The directory was successfully created.'})
            self.changeDirectories(self.currentDirectory)
            self.directoryToCreate = ''
          })
        } else {
          eventbus.$emit('showError', {title: 'Duplicate Name', message: 'There was already a directory with this name created in the current location.'})
        }
      },
      requestDeleteDirectory () {
        var self = this
        this.deleteDirectory(self.currentDirectory).then(function () {
          eventbus.$emit('showMessage', {title: 'Directory Deleted', message: 'The directory was successfully deleted from the server.'})
          self.changeDirectories('')
        })
      }
    },
    computed: {
      ...mapGetters([
        'files',
        'directories',
        'currentDirectory'
      ]),
      dropzoneOptions () {
        return {
          url: '/admin/media-manager/upload?directory=' + this.currentDirectory,
          dictDefaultMessage: "<i class='ion-android-attach'></i>",
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
