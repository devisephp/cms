<template>
  <div>
    <template v-if="editorMode">

      <loadbar v-if="isLoggedIn" />
      <messages v-if="isLoggedIn" />
      <media-manager v-if="isLoggedIn" />
      <div id="devise-container" :class="[breakpoint, adminClosed ? 'admin-closed' : '', wideAdmin ? 'wide-admin' : '', isPreviewFrame ? 'preview-frame' : '']">
        <div id="devise-admin" v-if="!isPreviewFrame && isLoggedIn" class="dvs-text-grey-darker dvs-bg-white" :class="[deviseOptions.adminClass]">
            <transition name="fade" mode="out-in">
              <router-view name="devise" :page="page"></router-view>
            </transition>
            
            <user></user>
        </div>
        <div class="dvs-flex-grow dvs-flex dvs-justify-center dvs-max-w-full">

          <!-- Desktop mode in editor or just viewing page -->
          <div class="devise-content" v-if="page.previewMode === 'desktop' || isPreviewFrame">
            <slot name="on-top"></slot>
            <slot name="static-content"></slot>

            <template v-if="page.slices">
              <slices :slices="page.slices"></slices>
            </template>

            <slot name="static-content-bottom"></slot>
            <slot name="on-bottom"></slot>
          </div>

          <!-- Preview mode in editor -->
          <iframe v-if="page.previewMode !== 'desktop' && !isPreviewFrame && isLoggedIn" :src="currentUrl" id="devise-responsive-preview" class="devise-content" :class="[page.previewMode]"/>

        </div>

        <template v-if="isLoggedIn">
          <div id="devise-admin-shim" v-if="!isPreviewFrame"></div>
          <i id="devise-admin-open" v-if="!isPreviewFrame" class="ion-gear-a" @click="closeAdmin"></i>
        </template>

      </div>
    </template>
    <template v-if="templateMode">

      <template-editor>
        <slot name="on-top" slot="on-top"></slot>
        <slot name="on-bottom" slot="on-bottom"></slot>
      </template-editor>

    </template>

  </div>
</template>

<script>
import Loadbar from './components/utilities/Loadbar'
import MediaManager from './components/media-manager/MediaManager'
import Messages from './components/utilities/Messages'
import PageEditor from './components/pages/Editor'
import Slice from './Slice'
import TemplateIndex from './components/templates/Index'
import TemplateEdit from './components/templates/Edit'
import TemplateEditor from './components/templates/TemplateEditor'
import User from './components/menu/User'

import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'Devise',
  data () {
    return {
      showLoadbar: false,
      loadbarPercentage: 0,
      templateMode: false,
      editorMode: false,
      adminClosed: true,
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
    let self = this

    if (typeof window.template !== 'undefined') {
      this.templateMode = true
    } else {
      this.initDevise()
      this.editorMode = true
    }

    this.$nextTick(function () {
      if (self.$route.name !== null && self.$route.name !== 'devise-page-editor') {
        self.adminClosed = false
      }
      setTimeout(function () {
        window.bus.$emit('devise-loaded')
      }, 10)
    })

    this.checkWidthOfInterface(this.$route)
    this.setSizeAndBreakpoint()
    this.addWatchers()
  },
  methods: {
    ...mapActions('devise', [
      'setBreakpoint'
    ]),
    initDevise () {
      try {
        if (!this.isPreviewFrame) {
          window.page.previewMode = 'desktop'
          this.page = window.page
        } else {
          this.page = window.parent.page
        }
      } catch (e) {
        console.warn('Devise: window.page or window.parent.page not found. Nothing to render')
      }

      window.devise = this
    },
    checkWidthOfInterface (route) {
      // If the route has the wide parameter set it to it's value
      if (route.meta) {
        this.wideAdmin = route.meta.wide
      } else {
        this.wideAdmin = false
      }
    },
    closeAdmin () {
      this.adminClosed = !this.adminClosed
      if (this.adminClosed) {
        this.goToPage('devise-page-editor')
        this.wideAdmin = false
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
      'breakpoint'
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
      return window.user
    }
  },
  watch: {
    '$route': function (newRoute) {
      this.checkWidthOfInterface(newRoute)

      if (newRoute.name !== null) {
        this.adminClosed = false
      }
    }
  },
  components: {
    Loadbar,
    Messages,
    MediaManager,
    PageEditor,
    Slice,
    TemplateIndex,
    TemplateEdit,
    TemplateEditor,
    User
  }
}
</script>
