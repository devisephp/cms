<div id="page-<?= $page->id ?>" data-dvs-reload-url="<?= URL::route('dvs-page-versions-card', array($page->id)) ?>">

    @include('devise::admin.pages.page-versions._card')

</div>