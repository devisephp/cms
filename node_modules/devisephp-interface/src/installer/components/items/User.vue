<template>
  <devise-installer-item :item="item" id="nav-user" title="First Administration User (required)">
    <template slot="instructions">
      <p>You need to update the User.php model to add the HasPermissions trait</p>
      <p>Also, for the first user to login you will need to create a user. You can either enter one directly into the database manually or add one using the form to the right.</p>
    </template>

    <template slot="example">
      <h3 class="dvs-mb-4">Add HasPermissions trait to the User model</h3>
      <div class="dvs-mb-8">
        <pre class="lang-php line-numbers">
          <code>
          &lt;?php
          namespace App;
          use Illuminate\Notifications\Notifiable;
          use Illuminate\Contracts\Auth\MustVerifyEmail;
          use Illuminate\Foundation\Auth\User as Authenticatable;
          use Devise\Traits\HasPermissions;

          class User extends Authenticatable
          {
            use Notifiable, HasPermissions;

            /**
            * The attributes that are mass assignable.
            *
            * @var array
            */
            protected $fillable = [
              'name', 'email', 'password',
            ];

            /**
            * The attributes that should be hidden for arrays.
            *
            * @var array
            */
            protected $hidden = [
              'password', 'remember_token',
            ];
          }
          </code>
        </pre>
      </div>

      <h3 class="dvs-mb-4">Create Your first User
        <template v-if="item">(Already Created)</template>
      </h3>
      <form :class="{'dvs-opacity-50': item}">
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Name</label>
          <input type="text" v-model="newUser.name" :disabled="item">
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-4">
          <label>Email</label>
          <input type="email" v-model="newUser.email" :disabled="item">
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-6">
          <label>Password</label>
          <input type="text" v-model="newUser.password" :disabled="item">
        </fieldset>
        <fieldset class="dvs-fieldset dvs-mb-6">
          <label>Confirm Password</label>
          <input type="text" v-model="newUser.password_confirmation" :disabled="item">
        </fieldset>
        <button
          class="dvs-btn dvs-bg-green dvs-text-white"
          :disabled="item"
          @click.prevent="attemptCreateUser()"
        >Create User</button>
      </form>
    </template>
  </devise-installer-item>
</template>

<script>
import { mapActions, mapState } from 'vuex';

import Item from './../Item';

export default {
  data() {
    return {
      newUser: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    ...mapActions(['createUser']),
    attemptCreateUser() {
      this.createUser(this.newUser);
    }
  },
  components: {
    Item
  },
  props: {
    item: {
      required: true
    }
  }
};
</script>
