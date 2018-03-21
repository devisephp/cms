<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Slices</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-developers-index')">Back to Developers</a>
      <ul class="dvs-list-reset">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg dvs-cursor-pointer" @click.prevent="showCreate = true">
          Create New Slice
        </li>
      </ul>
    </div>
    <div id="devise-admin-content">
      <h2 class="dvs-mb-10">Current Slices</h2>

      <div v-for="slice in slices.data" class="dvs-mb-6 dvs-rounded-sm dvs-bg-white dvs-shadow-sm dvs-flex dvs-justify-between dvs-items-center">
        <div class="dvs-min-w-2/5 dvs-text-base dvs-font-bold dvs-pr-8">
          {{ slice.name }}<br>
          <span class="dvs-font-mono dvs-font-normal">{{ slice.domain }}</span>
        </div>
        <div class="dvs-min-w-1/5 dvs-text-sm dvs-font-mono dvs-pr-8">
          {{ slice.view }}
        </div>
        <div class="dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end">
          <button class="dvs-btn dvs-btn-xs dvs-mr-2" @click="showEditSlice(slice)">Edit</button>
          <button class="dvs-btn dvs-btn-xs" v-devise-alert-confirm="{callback: requestDeleteSlice, arguments: slice, message: 'Are you sure you want to delete this slice?'}">Delete</button>
        </div>
      </div>
    </div>

    <transition name="fade">
      <devise-modal class="dvs-z-50" v-if="showCreate" @close="showCreate = false">
        <h4 class="dvs-mb-4">Create new slice</h4>

        <fieldset class="dvs-fieldset mb-4">
          <label>Name</label>
          <input type="text" v-model="newSlice.name" placeholder="Name of the Slice">
        </fieldset>

        <help class="dvs-mb-8">The view file that you are referencing will be located in the resources/views directory of your project and needs to be referenced through dot notation. For example, if you're referencing "/resources/views/heros/main-hero.blade.php" you will need to put "heros.main-hero" in this field.</help>

        <fieldset class="dvs-fieldset mb-4">
          <label>View</label>
          <input type="text" v-model="newSlice.view" placeholder="View of the Slice">
        </fieldset>

        <button class="dvs-btn" @click="requestCreateSlice" :disabled="createInvalid">Create</button>
        <button class="dvs-btn dvs-btn-plain" @click="showCreate = false">Cancel</button>
      </devise-modal>
    </transition>

    <transition name="fade">
      <devise-modal class="dvs-z-50" v-if="showEdit" @close="showEdit = false">
        <h4 class="dvs-mb-4">Edit slice</h4>

        <fieldset class="dvs-fieldset mb-4">
          <label>Name</label>
          <input type="text" v-model="editSlice.name" placeholder="Name of the Slice">
        </fieldset>

        <button class="dvs-btn" @click="requestEditSlice" :disabled="editInvalid">Edit</button>
        <button class="dvs-btn dvs-btn-plain" @click="showEdit = false">Cancel</button>
      </devise-modal>
    </transition>
  </div>

</template>

<script>
import DeviseModal from './../utilities/Modal'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'SlicesIndex',
  data () {
    return {
      modulesToLoad: 1,
      showCreate: false,
      showEdit: false,
      editAddLanguage: null,
      editSlice: {
        id: null,
        name: null
      },
      newSlice: {
        name: null,
        view: null
      }
    }
  },
  mounted () {
    this.retrieveAllSlices()
  },
  methods: {
    ...mapActions('devise', [
      'getSlices',
      'createSlice',
      'updateSlice',
      'deleteSlice'
    ]),
    requestCreateSlice () {
      let self = this
      this.createSlice(this.newSlice).then(function () {
        self.newSlice.name = null
        self.newSlice.view = null
        self.showCreate = false
      })
    },
    showEditSlice (slice) {
      this.editSlice.id = slice.id
      this.editSlice.name = slice.name
      this.showEdit = true
    },
    requestEditSlice () {
      let self = this
      this.updateSlice({slice: this.originalSlice(this.editSlice.id), data: this.editSlice}).then(function () {
        self.editSlice.id = null
        self.editSlice.name = null
        self.showEdit = false
      })
    },
    requestDeleteSlice (slice) {
      let self = this
      this.deleteSlice(slice).then(function () {
        self.retrieveAllSlices()
      })
    },
    retrieveAllSlices (loadbar = true) {
      this.getSlices().then(function () {
        if (loadbar) {
          window.bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    originalSlice (id) {
      return this.slices.data.find(slice => slice.id === id)
    }
  },
  computed: {
    ...mapGetters('devise', [
      'slices'
    ]),
    createInvalid () {
      return this.newSlice.name === null ||
             this.newSlice.view === null
    },
    editInvalid () {
      return this.editSlice.name === null
    }
  },
  components: {
    DeviseModal
  }
}
</script>
