<template>

  <div class="dvs-mb-8">
    <div class="dvs-flex dvs-items-center dvs-mb-4">
      <h3 :style="{color: theme.adminText.color}">Images</h3>
      <div @click="showMediaManager">
        <images-icon class="dvs-ml-4 dvs-cursor-pointer" w="30px" h="30px"/>
      </div>
    </div>


    <div class="dvs-flex dvs-flex-wrap">
      <div class="dvs-w-1/5 dvs-max-w-1/4 dvs-pr-4 dvs-pb-4" v-for="image in value">
        <div class="dvs-p-4 dvs-bg-grey-lighter dvs-text-xs">
          <close-icon class="dvs-cursor-pointer" w="30px" h="30px"/>
          <p class="dvs-mt-2">
            {{ getName(image) }}<br>
            <a href="#" @click.prevent="removeImage(index)">Remove</a>
          </p>
        </div>
      </div>
    </div>

    <help v-if="value.length === 0">
      <p>No images found. Add images using the button above.</p>
    </help>
  </div>

</template>

<script>
  import ImagesIcon from 'vue-ionicons/dist/ios-images.vue'
  import CloseIcon from 'vue-ionicons/dist/ios-search.vue'

  import {mapActions, mapGetters} from 'vuex'

  export default {
    name: 'ImagesField',
    data() {
      return {}
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
        this.value.push(media.url)
        this.updateValue()
      },
      removeImage(index) {
        this.value.splice(index, 1)
      },
      getName(path){
        let parts = path.split('/')
        return parts[ parts.length - 1 ]
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
      CloseIcon
    }
  }
</script>
