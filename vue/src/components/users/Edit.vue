<template>

  <div class="dvs-flex dvs-justify-end dvs-items-stretch dvs-min-h-screen dvs-relative" v-if="user">
    <div id="devise-sidebar">
      
      <sidebar-header title="Manage User" back-text="Back to Users" back-page="devise-users-index" />

      <ul class="dvs-list-reset dvs-mb-10">
        <li class="dvs-cursor-pointer dvs-mb-6 dvs-text-sm uppercase font-bold" v-devise-alert-confirm="{callback: requestDeleteUser, message: 'Are you sure you want to delete this user?'}">
          Delete This User
        </li>
      </ul>
    </div>
    <div id="devise-admin-content" :style="adminTheme">
      <h3 class="dvs-mb-8" :style="{color: theme.adminText.color}">{{ localValue.name }} Settings</h3>

      <div class="dvs-mb-12">
        <form>
          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Name of User</label>
            <input type="text" autocomplete="off" v-model="localValue.name" placeholder="Name of the User">
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4">
            <label>Email</label>
            <input type="text" autocomplete="off" v-model="localValue.email" placeholder="Email of the User">
          </fieldset>

          <fieldset class="dvs-fieldset dvs-mb-4" v-if="!showPassword">
            <label>Edit Password?</label>
            <input type="checkbox" v-model="showPassword">
          </fieldset>

          <template v-if="showPassword">
            <fieldset class="dvs-fieldset dvs-mb-4">
              <label>Password</label>
              <input type="password" autocomplete="off" v-model="localValue.password">
            </fieldset>

            <fieldset class="dvs-fieldset dvs-mb-4">
              <label>Password Confirm</label>
              <input type="password" autocomplete="off" v-model="localValue.password_confirmation">
            </fieldset>
          </template>
        </form>

        <div class="dvs-flex">
          <button @click="requestSaveUser" class="dvs-btn dvs-mr-2" :style="actionButtonTheme">Save</button>
          <button @click="goToPage('devise-users-index')" class="dvs-btn dvs-btn-plain dvs-mr-4" :style="regularButtonTheme">Cancel</button>
        </div>
      </div>

    </div>

  </div>

</template>

<script>
import SidebarHeader from './../utilities/SidebarHeader'

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
        devise.$bus.$emit('incrementLoadbar', self.modulesToLoad)
      })
    }
  },
  computed: {
    ...mapGetters('devise', [
      'user'
    ])
  },
  components: {
    SidebarHeader
  }
}
</script>
