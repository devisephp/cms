<template>
  <div
    class="dvs-relative dvs-cursor-pointer dvs-border-b dvs-transitions-hover-slow"
    @mouseenter="openPreviewSelector"
    @mouseleave="closePreviewSelector"
    :style="theme.panelSidebar"
  >
    <div
      class="dvs-m-4 dvs-cursor-pointer"
      v-if="previewMode === 'desktop'"
      :style="{color: theme.panelSidebar.secondaryColor}"
    >
      <desktop-icon w="25" h="25"/>
    </div>
    <div
      class="dvs-m-4 dvs-cursor-pointer"
      v-if="previewMode === 'tablet'"
      :style="{color: theme.panelSidebar.secondaryColor}"
    >
      <tablet-icon w="25" h="25"/>
    </div>
    <div
      class="dvs-m-4 dvs-cursor-pointer"
      v-if="previewMode === 'mobile-portrait'"
      :style="{color: theme.panelSidebar.secondaryColor}"
    >
      <phone-portrait-icon w="25" h="25"/>
    </div>
    <div
      class="dvs-m-4 dvs-cursor-pointer"
      v-if="previewMode === 'mobile-landscape'"
      :style="{color: theme.panelSidebar.secondaryColor}"
    >
      <phone-landscape-icon w="25" h="25"/>
    </div>
    <div
      ref="previewSelector"
      class="dvs-flex dvs-overflow-hidden dvs-flex-col dvs-rounded-sm dvs-absolute dvs-pin-t dvs-pin-l dvs-mt-2 dvs-ml-10 dvs-z-10"
      :style="theme.panelSidebar"
    >
      <div
        class="dvs-p-3 dvs-cursor-pointer dvs-border-b"
        :style="onStyle('desktop')"
        @click="setPreviewMode('desktop')"
      >
        <desktop-icon w="20" h="20"/>
      </div>
      <div
        class="dvs-p-3 dvs-cursor-pointer dvs-border-b"
        :style="onStyle('tablet')"
        @click="setPreviewMode('tablet')"
      >
        <tablet-icon w="20" h="20"/>
      </div>
      <div
        class="dvs-p-3 dvs-cursor-pointer dvs-border-b"
        :style="onStyle('mobile-portrait')"
        @click="setPreviewMode('mobile-portrait')"
      >
        <phone-portrait-icon w="20" h="20"/>
      </div>
      <div
        class="dvs-p-3 dvs-cursor-pointer"
        :style="onStyle('mobile-landscape')"
        @click="setPreviewMode('mobile-landscape')"
      >
        <phone-landscape-icon w="20" h="20"/>
      </div>
    </div>
  </div>
</template>

<script>
import { TweenMax, CSSPlugin } from 'gsap';
import { mapActions } from 'vuex';

export default {
  data() {
    return {
      previewMode: 'desktop',
      previewSelector: null
    };
  },
  mounted() {
    this.previewSelector = this.$refs.previewSelector;
    this.closePreviewSelector();
  },
  methods: {
    ...mapActions('devise', ['setPreviewModeInCurrentPage']),
    closePreviewSelector() {
      TweenMax.to(this.previewSelector, 0.5, {
        maxHeight: `0px`
      });
    },
    openPreviewSelector() {
      TweenMax.to(this.previewSelector, 0.5, {
        maxHeight: `500px`
      });
    },
    setPreviewMode(mode) {
      this.previewMode = mode;
      this.setPreviewModeInCurrentPage(mode);
    },
    onStyle(type) {
      if (this.previewMode === type) {
        return {
          color: this.theme.panelSidebar.secondaryColor
        };
      }
    }
  },
  components: {
    Panel: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Panel'),
    DesktopIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-desktop.vue'),
    TabletIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-tablet-portrait.vue'),
    PhonePortraitIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-phone-portrait.vue'),
    PhoneLandscapeIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-phone-landscape.vue')
  }
};
</script>
