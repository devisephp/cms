<h3>Checkbox</h3>

<p data-devise="checkbox1, checkbox, Checkbox">
    <?= $page->checkbox1->value ? 'Do something with check' : 'Do something else' ?>
</p>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<p data-devise="checkbox1, checkbox, Checkbox">
    {{ $page->checkbox1->value ? \'Do something with check\' : \'Do something else\' }}
</p>
') ?>
</code></pre>


@include('devise::admin.fields.show',
[
    'name' => '$page->checkbox1',
    'values' => $page->checkbox1,
    'descriptions' => [
        'value' => 'Value of this checkbox field (0 or 1)'
    ],
])
