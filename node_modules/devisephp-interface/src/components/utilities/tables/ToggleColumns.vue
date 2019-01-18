<template>
  <div class="dvs-mr-4 dvs-relative">
    <div @click="show = true">
      <switch-icon class="dvs-cursor-pointer dvs-float-right"/>
    </div>
    <div
      v-show="show"
      class="dvs-absolute dvs-pin-t dvs-pin-r dvs-mt-1 dvs-z-40 dvs-shadow-lg dvs-border-t-2"
    >
      <div class="dvs-pt-4 dvs-pb-2 dvs-px-4">Toggle Columns
        <span @click="show = false">
          <switch-icon class="dvs-cursor-pointer dvs-float-right"/>
        </span>
      </div>
      <div class="dvs-px-4">
        <div
          class="dvs-flex dvs-px-4 dvs-py-8 dvs-flex dvs-flex-col dvs-max-h-200 dvs-overflow-y-scroll"
        >
          <div>
            <fieldset
              class="dvs-mr-4 dvs-flex dvs-mb-2"
              v-for="(column) in columns"
              :key="column.key"
              v-if="!column.toggleColumns"
            >
              <div class="dvs-flex dvs-items-center">
                <input type="checkbox" v-model="column.show" @change="update">
                <label class="dvs-pl-2">{{ column.label }}</label>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'ToggleColumns',
  data() {
    return {
      show: false,
      columns: []
    };
  },
  mounted() {
    this.columns = this.value;

    for (let i = 0; i < this.columns.length; i++) {
      if (typeof this.columns[i].show === 'undefined') {
        this.$set(this.columns[i], 'show', true);
      }
    }
  },
  methods: {
    update() {
      // TODO - This is current an error and needs to be ported for Devise
      // local.set(this.type + '-columns-' + this.currentTeam.id, this.columns)

      this.$emit('input', this.columns);
    }
  },
  computed: {
    ...mapGetters(['currentTeam'])
  },
  props: {
    value: {
      type: Array,
      required: true
    },
    type: {
      type: String,
      required: true
    }
  },
  components: {
    SwitchIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/md-switch.vue')
  }
};
</script>
