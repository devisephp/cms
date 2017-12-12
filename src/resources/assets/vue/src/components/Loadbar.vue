<template>
  <div class="text-center w-full flex flex-col items-center">
    <h6 class="mb-2 text-action">Just a moment</h6>
    <div class="loadbar">
      <div class="bar accent background" :style="{width:loadPercentage * 100 + '%'}"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'loadPercentage'
  ]
}
</script>
