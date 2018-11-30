<template>
  <!-- Laravel Routes -->
  <devise-installer-item id="nav-remove-laravel-route" title="Remove Laravel Routes (Optional)">
    <template slot="instructions">
      <p>Laravel ships with a default route for the homepage and if you ran the "make:auth" command above added some more. You most likely want to remove these.</p>
      <help>
        <strong>Important:</strong> Do NOT remove the Auth::routes(); line from web.php
      </help>
    </template>

    <template slot="example">
      <h3 class="dvs-mb-4">Where the routes are located:</h3>
      <p>In '/routes/web.php' remove the following:</p>
      <pre class="lang-bash" data-start="1">
                <code>
                  Route::get('/', function () {
                      return view('welcome');
                  });
                </code>
              </pre>
      <pre class="lang-bash" data-start="1">
                <code>
                  Route::get('/home', 'HomeController@index')->name('home');
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
  }
};
</script>
