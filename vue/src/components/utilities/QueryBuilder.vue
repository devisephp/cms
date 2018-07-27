<template>
  <div>
    <div>
      <help class="dvs-mb-8" v-if="!model">
        The models below are loaded by Devise by scanning your Laravel application directory for anything that extends the Model class. Ensure it does this for it to appear below.
      </help>
      <fieldset class="dvs-fieldset dvs-mb-4" v-if="storeModels.length > 0">
        <label>Select a Model</label>
        <select v-model="model">
          <option :value="null">Select a Model</option>
          <option :value="model" v-for="model in storeModels" :key="model.id">{{ model.name }}</option>
        </select>
      </fieldset>
    </div>
    <div v-if="model">
      <super-table
          v-model="modelQuery"
          :columns="model.columns"
          :showLinks="false"
          @cancel="cancel"
          @done="update"
          />
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

import SuperTable from '../utilities/tables/SuperTable'

export default {
  data () {
    return {
      model: null,
      modelQuery: null
    }
  },
  mounted () {
    this.model = this.value.model
    this.modelQuery = this.value.modelQuery

    this.getModels()
  },
  methods: {
    ...mapActions('devise', [
      'getModels',
      'getModelSettings'
    ]),
    update () {
      this.$emit('input', {
        model: this.model, 
        modelQuery: this.modelQuery
      })
    },
    cancel () {
      this.model = null
      this.modelQuery = null
    }
  },
  computed: {
    ...mapGetters('devise', [
      'storeModels',
      'modelSettings'
    ])
  },
  components: {
    SuperTable
  },
  props: ['value']
}
</script>
