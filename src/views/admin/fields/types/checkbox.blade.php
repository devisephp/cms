<h3>Checkbox</h3>

@snippet
<p data-devise="checkbox1, checkbox, Checkbox">
    <?= $page->checkbox1->value ? 'Do something with check' : 'Do something else' ?>
</p>
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->checkbox1',
    'values' => $page->checkbox1,
    'descriptions' => [
        'value' => 'Value of this checkbox field (0 or 1)'
    ],
])
