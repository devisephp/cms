<template>
  <fieldset class="dvs-fieldset">
    <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Number of example words to display</label>
    <div class="dvs-flex">
      <input type="number" min="0" max="200" class="dvs-mr-4 dvs-min-w-1/4 dvs-max-w-1/4" v-model="localValue.settings.numberOfWords" @keyup="updateValue">
      <input type="range" v-model="localValue.settings.numberOfWords" max="200" class="dvs-w-3/4" @change="updateValue">
    </div>
  </fieldset>
</template>

<script>
  import faker from 'faker/locale/en'

  export default {
    data () {
      return {
        localValue: {
          text: '',
          settings: {
            numberOfWords: 15
          }
        }
      }
    },
    mounted () {
      this.localValue = Object.assign(this.localValue, this.value)
    },
    methods: {
      updateValue () {
        this.localValue.text = faker.lorem.words(this.localValue.settings.numberOfWords)
        this.$emit('input', this.localValue)
        this.$emit('change', this.localValue)
      }
    },
    props: ['value']
  }
</script>
