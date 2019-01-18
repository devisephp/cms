<template>
  <div class="dvs-bg-white dvs-text-black dvs-relative">
    <div
      v-if="imageToManage !== null"
      class="dvs-absolute dvs-absolute-center dvs-shadow-lg dvs-p-8 dvs-rounded dvs-z-50 dvs-bg-white"
    >
      <h4 class="dvs-pb-4">Image Positioning:</h4>

      <div class="dvs-flex dvs-mb-4">
        <button
          class="dvs-btn dvs-mr-2"
          :style="theme.actionButton"
          @click="setImageFloat('left')"
        >Float Left</button>
        <button
          class="dvs-btn dvs-mr-2"
          :style="theme.actionButton"
          @click="setImageFloat('')"
        >No Float</button>
        <button
          class="dvs-btn dvs-mr-2"
          :style="theme.actionButton"
          @click="setImageFloat('right')"
        >Float Right</button>
      </div>

      <div class="dvs-mb-4">
        <fieldset class="dvs-fieldset">
          <label>Margin</label>
          <input type="number" ref="marginsetting" min="0" max="200" @keyup="setImageMargin">
        </fieldset>
      </div>

      <div class="dvs-pb-8">
        <fieldset class="dvs-fieldset">
          <button class="dvs-btn" :style="theme.actionButton" @click="doneEditingImageStyles">Done</button>
        </fieldset>
      </div>

      <h4 class="dvs-pb-4">Remove Image:</h4>

      <div>
        <fieldset class="dvs-fieldset">
          <button class="dvs-btn" :style="theme.actionButton" @click="removeImage">Remove Image</button>
        </fieldset>
      </div>
    </div>
    <div class="dvs-blocker dvs-z-20" v-if="imageToManage !== null" @click="imageToManage = null"></div>
    <trumbowyg
      class="dvs-relative dvs-z-10"
      ref="theEditor"
      v-model="localValue"
      :config="config"
      :svg-path="'/devise/icons/icons.svg'"
      @tbw-change="update"
      @tbw-paste="update"
      @tbw-blur="update"
    ></trumbowyg>
  </div>
</template>

<script>
import mezr from 'mezr';
import Table from 'trumbowyg/dist/plugins/table/trumbowyg.table.min.js';

// Import editor cs
import 'trumbowyg/dist/ui/icons.svg';
import 'trumbowyg/dist/ui/trumbowyg.css';
import 'trumbowyg/dist/plugins/table/ui/trumbowyg.table.css';
import Trumbowyg from 'vue-trumbowyg';
import Strings from './../../mixins/Strings';

export default {
  name: 'Wysiwyg',
  data() {
    return {
      theEditor: null,
      imageToManage: null,
      localValue: '',
      scrollEvent: null,
      buttonPane: null,
      config: {
        btns: [
          ['viewHTML'],
          ['strong', 'em', 'del'],
          ['unorderedList', 'orderedList'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['deviseImage', 'link'],
          ['formatting'],
          ['removeformat'],
          ['table'],
          ['floats'],
          ['undo', 'redo']
        ],
        autogrow: true,
        btnsDef: {
          deviseImage: {
            fn: this.launchMediaManager,
            tag: 'mediamanager',
            title: 'Media Manager',
            text: 'Media Manager',
            isSupported: function() {
              return true;
            },
            key: 'M',
            param: '',
            forceCSS: true,
            ico: 'insert-image',
            hasIcon: true
          }
        },
        imageWidthModalEdit: false,
        imgDblClickHandler: this.imageManager
      },
      plugins: {
        table: {
          rows: 8,
          columns: 8,
          styler: 'table'
        }
      }
    };
  },
  mounted() {
    this.localValue = this.value;
    this.theEditor = this.$refs.theEditor;

    this.$nextTick(() => {
      let fieldPanel = document.querySelector('#field-panel');

      if (fieldPanel) {
        let container = fieldPanel.querySelector('.simplebar-scroll-content');
        this.buttonPane = fieldPanel.querySelector('.trumbowyg-button-pane');

        if (container) {
          container.addEventListener('scroll', () => {
            if (!this.checkInView()) {
              this.buttonPane.style.position = 'fixed';
              this.buttonPane.style.maxWidth = '300px';
              this.buttonPane.style.right = '3em';
              this.buttonPane.style.borderRadius = '3px';
            } else {
              this.buttonPane.style.position = 'relative';
              this.buttonPane.style.maxWidth = 'none';
              this.buttonPane.style.right = 'auto';
              this.buttonPane.style.borderRadius = '0';
            }
          });
        }
      }
    });
  },
  methods: {
    launchMediaManager(event) {
      devise.$bus.$emit('devise-launch-media-manager', {
        callback: this.mediaSelected
      });
    },
    mediaSelected(imagesAndSettings) {
      if (typeof imagesAndSettings === 'object') {
        let html = this.theEditor.el.trumbowyg('html');
        this.theEditor.el.trumbowyg(
          'html',
          `${html}<img src="${imagesAndSettings.images.orig_optimized}" width="${
            imagesAndSettings.settings.w
          }" height="${imagesAndSettings.settings.h}">`
        );
      }
    },
    update() {
      this.localValue = this.theEditor.el.trumbowyg('html');
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    setHtml(html) {
      this.localValue = html;
      this.theEditor.el.trumbowyg('html', html);
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    empty() {
      this.localValue = '';
      this.theEditor.el.trumbowyg('empty');
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    },
    imageManager(image) {
      this.imageToManage = image;
      this.$nextTick(() => {
        this.$refs.marginsetting.value = this.imageToManage.currentTarget.style.margin.slice(0, -2);
      });
    },
    setImageFloat(direction) {
      this.imageToManage.currentTarget.style.float = direction;
      this.localValue = this.theEditor.el.trumbowyg('html');
      this.updateAndCloseImageEditor();
    },
    setImageMargin(evt) {
      this.imageToManage.currentTarget.style.margin = `${evt.target.value}px`;
    },
    doneEditingImageStyles() {
      this.localValue = this.theEditor.el.trumbowyg('html');
      this.updateAndCloseImageEditor();
    },
    removeImage() {
      let newHTML = this.theEditor.el
        .trumbowyg('html')
        .replace(this.imageToManage.currentTarget.outerHTML, '');
      this.theEditor.el.trumbowyg('html', newHTML);
      this.localValue = this.theEditor.el.trumbowyg('html');
      this.updateAndCloseImageEditor();
    },
    updateAndCloseImageEditor() {
      this.imageToManage = null;
      this.theEditor.el.trumbowyg('toggle');
      this.theEditor.el.trumbowyg('toggle');
      this.update();
    },
    checkInView() {
      let fieldPanel = document.querySelector('#field-panel');
      let container = fieldPanel.querySelector('.simplebar-scroll-content');
      let contTop = container.scrollTop;

      return contTop < 100;
    }
  },
  components: {
    Trumbowyg
  },
  mixins: [Strings],
  props: ['id', 'value']
};
</script>
