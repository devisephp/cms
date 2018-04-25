<template>
  <div>
    <fieldset class="dvs-fieldset dvs-mb-4">
      <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Width of Image</label>
      <div class="dvs-flex">
        <input type="number" min="0" max="2000" class="dvs-mr-4 dvs-min-w-1/3 dvs-max-w-1/3" v-model="localValue.settings.width" @keyup="updateValue">
        <input type="range" v-model="localValue.settings.width" max="2000" class="dvs-w-2/3" @change="updateValue">
      </div>
    </fieldset>
    <fieldset class="dvs-fieldset dvs-mb-4">
      <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Height of Image</label>
      <div class="dvs-flex">
        <input type="number" min="0" max="2000" class="dvs-mr-4 dvs-min-w-1/3 dvs-max-w-1/3" v-model="localValue.settings.height" @keyup="updateValue">
        <input type="range" v-model="localValue.settings.height" max="2000" class="dvs-w-2/3" @change="updateValue">
      </div>
    </fieldset>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        localValue: {
          url: '',
          settings: {
            width: 800,
            height: 600
          }
        }
      }
    },
    mounted () {
      this.localValue = Object.assign(this.localValue, this.value)
    },
    methods: {
      updateValue () {
        this.localValue.url = this.url

        this.$emit('input', this.localValue)
        this.$emit('change', this.localValue)
      }
    },
    computed: {
      url () {
        return 'https://picsum.photos/' + this.localValue.settings.width + '/' + this.localValue.settings.height + '?random'
      }
    },
    props: ['value']
  }
</script>
