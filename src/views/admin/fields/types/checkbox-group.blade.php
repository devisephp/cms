<h3>Checkbox Group</h3>

<div data-devise="checkboxGroup1, checkbox-group, Checkbox Group">
   @foreach ($page->checkboxGroup1->checkboxes as $checkbox)
      <label>
         <input type="checkbox" value="<?= $checkbox->key ?>" <?= $checkbox->default ? 'checked' : '' ?>>
         <?= $checkbox->label ?>
      </label>
    @endforeach
</div>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<div data-devise="checkboxGroup1, checkbox-group, Checkbox Group">
   @foreach ($page->checkboxGroup1->checkboxes as $checkbox)
      <label>
         <input type="checkbox" value="{{ $checkbox->key }}" {{ $checkbox->default ? \'checked\' : \'\' }}>
         {{ $checkbox->label }}
      </label>
    @endforeach
</div>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->checkboxGroup1',
    'values' => $page->checkboxGroup1,
    'descriptions' => [
        'checkboxes' => 'An array of key, labels and defaults of checkboxes'
    ],
])
