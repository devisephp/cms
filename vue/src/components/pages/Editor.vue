<template>
  <div>
    <div class="dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-4 dvs-mr-4">
      <toggle :mini="true" @change="setDevMode" :id="randomString(8)"></toggle>
    </div>

    <div class="dvs-p-8">
      <fieldset class="dvs-fieldset">
        <label>Page Version</label>
        <select onchange="selectVersion" class="dvs-small" :style="theme.panelCard">
          <option :value="version" v-for="version in currentPage.versions" :key="version.id">
            {{ version.name }}
            <template v-if="version.current">(Currently Viewing)</template>
            <template v-if="version.is_live">(Live)</template>
          </option>
        </select>
      </fieldset>
    </div>

    <div class="dvs-px-8">
      <fieldset class="dvs-fieldset">
        <label>Page Slices</label>
      </fieldset>
    </div>

    <div class="dvs-flex dvs-flex-col dvs-items-center dvs-px-8 dvs-pb-8">
      <draggable v-model="currentPage.slices" element="ul" class="dvs-list-reset dvs-w-full">
        <template v-for="slice in currentPage.slices">
          <slice-editor
            @opened="openSlice(slice)"
            :key="slice.id"
            :devise="slice"
            @addSlice="addSlice"
            @editSlice="editSlice"
            @removeSlice="removeSlice"
            @copySlice="copySlice"
          />
        </template>
      </draggable>

      <manage-slice
        ref="manageSlice"
        v-if="createSlice === true"
        @addSlice="addSlice"
        @cancel="createSlice = false"
      />

      <div class="dvs-flex dvs-justify-center">
        <button
          :style="theme.actionButtonGhost"
          class="dvs-rounded-full dvs-my-4 dvs-flex dvs-justify-center dvs-items-center dvs-p-2 dvs-pr-4 dvs-uppercase dvs-text-xs dvs-font-bold"
          @click.prevent="requestAddSlice"
        >
          <add-icon w="20" h="20"/>Add Slice
        </button>
      </div>

      <button
        :style="theme.actionButton"
        class="dvs-btn dvs-mt-8 dvs-block dvs-w-full dvs-flex dvs-justify-center dvs-items-center"
        @click.prevent="requestSavePage()"
      >
        <refresh-icon w="15" h="15" v-if="saving" animate="rotate"/>
        <span class="dvs-ml-2">Save Page</span>
      </button>
    </div>

    <portal to="devise-root">
      <analytic-totals/>
    </portal>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex';
import Strings from './../../mixins/Strings';
export default {
  name: 'PageEditor',
  data() {
    return {
      saving: false,
      createSlice: false
    };
  },
  mounted() {
    setTimeout(() => {
      this.$watch(
        'currentPage',
        function(newValue, oldValue) {
          window.onbeforeunload = () => {
            return 'Changes you made may not be saved';
          };
        },
        { deep: true }
      );
    }, 1000);
  },
  methods: {
    ...mapActions('devise', ['savePage', 'setDevMode']),
    requestSavePage() {
      this.saving = true;
      this.savePage(this.currentPage).then(() => {
        this.saving = false;
        window.onbeforeunload = null;
      });
    },
    toggleSlice(slice) {
      if (slice.metadata.open) {
        this.closeSlice(slice);
      } else {
        this.openSlice(slice);
      }
    },
    openSlice(sliceToOpen) {
      this.currentPage.slices.map(s => this.closeSlice(s));
      this.$set(sliceToOpen.metadata, 'open', true);
    },
    closeSlice(slice) {
      this.$set(slice.metadata, 'open', false);
    },
    requestAddSlice() {
      let self = this;
      this.createSlice = true;
      this.$nextTick(function() {
        this.$refs.manageSlice.action = 'insert';
      });
    },
    addSlice(newSlice, referenceSlice) {
      if (typeof referenceSlice !== 'undefined') {
        let config = this.sliceConfig(referenceSlice);
        if (config.has_child_slot === true) {
          if (typeof referenceSlice.slices === 'undefined') {
            this.$set(referenceSlice, 'slices', []);
          }
          referenceSlice.slices.push(newSlice);
        }
      } else {
        this.currentPage.slices.push(newSlice);
      }

      this.createSlice = false;
    },
    findReferenceSliceInSlices(slices, referenceSlice) {
      return slices.find(slice => {
        if (slice === referenceSlice) return slice;
        else if (slice.slices) return this.findReferenceSliceInSlices(slice.slices, referenceSlice);
      });
      // this.currentPage.slices[this.currentPage.slices.indexOf(referenceSlice)]
    },
    editSlice(editedSlice, referenceSlice) {
      this.currentPage.slices.splice(
        this.currentPage.slices.indexOf(referenceSlice),
        1,
        editedSlice
      );
    },
    setSubSliceInstaceToZero(slices) {
      for (let i = 0; i < slices.length; i++) {
        slices[i].metadata.instance_id = 0;

        if (typeof slices[i].slices === 'object' && slices[i].slices.length > 0) {
          slices[i].slices = this.setSubSliceInstaceToZero(slices[i].slices);
        }
      }

      return slices;
    },
    copySlice(sliceToCopy, referenceSlice) {
      if (referenceSlice === null) {
        referenceSlice = this.currentPage;
      }

      var newSlice = JSON.parse(JSON.stringify(sliceToCopy));
      newSlice.metadata.instance_id = 0;

      if (typeof newSlice.slices === 'object' && newSlice.slices.length > 0) {
        newSlice.slices = this.setSubSliceInstaceToZero(newSlice.slices);
      }

      referenceSlice.slices.push(newSlice);
    },
    removeSlice(deletingSlice, referenceSlice) {
      if (typeof referenceSlice === 'undefined') {
        referenceSlice = this.currentPage;
      }
      referenceSlice.slices.splice(referenceSlice.slices.indexOf(deletingSlice), 1);
    },
    selectVersion(version) {
      // pass version_id through the url
      // location.href=
    }
  },
  computed: {
    ...mapGetters('devise', ['currentPage', 'sliceConfig'])
  },
  mixins: [Strings],
  components: {
    AddIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-add.vue'),
    RefreshIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-refresh.vue'),
    AnalyticTotals: () => import(/* webpackChunkName: "js/devise-pages" */ './AnalyticTotals'),
    draggable: () =>
      import(/* webpackChunkName: "js/devise-modules-unsure-where-to-put" */ 'vuedraggable'),
    ManageSlice: () => import(/* webpackChunkName: "js/devise-editors" */ './slices/ManageSlice'),
    SliceEditor: () => import(/* webpackChunkName: "js/devise-editors" */ './slices/SliceEditor'),
    Toggle: () => import(/* webpackChunkName: "js/devise-utilities" */ './../utilities/Toggle')
  }
};
</script>