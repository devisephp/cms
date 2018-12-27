<template>
  <div>
    <div>
      <help
        class="dvs-mb-8"
        v-if="!model"
      >The models below are loaded by Devise by scanning your Laravel application directory for anything that extends the Model class. Ensure it does this for it to appear below.</help>
      <fieldset class="dvs-fieldset dvs-mb-4" v-if="storeModels.length > 0">
        <label>Select a Model</label>
        <select v-model="model" @change="updateModelQueryModel()">
          <option :value="null">Select a Model</option>
          <option :value="model" v-for="model in storeModels" :key="model.id">{{ model.name }}</option>
        </select>
      </fieldset>
    </div>
    <div v-if="model" class="dvs-relative dvs-mb-8">
      <super-table
        v-model="modelQuery"
        :model="model"
        :editData="editData"
        :columns="model.columns"
        :showLinks="false"
        @input="update"
      />
    </div>
    

    <button @click="save" class="dvs-btn" :style="theme.actionButton">Save</button>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      firstRecord: false,
      limit: 20,
      paginated: false,
      model: null,
      modelQuery: null,
      name: null,
      filters: {}
    };
  },
  mounted() {
    let self = this;

    if (typeof this.editData === "undefined") {
      this.model = this.value.model;
      this.name = this.value.name;
      this.modelQuery = this.value.modelQuery;
    }

    this.getModels().then(function() {
      if (typeof self.editData !== "undefined") {
        self.model = self.storeModels.find(
          model => model.class === self.editData.filters.class
        );
        self.name = self.editData.key;
        self.modelQuery = self.editData.filters.class;
        self.filters = self.editData.filters;
      }
    });
  },
  methods: {
    ...mapActions("devise", ["getModels", "getModelSettings"]),
    save() {
      this.update();
      this.$emit("save");
    },
    update() {
      this.$emit("input", {
        model: this.model,
        name: this.name,
        modelQuery: this.modelQuery
      });
    },
    updateModelQueryModel() {
      let self = this;
      if (this.model !== null) {
        this.modelQuery = this.model.class;
      }
      if (this.model === null) {
        this.modelQuery = null;
      }
      this.$nextTick(function() {
        self.update();
      });
    }
  },
  computed: {
    ...mapGetters("devise", ["storeModels", "modelSettings"])
  },
  components: {
    SuperTable: () =>
      import(/* webpackChunkName: "js/devise-tables" */ "./../utilities/tables/SuperTable")
  },
  props: ["value", "editData"]
};
</script>
