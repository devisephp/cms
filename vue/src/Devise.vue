<template>
  <div>
    <portal-target name="devise-root" v-if="isLoggedIn"></portal-target>
    <portal-target name="app-root"></portal-target>

    <messages v-if="isLoggedIn" />
    <loadbar v-if="isLoggedIn" />
    <media-manager v-if="isLoggedIn" />
    <media-editor v-if="isLoggedIn" />

    <template v-if="editorMode || pageMode">

      <div id="devise-container" :class="[breakpoint, !adminOpen ? 'admin-closed' : '', wideAdmin ? 'wide-admin' : '', isPreviewFrame ? 'preview-frame' : '']">
        
        <administration v-if="isLoggedIn && adminOpen" :page="page" />

        <div id="dvs-app-content" :class="{'dvs-no-scroll': wideAdmin}">
          <!-- Desktop mode in editor or just viewing page -->
          <div class="devise-content" v-if="page.previewMode === 'desktop' || isPreviewFrame">
            <slot name="on-top"></slot>
            <slot name="static-content"></slot>

            <template v-if="page.slices">
              <slices :slices="page.slices" :editorMode="adminOpen && editorMode"></slices>
            </template>

            <slot name="static-content-bottom"></slot>
            <slot name="on-bottom"></slot>
          </div>

          <div id="devise-iframe-editor">
            <!-- Preview mode in editor -->
            <iframe v-if="page.previewMode !== 'desktop' && !isPreviewFrame && isLoggedIn" :src="currentUrl" id="devise-responsive-preview" :class="[page.previewMode]"/>
          </div>
        </div>

        <template v-if="isLoggedIn && !isPreviewFrame">
          <div id="devise-admin-open" @click="toggleAdmin">
            <settings-icon class="dvs-gear-1" w="30px" h="30px" />
            <settings-icon class="dvs-gear-2" w="20px" h="20px" />
          </div>
        </template>

      </div>
    </template>
    <template v-if="templateMode && isLoggedIn">
      <template-editor>
        <slot name="on-top" slot="on-top"></slot>
        <slot name="on-bottom" slot="on-bottom"></slot>
      </template-editor>
    </template>

  </div>
</template>

<script>
import Loadbar from './components/utilities/Loadbar'
import MediaEditor from './components/media-manager/MediaEditor'
import MediaManager from './components/media-manager/MediaManager'
import Messages from './components/utilities/Messages'
import Slice from './Slice'
import TemplateIndex from './components/templates/Index'
import TemplateEdit from './components/templates/Edit'
import TemplateEditor from './components/templates/TemplateEditor'
import User from './components/menu/User'
import SimpleBar from 'SimpleBar'
import anime from 'animejs'

import SettingsIcon from 'vue-ionicons/dist/ios-settings.vue'

import { mapGetters, mapActions, mapMutations } from 'vuex'

export default {
  name: 'Devise',
  data () {
    return {
      showLoadbar: false,
      loadbarPercentage: 0,
      templateMode: false,
      editorMode: false,
      pageMode: false,
      adminOpen: true,
      openAnimation: null,
      wideAdmin: false,
      page: {
        title: null,
        body: null,
        slices: {},
        previewMode: 'desktop'
      }
    }
  },
  mounted () {
    window.devise = this
    devise.$bus = deviseSettings.$bus

    if (typeof deviseSettings.$template !== 'undefined') {
      this.templateMode = true
    } else {
      this.editorMode = true
      this.mountGlobalVariables()
      this.initDevise()
    }

    let blocker = document.getElementById('devise-blocker')
    if (blocker) {
      blocker.classList.add('fade')
    }

  },
  methods: {
    ...mapActions('devise', [
      'setBreakpoint'
    ]),
    ...mapMutations('devise', [
      'setPage',
      'setSites'
    ]),
    initDevise () {
      try {
        if (!this.isPreviewFrame) {
          deviseSettings.$page.previewMode = 'desktop'
          this.page = deviseSettings.$page
        } else {
          this.page = window.parent.deviseSettings.$page
        }
      } catch (e) {
        console.warn('Devise: deviseSettings.$page or window.parent.deviseSettings.$page not found. Nothing to render')
      }
      
      this.addWatchers()
      this.setSizeAndBreakpoint()

      let self = this
      this.$nextTick(function () {
        if (self.$route.name !== null && self.$route.name !== 'devise-page-editor') {
          self.adminOpen = true
          self.checkWidthOfInterface(self.$route)
        }
        setTimeout(function () {
          devise.$bus.$emit('devise-loaded')
        }, 10)
      })
    },
    mountGlobalVariables () {
      // page, sites
      this.setPage(deviseSettings.$page)
      this.setSites({data: deviseSettings.$sites})
    },
    checkWidthOfInterface (route) {
      // If the route has the wide parameter set it to it's value
      if (route.meta) {
        this.wideAdmin = route.meta.wide
      } else {
        this.wideAdmin = false
      }
    },
    toggleAdmin () {
      this.adminOpen = !this.adminOpen
      if (!this.adminOpen) {
        this.wideAdmin = false
        window.location.hash = '#'
      } else {
        if (deviseSettings.$page) {
          this.goToPage('devise-page-editor')
        } else {
          this.goToPage('devise-index')
        }
      }
    },
    addWatchers () {
      window.onresize = this.setSizeAndBreakpoint
    },
    setSizeAndBreakpoint () {
      let width = window.innerWidth
      let height = window.innerHeight
      let breakpoint = this.findBreakpoint(width)

      this.setBreakpoint({
        breakpoint: breakpoint,
        diminsions: {width: width, height: height}
      })
    },
    findBreakpoint (width) {
      for (var breakpoint in this.deviseOptions.breakpoints) {
        if (this.deviseOptions.breakpoints.hasOwnProperty(breakpoint)) {
          if (width < this.deviseOptions.breakpoints[breakpoint]) {
            return breakpoint
          }
        }
      }
      return 'ultraWideDesktop'
    }
  },
  computed: {
    ...mapGetters('devise', [
      'breakpoint',
      'currentUser'
    ]),
    currentUrl () {
      return window.location.href
    },
    isPreviewFrame () {
      try {
        return window.self !== window.top
      } catch (e) {
        return true
      }
    },
    isLoggedIn () {
      return this.currentUser
    }
  },
  watch: {
    '$route': function (newRoute) {
      this.checkWidthOfInterface(newRoute)

      if (newRoute.name !== null) {
        this.adminOpen = true
      }
    }
  },

  components: {
    Loadbar,
    Messages,
    MediaEditor,
    MediaManager,
    SettingsIcon,
    Slice,
    TemplateIndex,
    TemplateEdit,
    TemplateEditor,
    User
  }
}
</script>