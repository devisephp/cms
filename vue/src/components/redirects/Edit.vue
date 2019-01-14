<template>
  <administration>
    <div id="devise-admin-content">
      <action-bar>
        <li
          class="dvs-btn dvs-btn-sm dvs-mb-2"
          :style="theme.actionButton"
          v-devise-alert-confirm="{callback: requestDeleteRedirect, message: 'Are you sure you want to delete this redirect?'}"
        >Delete This Redirect</li>
      </action-bar>

      <h3 class="dvs-mb-8 dvs-pr-16" :style="{color: theme.panel.color}">Redirect Settings</h3>

      <div class="dvs-mb-12">
        <form>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>From URL</label>
            <input
              type="text"
              autocomplete="off"
              v-model="localValue.from_url"
              placeholder="Name of the Redirect"
            >
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>To URL</label>
            <input
              type="text"
              autocomplete="off"
              v-model="localValue.to_url"
              placeholder="Email of the Redirect"
            >
          </fieldset>
        </form>

        <div class="dvs-flex">
          <button
            @click="requestSaveRedirect"
            class="dvs-btn dvs-mr-2"
            :style="theme.actionButton"
          >Save</button>
          <button
            @click="goToPage('devise-redirects-index')"
            class="dvs-btn dvs-mr-4"
            :style="theme.actionButtonGhost"
          >Cancel</button>
        </div>
      </div>
    </div>
  </administration>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'RedirectsView',
  data() {
    return {
      localValue: {},
      modulesToLoad: 1,
      showPassword: false
    };
  },
  mounted() {
    this.retrieveAllRedirects();
  },
  methods: {
    ...mapActions('devise', ['getRedirects', 'deleteRedirect', 'updateRedirect']),
    requestSaveRedirect() {
      this.updateRedirect({ redirect: this.redirect, data: this.localValue });
    },
    requestDeleteRedirect() {
      let self = this;
      this.deleteRedirect(this.redirect).then(function() {
        self.goToPage('devise-redirects-index');
      });
    },
    retrieveAllRedirects() {
      let self = this;
      this.getRedirects().then(function() {
        self.localValue = Object.assign({}, self.localValue, self.redirect);
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad);
      });
    }
  },
  computed: {
    ...mapGetters('devise', ['redirect'])
  },
  components: {
    ActionBar: () =>
      import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/ActionBar'),
    Administration: () =>
      import(/* webpackChunkName: "js/devise-administration" */ './../admin/Administration.vue')
  }
};
</script>
