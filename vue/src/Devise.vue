<template>
  <div>
    <template v-if="editorMode">

      <loadbar/>
      <messages v-if="!adminDisabled"/>
      <media-manager v-if="!adminDisabled"/>
      <div id="devise-container" :class="{'admin-closed': adminClosed, 'wide-admin': wideAdmin, 'preview-frame': isPreviewFrame}">
        <div id="devise-admin" v-if="!isPreviewFrame && !adminDisabled" class="dvs-text-grey-darker dvs-bg-white" :class="[deviseOptions.adminClass]">
            <user></user>
            <transition name="fade" mode="out-in">
              <router-view name="devise" :page="page"></router-view>
            </transition>
        </div>
        <div class="dvs-flex-grow dvs-flex dvs-justify-center">

          <!-- Desktop mode in editor or just viewing page -->
          <div class="devise-content" v-if="page.previewMode === 'desktop' || isPreviewFrame" >

            <slot name="on-top"></slot>

            <slot name="static-content"></slot>

            <slice v-for="(slice, key) in page.slices" :key="key" :slice="slice"/>

            <slot name="static-content-bottom"></slot>

            <slot name="on-bottom"></slot>

          </div>

          <!-- Preview mode in editor -->
          <iframe v-if="page.previewMode !== 'desktop' && !isPreviewFrame && !adminDisabled" :src="currentUrl" id="devise-responsive-preview" class="devise-content" :class="[page.previewMode]"/>

        </div>
        <div id="devise-admin-shim" v-if="!isPreviewFrame && !adminDisabled"></div>
        <i id="devise-admin-open" v-if="!isPreviewFrame && !adminDisabled" class="ion-gear-a" @click="closeAdmin"></i>
      </div>
    </template>

    <template v-if="templateMode">

      <template-preview>
        <slot name="on-top" slot="on-top"></slot>
        <slot name="on-bottom" slot="on-bottom"></slot>
      </template-preview>

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
import TemplatePreview from './components/templates/Preview'
import User from './components/menu/User'

export default {
  name: 'Devise',
  data () {
    return {
      adminDisabled: true,
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
    if (this.isLoggedIn()) {
      this.adminDisabled = false
    }

    if (typeof window.template !== 'undefined') {
      this.templateMode = true
    } else {
      this.initDevise()
      this.editorMode = true
    }

    this.$nextTick(function () {
      setTimeout(function () {
        window.bus.$emit('devise-loaded')
      }, 10)
    })

    this.checkWidthOfInterface(this.$route)
  },
  methods: {
    isLoggedIn () {
      let user = window.user
      return user
    },
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
    getComponent (slice) {
      return window.deviseComponents[slice.name]
    },
    closeAdmin () {
      this.adminClosed = !this.adminClosed
      if (this.adminClosed) {
        this.goToPage('devise-page-editor')
        this.wideAdmin = false
      }
    }
  },
  computed: {
    currentUrl () {
      return window.location.href
    },
    isPreviewFrame () {
      try {
        return window.self !== window.top
      } catch (e) {
        return true
      }
    }
  },
  watch: {
    '$route': function (newRoute) {
      if (newRoute.name !== null) {
        this.adminClosed = false
      }
      this.checkWidthOfInterface(newRoute)
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
    TemplatePreview,
    User
  }
}
</script>
