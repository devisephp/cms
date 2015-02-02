<div id="dvs-sidebar-groups-wpr">

    <div id="dvs-sidebar-groups">
        <select class="dvs-select" class="large">
            @foreach ($groups as $group)
                <option value="{{ $group->index }}">{{ $group->human_name }}</option>
            @endforeach
        </select>
    </div>

</div>