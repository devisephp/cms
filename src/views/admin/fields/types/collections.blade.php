<h3>Collections</h3>

@foreach ($page->myCollection as $collection)
	<div data-devise="myCollection[imageName], image, Image For Collection, Collection Name"
		 data-devise="myCollection[textName], text, Text For Collection, Collection Name">
		<p>{{ $collection->textName->text('default value') }}</p>
		<img style="width: 100px;" src="{{ $collection->imageName->image('/packages/devisephp/cms/img/devise-installer-logo.gif') }}" alt="{{ $collection->imageName->caption('default caption') }}">
	</div>
@endforeach


<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
@foreach ($page->myCollection as $collection)
	<div data-devise="myCollection[imageName], image, Image For Collection, Collection Name"
		 data-devise="myCollection[textName], text, Text For Collection, Collection Name">
		<p>{{ $collection->textName->text(\'default value\') }}</p>
		<img style="width: 100px;" src="{{ $collection->imageName->image(\'/packages/devisephp/cms/img/devise-installer-logo.gif\') }}" alt="{{ $collection->imageName->caption(\'default caption\') }}">
	</div>
@endforeach
') ?>
</code></pre>
