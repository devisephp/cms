<h3>Models with Page Versions (DvsTestModel)</h3>

@php $testModel = DvsTestModel::find(1); @endphp
<div data-devise="$testModel, Edit the Page Versioned Model">
	Value: <?= $testModel->name ?> <br>
	Id: <?= $testModel->id ?> <br>
	Page Version Id: <?= $testModel->page_version_id ?>
</div>

<pre class="devise-code-snippet">
	<code class="html">
&lt;php $testModel = DvsTestModel::find(1); ?&gt;
&lt;div data-devise&#61;"$testModel, Edit the Page Versioned Model"&gt;
	Value: &lt;?= $testModel-&gt;name ?&gt; &lt;br&gt;
	Id: &lt;?= $testModel-&gt;id ?&gt; &lt;br&gt;
	Page Version Id: &lt;?= $testModel-&gt;page_version_id ?&gt;
&lt;/div&gt;
	</code>
</pre>
