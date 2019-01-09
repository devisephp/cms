<template>
  <div class="media-manager-interface">
    <div
      class="dvs-py-4 dvs-px-8 dvs-rounded-tl dvs-rounded-tr dvs-flex dvs-justify-between dvs-items-center dvs-bg-grey-lighter dvs-border-b dvs-border-lighter dvs-relative"
    >Media Editor
      <div>
        <button
          class="dvs-btn"
          @click="done"
          :disabled="!allImagesLoaded"
          :style="theme.actionButton"
        >Done</button>
        <button class="dvs-btn" @click="cancel" :style="theme.actionButtonGhost">Cancel</button>
      </div>
    </div>
    <div class="dvs-flex dvs-items-stretch dvs-h-full">
      <div class="dvs-min-w-1/3 dvs-border-r dvs-border-lighter dvs-bg-grey-light" data-simplebar>
        <div class="dvs-h-full dvs-p-8 dvs-flex dvs-flex-col dvs-justify-between">
          <h3 class="dvs-mb-4">Image Edits</h3>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Crop / Fitting</label>
            <select v-model="edits.fit">
              <option :label="null">None</option>
              <option value="crop">Contain</option>
              <option value="max">Best Fit</option>
              <option value="fill">Fill</option>
              <option value="stretch">Stretch</option>
              <option value="crop">Crop Center</option>
              <option value="crop-left">Crop Center Left</option>
              <option value="crop-right">Crop Center Right</option>
              <option value="crop-top">Crop Top</option>
              <option value="crop-top-left">Crop Top Left</option>
              <option value="crop-top-right">Crop Top Right</option>
              <option value="crop-bottom">Crop Bottom</option>
              <option value="crop-bottom-left">Crop Bottom Left</option>
              <option value="crop-bottom-right">Crop Bottom Right</option>
            </select>
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Quality</label>
            <div class="dvs-flex">
              <input
                type="range"
                @dblclick="edits.q = null"
                v-model="edits.q"
                min="0"
                max="100"
                step="5"
              >
              <div class="dvs-font-bold dvs-text-xs dvs-pl-2">{{ edits.q }}</div>
            </div>
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Sharpen</label>
            <div class="dvs-flex">
              <input
                type="range"
                @dblclick="edits.sharp = null"
                v-model="edits.sharp"
                min="0"
                max="100"
                step="1"
              >
              <div class="dvs-font-bold dvs-text-xs dvs-pl-2">{{ edits.sharp }}</div>
            </div>
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mb-4" v-if="edits.fit === 'fill'">
            <label>Background Color</label>
            <sketch-picker v-model="editorColor" @cancel="edits.bg = null"/>
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Rotation</label>
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
              <input
                type="range"
                @dblclick="edits.bri = null"
                v-model="edits.bri"
                min="-100"
                max="100"
                step="1"
              >
              <div class="dvs-font-bold dvs-text-xs dvs-pl-2">{{ edits.bri }}</div>
            </div>
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Contrast</label>
            <div class="dvs-flex">
              <input
                type="range"
                @dblclick="edits.con = null"
                v-model="edits.con"
                min="-100"
                max="100"
                step="1"
              >
              <div class="dvs-font-bold dvs-text-xs dvs-pl-2">{{ edits.con }}</div>
            </div>
          </fieldset>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Gamma</label>
            <div class="dvs-flex">
              <input
                type="range"
                @dblclick="edits.gam = null"
                v-model="edits.gam"
                min="0.1"
                max="9.99"
                step="0.01"
              >
              <div class="dvs-font-bold dvs-text-xs dvs-pl-2">{{ edits.gam }}</div>
            </div>
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Pixelate</label>
            <div class="dvs-flex">
              <input
                type="range"
                @dblclick="edits.pixel = null"
                v-model="edits.pixel"
                min="0"
                max="20"
                step="1"
              >
              <div class="dvs-font-bold dvs-text-xs dvs-pl-2">{{ edits.pixel }}</div>
            </div>
          </fieldset>
        </div>
      </div>

      <div class="dvs-flex-grow dvs-relative dvs-overflow-y-scroll">
        <div class="dvs-p-8 dvs-border-l dvs-border-grey-lighter">
          <template v-if="sizes">
            <h3 class="dvs-mb-4">Images</h3>

            <h6 class="dvs-mb-4">Original Image</h6>
            <img :src="`/styled/preview/${source}`" @load="addToImagesLoaded">
            <hr class="my-4">
            <div v-for="(size, key) in sizes" :key="key" class="mb-8">
              <h6 class="dvs-mb-4">{{ key }} ({{ size.w }}x{{ size.h }})</h6>
              <img
                :src="`/styled/preview/${source}?${encodedEdits}${encodedSize(size)}`"
                @load="addToImagesLoaded"
              >
            </div>
          </template>

          <template v-else>
            <h3 class="dvs-mb-4">Image</h3>

            <help
              class="dvs-mb-4"
              v-if="!customSize.w || !customSize.h"
            >Please provide a width and height for this image</help>

            <div class="dvs-flex dvs-mb-8 dvs-items-center">
              <fieldset class="dvs-fieldset dvs-mr-4">
                <label>Width</label>
                <input type="number" v-model="customSize.w">
              </fieldset>
              <fieldset class="dvs-fieldset dvs-mr-4">
                <label>Height</label>
                <input type="number" v-model="customSize.h">
              </fieldset>
              <fieldset>
                <button
                  class="btn btn-sm"
                  :style="theme.actionButton"
                  @click="setCustomSizeToOriginal"
                >Original Dimensions</button>
              </fieldset>
            </div>
            <img
              v-if="customSize.w && customSize.h"
              :src="`/styled/preview/${source}?${encodedEdits}${encodedSize(customSize)}`"
              @load="addToImagesLoaded"
            >
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
var tinycolor = require('tinycolor2');
import { Sketch } from 'vue-color';

