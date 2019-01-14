<template>
  <div class="dvs-mb-8">
    <div class="dvs-flex dvs-items-center dvs-mb-4">
      <h3 :style="{color: theme.panel.color}">{{ labelText }}</h3>
      <div @click="showMediaManager">
        <images-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px"/>
      </div>
    </div>

    <div class="dvs-flex dvs-flex-wrap">
      <div
        class="dvs-w-1/5 dvs-max-w-1/4 dvs-pr-4 dvs-pb-4"
        v-for="(image, key) in images"
        :key="key"
      >
        <div
          class="dvs-p-4 dvs-bg-grey-lighter dvs-text-xs dvs-overflow-hidden"
          :style="theme.panelCard"
        >
          <div @click="loadPreview(image)">
            <search-icon class="dvs-cursor-pointer" w="30px" h="30px"/>
          </div>
          <p class="dvs-mt-2">
            {{ getName(image) }}
            <br>
            <a href="#" @click.prevent="removeImage(key)">Remove</a>
          </p>
        </div>
      </div>
    </div>

    <help v-if="value.length === 0">
      <p>No images found. Add images using the button above.</p>
    </help>

    <div v-if="showPreview">
      <portal to="devise-root">
        <div
          class="dvs-blocker"
          :style="{backgroundColor: 'transparent'}"
          @click="showPreview = false"
        ></div>
        <div
          v-for="(image, key) in images"
          :key="key"
          class="dvs-modal dvs-fixed dvs-pin-b dvs-pin-r dvs-mx-8 dvs-mb-8 dvs-z-40 dvs-w-1/2"
          :style="theme.panel"
        >
          <img :src="previewImagePath">
          <h6 class="dvs-text-base dvs-mb-4 dvs-mt-4">
            <span>{{ previewImageName }}</span>
            <br>
            <small class="dvs-text-xs">
              Location:
              <span class="dvs-italic dvs-font-normal">{{ previewImagePath }}</span>
            </small>
          </h6>
          <div class="dvs-flex dvs-items-center dvs-mt-4 dvs-justify-between">
            <div>
              <button
                class="dvs-btn dvs-mr-2"
                @click="showPreview = false"
                :style="theme.actionButtonGhost"
              >Close</button>
            </div>
          </div>
        </div>
      </portal>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'ImagesField',
  data() {
    return {
      showPreview: false,
      previewImageName: '',
      previewImagePath: ''
    };
  },
  methods: {
    showMediaManager(event) {
      devise.$bus.$emit('devise-launch-media-manager', {
        callback: this.mediaSelected
      });
    },
    mediaSelected(images) {
      this.images.push(images.images.orig_optimized);
    },
    removeImage(index) {
      this.images.splice(index, 1);
    },
    getName(path) {
      let parts = path.split('/');
      return parts[parts.length - 1];
    },
    loadPreview(imagePath) {
      this.showPreview = true;
      this.previewImageName = this.getName(imagePath);
      this.previewImagePath = imagePath;
    }
  },
  computed: {
    images: {
      get() {
        return this.value;
      },
      set(newValue) {
        this.$emit('input', newValue);
        this.$emit('change', newValue);
      }
    },
    labelText() {
      return this.label ? this.label : 'Images';
    }
  },
  props: {
    value: {
      type: Array,
      default: []
    },
    label: {
      type: String,
      default: 'Images'
    }
  },
  components: {
    ImagesIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-images.vue'),
    SearchIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-search.vue')
  }
};
</script>
