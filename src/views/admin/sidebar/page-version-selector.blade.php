<div id="dvs-sidebar-versions-selector">
    <select class="dvs-select" name="page_version" id="dvs-sidebar-version-selector">
        @foreach ($pageVersions as $pageVersion)
            <option <?= $pageVersion->selected ?> value="<?= $pageVersion->name ?>"><?= $pageVersion->name ?> (<?=$pageVersion->status?>)</option>
        @endforeach
    </select>
    <button id="dvs-sidebar-add-version" class="dvs-button dvs-button-primary">Add</button>
</div>