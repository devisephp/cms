<template>

  <div class="dvs-flex dvs-items-stretch dvs-min-h-screen dvs-relative" v-if="user">
    <div id="devise-sidebar">
      <h2 class="dvs-font-bold dvs-mb-2">Manage User</h2>
      <a class="dvs-mb-8 dvs-block dvs-uppercase dvs-font-bold dvs-text-xs" href="#" @click.prevent="goToPage('devise-users-index')">Back to Users</a>
      <ul class="dvs-list-reset dvs-mb-10">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-lg" v-devise-alert-confirm="{callback: requestDeleteUser, message: 'Are you sure you want to delete this user?'}">
          Delete This User
        </li>
      </ul>
    </div>
    <div id="devise-admin-content">
      <h3 class="dvs-mb-8">{{ localValue.name }} Settings</h3>

      <div class="dvs-mb-12">
        <form>
          <fieldset class="dvs-fieldset mb-4">
            <label>Name of User</label>
            <input type="text" autocomplete="off" v-model="localValue.name" placeholder="Name of the User">
          </fieldset>

          <fieldset class="dvs-fieldset mb-4">
            <label>Email</label>
            <input type="text" autocomplete="off" v-model="localValue.email" placeholder="Email of the User">
          </fieldset>

          <fieldset class="dvs-fieldset mb-4" v-if="!showPassword">
            <label>Edit Password?</label>
            <input type="checkbox" v-model="showPassword">
          </fieldset>

          <template v-if="showPassword">
            <fieldset class="dvs-fieldset mb-4">
              <label>Password</label>
              <input type="password" autocomplete="off" v-model="localValue.password">
            </fieldset>

            <fieldset class="dvs-fieldset mb-4">
              <label>Password Confirm</label>
              <input type="password" autocomplete="off" v-model="localValue.password_confirmation">
            </fieldset>
          </template>
        </form>

        <div class="dvs-flex">
          <button @click="requestSaveUser" class="dvs-btn dvs-mr-2">Save</button>
          <button @click="goToPage('devise-users-index')" class="dvs-btn dvs-btn-plain dvs-mr-4">Cancel</button>
        </div>
      </div>

    </div>

  </div>

</template>

<script>
import DeviseModal from './../utilities/Modal'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'UsersView',
  data () {
    return {
      localValue: {},
      modulesToLoad: 1,
      showPassword: false
    }
  },
  mounted () {
    this.retrieveAllUsers()
  },
  methods: {
    ...mapActions('devise', [
      'getUsers',
      'deleteUser',
      'updateUser'
    ]),
    requestSaveUser () {
      this.updateUser({user: this.user, data: this.localValue})
    },
    requestDeleteUser () {
      let self = this
      this.deleteUser(this.user).then(function () {
        self.goToPage('devise-users-index')
      })
    },
    retrieveAllUsers () {
      let self = this
      this.getUsers().then(function () {
        self.localValue = Object.assign({}, self.localValue, self.user)
        window.bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    }
  },
  computed: {
    ...mapGetters('devise', [
      'user'
    ])
  },
  components: {
    DeviseModal
  }
}
</script>
