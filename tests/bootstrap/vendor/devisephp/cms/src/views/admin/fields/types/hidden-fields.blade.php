<h3>Hidden Fields</h3>

@snippet
    <!-- only see it when we change the field value to something besides 'Hidden' -->
    @if ($page->hiddenTestField->text('Hidden') != 'Hidden')
        <div data-devise="hiddenTestField, text"><?= $page->hiddenTestField->text('Hidden') ?></div>
    @endif
@endsnippet