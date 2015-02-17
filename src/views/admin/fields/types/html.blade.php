<h3>HTML</h3>

@snippet
<div data-devise="html1, html, Html">
	<?= $page->html1->html ?>
</div>
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->html1',
    'values' => $page->html1,
    'descriptions' => [
    	'html' => 'HTML stored here'
    ],
])


