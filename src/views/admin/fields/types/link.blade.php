<h3>Link</h3>

<a data-devise="link1, link, Link" href="<?= $page->link1->url('http://google.com') ?>" target="<?= $page->link1->target('_self') ?>">
    <?= $page->link1->text('Edit me cause I just go to google') ?>
</a>

<pre class="devise-code-snippet"><code class="html">
<?= htmlentities('
<a data-devise="link1, link, Link" href="{{ $page->link1->url() }}" target="{{ $page->link1->target() }}">
    {{ $page->link1->text() }}
</a>
') ?>
</code></pre>

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

