@if(!$data->isCollection)
    @if ($data->groups && count($data->groups) >= 2)
        <div id="dvs-sidebar-groups">
            <select class="dvs-select large" id="dvs-groups-select" name="groups">
                @php $index = 0 @endphp

                @foreach ($data->groups as $groupName => $group)
                    @php $contentRequested = false; @endphp

                    @foreach($group as $element)
                        @if(isset($element->content_requested) && $element->content_requested)
                            @php $contentRequested = true; @endphp
                        @endif
                    @endforeach

                    <option value="<?= $index++ ?>"><?= ($contentRequested) ? '[ ! ] ' : null ?><?= $groupName ?></option>
                @endforeach
            </select>
        </div>
    @endif
@else
    @if ($data->groups)
        <div id="dvs-sidebar-groups">
            <select class="dvs-select dvs-button-solid large" id="dvs-groups-select" name="groups">
                @php $index = 0 @endphp

                @foreach($data->groups as $groupName => $group)
                    <option value="<?= $index++ ?>"><?= $groupName ?></option>
                @endforeach
            </select>
            <button id="dvs-sidebar-manage-groups" class="dvs-button dvs-button-secondary dvs-button-small dvs-button-solid">Collections</button>
        </div>
    @else
        <div id="dvs-sidebar-groups">
            <select class="dvs-select large" id="dvs-groups-select" name="groups">
                <option value="0">None</option>
            </select>
            <button id="dvs-sidebar-manage-groups" class="dvs-button dvs-button-secondary dvs-button-small dvs-button-solid">Collections</button>
        </div>
    @endif
@endif