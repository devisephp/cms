<template>
  <devise-installer-item :item="item" id="nav-slices" title="Authentication (required)">
    <template slot="instructions">
      <p>Devise pages are made up of slices and they live inside /resources/views/slices directory. Make this directory and you'll be on your way.</p>
    </template>
  </devise-installer-item>
</template>

<script>
import Item from './../Item';

export default {
  components: {
    Item
  },
  props: {
    item: {
      required: true
    }
  }
};
</script>
