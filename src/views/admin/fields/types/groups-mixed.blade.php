<h3>Mixed Groups</h3>

<!-- field -->
<p data-devise="groupField, text, Text, Mixed Group"></p>

<!-- collection -->
<p data-devise="groupCol[key1], text, Text, Collection Name Inside Group, Mixed Group"></p>
<p data-devise="groupCol[key2], datetime, Datetime, Collection Name Inside Group, Mixed Group"></p>

<!-- model -->
<?php $user = DvsUser::find(1); ?>
<p data-devise="$user, User $user->id, Mixed Group"></p>

<!-- model attribute -->
<p data-devise="$user->email, User $user->id Email, Mixed Group"></p>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<!-- field -->
<p data-devise="groupField, text, Text, Mixed Group"></p>

<!-- collection -->
<p data-devise="groupCol[key1], text, Text, Mixed Group"></p>
<p data-devise="groupCol[key2], datetime, Datetime, Mixed Group"></p>

<!-- model -->
<?php $user = DvsUser::find(1); ?>
<p data-devise="$user, User $user->id, Mixed Group"></p>

<!-- model attribute -->
<p data-devise="$user->email, User $user->id Email, Mixed Group"></p>
') ?>
</code></pre>
