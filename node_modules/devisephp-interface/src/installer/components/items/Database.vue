<template>
  <!-- Database -->
  <devise-installer-item
    :item="item"
    id="nav-database-connection"
    title="Database Connection (required)"
  >
    <template slot="instructions">
      <p>
        Your application will need to connect to a database. You can do this by editing your
        <span
          class="dvs-font-monospace"
        >.env</span> file in the root of your project and ensuring the following values are set:
      </p>
    </template>

    <template slot="example">In your .env file
      <pre class="lang-ini line-numbers" data-start="1">
          <code>
            DB_CONNECTION=mysql
            <br>DB_HOST=127.0.0.1
            <br>DB_PORT=3306
            <br>DB_DATABASE=database_name
            <br>DB_USERNAME=root
            <br>DB_PASSWORD=
            <br>
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
