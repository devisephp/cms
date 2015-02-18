<h3>Color</h3>

@snippet
<p data-devise="color1, color, Color, null, null, backgroundColor" style="background-color: <?= $page->color1->color('blue') ?>;">
	Showing the color <?= $page->color1->color('blue') ?>
</p>
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->color1',
    'values' => $page->color1,
    'descriptions' => [
      'color' => '#hexidecimal color value for this field'
    ],
])
