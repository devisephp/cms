<template>
  <div>
    <close-circle-icon :w="size.toString()" :h="size.toString()" v-if="!item"/>
    <div v-else class="dvs-text-green">
      <checkmark-icon :w="size.toString()" :h="size.toString()"/>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Boolean,
      required: true
    },
    size: {
      type: Number,
      default: 50
    }
  }
};
</script>

<style>
</style>
