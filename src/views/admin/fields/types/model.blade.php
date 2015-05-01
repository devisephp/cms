<h3>Models (DvsUser)</h3>

@php $user = DvsUser::find(1); @endphp
<div data-devise="$user, Edit the User"><?= $user->email ?> has an id of <?= $user->id ?></div>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<?php $user = DvsUser::find(1); ?>
<div data-devise="$user, Edit the User">{{ $user->email }} has an id of {{ $user->id }}</div>
') ?>
</code></pre>