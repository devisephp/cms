<template>
  <div>
    <div class="dvs-flex dvs-items-center">
      <input type="text" v-model="value" :maxlength="getMaxLength" disabled>
      <div @click="showMediaManager()">
        <document-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px"/>
      </div>
      <div @click="loadPreview" v-bind:class="{ ' dvs-opacity-25': !previewEnabled }">
        <search-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px"/>
      </div>
    </div>

    <div v-if="showPreview">
      <portal to="devise-root">
        <div
          class="dvs-blocker"
          :style="{backgroundColor: 'transparent'}"
          @click="showPreview = false"
        ></div>
        <div class="dvs-modal dvs-fixed dvs-pin-b dvs-pin-r dvs-mx-8 dvs-mb-8 dvs-z-40 dvs-w-1/2">
          <img :src="value">
          <h6 class="dvs-text-base dvs-mb-4 dvs-mt-4" :style="{color: theme.panel.color}">
            <span>{{ fileName }}</span>
            <br>
            <small class="dvs-text-xs">
              Location:
              <span class="dvs-italic dvs-font-normal">{{ value }}</span>
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
  name: 'ImageField',
  data() {
    return {
      showPreview: false
    };
  },
  methods: {
    showMediaManager(event) {
      devise.$bus.$emit('devise-launch-media-manager', {
        callback: this.mediaSelected,
        options: {
          type: 'file'
        }
      });
    },
    mediaSelected(url) {
      this.file = url;
    },
    loadPreview() {
      if (this.previewEnabled) this.showPreview = true;
    }
  },
  computed: {
    file: {
      get() {
        return this.value;
      },
      set(newValue) {
        this.$emit('input', newValue);
        this.$emit('change', newValue);
      }
    },
    fileName() {
      let parts = this.value.split('/');
      return parts[parts.length - 1];
    },
    previewEnabled() {
      return this.value !== '' && this.value !== null;
    },
    getMaxLength: function() {
      if (typeof this.settings !== 'undefined' && typeof this.settings.maxlength !== 'undefined') {
        return this.settings.maxlength;
      }
      return '';
    }
  },
  props: ['value'],
  components: {
    DocumentIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-document.vue'),
    SearchIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-search.vue')
  }
};
</script>
