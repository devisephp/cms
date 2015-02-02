<h3>Models (DvsUser)</h3>

@php $user = DvsUser::find(2); @endphp
<div data-devise="$user, Edit the User">{{ $user->email }} has an id of {{ $user->id }}</div>

<pre class="devise-code-snippet">
&lt;php $user = DvsUser::find(2); ?&gt;
&lt;div data-devise&#61;"$user, Edit the User"&gt;@{{ $user->email }} has an id of @{{ $user->id }}&lt;/div&gt;
</pre>