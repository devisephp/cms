<h3>Model Group (DvsUser)</h3>

@php $users = DvsUser::where('id', '<', 4)->get(); @endphp
@foreach ($users as $user)
	<div data-devise="$user, User $user->id, Edit Users">We might want to edit user {{ $user->id }} inside a group.</div>
@endforeach

<pre class="devise-code-snippet">
&lt;php $users = DvsUser::where('id', '&lt;', 4)->get(); ?&gt;
&#64;foreach ($users as $user)
&lt;div data-devise&#61;"$user, User $user->id, Edit Users"&gt;We might want to edit user @{{ $user->id }} inside a group.&lt;/div&gt;
&#64;endforeach
</pre>