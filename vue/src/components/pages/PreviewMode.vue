<template>
  <div id="dvs-preview-mode-controls" style="background:rgba(0,0,0,0.7)" class="admin-component-second-in">
    <div class="dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'desktop'}"  @click="setPreviewMode('desktop')">
      <desktop-icon w="25" h="25" />
    </div>
    <div class="dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'tablet'}"  @click="setPreviewMode('tablet')">
      <tablet-icon w="25" h="25" />
    </div>
    <div class="dvs-mr-6 dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'mobile-portrait'}"  @click="setPreviewMode('mobile-portrait')">
      <phone-portrait-icon w="25" h="25" />
    </div>
    <div class="dvs-cursor-pointer" :class="{'dvs-text-green': previewMode === 'mobile-landscape'}"  @click="setPreviewMode('mobile-landscape')">
      <phone-landscape-icon w="25" h="25" />
    </div>
  </div>
</template>

<script>
import DesktopIcon from 'vue-ionicons/dist/md-desktop.vue'
import TabletIcon from 'vue-ionicons/dist/md-tablet-portrait.vue'
import PhonePortraitIcon from 'vue-ionicons/dist/md-phone-portrait.vue'
import PhoneLandscapeIcon from 'vue-ionicons/dist/md-phone-landscape.vue'

export default {
  data () {
    return {
      previewMode: 'desktop'
    }
  },
  methods: {
    setPreviewMode (mode) {
      this.previewMode = mode
      deviseSettings.$page.previewMode = mode
    }
  },
  components: {
    DesktopIcon,
    PhonePortraitIcon,
    PhoneLandscapeIcon,
    TabletIcon,
  }
}
</script>
