<div class="dvs-model-group-editor">
    <div id="dvs-sidebar-header" data-page-id="<?= $page_id ?>"  data-page-version-id="<?= $page_version_id ?>">

        @include('devise::admin.sidebar._sidebar-header', ['title' => $human_name])

        <div id="dvs-sidebar-contents-container">

            @include('devise::admin.sidebar._sidebar-page-version-selector')

            <div id="dvs-sidebar-groups-wpr">
                @include('devise::admin.sidebar.group-selector')
            </div>

            <hr class="thick">
        </div>
    </div>

    @include('devise::admin.sidebar._sidebar-page-version-date-pickers')

    <div id="dvs-sidebar-breadcrumbs"></div>

    @include('devise::admin.sidebar._sidebar-validation-messages')

    <ul id="dvs-sidebar-elements-and-groups">
    @foreach ($groups as $group)
        <li id="dvs-sidebar-group-<?= $group->index ?>" class="dvs-sidebar-group dvs-sidebar-collection-group <?= $group->active ?>" data-group-container="<?= $group->cid ?>" data-group-type="<?= $group->type ?>" data-group-key="<?= $group->key ?>" data-group-class-name="<?= $group->class_name ?>">
            <?= $group->view ?>
        </li>
    @endforeach
    </ul>

    <div class="dvs-model-forms" id="dvs-sidebar-element-forms">
        <button type="button" data-submit-action="/admin/sidebar/groups" data-submit-method="put" data-page-version-id="<?= $page_version_id ?>" class="dvs-sidebar-save-model-groups">Save Changes</button>
     </div>
</div>