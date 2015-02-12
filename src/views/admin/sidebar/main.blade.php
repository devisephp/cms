<div id="dvs-sidebar-header" data-page-id="{{ $data->page_id }}"  data-page-version-id="{{ $data->page_version_id }}" >
    <div id="dvs-sidebar-title">
        <h1>{{ $data->sidebarTitle }}</h1>
        <a class="dvs-sidebar-close">Close</a>
    </div>

    <div id="dvs-sidebar-contents-container">
        @if(count($availableLanguages) > 1)
        <div id="dvs-sidebar-language-selector">
            <select class="dvs-select" name="other_languages">
                @foreach ($availableLanguages as $language)
                <option value="{{ $language['url']  }}">{{ $language['code'] }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div id="dvs-sidebar-versions-selector">
            <select class="dvs-select" name="page_version" id="dvs-sidebar-version-selector">
                @foreach ($pageVersions as $pageVersion)
                    <option {{ $pageVersion->selected }} value="{{ $pageVersion->name }}">{{ $pageVersion->name }} ({{$pageVersion->status}})</option>
                    @if ($pageVersion->selected)
                        @php $selectedVersion = $pageVersion @endphp
                    @endif
                @endforeach
            </select>
            <button id="dvs-sidebar-add-version" class="dvs-button dvs-button-gray">Add</button>
            <button id="dvs-sidebar-edit-version" onclick="location.href = '{{ route('dvs-pages-edit', $pageVersion->page_id) }}'" class="dvs-button dvs-button-gray">Edit</a>
        </div>

        <div id="dvs-sidebar-groups-wpr">
            @include("devise::admin.sidebar._sidebar-groups-select")
        </div>

        <hr class="thick">
    </div>
</div>


<div class="js-datepickers dvs-hidden dvs-clearfix">
    <span>Show live<span>
    <input type="text" name="starts_at" value="{{ $selectedVersion->starts_at_human }}" placeholder="Start Date" class="js-datepicker js-start-date" style="line-height: 20px;">
    <span>thru</span>
    <input type="text" name="ends_at" value="{{ $selectedVersion->ends_at_human }}" placeholder="End Date" class="js-datepicker js-end-date" style="line-height: 20px;">
    <button data-url="{{ URL::route('dvs-update-page-versions-dates', $selectedVersion->id) }}" class="js-update-dates btn">Update</button>
</div>

<div id="dvs-sidebar-breadcrumbs"></div>

@if($data->isCollection)
    <div id="dvs-sidebar-collections" data-page-id="{{ $data->page_id }}" data-collection-name="{{ $data->collection->name }}" data-collection-id="{{ $data->collection->id }}" data-page-version-id="{{ $data->page_version_id }}">

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