<template>
  <section>
    <div>
      <h3 class="dvs-my-4">{{ title }}</h3>

      <close-circle-icon w="50" v-if="!item" h="50"/>
      <div v-else class="dvs-text-green">
        <checkmark-icon w="50" h="50"/>
      </div>

      <slot name="instructions"/>
    </div>

    <div>
      <slot name="example"></slot>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    item: {
      required: true,
      type: Boolean
    },
    title: {
      required: true,
      type: String
    }
  }
};
</script>

