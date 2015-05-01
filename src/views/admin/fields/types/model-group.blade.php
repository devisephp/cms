<h3>Model Group (DvsUser)</h3>

@php $users = DvsUser::where('id', '<', 4)->get(); @endphp

@foreach ($users as $user)
	<div data-devise="$user, User $user->id, Edit Users">We might want to edit user <?= $user->id ?> inside a group.</div>
@endforeach

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<?php $users = DvsUser::where(\'id\', \'<\', 4)->get(); ?>

@foreach ($users as $user)
	<div data-devise="$user, User $user->id, Edit Users">
		We might want to edit user {{ $user->id }} inside a group.
	</div>
@endforeach
') ?>
</code></pre>

