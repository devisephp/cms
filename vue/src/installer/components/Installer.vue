<template>
  <div class="dvs-flex">
    <div id="sidebar" class="dvs-absolute dvs-pin-l dvs-pin-t dvs-pin-b dvs-bg-grey-lighter">Sidebar</div>

    <div id="content" class="dvs-absolute dvs-pin dvs-overflow-scroll">
      <section>
        <div>
          <h1 class="dvs-mb-8 dvs-font-light">Welcome to Devise</h1>

          <p
            class="dvs-text-xl dvs-mb-16"
          >We are very excited that you are giving Devise 2 a spin. We are still in the early beta stages of this product so things may change but until then we encourage you to check out the project, submit any PR's or suggestions on Github.</p>

          <div class="dvs-text-left dvs-w-full">
            <h2 class="dvs-mb-4">Installation</h2>

            <p
              class="dvs-mb-4"
            >Below we have setup an interactive installer that will continually poll to see if you have correctly configured your server and application for Devise. Once you have turned all the items in "Required Setup" green you are good to go. However, we have also provided some helpful items in "Non-required Setup" that you may want to take a look at.</p>

            <div
              class="dvs-mb-8 dvs-relative dvs-flex dvs-items-center dvs-bg-green-lightest dvs-p-8 dvs-border dvs-rounded dvs-border-green dvs-text-green"
            >
              <alert-icon w="40" h="40" class="dvs-mr-4"/>
              <p>Click on any of the items below to get some helpful hints!</p>
            </div>

            <h3 class="dvs-mb-4">Required Setup</h3>
          </div>
        </div>
        <div>asdfasdf</div>
      </section>

      <!-- Database -->
      <devise-installer-item :item="checklist.database" title="Database Connection">
        <template slot="instructions">
          <p>Your application will need to connect to a database. You can do this by editing your
            <span class="dvs-font-monospace">.env</span> file in the root of your project and ensuring the following values are set:
          </p>
        </template>

        <template slot="example">
          <div
            class="dvs-bg-grey-light dvs-border-grey dvs-border-l-8 dvs-p-4 dvs-text-black dvs-w-full"
          >
            <code>DB_CONNECTION=mysql
              <br>DB_HOST=127.0.0.1
              <br>DB_PORT=3306
              <br>DB_DATABASE=database_name
              <br>DB_USERNAME=root
              <br>DB_PASSWORD=
              <br>
            </code>
          </div>
        </template>
      </devise-installer-item>

      <!-- Migrations -->
      <devise-installer-item :item="checklist.migrations" title="Database Migrations">Migrations</devise-installer-item>

      <!-- Authentication -->
      <devise-installer-item :item="checklist.auth" title="Authentication">Authentication</devise-installer-item>

      <!-- User -->
      <devise-installer-item :item="checklist.auth" title="First Administration User">user</devise-installer-item>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      openItems: {
        database: false,
        migrations: false,
        auth: false,
        user: false,
        site: false,
        page: false,
        image_library: false,
        image_optimization: false,
        remove_routes: false,
        remove_login_home: false,
        change_auth_config: false,
        setting_up_dev: false
      }
    };
  },
  computed: {
    checklist() {
      return this.$store.state.checklist;
    }
  }
};
</script>

<style lang="scss">
body {
  background-color: aquamarine;
}

#sidebar {
  width: 200px;
}

#content {
  left: 200px;
}

section {
  display: flex;

  > div {
    &:first-child {
      width: 50%;
      color: rgb(72, 82, 91);
      background-color: #f8fafc;
      padding: 3em;
    }

    &:last-child {
      width: 50%;
      background-color: #22292f;
      color: #f8fafc;
      padding: 3em;
    }
  }
}
</style>