@if(!$data->isCollection)
    @if ($data->groups && count($data->groups) >= 2)
        <div id="dvs-sidebar-groups">
            <select class="dvs-select" name="groups" class="large">
                @php $index = 0 @endphp
                @foreach ($data->groups as $groupName => $group)
                    <option value="<?= $index++ ?>">Group: <?= $groupName ?></option>
                @endforeach
            </select>
        </div>
    @endif
@else
    @if ($data->groups)
        <div id="dvs-sidebar-groups">
            <select class="dvs-select dvs-button-solid" name="groups" class="large">
                @php $index = 0 @endphp
                @foreach ($data->groups as $groupName => $group)
                    <option value="<?= $index++ ?>"><?= $groupName ?></option>
                @endforeach
            </select>
            <button id="dvs-sidebar-manage-groups" class="dvs-button dvs-button-secondary dvs-button-small dvs-button-solid">Collections</button>
        </div>
    @else
        <div id="dvs-sidebar-groups">
            <select class="dvs-select" name="groups" class="large">
                <option value="0">None</option>
            </select>
            <button id="dvs-sidebar-manage-groups" class="dvs-button dvs-button-secondary dvs-button-small dvs-button-solid">Collections</button>
        </div>
    @endif
@endif