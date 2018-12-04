<template>
  <div class="dvs-flex">
    <installer-finish
      ref="finshline"
      :finished="finished"
      class="dvs-fixed dvs-pin-t dvs-pin-l dvs-pin-r dvs-z-50"
      :style="finishedStyles"
    ></installer-finish>

    <main-menu v-if="checklist.database" :checklist="checklist" :style="bodyFinishedStyles"></main-menu>

    <div id="content" class="dvs-absolute dvs-pin dvs-overflow-scroll" :style="bodyFinishedStyles">
      <section id="nav-welcome" name="nav-welcome">
        <div>
          <div class="dvs-w-1/2 dvs-mb-4">
            <devise-logo color="#222"/>
          </div>

          <p
            class="dvs-text-xl dvs-mb-16"
          >We are very excited that you are giving Devise 2 a spin. We are still in the early beta stages of this product but we do believe we have settled on the final structure of things. We encourage you to send us any feedback via Github issues, submit any PR's or just let us know what you think of the project on Twitter @devisephp.</p>

          <div class="dvs-mb-16 dvs-flex">
            <a
              href="https://devise.gitbook.io/cms/"
              target="_blank"
              class="dvs-btn dvs-bg-blue dvs-text-white dvs-mr-2"
            >Documentation</a>
            <a
              href="https://devisephp.com"
              target="_blank"
              class="dvs-btn dvs-bg-blue dvs-text-white dvs-mr-2"
            >Website</a>
            <a
              href="https://github.com/devisephp/cms"
              target="_blank"
              class="dvs-btn dvs-bg-blue dvs-text-white"
            >Github</a>
          </div>

          <div class="dvs-text-left dvs-w-full">
            <h2 class="dvs-mb-4">Installation</h2>

            <p
              class="dvs-mb-4"
            >Below we have setup an interactive installer that will continually poll to see if you have correctly configured your server and application for Devise. Once you have turned all the items in "Required Setup" green you are good to go. However, we have also provided some helpful items in "Non-required Setup" that you may want to take a look at.</p>
          </div>
        </div>
        <div></div>
      </section>

      <div id="nav-required"></div>

      <template v-if="checklist.database">
        <database :item="checklist.database"></database>

        <migrations :item="checklist.migrations"></migrations>

        <auth :item="checklist.auth"></auth>

        <user :item="checklist.user"></user>

        <site :item="checklist.site"></site>

        <page :item="checklist.page"></page>

        <slices :item="checklist.slices"></slices>

        <image-library :item="checklist.image_library"></image-library>

        <div id="nav-suggested"></div>

        <optional-extras></optional-extras>

        <image-optimization :checklist="checklist"></image-optimization>
      </template>
    </div>

    <messages/>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

import Messages from './Messages';
import MainMenu from './MainMenu.vue';
import DeviseLogo from './../../components/utilities/DeviseLogo.vue';

import Database from './items/Database.vue';
import Migrations from './items/Migrations.vue';
import Auth from './items/Auth.vue';
import User from './items/User.vue';
import Site from './items/Site.vue';
import Slices from './items/Slices.vue';
import Page from './items/Page.vue';
import ImageLibrary from './items/ImageLibrary.vue';
import ImageOptimization from './items/ImageOptimization.vue';
import OptionalExtras from './items/OptionalExtras.vue';

export default {
  mounted() {
    this.getLanguages();
    this.startChecker();
  },
  methods: {
    ...mapActions(['refreshChecklist', 'getLanguages']),
    startChecker() {
      this.refreshChecklist();
      setInterval(() => {
        this.refreshChecklist();
      }, 5000);
    }
  },
  computed: {
    ...mapState({
      checklist: state => state.checklist,
      languages: state => state.languages.data
    }),
    finished() {
      for (const task in this.checklist) {
        if (this.checklist.hasOwnProperty(task)) {
          if (!this.checklist[task]) {
            return false;
          }
        }
      }

      return true;
    },
    finishedStyles() {
      if (this.finished) {
        return { top: 0 };
      }

      return { top: '-200px' };
    },
    bodyFinishedStyles() {
      if (this.finished) {
        return { marginTop: '200px' };
      }

      return { marginTop: '0' };
    }
  },
  components: {
    Auth,
    Database,
    Migrations,
    User,
    Site,
    Slices,
    Page,
    ImageLibrary,
    ImageOptimization,
    OptionalExtras,
    Messages,
    MainMenu,
    DeviseLogo
  }
};
</script>

<style lang="scss">
body {
  background-color: aquamarine;
}

#sidebar {
  width: 200px;
}

#content {
  left: 200px;
}

section {
  display: flex;

  > div {
    &:first-child {
      width: 50%;
      color: rgb(72, 82, 91);
      background-color: #f8fafc;
      padding: 3em;
    }

    &:last-child {
      width: 50%;
      background-color: #22292f;
      color: #f8fafc;
      padding: 3em;
      font-size: 0.8em;
    }
  }
}

#menu {
  font-size: 0.9em;

  a {
    text-decoration: none;
    font-weight: normal;

    &.is-active {
      font-weight: bold;
    }
  }

  ul {
    padding-bottom: 1em;

    > li:first-child {
      margin-top: 0.5em;
    }
  }
  li {
    padding-top: 0.5em;
    padding-bottom: 0.5em;
  }
}
</style>