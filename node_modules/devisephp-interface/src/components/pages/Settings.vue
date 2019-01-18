<template>
  <div class="dvs-p-8">
    <fieldset class="dvs-fieldset dvs-mb-4">
      <label>Page Title</label>
      <input type="text" v-model="editPage.title" class="dvs-small" placeholder="Title of the Page">
    </fieldset>

    <button
      :style="theme.actionButton"
      class="dvs-btn dvs-block dvs-w-full dvs-mb-2"
      @click.prevent="requestSavePage()"
    >Save Page</button>

    <router-link
      :to="{ name: 'devise-pages-view', params: { pageId: page.id }}"
      class="dvs-btn dvs-block"
      :style="theme.actionButtonGhost"
    >All Settings</router-link>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'PageSettings',
  data() {
    return {
      pageSlices: [],
      pageSettingsOpen: false,
      pageContentOpen: true
    };
  },
  mounted() {
    this.pageSlices = this.page.slices;
  },
  methods: {
    ...mapActions('devise', ['savePage']),
    requestSavePage() {
      this.savePage(this.page);
    },
    toggleSlice(slice) {
      if (slice.metadata.open) {
        this.closeSlice(slice);
      } else {
        this.openSlice(slice);
      }
    },
    openSlice(sliceToOpen) {
      this.pageSlices.map(s => this.closeSlice(s));
      this.$set(sliceToOpen.metadata, 'open', true);
    },
    closeSlice(slice) {
      this.$set(slice.metadata, 'open', false);
    }
  },
  computed: {
    ...mapGetters('devise', ['sliceConfig', 'fieldConfig']),
    editPage: {
      get() {
        return this.page;
      },
      set(newValue) {
        this.$emit('updatePage', newValue);
      }
    }
  },
  props: ['page'],
  components: {
    AnalyticTotals: () => import(/* webpackChunkName: "js/devise-pages" */ './AnalyticTotals')
  }
};
</script>
