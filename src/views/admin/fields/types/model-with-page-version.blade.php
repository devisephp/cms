<h3>Models with Page Versions (DvsTestModel)</h3>

@php $testModel = DvsTestModel::find(1); @endphp

<div data-devise="$testModel, Edit the Page Versioned Model">
	Value: <?= $testModel->name ?> <br>
	Id: <?= $testModel->id ?> <br>
	Page Version Id: <?= $testModel->page_version_id ?>
</div>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<?php $testModel = DvsTestModel::find(1); ?>

<div data-devise="$testModel, Edit the Page Versioned Model">
	Value: {{ $testModel->name }} <br>
	Id: {{ $testModel->id }} <br>
	Page Version Id: {{ $testModel->page_version_id }}
</div>
') ?>
</code></pre>