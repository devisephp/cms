<template>
  <div 
    id="devise-admin"
    :class="[deviseOptions.adminClass]">

    <portal-target name="devise-root"></portal-target>
    <messages class="dvs-z-9999" />
    <loadbar class="dvs-z-9999" />
    <media-manager class="dvs-z-9999" />
    <transition name="dvs-fade">
      <preview-mode class="dvs-z-9999" v-tuck v-if="managingPage" />
    </transition>
      
    <panel class="dvs-m-8 dvs-fixed dvs-z-9999" style="min-width:300px;" :panel-style="theme.panel" v-tuck v-tilt>
      <div class="dvs-flex">
        <div :style="theme.panelSidebar" class="dvs-flex dvs-flex-col" >
          <template v-for="(menuItem, key) in adminMenu">
            <button 
              :key="key"
              :style="theme.panelSidebar"
              class="dvs-outline-none dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b"
              @click.prevent="goToPage(menuItem.routeName)">
              <component v-bind:is="menuItem.icon" class="dvs-m-4" w="25" h="25"></component>
            </button>
          </template>
          <a href="/logout}" 
            :style="theme.panelSidebar"
            class="dvs-outline-none dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b"
            onclick="event.preventDefault(); document.getElementById('dvs-logout-form').submit();">
            <power-icon class="dvs-m-4" w="25" h="25" />
          </a>

          <form id="dvs-logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" :value="csrf_field">
          </form>
        </div>

        <div class="dvs-max-h-screen" ref="admin-route-wrapper" data-simplebar>
          <transition name="dvs-fade" mode="out-in">
            <router-view name="devise" :page="page"></router-view>
          </transition>
        </div>

      </div>
    </panel>

  </div>
</template>

<script>

import SaveIcon from 'vue-ionicons/dist/md-save.vue'
import CreateIcon from 'vue-ionicons/dist/md-create.vue'
import CogIcon from 'vue-ionicons/dist/md-cog.vue'
import CubeIcon from 'vue-ionicons/dist/md-cube.vue'
import PowerIcon from 'vue-ionicons/dist/ios-power.vue'
import BackIcon from 'vue-ionicons/dist/md-arrow-round-back.vue'
import DocumentIcon from 'vue-ionicons/dist/md-document.vue'

import Loadbar from './../utilities/Loadbar'
import MediaEditor from './../media-manager/MediaEditor'
import MediaManager from './../media-manager/MediaManager'
import Messages from './../utilities/Messages'
import Panel from './../utilities/Panel'
import PreviewMode from './../pages/PreviewMode'
import { mapState } from 'vuex';

export default {
  name: 'Administration',
  computed: {
    ...mapState('devise', [
      'adminMenu'
    ]),
    user () {
      return deviseSettings.$user
    },
    csrf_field () {
      return window.axios.defaults.headers.common['X-CSRF-TOKEN']
    },
    managingPage () {
      return this.$route.name === 'devise-page-editor'
    }
  },
  props: {
    page: {
      type: Object
    }
  },
  components: {
    Loadbar,
    Messages,
    MediaEditor,
    MediaManager,
    PreviewMode,
    BackIcon,
    CogIcon,
    CreateIcon,
    CubeIcon,
    DocumentIcon,
    Panel,
    PowerIcon,
    SaveIcon,
  }
}
</script>
