<h3>Checkbox Group</h3>

@snippet
<div data-devise="checkboxGroup1, checkbox-group, Checkbox Group">
   @foreach ($page->checkboxGroup1->checkboxes as $checkbox)
      <label>
         <input type="checkbox" value="{{ $checkbox->key }}" {{ $checkbox->default ? 'checked' : '' }}>
         {{ $checkbox->label }}
      </label>
    @endforeach
</div>
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->checkboxGroup1',
    'values' => $page->checkboxGroup1,
    'descriptions' => [
        'checkboxes' => 'An array of key, labels and defaults of checkboxes'
    ],
])
