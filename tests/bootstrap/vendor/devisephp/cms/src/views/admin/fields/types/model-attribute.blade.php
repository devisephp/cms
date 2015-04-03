<h3>Model Attributes (DvsUser)</h3>

@php $user = DvsUser::find(1); @endphp
<div data-devise="$user->email, Edit the User Email">So... <?= $user->email ?> has an id of <?= $user->id ?> but you already knew that right? Here we edit only the `email` attribute of a user.</div>

<pre class="devise-code-snippet">
	<code class="html">
&lt;php $user = DvsUser::find(2); ?&gt;
&lt;div data-devise&#61;"$user->email, Edit the User Email"&gt;So... @<?= $user->email ?> has an id of @<?= $user->id ?> but you already knew that right? Here we edit only the `email` attribute of a user.&lt;/div&gt;
	</code>
</pre>
