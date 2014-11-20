@if(!$data->isCollection)
    @if ($data->groups)
        <div id="dvs-sidebar-groups">
            <select class="dvs-select" name="groups" class="large">
                @php $index = 0 @endphp
                @foreach ($data->groups as $groupName => $group)
                    <option value="{{ $index++ }}">Group: {{ $groupName }}</option>
                @endforeach
            </select>
            <button id="dvs-sidebar-manage-groups" class="dvs-button dvs-button-secondary">Manage</button>
        </div>
    @endif
@else
    @if ($data->groups)
        <div id="dvs-sidebar-groups">
            <select class="dvs-select" name="groups" class="large">
                @php $index = 0 @endphp
                @foreach ($data->groups as $groupName => $group)
                    <option value="{{ $index++ }}">{{ $groupName }}</option>
                @endforeach
            </select>
            <button id="dvs-sidebar-manage-groups" class="dvs-button dvs-button-secondary">Manage</button>
        </div>
    @endif
@endif