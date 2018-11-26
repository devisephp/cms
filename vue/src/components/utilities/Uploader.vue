<template>
  <div>
    <div  v-show="$refs.upload && $refs.upload.dropActive" class="dvs-fixed dvs-pin" style="z-index:9999">
      <div class="dvs-blocker"></div>
      <div class=" dvs-flex dvs-justify-center dvs-items-center dvs-relative" style="z-index:9999">
        <div class="dvs-bg-black dvs-p-8 dvs-rounded dvs-shadow">
          <h3 class="dvs-text-abs-white">Drop files to upload</h3>
        </div>
      </div>
    </div>

    <div class="dvs-m-4 dvs-flex">
      <vue-upload
        ref="upload"
        class="dvs-w-full dvs-bg-abs-white dvs-p-4 dvs-shadow dvs-rounded-sm"
        v-model="uploadingFiles"
        :post-action="`/api/devise/media?directory=${this.currentDirectory}`"
        :headers="uploadHeaders"
        :drop="true"
        :multiple="true"
        @input-file="inputFile"
        @input-filter="inputFilter"
      >Upload New Files</vue-upload>
    </div>

    <div v-show="uploadingFiles.length" class="dvs-w-full ">
      <h6 class="dvs-ml-4">Queued Files for Upload</h6>
      <table class="dvs-m-4 dvs-border-collapse dvs-w-full">
        <tr class="dvs-border-b-2">
          <th class="dvs-p-2">File</th>
        </tr>
        <tr v-for="file in uploadingFiles" :key="file.id" class="dvs-border-b">
          <td class="dvs-p-4">
            <div class="dvs-flex">
              <div class="dvs-bg-cover dvs-bg-center" :style="`width:40px;height:40px;background-image:url(${file.thumb})`">
                <span v-if="!file.thumb">No Image</span>
              </div>
              <div class="dvs-ml-4">
                {{ file.name }}
              </div>
            </div>
          </td>
        </tr>
      </table>
      <button v-show="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.active = true" type="button" class="dvs-btn dvs-ml-2" :style="theme.actionButton">Start upload</button>
      <button v-show="$refs.upload && $refs.upload.active" @click.prevent="$refs.upload.active = false" type="button">Stop upload</button>
    </div>
  </div>
</template>

<script>

const VueUpload = require('vue-upload-component')

export default {
  data () {
    return {
      uploadingFiles: []
    }
  },
  methods: {
    /**
     * Has changed
     * @param  Object|undefined   newFile   Read only
     * @param  Object|undefined   oldFile   Read only
     * @return undefined
     */
    inputFile: function (newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        console.log('response', newFile.response)
        if (newFile.xhr) {
          //  Get the response status code
          console.log('status', newFile.xhr.status)
        }
      }
    },
    /**
     * Pretreatment
     * @param  Object|undefined   newFile   Read and write
     * @param  Object|undefined   oldFile   Read only
     * @param  Function           prevent   Prevent changing
     * @return undefined
     */
    inputFilter: function (newFile, oldFile, prevent) {
      // Create a blob field
      newFile.blob = ''
      let URL = window.URL || window.webkitURL
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file)
      }

      // Thumbnails
      newFile.thumb = ''
      if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
        newFile.thumb = newFile.blob
      }
    }
  },
  computed: {
    uploadHeaders () {
      let token = document.head.querySelector('meta[name="csrf-token"]')
      return {
        'X-CSRF-TOKEN': token.content
      }
    }
  },
  components: {
    VueUpload
  }
}
</script>
