<h3>HTML</h3>

<div data-devise="html1, html, Html">
	<?= $page->html1->html ?>
</div>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<div data-devise="html1, html, Html">
	{{ $page->html1->html }}
</div>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->html1',
    'values' => $page->html1,
    'descriptions' => [
    	'html' => 'HTML stored here'
    ],
])


