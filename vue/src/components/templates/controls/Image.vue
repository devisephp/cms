<template>
  <div>
    <fieldset class="dvs-fieldset dvs-mb-4">
      <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Width of Image</label>
      <div class="dvs-flex">
        <input type="number" min="0" max="2000" class="dvs-mr-4 dvs-min-w-1/4 dvs-max-w-1/4" v-model="localValue.settings.width" @keyup="updateValue">
        <input type="range" v-model="localValue.settings.width" max="2000" class="dvs-w-3/4" @change="updateValue">
      </div>
    </fieldset>
    <fieldset class="dvs-fieldset dvs-mb-4">
      <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Height of Image</label>
      <div class="dvs-flex">
        <input type="number" min="0" max="2000" class="dvs-mr-4 dvs-min-w-1/4 dvs-max-w-1/4" v-model="localValue.settings.height" @keyup="updateValue">
        <input type="range" v-model="localValue.settings.height" max="2000" class="dvs-w-3/4" @change="updateValue">
      </div>
    </fieldset>
    <fieldset class="dvs-fieldset">
      <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Category of Placeholder</label>
      <select v-model="localValue.settings.category" @change="updateValue">
        <option value="image">image</option>
        <option value="avatar">avatar</option>
        <option value="abstract">abstract</option>
        <option value="animals">animals</option>
        <option value="business">business</option>
        <option value="cats">cats</option>
        <option value="city">city</option>
        <option value="food">food</option>
        <option value="nightlife">nightlife</option>
        <option value="fashion">fashion</option>
        <option value="people">people</option>
        <option value="nature">nature</option>
        <option value="sports">sports</option>
        <option value="technics">technics</option>
        <option value="transport">transport</option>
      </select>
    </fieldset>
  </div>
</template>

<script>
  import faker from 'faker'

  export default {
    data () {
      return {
        localValue: {
          url: '',
          settings: {
            width: 800,
            height: 600,
            category: 'cats'
          }
        }
      }
    },
    mounted () {
      this.localValue = Object.assign(this.localValue, this.value)
    },
    methods: {
      updateValue () {
        this.localValue.url = faker.image.imageUrl(
          this.localValue.settings.width,
          this.localValue.settings.height,
          this.localValue.settings.category
        )
        this.$emit('input', this.localValue)
        this.$emit('change', this.localValue)
      }
    },
    props: ['value']
  }
</script>
