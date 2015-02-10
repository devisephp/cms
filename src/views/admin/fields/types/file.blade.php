<h3>File</h3>

<p style="font-style: italic;">This field is still under development so it does not currently work as expected</p>

@snippet
<a data-devise="file1, file, File" href="{{ $page->file1->file }}">Download file</a>
@endsnippet

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


