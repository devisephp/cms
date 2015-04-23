<h3>Datetime</h3>

<p data-devise="datetime1, datetime, Datetime">
	Concert starts at <?= $page->datetime1->datetime ?>
</p>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<p data-devise="datetime1, datetime, Datetime">
	Concert starts at {{ $page->datetime1->datetime }}
</p>
') ?>
</code></pre>

@include('devise::admin.fields.show',
[
    'name' => '$page->datetime1',
    'values' => $page->datetime1,
    'descriptions' => [
        'datetime' => 'Formated date and time',
        'datetimevalue' => 'Unformatted date and time',
        'format' => 'PHP datetime format which will be used to format datetimevalue into datetime'
    ],
])
