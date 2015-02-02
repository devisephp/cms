<div id="dvs-sidebar-header" data-page-id="{{ $page_id }}"  data-page-version-id="{{ $page_version_id }}" >
    <div id="dvs-sidebar-title">
        <h1>{{ $human_name }}</h1>
        <a class="dvs-sidebar-close">Close</a>
    </div>

    <div id="dvs-sidebar-contents-container">

    	@include('devise::admin.sidebar.language-selector')

    	@include('devise::admin.sidebar.page-version-selector')

        <div id="dvs-sidebar-groups-wpr">

        </div>
    </div>

    <hr class="thick">
</div>

@include('devise::admin.sidebar.page-version-date-pickers')

<div id="dvs-sidebar-breadcrumbs"></div>

@include('devise::admin.sidebar.validation-messages')

@include('devise::admin.sidebar._model')

<div class="dvs-model-forms" id="dvs-sidebar-element-forms">
    <div id="dvs-sidebar-current-element"></div>
    <button type="button" data-submit-action="/admin/sidebar/models" data-submit-method="post" data-model="{{ $class_name }}" data-page-version-id="{{ $page_version_id }}" class="dvs-sidebar-save-model">Save Changes</button>
</div>

