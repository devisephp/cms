<template>
  <div class="text-ptext min-h-screen">
    <div v-if="!loaded" class="absolute absolute-center w-1/2">
      <loadbar :load-percentage=".5"></loadbar>
    </div>
    <div v-else class="min-h-screen">
      <div class="bg-lighter text-light py-4 px-8 flex justify-between">
        Top Navigation
      </div>

      <div class="flex items-stretch min-h-screen">

        <div class="bg-lighter mt-1 p-8 w-1/4" v-if="directories.length > 0">

          <ul class="list-reset">
            <li v-for="directory in directories" class="cursor-pointer mt-2 text-bold text-white" @click="changeDirectories(directory.path)">
              {{ directory.name }}
            </li>
          </ul>
        </div>
        <div class=" w-3/4 mx-8">
          <breadcrumbs :currentDirectory="currentDirectory" @chooseDirectory="changeDirectories"></breadcrumbs>
          <ul class="list-reset">
            <li v-for="file in files" class="bg-light text-darker card p-4 mt-2 w-full cursor-pointer" @click="toggleFile(file)">
              <div v-if="!file.on" class="flex justify-between items-center">
                <img :src="file.thumb" height="50">
                {{ file.name }}
                <div class="rounded-full" :class="{
                  'bg-action-light': isActive(file),
                  'bg-darker': !isActive(file)
                }" style="height:10px;width:10px;"></div>
              </div>
              <div v-else class="flex">
                <div class="w-1/2 mr-8">
                  <a :href="file.url" target="_blank"><img :src="file.url"></a>
                </div>
                <div class="w-1/2">
                  <h6>Filename</h6>
                  <p class="text-darker">{{ file.name }}</p>

                  <h6 class="mt-4">Size</h6>
                  <p class="text-darker">{{ file.size }}</p>

                  <template v-if="isActive(file)">
                    <h6 class="my-2">Appears On</h6>
                    <ul class="list-reset">
                      <li v-for="field in file.fields" class="flex border-b border-white py-2 justify-between">
                        <p class="text-darker">Page - Field</p>
                        <a :href="field.page_slug" target="_blank" class="btn btn-sm">{{ field.page_title }} - {{ field.field_name }}</a>
                      </li>
                    </ul>
                  </template>

                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  import Loadbar from './Loadbar'
  import Breadcrumbs from './Breadcrumbs'

  export default {
    data () {
      return {
        loaded: false
      }
    },
    mounted () {
      this.changeDirectories('')
    },
    methods: {
      ...mapActions([
        'setCurrentDirectory',
        'getCurrentFiles',
        'getCurrentDirectories',
        'toggleFile'
      ]),
      changeDirectories (directory) {
        console.log('here')
        let self = this
        self.loaded = false

        self.setCurrentDirectory(directory).then(function () {
          // self.getCurrentFiles().then(function () {
          self.getCurrentDirectories().then(function () {
            self.loaded = true
          })
          // })
        })
      },
      isActive (file) {
        return file.fields.length > 0 || file.global_fields.length > 0
      }
    },
    computed: {
      ...mapGetters([
        'files',
        'directories',
        'currentDirectory'
      ])
    },
    components: {
      'loadbar': Loadbar,
      'breadcrumbs': Breadcrumbs
    }
  }
</script>
