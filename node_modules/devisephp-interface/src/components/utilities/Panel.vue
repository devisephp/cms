<template>
  <div class="dvs-panel">
    <div class="dvs-panel-contents dvs-max-h-screen" :style="panelStyle">
      <div>
        <slot/>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  props: {
    panelStyle: {
      default: null,
      type: Object
    }
  }
};
</script>
