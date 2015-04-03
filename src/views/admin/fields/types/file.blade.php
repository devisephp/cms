<h3>File</h3>

<a data-devise="file1, file, File" href="<?= $page->file1->file ?>">Download file</a>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<a data-devise="file1, file, File" href="{{ $page->file1->file }}">Download file</a>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->file1',
    'values' => $page->file1,
    'descriptions' => [
	    'file' => 'URL to file that was uploaded by user',
    	'sizeLimit' => 'Limit the size of files (in KB?)',
    	'allowedTypes' => 'List of allowed file types seperated by spaces',
    ],
])


