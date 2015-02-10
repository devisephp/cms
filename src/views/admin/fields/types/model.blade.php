<h3>Models (DvsUser)</h3>

@php $user = DvsUser::find(1); @endphp
<div data-devise="$user, Edit the User">{{ $user->email }} has an id of {{ $user->id }}</div>

<pre class="devise-code-snippet">
	<code class="html">
&lt;php $user = DvsUser::find(1); ?&gt;
&lt;div data-devise&#61;"$user, Edit the User"&gt;@{{ $user->email }} has an id of @{{ $user->id }}&lt;/div&gt;
	</code>
</pre>
