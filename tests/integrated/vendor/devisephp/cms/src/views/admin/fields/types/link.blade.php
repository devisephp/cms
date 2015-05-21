<h3>Link</h3>

@snippet
<a data-devise="link1, link, Link" href="<?= $page->link1->url ?>" target="<?= $page->link1->target ?>">
    <?= $page->link1->text ?>
</a>
@endsnippet

@include('devise::admin.fields.show',
[
    'name' => '$page->link1',
    'values' => $page->link1,
    'descriptions' => [
        'text' => 'Link text that would likely be clickable',
        'route' => 'Use a route defined in pages table, if defined url is overridden',
        'url' => 'Use a regular URL, unless route is set then this will point to the route URL',
        'target' => 'Open the window in _self or _blank',
    ],
])

