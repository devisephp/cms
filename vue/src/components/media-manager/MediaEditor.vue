<template>
  <div class="dvs-min-h-screen dvs-fixed dvs-pin dvs-z-60 dvs-text-grey-darker dvs-flex dvs-items-center dvs-justify-center" :class="{'dvs-pointer-events-none': !show}" v-if="show">
    <div class="dvs-blocker dvs-z-30" @click="show = false"></div>

    <div class="dvs-z-40 dvs-relative dvs-bg-white dvs-rounded dvs-flex dvs-shadow-lg">
      <div class="dvs-p-8">
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Format</label>
          <select v-model="edits.fm">
            <option :value="null">No Change</option>
            <option value="90">90&deg; Counter Clockwise</option>
          </select>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Rotate</label>
          <select v-model="edits.or">
            <option :value="null">No Rotation</option>
            <option value="90">90&deg; Counter Clockwise</option>
            <option value="180">180&deg;</option>
            <option value="270">270&deg; Counter Clockwise</option>
            <option value="auto">Auto (Reads EXIF Data)</option>
          </select>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Flip</label>
          <select v-model="edits.flip">
            <option :value="null">No Flip</option>
            <option value="v">Vertical</option>
            <option value="h">Horizontal</option>
            <option value="both">Vertical &amp; Horizontal</option>
          </select>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Crop</label>
          <select v-model="edits.fit">
            <option :value="null">No Crop</option>
            <option value="crop">Crop Center</option>
            <option value="crop-top-left">Crop Top Left</option>
            <option value="crop-top">Crop Top</option>
            <option value="crop-top-right">Crop Top Right</option>
            <option value="crop-left">Crop Center Left</option>
            <option value="crop-right">Crop Center Right</option>
            <option value="crop-bottom-left">Crop Bottom Left</option>
            <option value="crop-bottom">Crop Bottom</option>
            <option value="crop-bottom-right">Crop Bottom Right</option>
          </select>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Effects</label>
          <select v-model="edits.filt">
            <option :value="null">No Effect</option>
            <option value="greyscale">Greyscale</option>
            <option value="sepia">Sepia</option>
          </select>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Brightness</label>
          <div class="dvs-flex">
            <input type="range" @dblclick="edits.bri = null" v-model="edits.bri" min="-100" max="100" step="1">
            <div class="dvs-font-bold dvs-text-xs dvs-pl-2">
              {{ edits.bri }}
            </div>
          </div>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Contrast</label>
          <div class="dvs-flex">
            <input type="range" @dblclick="edits.con = null" v-model="edits.con" min="-100" max="100" step="1">
            <div class="dvs-font-bold dvs-text-xs dvs-pl-2">
              {{ edits.con }}
            </div>
          </div>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Gamma</label>
          <div class="dvs-flex">
            <input type="range" @dblclick="edits.gam = null" v-model="edits.gam" min="0.1" max="9.99" step="0.01">
            <div class="dvs-font-bold dvs-text-xs dvs-pl-2">
              {{ edits.gam }}
            </div>
          </div>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Sharpen</label>
          <div class="dvs-flex">
            <input type="range" @dblclick="edits.sharp = null" v-model="edits.sharp" min="0" max="100" step="1">
            <div class="dvs-font-bold dvs-text-xs dvs-pl-2">
              {{ edits.sharp }}
            </div>
          </div>
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Pixelate</label>
          <div class="dvs-flex">
            <input type="range" @dblclick="edits.pixel = null" v-model="edits.pixel" min="0" max="20" step="1">
            <div class="dvs-font-bold dvs-text-xs dvs-pl-2">
              {{ edits.pixel }}
            </div>
          </div>
        </fieldset>
      </div>
      <div class="dvs-p-8 dvs-border-l dvs-border-grey-lighter">
        <img :src="`styled/preview/${source}?${encodedEdits}`">
      </div>
    </div>
  </div>  
</template>

<script>
export default {
  data () {
    return {
      show: false,
      source: null,
      callback: null,
      target: null,
      edits: {
        or: null,
        flip: null,
        fit: null,
        bri: null,
        con: null,
        gam: null,
        sharp: null,
        pixel: null,
        filt: null,
      }
    }
  },
  mounted () {
    this.startOpenerListener()
  },
  methods: {
    startOpenerListener () {
      var self = this

      deviseSettings.$bus.$on('devise-launch-media-editor', function ({source, target, callback}) {
        self.source = source
        self.callback = callback
        self.target = target
        self.show = true
      })
    },
  },
  computed: {
    encodedEdits () {
      var encodedString = ''
      
      for (var editProperty in this.edits) {
        if (this.edits[editProperty] !== null) {
          if (encodedString !== '') {
            encodedString += '&'
          }

          encodedString += `${editProperty}=${this.edits[editProperty]}`
        }
      }

      return encodedString
    }
  }
}
</script>
