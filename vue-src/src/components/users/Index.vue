<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Users</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-index')">Back to Main Menu</a>
      <ul class="dvs-list-reset">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg dvs-cursor-pointer" @click.prevent="showCreate = true">
          Create New User
        </li>
      </ul>
    </div>
    <div id="devise-admin-content">
      <h2 class="dvs-mb-10">Current Users</h2>

      <div v-for="user in users.data" class="dvs-mb-6 dvs-rounded-sm dvs-bg-white dvs-shadow-sm dvs-flex dvs-justify-between dvs-items-center">
        <div class="dvs-min-w-2/5 dvs-text-xl dvs-font-bold dvs-pr-8">
          {{ user.name }}
        </div>
        <div class="dvs-w-2/5 dvs-px-8 dvs-flex dvs-justify-end">
          <button class="dvs-btn dvs-btn-xs" @click="loadUser(user.id)">Manage</button>
        </div>
      </div>
    </div>

    <transition name="fade">
      <devise-modal class="dvs-z-50" v-if="showCreate">
        <h4 class="dvs-mb-4">Create new user</h4>

        <fieldset class="dvs-fieldset mb-4">
          <label>Name</label>
          <input type="text" v-model="newUser.name" placeholder="Name of the User">
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Email</label>
          <input type="text" v-model="newUser.email" placeholder="Email of the User">
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Password</label>
          <input type="password" v-model="newUser.password">
        </fieldset>

        <fieldset class="dvs-fieldset mb-4">
          <label>Confirm Password</label>
          <input type="password" v-model="newUser.password_confirmation">
        </fieldset>

        <button class="dvs-btn" @click="requestCreateUser" :disabled="createInvalid">Create</button>
        <button class="dvs-btn dvs-btn-plain" @click="showCreate = false">Cancel</button>
      </devise-modal>
    </transition>
  </div>

</template>

<script>
import DeviseModal from './../utilities/Modal'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'UsersIndex',
  data () {
    return {
      modulesToLoad: 1,
      showCreate: false,
      newUser: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      }
    }
  },
  mounted () {
    this.retrieveAllUsers()
  },
  methods: {
    ...mapActions('devise', [
      'getUsers',
      'createUser'
    ]),
    requestCreateUser () {
      let self = this
      this.createUser(this.newUser).then(function () {
        self.newUser.name = null
        self.newUser.email = null
        self.newUser.password = null
        self.newUser.password_confirmation = false
        self.showCreate = false
      })
    },
    retrieveAllUsers (loadbar = true) {
      this.getUsers().then(function () {
        if (loadbar) {
          window.bus.$emit('incrementLoadbar', self.modulesToLoad)
        }
      })
    },
    loadUser (id) {
      this.$router.push({name: 'devise-users-edit', params: { userId: id }})
    }
  },
  computed: {
    ...mapGetters('devise', [
      'users'
    ]),
    createInvalid () {
      return this.newUser.name === null ||
             this.newUser.email === null ||
             this.newUser.password === null ||
             this.newUser.password_confirmation === null ||
             this.newUser.password !== this.newUser.password_confirmation
    }
  },
  components: {
    DeviseModal
  }
}
</script>
