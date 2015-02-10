<h3>Wysiwyg</h3>

<p style="font-style: italic;">Adding images insdie of wysiwyg not currently working</p>

@snippet
<div data-devise="wysiwyg1, wysiwyg, Wysiwyg" style="width: 200px; height: 200px; overflow: scroll; background-color: #eee; padding: 5px;" >
	{!! $page->wysiwyg1->text !!}
</div>
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->wysiwyg1',
    'values' => $page->wysiwyg1,
    'descriptions' => [
    	'text' => 'HTML content delivered by WYSIWYG editor'
    ],
])
