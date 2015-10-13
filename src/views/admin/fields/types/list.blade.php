<h3>Select</h3>

<ul data-devise="list1, list, List">
    @foreach ($page->list1->items as $item)
        <li><?= $item->value ?></li>
    @endforeach
</ul>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<ul data-devise="list1, list, List">
    @foreach ($page->list1->items as $item)
        <li>{{ $item->value }}</li>
    @endforeach
</ul>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->list1',
    'values' => $page->list1,
    'descriptions' => [
        'items' => 'Array of list item values'
    ],
])
