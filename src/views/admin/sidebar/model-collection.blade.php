
<div id="dvs-sidebar-header" data-page-id="{{ $page_id }}"  data-page-version-id="{{ $page_version_id }}" >
    <div id="dvs-sidebar-title">
        <h1>{{ $human_name }}</h1>
        <a class="dvs-sidebar-close">Close</a>
    </div>

    <div id="dvs-sidebar-contents-container" style="min-height: 110px;">
        @include('devise::admin.sidebar.language-selector')

        @include('devise::admin.sidebar.page-version-selector')

        @include('devise::admin.sidebar.page-version-date-pickers')

        @include('devise::admin.sidebar.group-selector')
    </div>

    <hr class="thick">
</div>

<div id="dvs-sidebar-breadcrumbs"></div>

@include('devise::admin.sidebar.validation-messages')

@foreach ($groups as $group)
    <div id="dvs-sidebar-group-{{ $group->index }}" class="dvs-sidebar-group {{ $group->active }}" data-group-container="{{ $group->cid }}" data-group-type="{{ $group->type }}" data-group-key="{{ $group->key }}" data-group-class-name="{{ $group->class_name }}">
        {{ $group->view }}
    </div>
@endforeach

<div class="dvs-model-forms" id="dvs-sidebar-element-forms">
    <button type="button" data-submit-action="/admin/sidebar/groups" data-submit-method="put" data-page-version-id="{{ $page_version_id }}" class="dvs-sidebar-save-model-groups">Save Changes</button>
 </div>
