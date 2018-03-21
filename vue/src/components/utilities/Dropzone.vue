<template>
    <div>
      <form class="dropzone compact" :id="id">
        <div class="dz-message"><i class="icon ion-document-text"></i> <i class="icon ion-plus-round"></i> <i class="icon ion-image"></i> <span class="message"><slot></slot></span></div>
      </form>

      <div class="dz-preview" id="preview-template">
        <div class="dz-image"></div>
        <div class="dz-details">
          <img data-dz-thumbnail />
          <div class="dz-size" data-dz-size></div>
        </div>
        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
        <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
        <div class="dz-success-mark">
          <span><i class="icon ion-android-checkmark-circle"></i></span>
        </div>
        <div class="dz-error-mark">
          <span><i class="icon ion-android-close"></i></span>
        </div>
      </div>
    </div>
</template>

<script>
import eventbus from '../../event-bus/event-bus'
import Dropzone from 'Dropzone'
import { mapGetters, mapMutations } from 'vuex'

export default {
  data () {
    return {
      dropzoneInstance: null,
      resetTimer: null
    }
  },
  mounted: function () {
    this.initDropzone()
  },
  computed: {
    ...mapGetters([
      'accessToken',
      'tradeConnection'
    ])
  },
  methods: {
    ...mapMutations([
      'processNewAttachments'
    ]),
    initDropzone: function () {
      var self = this
      // var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      var theUrl = this.buildUrl()

      self.$nextTick(function () {
        var el = document.getElementById(self.id)
        var initialized = this.hasClass(el, 'dz-clickable')

        if (!initialized) {
          self.dropzoneInstance = new Dropzone(
            '#' + self.id,
            {
              // previewTemplate: Dom('#preview-template').html(),
              init: function () {
                this.on('sending', function (file, xhr, formData) {
                  console.log('sending')
                })
                this.on('complete', function (file) {
                  if (self.completeEvent !== '') {
                    eventbus.$emit(self.completeEvent, JSON.parse(file.xhr.response))
                  }
                  self.$emit('complete', JSON.parse(file.xhr.response))
                  self.dropzoneInstance.removeFile(file)
                })
                this.on('processing', function (file) {
                  console.log('processing')
                  if (self.url !== '' && typeof self.url !== 'undefined') {
                    this.options.url = self.url
                  }
                })
              },
              method: 'post',
              url: theUrl,
              autoProcessQueue: self.autoProcessQueue,
              addRemoveLinks: !self.autoProcessQueue,
              dictRemoveFile: 'x',
              headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + self.accessToken,
                'TradeConnection': self.tradeConnection
              }
            }
          )

          self.initAddFileEvents()
          self.initCompleteEvents()
        }
      })
    },
    initAddFileEvents: function () {
      var self = this

      self.dropzoneInstance.on('addedfile', function (file) {
        file.previewElement.addEventListener('click', function () {
          self.dropzoneInstance.removeFile(file)
        })
      })
    },
    initCompleteEvents: function () {
      var self = this

      if (self.disappear === 'true') {
        self.dropzoneInstance.on('complete', function (file) {
          setTimeout(function () {
            self.dropzoneInstance.removeFile(file)
          }, 5000)
        })
      }
    },
    buildUrl: function () {
      if (this.autoProcessQueue && this.autoProcessUrl !== null) {
        return this.autoProcessUrl
      } else {
        return 'thisurlshouldbereplaced'
      }
    },
    hasClass: function (element, cls) {
      return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1
    }
  },
  props: {
    'disappear': {
      type: Boolean,
      default: true
    },
    'id': {
      type: String,
      required: true
    },
    'autoProcessQueue': {
      type: Boolean,
      default: true
    },
    'autoProcessUrl': {
      type: String,
      default: null
    },
    'completeEvent': {
      type: String,
      default: ''
    }
  },
  watch: {
    'url': function (newValue, oldValue) {
      if (newValue !== '') {
        this.dropzoneInstance.processQueue()
        this.processNewAttachments('')
      }
    }
  }
}
</script>
