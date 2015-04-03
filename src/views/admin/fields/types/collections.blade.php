<h3>Collections</h3>

<div data-devise="myCollection[imageName], image, Image For Collection, Collection Name"></div>
<div data-devise="myCollection[textName], text, Text For Collection, Collection Name"></div>

@if (isset($myCollection))
    @foreach ($myCollection as $collection)
        <?= $collection->textName->text('default value') ?>
    @endforeach
@endif


<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<div data-devise="myCollection[imageName], image, Image For Collection, Collection Name"></div>
<div data-devise="myCollection[textName], text, Text For Collection, Collection Name"></div>

@if (isset($myCollection))
    @foreach ($myCollection as $collection)
        {{ $collection->textName->text(\'default value\') }}
    @endforeach
@endif
') ?>
</code></pre>
