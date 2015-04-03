<h3>Map</h3>

<p data-devise="map1, map, Map">
    figure out how to display google map here
</p>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<p data-devise="map1, map, Map">
    figure out how to display google map here
</p>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->map1',
    'values' => $page->map1,
    'descriptions' => [
        'address' => 'Full address to be displayed in map',
        'latitude' => 'Latitude on map',
        'longitude' => 'Longitude on map',
        'mode' => 'Show map in Streets, Satellite or Hybrid mode',
        'minZoom' => 'Amount allowed to zoom in on map scaled 1 thru 19',
        'maxZoom' => 'Amount allowed to zoom out on map scalled 1 thru 19',
    ],
])

