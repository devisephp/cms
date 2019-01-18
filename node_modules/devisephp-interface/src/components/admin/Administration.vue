<template>
  <div id="devise-admin" :class="[deviseOptions.adminClass]">
    <panel
      class="dvs-m-8 dvs-fixed dvs-z-9980"
      style="min-width:360px;"
      :panel-style="theme.panel"
      v-tuck
    >
      <div class="dvs-flex">
        <div :style="theme.panelSidebar" class="dvs-flex dvs-flex-col">
          <preview-mode/>

          <template v-for="(menuItem, key) in adminMenu">
            <button
              :key="key"
              :style="checkActivePanelSidebar(menuItem)"
              class="dvs-outline-none dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b"
              @click.prevent="loadAdminPage(menuItem)"
            >
              <component v-bind:is="menuItem.icon" class="dvs-m-4" w="25" h="25"></component>
            </button>
          </template>
          <a
            href="/logout}"
            :style="theme.panelSidebar"
            class="dvs-outline-none dvs-transitions-hover-slow dvs-cursor-pointer dvs-border-b"
            onclick="event.preventDefault(); document.getElementById('dvs-logout-form').submit();"
          >
            <power-icon class="dvs-m-4" w="25" h="25"/>
          </a>

          <form id="dvs-logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" :value="csrf_field">
          </form>
        </div>

        <div
          class="dvs-max-h-screen dvs-flex-grow"
          id="dvs-admin-content-container"
          ref="admin-route-wrapper"
          data-simplebar
        >
          <transition name="dvs-fade" mode="out-in">
            <router-view name="devise"></router-view>
          </transition>
        </div>
      </div>
    </panel>

    <portal-target class="dvs-relative dvs-z-9999" name="devise-root"></portal-target>
    <media-manager class="dvs-z-9999"/>
    <slice-settings/>
    <loadbar class="dvs-relative dvs-z-9999"/>
    <loading-screen class="dvs-relative dvs-z-9999"/>
    <messages class="dvs-relative dvs-z-9999"/>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';

export default {
  name: 'Administration',
  data() {
    return {
      everythingIsLoaded: false
    };
  },
  mounted() {
    setTimeout(() => {
      this.everythingIsLoaded = true;
    }, 2000);
  },
  methods: {
    loadAdminPage(menuItem) {
      if (menuItem.routeName === 'media-manager') {
        devise.$bus.$emit('devise-launch-media-manager', {});
      } else if (typeof menuItem.routeParams !== 'undefined') {
        this.goToPage(menuItem.routeName, menuItem.routeParams);
      } else {
        this.goToPage(menuItem.routeName);
      }
    },
    checkActivePanelSidebar(menuItem) {
      var styles = Object.assign({}, this.theme.panelSidebar);
      if (this.$route.meta && this.$route.meta.parentRouteName) {
        if (
          this.$route.name === 'devise-pages-view' &&
          this.$route.params.pageId === this.currentPage.id &&
          menuItem.routeName === 'devise-pages-view'
        ) {
          styles.background = this.theme.panelSidebar.secondaryColor;
        }

        if (
          menuItem.routeName === this.$route.meta.parentRouteName &&
          (this.$route.name !== 'devise-pages-view' ||
            this.$route.params.pageId !== this.currentPage.id)
        ) {
          styles.background = this.theme.panelSidebar.secondaryColor;
        }
      }

      return styles;
    }
  },
  computed: {
    ...mapState('devise', ['adminMenu']),
    user() {
      return deviseSettings.$user;
    },
    csrf_field() {
      return window.axios.defaults.headers.common['X-CSRF-TOKEN'];
    }
  },
  components: {
    Loadbar: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Loadbar'),
    LoadingScreen: () =>
      import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/LoadingScreen'),
    Messages: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Messages'),
    MediaEditor: () =>
      import(/* webpackChunkName: "js/devise-media" */ './../media-manager/MediaEditor'),
    MediaManager: () =>
      import(/* webpackChunkName: "js/devise-media" */ './../media-manager/MediaManager'),
    PreviewMode: () => import(/* webpackChunkName: "js/devise-pages" */ './../pages/PreviewMode'),
    BackIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-arrow-round-back.vue'),
    CogIcon: () => import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-cog.vue'),
    CreateIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-create.vue'),
    CubeIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-cube.vue'),
    DocumentIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-document.vue'),
    ImageIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-image.vue'),
    Panel: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Panel'),
    PowerIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-power.vue'),
    SaveIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-save.vue'),
    SliceSettings: () =>
      import(/* webpackChunkName: "js/devise-pages" */ './../slices/SliceSettings')
  }
};
</script>
