<template>
  <div>
    <div id="devise-admin-content">
      <action-bar>
        <li
          class="dvs-btn dvs-btn-sm dvs-mb-2"
          :style="theme.actionButton"
          @click.prevent="showCreate = true"
        >Create Redirect</li>
      </action-bar>
      <h3 class="dvs-mb-10 dvs-mr-12" :style="{color: theme.panel.color}">Current Redirects</h3>
      <div
        v-for="redirect in redirects.data"
        :key="redirect.id"
        class="dvs-mb-6 dvs-flex dvs-justify-between dvs-items-center"
      >
        <div class="dvs-min-w-1/6 dvs-font-bold dvs-pr-8">{{ redirect.type }}</div>
        <div class="dvs-min-w-2/6 dvs-font-bold dvs-pr-8">From: {{ redirect.from_url }}</div>
        <div class="dvs-min-w-2/6 dvs-font-bold dvs-pr-8">To: {{ redirect.to_url }}</div>
        <div class="dvs-w-1/6 dvs-px-8 dvs-flex dvs-justify-end">
          <button
            class="dvs-btn dvs-btn-xs"
            @click="loadRedirect(redirect.id)"
            :style="theme.actionButtonGhost"
          >Manage</button>
        </div>
      </div>

      <help v-if="redirects.data.length < 1">You do not have any redirects currently</help>
    </div>

    <transition name="dvs-fade">
      <portal to="devise-root">
        <devise-modal class="dvs-z-50" v-if="showCreate" @close="showCreate = false">
          <h4 class="dvs-mb-4" :style="{color: theme.panel.color}">New Redirect</h4>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>From URL</label>
            <input type="text" v-model="newRedirect.from_url">
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>To URL</label>
            <input type="text" v-model="newRedirect.to_url">
          </fieldset>

          <button
            class="dvs-btn"
            @click="requestCreateRedirect"
            :disabled="createInvalid"
            :style="theme.actionButton"
          >Create</button>
          <button
            class="dvs-btn"
            @click="showCreate = false"
            :style="theme.actionButtonGhost"
          >Cancel</button>
        </devise-modal>
      </portal>
    </transition>
  </div>
</template>

<script>
import DeviseModal from './../utilities/Modal';

import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'RedirectsIndex',
  data() {
    return {
      modulesToLoad: 1,
      showCreate: false,
      newRedirect: {
        from_url: null,
        to_url: null
      }
    };
  },
  mounted() {
    this.retrieveAllRedirects();
  },
  methods: {
    ...mapActions('devise', ['getRedirects', 'createRedirect']),
    requestCreateRedirect() {
      let self = this;
      this.createRedirect(this.newRedirect).then(function() {
        self.newRedirect.from_url = null;
        self.newRedirect.to_url = null;
        self.showCreate = false;
      });
    },
    retrieveAllRedirects(loadbar = true) {
      this.getRedirects().then(function() {
        if (loadbar) {
          devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
        }
      });
    },
    loadRedirect(id) {
      this.$router.push({ name: 'devise-redirects-edit', params: { redirectId: id } });
    }
  },
  computed: {
    ...mapGetters('devise', ['redirects']),
    createInvalid() {
      return (
        this.newRedirect.name === null ||
        this.newRedirect.email === null ||
        this.newRedirect.password === null ||
        this.newRedirect.password_confirmation === null ||
        this.newRedirect.password !== this.newRedirect.password_confirmation
      );
    }
  },
  components: {
    DeviseModal,
    ActionBar: () =>
      import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/ActionBar'),
    ArrowIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-arrow-dropright-circle.vue')
  }
};
</script>
