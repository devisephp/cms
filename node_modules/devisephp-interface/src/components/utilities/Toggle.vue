<template>
  <label :class="{'dvs-toggle': !mini, 'dvs-mini-toggle': mini}" :for="id">
    <input type="checkbox" v-model="localValue" :id="id" @change="updateValue">
    <div class="dvs-toggle-slider"></div>
  </label>
</template>

<script>
export default {
  name: 'DeviseToggle',
  data() {
    return {
      localValue: true
    };
  },
  mounted() {
    this.localValue = this.value;
  },
  methods: {
    updateValue: function() {
      // Emit the number value through the input event
      this.$emit('input', this.localValue);
      this.$emit('change', this.localValue);
    }
  },
  watch: {
    value(newValue) {
      this.localValue = this.value;
    }
  },
  props: ['value', 'id', 'mini']
};
</script>
