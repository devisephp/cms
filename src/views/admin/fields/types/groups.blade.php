<h3>Groups</h3>

<p data-devise="colorGroup, color, Color, Group Example, null, backgroundColor" style="background-color: <?= $page->colorGroup->color('pink') ?>;">
	Showing the color <?= $page->colorGroup->color('pink') ?>
</p>
<p data-devise="textGroup, text, Text, Group Example">
    <?= $page->textGroup->text('This is some default text') ?>
<p>


<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<p data-devise="colorGroup, color, Color, Group Example, null, backgroundColor" style="background-color: {{ $page->colorGroup->color(\'blue\') }};">
	Showing the color {{ $page->colorGroup->color(\'pink\') }}
</p>
<p data-devise="textGroup, text, Text, Group Example">
    {{ $page->textGroup->text(\'This is some default text\') }}
<p>
') ?>
</code></pre>
