<template>
  <div>
    <template v-if="editorMode || pageMode">

      <loadbar v-if="isLoggedIn" />
      <messages v-if="isLoggedIn" />
      <media-manager v-if="isLoggedIn" />
      <div id="devise-container" :class="[breakpoint, adminClosed ? 'admin-closed' : '', wideAdmin ? 'wide-admin' : '', isPreviewFrame ? 'preview-frame' : '']">
        <div 
          id="devise-admin" 
          v-if="!isPreviewFrame && isLoggedIn && !adminClosed" 
          class="dvs-text-grey-darker dvs-bg-white"
          :class="[deviseOptions.adminClass]" 
          :style="`
            background-image: linear-gradient(180deg, ${theme.sidebarTop.color} 0%, ${theme.sidebarBottom.color} 100%);
            color:${theme.sidebarText.color};
          `"
          data-simplebar>
            
          <transition name="fade" mode="out-in">
            <router-view name="devise" :page="page"></router-view>
          </transition>

          <user></user>

        </div>

        
        <div class="dvs-flex-grow dvs-flex dvs-justify-center dvs-max-w-full">

          <!-- Shim -->
          <div id="devise-admin-shim" v-if="!isPreviewFrame"></div>
          
          <div id="dvs-app-content" :class="{'dvs-no-scroll': wideAdmin}">
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

            <div id="devise-iframe-editor">
              <!-- Preview mode in editor -->
              <iframe v-if="page.previewMode !== 'desktop' && !isPreviewFrame && isLoggedIn" :src="currentUrl" id="devise-responsive-preview" class="devise-content" :class="[page.previewMode]"/>
            </div>
          </div>

        </div>

        <template v-if="isLoggedIn && !isPreviewFrame">
          <div id="devise-admin-open" @click="toggleAdmin">
            <settings-icon class="dvs-gear-1" w="30px" h="30px" />
            <settings-icon class="dvs-gear-2" w="20px" h="20px" />
          </div>
        </template>

        <portal-target name="devise-field-editor" class="dvs-fieldset"> </portal-target>
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
      adminClosed: true,
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
    if (typeof deviseSettings.$template !== 'undefined') {
      this.templateMode = true
    } else if (typeof deviseSettings === 'undefined' || typeof deviseSettings.$page === 'undefined') {
      this.pageMode = true
      this.addAdminAnimations()
    } else {
      this.editorMode = true
      this.mountGlobalVariables()
      this.addAdminAnimations()
      this.initDevise()
      this.removeDeviseBlocker()
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

      window.devise = this
      devise.$bus = deviseSettings.$bus
      
      this.addWatchers()
      this.setSizeAndBreakpoint()

      let self = this
      this.$nextTick(function () {
        if (self.$route.name !== null && self.$route.name !== 'devise-page-editor') {
          self.adminClosed = false
          self.checkWidthOfInterface(self.$route)
          self.openAnimation.restart()
          self.openAnimation.seek(100)
        }
        setTimeout(function () {
          devise.$bus.$emit('devise-loaded')
        }, 10)
      })
    },
    removeDeviseBlocker () {
      let blocker = document.getElementById('devise-blocker')
      blocker.classList.add('fade')
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
      this.adminClosed = !this.adminClosed
      if (this.adminClosed) {
        this.wideAdmin = false
        this.openAnimation.reverse()
        this.openAnimation.play()
      } else {
        this.goToPage('devise-page-editor')
        this.openAnimation.restart()
      }
    },
    addWatchers () {
      window.onresize = this.setSizeAndBreakpoint
    },
    addAdminAnimations () {
      this.$nextTick(() => {

        this.openAnimation = anime.timeline({
          autoplay: true,
          loop: false,
          duration: 200
        });

        this.openAnimation
          .add({
            targets: document.querySelector('#devise-admin-open'),
            translateX: [0, 350],
            easing: 'linear',
            duration:100
          })
          .add({
            targets: document.querySelector('#devise-admin'),
            translateX: [-350, 0],
            easing: 'easeOutQuad',
            duration:300,
            offset: '+=0',
          })
          .add({
            targets: document.querySelectorAll('.admin-component-first-in'),
            translateX: [-350, 0],
            easing: 'easeOutQuad',
            offset: '-=100',
            duration:300,
          })
          .add({
            targets: document.querySelectorAll('.admin-component-second-in'),
            translateX: [-350, 0],
            easing: 'easeOutQuad',
            offset: '-=200',
            duration:300,
          })
          .add({
            targets: document.querySelectorAll('.admin-component-third-in'),
            translateX: [-350, 0],
            easing: 'easeOutQuad',
            offset: '-=200',
            duration:300,
          })

        this.openAnimation.reverse()
      })
      
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
      return deviseSettings.$user
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
    SettingsIcon,
    Slice,
    TemplateIndex,
    TemplateEdit,
    TemplateEditor,
    User
  }
}
</script>