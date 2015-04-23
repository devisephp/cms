<h3>Groups with Categories</h3>

<p data-devise="color5, color, Color, Group with Categories, Category 1, backgroundColor" style="background-color: <?= $page->color5->color('blue') ?>;">
	Showing the color <?= $page->color5->color('pink') ?>
</p>
<p data-devise="text5, text, Text, Group with Categories, Category 2">
    <?= $page->text5->text('This is some default text') ?>
<p>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<p data-devise="color5, color, Color, Group with Categories, Category 1, backgroundColor" style="background-color: <?= $page->color5->color(\'pink\') ?>;">
	Showing the color <?= $page->color5->color(\'pink\') ?>
</p>
<p data-devise="text5, text, Text, Group with Categories, Category 2">
    <?= $page->text5->text(\'This is some default text\') ?>
<p>
') ?>
</code></pre>
