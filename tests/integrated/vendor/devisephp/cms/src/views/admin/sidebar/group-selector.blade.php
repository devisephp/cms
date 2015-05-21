    <div id="dvs-sidebar-groups">
        <select class="dvs-select">
            @foreach ($groups as $group)
                <option value="<?= $group->index ?>"><?= $group->human_name ?></option>
            @endforeach
        </select>
    </div>