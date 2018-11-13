<template>
    <div class="dvs-p-8">
        <h3 class="mb-6" :style="{color: theme.panel.color}">Mothership</h3>
        <ul class="dvs-list-reset dvs-mt-8">
            <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold"
                @click="goToPage('devise-ms-analytics-index')">
                Analytics
            </li>
            <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold"
                @click.prevent="goToPage('devise-ms-releases-index')">
                Releases
            </li>
            <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold"
                @click.prevent="goToPage('devise-ms-healthreports-index')">
                Health Report
            </li>
            <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold"
                @click.prevent="goToPage('devise-ms-backups-index')">
                Backups
            </li>
        </ul>
    </div>
</template>

<script>

  export default {
    name: 'MothershipIndex'
  }
</script>