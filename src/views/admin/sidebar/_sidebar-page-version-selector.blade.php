<?php

if (!isset($data) && isset($field)) {
	$data = $field;
}

if (isset($data)) {
?>


<div id="dvs-sidebar-versions-selector">
    <select class="dvs-select dvs-select-small dvs-button-solid" name="page_version" id="dvs-sidebar-version-selector">
        @foreach ($pageVersions as $pageVersion)
            <option <?= $pageVersion->selected ?> value="<?= $pageVersion->name ?>"><?= $pageVersion->name ?> (<?=$pageVersion->status?>)</option>
            @if ($pageVersion->selected)
                @php $selectedVersion = $pageVersion @endphp
            @endif
        @endforeach
    </select>
    <button id="dvs-sidebar-add-version" class="dvs-button dvs-button-secondary dvs-button-small dvs-button-solid">Add</button>
    <button id="dvs-sidebar-edit-version" onclick="location.href = '<?= route('dvs-pages-edit', $data->page_version_id) ?>'" class="dvs-button dvs-button-gray dvs-button-small dvs-button-solid">Edit</a>
</div>

<?php } ?>