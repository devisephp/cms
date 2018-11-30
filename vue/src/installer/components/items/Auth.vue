<template>
  <devise-installer-item :item="item" id="nav-auth" title="Authentication (required)">
    <template slot="instructions">
      <p>Devise is not opinionated about the authentication system that you use. But to get started fast you can use the one that ships with Laravel which is great for systems with simple permissions.</p>
      <p>
        More information on laravels authentication you can read the documentation
        <a
          href="https://laravel.com/docs/5.7/authentication"
        >here</a>
      </p>
    </template>

    <template slot="example">
      <p>From the root of your project on the command line run the following command</p>
      <pre class="lang-bash" data-start="1">
          <code>
            php artisan make:auth
          </code>
        </pre>
    </template>
  </devise-installer-item>
</template>

<script>
import Item from './../Item';

export default {
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
