<h3>Textarea</h3>

@snippet
<p data-devise="textarea1, textarea, Text Area">
    {{ $page->textarea1->text('This is some default text') }}
<p>
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->textarea1',
    'values' => $page->textarea1,
    'descriptions' => [
        'text' => 'The value of the text field',
        'maxlength' => 'The maximum amount of characters that can be used',
    ],
])
