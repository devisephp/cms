<h3>Color</h3>

<p data-devise="color1, color, Color, null, null, backgroundColor" style="padding:20px; border-radius:3px; background-color: <?= $page->color1->color('#61BABC') ?>;">
	Showing the color <?= $page->color1->color('#61BABC') ?>
</p>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<p data-devise="color1, color, Color, null, null, backgroundColor" style="padding:20px; border-radius:3px; background-color: {{ $page->color1->color(\'#61BABC\') }};">
	Showing the color {{ $page->color1->color(\'#61BABC\') }}
</p>
') ?>
</code></pre>


@include('devise::admin.fields.show',
[
    'name' => '$page->color1',
    'values' => $page->color1,
    'descriptions' => [
      'color' => '#hexidecimal color value for this field'
    ],
])
