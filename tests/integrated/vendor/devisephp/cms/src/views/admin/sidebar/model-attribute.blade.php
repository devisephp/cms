<div class="model-attribute-editor">
    <div id="dvs-sidebar-header" data-page-id="<?= $page_id ?>"  data-page-version-id="<?= $page_version_id ?>" >

        @include('devise::admin.sidebar._sidebar-header', ['title' => $human_name])

        <div id="dvs-sidebar-contents-container">

        	@include('devise::admin.sidebar._sidebar-page-version-selector')

            <hr class="thick">
        </div>

    </div>

    @include('devise::admin.sidebar._sidebar-page-version-date-pickers')

    <div id="dvs-sidebar-breadcrumbs"></div>

    @include('devise::admin.sidebar._sidebar-validation-messages')

    @include('devise::admin.sidebar._attribute')

    <div class="dvs-model-forms" id="dvs-sidebar-element-forms">
        <div id="dvs-sidebar-current-element"></div>
        <button type="button" data-submit-action="/admin/sidebar/models" data-submit-method="put" data-model="<?= $class_name ?>" data-key="<?= $key ?>" data-page-version-id="<?= $page_version_id ?>" class="dvs-sidebar-save-model">Save Changes</button>
    </div>
</div>