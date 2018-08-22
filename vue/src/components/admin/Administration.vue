<template>
  <div 
    id="devise-admin"
    :class="[deviseOptions.adminClass]" 
    data-simplebar>
      
    <panel class="dvs-m-8" style="width:300px;" :panel-style="theme.panel" v-tilt>
      <div class="dvs-flex">
        <div :style="theme.panelSidebar" class="dvs-flex dvs-flex-col" >
          <template v-for="menuItem in adminMenu">
            <button 
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

        <transition name="dvs-fade" mode="out-in">
          <router-view name="devise" :page="page"></router-view>
        </transition>

      </div>
    </panel>

    <preview-mode></preview-mode>

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

import Panel from './../utilities/Panel'
import PreviewMode from './../pages/PreviewMode'
import { mapState } from 'vuex';

export default {
  name: 'Administration',
  methods: {
    openPageSettings () {
      this.pageSettingsOpen = !this.pageSettingsOpen
      this.pageContentOpen = false
    },
    openPageContent () {
      this.pageContentOpen = true
      this.pageSettingsOpen = false
    },
  },
  computed: {
    ...mapState('devise', [
      'adminMenu'
    ]),
    user () {
      return deviseSettings.$user
    },
    csrf_field () {
      return window.axios.defaults.headers.common['X-CSRF-TOKEN']
    }
  },
  props: {
    page: {
      type: Object
    }
  },
  components: {
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
