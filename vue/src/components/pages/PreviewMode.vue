<template>
  <panel :panel-style="theme.panel" class="dvs-fixed dvs-pin-r dvs-pin-t dvs-m-8" id="dvs-preview-mode-controls">
    <div class="dvs-flex dvs-p-8">
      <div class="dvs-mr-6 dvs-cursor-pointer" :style="onStyle('desktop')"  @click="setPreviewMode('desktop')">
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
  </panel>
</template>

<script>
import Panel from './../utilities/Panel'
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
    },
    onStyle (type) {
      if (this.previewMode === type) {
        return this.theme.panelIcons.color
      }
    }
  },
  components: {
    DesktopIcon,
    Panel,
    PhonePortraitIcon,
    PhoneLandscapeIcon,
    TabletIcon,
  }
}
</script>
