
<div id="dvs-media-manager-search">
	@if(count($pageData['crumbs']) > 1)
    <div id="dvs-media-crumbs">
        @foreach ($pageData['crumbs'] as $crumb)
            &nbsp;/&nbsp;<a href="<?= $crumb['url'] ?>"><?= $crumb['name'] ?></a>
        @endforeach
    </div>
    @endif

    <?= Form::open(['route' => 'dvs-media-manager', 'method' => 'get']) ?>
        @foreach (Input::except(['search']) as $name => $value)
            <input type="hidden" name="<?= $name ?>" value="<?= $value ?>">
        @endforeach
        <input type="text" name="search" value="<?= Input::get('search') ?>">
        <button class="dvs-button dvs-button-small" type="submit">Search</button>
    <?= Form::close() ?>
</div>
