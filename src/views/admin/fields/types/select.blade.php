<h3>Select</h3>

<select data-devise="select1, select, Select">
    @foreach ($page->select1->options as $option)
        <option value="<?= $option->value ?>"><?= $option->name ?></option>
    @endforeach
</select>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<select data-devise="select1, select, Select">
    @foreach ($page->select1->options as $option)
        <option value="{{ $option->value }}">{{ $option->name }}</option>
    @endforeach
</select>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->select1',
    'values' => $page->select1,
    'descriptions' => [
        'value' => 'Current value of the select box',
        'options' => 'Array of name, value pairs for this select field.'
    ],
])
