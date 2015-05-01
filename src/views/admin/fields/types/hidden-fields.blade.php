<h3>Hidden Fields</h3>

<!-- only see it when we change the field value to something besides 'Hidden' -->
@if ($page->hiddenTestField->text('Hidden') != 'Hidden')
    <div data-devise="hiddenTestField, text"><?= $page->hiddenTestField->text('Hidden') ?></div>
@endif


<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<!-- only see it when we change the field value to something besides \'Hidden\' -->
@if ($page->hiddenTestField->text(\'Hidden\') != \'Hidden\')
    <div data-devise="hiddenTestField, text">{{ $page->hiddenTestField->text(\'Hidden\') }}</div>
@endif
') ?>
</code></pre>
