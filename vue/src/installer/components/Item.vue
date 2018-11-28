<template>
  <section>
    <div>
      <h3 class="dvs-my-4">{{ title }}</h3>

      <item-check :item="item"></item-check>

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
