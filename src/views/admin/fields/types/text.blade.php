<h3>Text</h3>

@snippet
<p data-devise="text1, text, Text">
    {{ $page->text1->text('This is some default text') }}
<p>
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->text1',
    'values' => $page->text1,
    'descriptions' => [
        'text' => 'The value of the text field',
        'maxlength' => 'The maximum amount of characters that can be used',
    ],
])