<template>

  <div class="dvs-flex dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Settings</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-pages-index')">Back to Administration</a>
      <ul class="dvs-list-reset dvs-mb-10">
        <li class="dvs-mb-6 dvs-text-lg dvs-cursor-pointer" @click="goToPage('devise-meta-manage')">
          Global Meta
        </li>
        <li class="dvs-mb-6 dvs-text-lg dvs-cursor-pointer" @click="goToPage('devise-languages-manage')">
          Languages
        </li>
      </ul>
    </div>
  </div>

</template>

<script>
export default {
  name: 'SettingsIndex'
}
</script>
