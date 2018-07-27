<template>

  <div>

    <div class="dvs-flex dvs-items-center">
      <input type="text" v-model="value" :maxlength="getMaxLength" disabled>
      <div @click="showMediaManager($)">
        <images-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px"/>
      </div>
      <div @click="loadPreview" v-bind:class="{ ' dvs-opacity-25': !previewEnabled }">
        <search-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px"/>
      </div>
    </div>

    <div v-if="showPreview">
      <portal to="devise-root">
        <div class="dvs-blocker" :style="{backgroundColor: 'transparent'}" @click="showPreview = false"></div>
        <div class="dvs-modal dvs-fixed dvs-pin-b dvs-pin-r dvs-mx-8 dvs-mb-8 dvs-z-40 dvs-w-1/2"
             :style="infoBlockTheme">
          <img :src="value"/>
          <h6 class="dvs-text-base dvs-mb-4 dvs-mt-4" :style="{color: theme.statsText.color}">
            <span>{{ fileName }}</span><br>
            <small class="dvs-text-xs">
              Location:
              <span class="dvs-italic dvs-font-normal">
                {{ value }}
              </span>
            </small>
          </h6>
          <div class="dvs-flex dvs-items-center dvs-mt-4 dvs-justify-between">
            <div>
              <button class="dvs-btn dvs-mr-2" @click="showPreview = false" :style="regularButtonTheme">Close</button>
            </div>
          </div>
        </div>
      </portal>
    </div>

  </div>

</template>

<script>
  import ImagesIcon from 'vue-ionicons/dist/ios-images.vue'
  import SearchIcon from 'vue-ionicons/dist/ios-search.vue'

  import {mapActions, mapGetters} from 'vuex'

  export default {
    name: 'ImagesField',
    data() {
      return {
        showPreview: false
      }
    },
    methods: {
      updateValue: function () {
        // Emit the number value through the input event
        this.$emit('input', this.value)
        this.$emit('change', this.value)
      },
      showMediaManager(event) {
        devise.$bus.$emit('devise-launch-media-manager', {
          callback: this.mediaSelected
        })
      },
      mediaSelected(media) {
        this.value = media.url
        this.updateValue()
      },
      loadPreview() {
        if (this.previewEnabled)
          this.showPreview = true
      }
    },
    computed: {
      fileName() {
        let parts = this.value.split('/')
        return parts[parts.length - 1]
      },
      previewEnabled() {
        return (this.value !== '' && this.value !== null)
      }
    },
    watch: {
      value() {
        this.updateValue()
      }
    },
    props: ['value'],
    components: {
      ImagesIcon,
      SearchIcon
    }
  }
</script>
