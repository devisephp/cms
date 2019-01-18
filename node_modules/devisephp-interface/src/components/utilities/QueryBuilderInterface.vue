<template>
  <fieldset class="dvs-fieldset dvs-mb-10">
    <label>Manage Data</label>
    <help
      v-if="modelQueries === null || modelQueries.length < 1"
    >Currently you don't have any data assigned to this template. Data you add will be available whenever this template is applied to a page</help>
    <div
      class="dvs-flex dvs-justify-between dvs-items-center dvs-text-sm dvs-mb-2 dvs-font-bold dvs-p-4 dvs-rounded dvs-relative"
      :style="theme.actionButtonGhost"
      v-for="(query, key) in modelQueries"
      :key="key"
      v-else
    >
      {{ key }}
      <div
        @click="requestEditData(key)"
        class="dvs-absolute dvs-mt-3 dvs-mr-10 dvs-pin-t dvs-pin-r dvs-pin-b dvs-mr-4"
      >
        <edit-icon class="dvs-cursor-pointer" w="25" h="25"/>
      </div>
      <div
        @click="removeData(key)"
        class="dvs-absolute dvs-mt-3 dvs-pin-t dvs-pin-r dvs-pin-b dvs-mr-4"
      >
        <trash-icon class="dvs-cursor-pointer" w="25" h="25"/>
      </div>
    </div>
    <fieldset class="dvs-fieldset dvs-mt-8">
      <label>Add New Data</label>
      <div class="relative">
        <input
          type="text"
          placeholder="Variable Name"
          :value="newData.name"
          @input="newData.name = slugify($event.target.value)"
        >
        <div
          class="dvs-absolute dvs-mt-2 dvs-pin-t dvs-pin-r dvs-pin-b dvs-mr-4"
          :style="{color:theme.actionButtonGhost.color}"
          @click="addData"
        >
          <add-icon class="dvs-cursor-pointer" w="25" h="25"/>
        </div>
      </div>
    </fieldset>

    <portal to="devise-root">
      <devise-modal @close="showAddData = false" v-if="showAddData" class="dvs-z-50">
        <query-builder v-model="newData" @save="addNewData" @close="showAddData = false"></query-builder>
      </devise-modal>
    </portal>

    <portal to="devise-root">
      <devise-modal @close="showEditData = false" v-if="showEditData" class="dvs-z-50">
        <query-builder
          v-model="newData"
          :editData="editData"
          @save="saveEditData"
          @close="showEditData = false"
        ></query-builder>
      </devise-modal>
    </portal>
  </fieldset>
</template>

<script>
var qs = require('qs');

import DeviseModal from './Modal';
import QueryBuilder from './QueryBuilder';
import Strings from './../../mixins/Strings';

export default {
  name: 'QueryBuilderInterface',
  data() {
    return {
      showAddData: false,
      showEditData: false,
      editData: {
        key: null,
        model: null,
        filters: {}
      },
      newData: {
        name: null,
        model: null,
        modelQuery: null
      }
    };
  },
  methods: {
    addData() {
      if (this.newData.name !== null && this.newData.name !== '') {
        this.showAddData = true;
        this.newData.model = null;
        this.newData.modelQuery = null;
      } else {
        devise.$bus.$emit('showError', 'You must provide a variable name');
      }
    },
    addNewData() {
      if (this.modelQueries === null) {
        this.$set(this.localValue, 'model_queries', {});
      }

      this.$set(this.modelQueries, this.newData.name, `class=${this.newData.modelQuery}`);
      this.showAddData = false;

      this.newData = {
        name: null,
        model: null,
        modelQuery: null
      };
    },
    requestEditData(key) {
      let modelQuery = qs.parse(this.modelQueries[key]);
      this.editData = {
        key: key,
        model: modelQuery.class,
        filters: modelQuery
      };
      this.showEditData = true;
    },
    saveEditData() {
      this.showEditData = false;
      this.$set(this.modelQueries, this.newData.name, `class=${this.newData.modelQuery}`);

      this.editData = {
        key: null,
        model: null,
        filters: {}
      };

      this.newData = {
        name: null,
        model: null,
        modelQuery: null
      };
    },
    removeData(key) {
      this.$delete(this.modelQueries, key);
    }
  },
  computed: {
    modelQueries: {
      get() {
        return this.value;
      },
      set(newValue) {
        this.$emit('input', newValue);
      }
    }
  },
  mixins: [Strings],
  components: {
    AddIcon,
    EditIcon,
    DeviseModal,
    QueryBuilder,
    TrashIcon,
    AddIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-add-circle.vue'),
    EditIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-create.vue'),
    TrashIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-trash.vue')
  },
  props: ['value']
};
</script>
