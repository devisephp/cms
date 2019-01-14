<template>
  <div>
    <div id="devise-admin-content">
      <action-bar>
        <li
          class="dvs-btn dvs-btn-sm dvs-mb-2"
          :style="theme.actionButton"
          @click.prevent="showCreateForm()"
        >Create New Release</li>
      </action-bar>

      <h2 class="dvs-mb-10">Releases</h2>

      <div
        v-for="release in pushedReleases"
        :key="release.id"
        class="dvs-mb-6 dvs-flex dvs-justify-between dvs-items-center"
      >
        <div class="dvs-min-w-2/5 dvs-font-bold dvs-pr-8">{{ release.message }}</div>
        <div
          class="dvs-min-w-1/5 dvs-text-sm dvs-px-8 dvs-font-mono"
        >{{ trucatedHash(release.commit_hash) }}</div>
        <div class="dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end">
          <button
            v-if="releaseWasPulled(release.id)"
            class="dvs-btn dvs-btn-xs dvs-mr-2"
            :style="theme.actionButtonGhost"
          >Pulled</button>
          <button
            v-else
            class="dvs-btn dvs-btn-xs dvs-mr-2"
            :style="theme.actionButtonGhost"
            @click="pullRelease(release.id)"
          >Pull</button>
        </div>
      </div>

      <div v-if="releasesLoaded && pushedReleases.length === 0">
        <p>Mothership releases has not been initiated.</p>
        <button
          :style="theme.actionButton"
          class="dvs-btn dvs-block dvs-w-full"
          @click.prevent="initiateReleases(false)"
        >Initiate Mothership Releases</button>
      </div>
    </div>

    <transition name="dvs-fade">
      <portal to="devise-root">
        <devise-modal class="dvs-z-50" v-if="showCreate" @close="showCreate = false">
          <h3 class="dvs-mb-4" :style="{color: theme.panel.color}">Create New Release</h3>

          <div v-for="update in recentUpdates" :key="update.id" class="dvs-mb-6 dvs-items-center">
            <div class="dvs-w-full dvs-font-bold dvs-pr-8">
              <label>
                <input type="checkbox">
                {{ update.model }}
              </label>
            </div>

            <div
              v-for="change in update.changes"
              :key="change.id"
              class="dvs-w-full dvs-mb-6 dvs-mt-6 dvs-flex dvs-justify-between dvs-items-center"
            >
              <div class="dvs-min-w-2/5 dvs-font-bold dvs-pr-8">{{ change.description }}</div>
              <div class="dvs-min-w-1/5 dvs-text-sm dvs-px-8 dvs-font-mono">{{ change.updated_at }}</div>
            </div>
          </div>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Message</label>
            <input type="text" v-model="newRelease.message" placeholder="Release Message">
          </fieldset>

          <button
            class="dvs-btn"
            @click="requestCreateRelease"
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
import { mapActions } from 'vuex';

export default {
  name: 'MothershipReleases',
  data() {
    return {
      showCreate: false,
      releasesLoaded: false,
      pushedReleases: [],
      pulledReleases: [],
      newRelease: {
        message: null,
        ids: []
      },
      recentUpdates: []
    };
  },
  mounted() {
    this.fetchAllReleases();
  },
  methods: {
    ...mapActions('devise', [
      'getPushedReleases',
      'getPulledReleases',
      'getPendingChanges',
      'initReleases'
    ]),
    fetchAllReleases() {
      let self = this;
      this.getPulledReleases().then(function(first) {
        self.pulledReleases = first.data;
        self.getPushedReleases().then(function(second) {
          self.pushedReleases = second.data;
          self.releasesLoaded = true;
        });
      });
    },
    initiateReleases(force) {
      let self = this;
      this.initReleases(force).then(function(response) {
        if (response.hasOwnProperty('response') && response.response.status === 422) {
          self.showForceRequiredMessage();
        } else {
          self.fetchAllReleases();
        }
      });
    },
    showForceRequiredMessage() {
      let force = confirm(
        'You have uncommitted changes. Are you sure you want to create a release without committing your source?'
      );
      if (force) {
        this.initiateReleases(true);
      }
    },
    trucatedHash(hash) {
      return hash.substring(0, 6) + '...';
    },
    releaseWasPulled(id) {
      return this.pulledReleases.indexOf(id) > -1;
    },
    pullRelease(id) {
      console.log('go');
    },
    showCreateForm() {
      this.showCreate = true;
      this.loadPendingChanges();
    },
    loadPendingChanges() {
      let self = this;
      self.getPendingChanges().then(function(response) {
        self.recentUpdates = response.data.data;
      });
    },
    requestCreateRelease() {
      console.log('go');
    }
  },
  computed: {
    createInvalid() {
      return this.newRelease.message === null;
    }
  },
  components: {
    ActionBar: () =>
      import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/ActionBar'),
    DeviseModal: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Modal')
  }
};
</script>