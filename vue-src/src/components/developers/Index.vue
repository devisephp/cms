<template>
  <div class="dvs-p-8">
    <h2 class="dvs-font-bold dvs-mb-2">Developers</h2>
    <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-index')">Back to Main Menu</a>
    <ul class="dvs-list-reset">
      <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click.prevent="goToPage('devise-slices-index')">
        Slices
      </li>
      <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" @click.prevent="goToPage('devise-sites-index')">
        Sites
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'DevelopersIndex'
}
</script>
