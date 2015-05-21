<div id="dvs-sidebar-header" data-page-id="<?= $data->page_id ?>"  data-page-version-id="<?= $data->page_version_id ?>" >

    @include('devise::admin.sidebar._sidebar-header', ['title' => $data->sidebarTitle])

    <div id="dvs-sidebar-contents-container">

        @include('devise::admin.sidebar._sidebar-page-version-selector')

        <div id="dvs-sidebar-groups-wpr">
            @include("devise::admin.sidebar._sidebar-groups-select")
        </div>

        <hr class="thick">
    </div>
</div>

@include('devise::admin.sidebar._sidebar-page-version-date-pickers')

<div id="dvs-sidebar-breadcrumbs"></div>

@if($data->isCollection)
    <div id="dvs-sidebar-collections" data-page-id="<?= $data->page_id ?>" data-collection-name="<?= $data->collection->name ?>" data-collection-id="<?= $data->collection->id ?>" data-page-version-id="<?= $data->page_version_id ?>">

        <div class="dvs-new-collection">
            <p>Add a new instance by providing the name and clicking 'Add to Stack'</p>
            <input id="dvs-new-collection-instance-name" type="name" placeholder="Name">
            <button id="dvs-new-collection-instance" class="dvs-button">Add to Stack</button>
        </div>

        <ul id="dvs-collection-instances-sortable"></ul>
    </div>
@endif

@if ($data->groups || $data->isCollection)

    <ul id="dvs-sidebar-elements-and-groups">
        @if (count($data->groups))
            @include('devise::admin.sidebar._sidebar-elements-grid')
        @endif
    </ul>

    <div id="dvs-sidebar-element-forms">
        <div id="dvs-sidebar-current-element"></div>
        <button type="button" class="dvs-sidebar-save-group">Save Changes</button>
    </div>

@else

    @php $element = $data->elements[0]; @endphp

    <div id="dvs-sidebar-element-forms">
        <div id="dvs-sidebar-current-element" style="display:block">
             @include("devise::admin.sidebar._{$element->type}", compact('element'))
        </div>
        <button type="button" class="dvs-sidebar-save-group">Save</button>
    </div>

@endif