export default {
  data() {
    return {
      imagesLoaded: 0,
      edits: {
        q: 90,
        or: null,
        flip: null,
        fit: 'crop',
        bri: null,
        con: null,
        gam: null,
        sharp: 5,
        pixel: null,
        filt: null,
        bg: null
      },
      customSize: {
        w: null,
        h: null
      },
      originalDims: {
        w: null,
        h: null
      }
    };
  },
  mounted() {
    this.imagesLoaded = 0;
    this.loadOriginalDimentions();
  },
  methods: {
    done() {
      let edits = Object.assign({}, this.edits);
      var cleanEdits = this.clean(edits);
      this.$emit('done', cleanEdits);
    },
    cancel() {
      this.$emit('cancel');
    },
    loadOriginalDimentions() {
      let file = `/styled/preview/${this.source}`;
      let self = this;
      let img = new Image();

      img.onload = function() {
        self.originalDims.w = this.width;
        self.originalDims.h = this.height;

        self.setCustomSizeToOriginal();
      };

      img.onerror = function() {
        alert('not a valid file: ' + file.type);
      };

      img.src = file;
    },
    addToImagesLoaded(something) {
      this.imagesLoaded++;
    },
    setCustomSizeToOriginal() {
      this.customSize.w = this.originalDims.w;
      this.customSize.h = this.originalDims.h;
    },
    encodedSize(size) {
      var encodedString = '';
      if (this.encodedEdits.length > 0) {
        encodedString += '&';
      }

      return `${encodedString}w=${size.w}&h=${size.h}`;
    },
    clean(obj) {
      for (var propName in obj) {
        if (obj[propName] === null || obj[propName] === undefined) {
          delete obj[propName];
        } else if (propName === 'bg') {
          obj[propName] = obj[propName].substring(1);
        }
      }

      if (this.customSize.w && this.customSize.h) {
        obj.w = this.customSize.w;
        obj.h = this.customSize.h;
      }

      return obj;
    }
  },
  computed: {
    editorColor: {
      get() {
        if (this.edits.bg === null) {
          return '#ffffff';
        }
        return tinycolor(this.edits.bg).toRgb();
      },
      set(newValue) {
        this.edits.bg = newValue.hex;
      }
    },
    encodedEdits() {
      var encodedString = '';

      for (var property in this.edits) {
        if (this.edits[property] !== null) {
          if (encodedString !== '') {
            encodedString += '&';
          }

          var propertyValue = this.edits[property];

          // Chop off the hash for Glide
          if (property === 'bg') {
            propertyValue = propertyValue.substring(1);
          }

          encodedString += `${property}=${propertyValue}`;
        }
      }

      return encodedString;
    },
    allImagesLoaded() {
      let numberOfImages = this.imagesRequiredToLoad;
      if (this.imagesLoaded >= numberOfImages) {
        return true;
      }
      return false;
    },
    imagesRequiredToLoad() {
      if (this.sizes) {
        return Object.keys(this.sizes).length + 1;
      }

      return 1;
    }
  },
  props: {
    source: {
      type: String,
      required: true
    },
    sizes: {
      type: Object,
      required: false
    }
  },
  components: {
    'sketch-picker': Sketch
  }
};
</script>
