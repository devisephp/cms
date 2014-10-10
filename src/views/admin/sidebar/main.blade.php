<div id="dvs-sidebar-container">
    <div id="dvs-sidebar-content">

        <div id="dvs-sidebar-header">

            <div>
                <select id="dvs-sidebar-version-selector" name="page_version" style="display: inline-block; width: 82%;">
                    @foreach ($pageVersions as $pageVersion)
                        <option {{ $pageVersion->selected }} value="{{ $pageVersion->name }}">{{ $pageVersion->name }}</option>
                    @endforeach
                </select>
                <button style="
                    background: rgba(19,138,210,0.95);
                    display: inline-block;
                    cursor: pointer;
                    width: 30px;
                    height: 30px;
                    border-radius: 4px;
                    border: 2px solid rgba(19,138,210,0.95);
                    line-height: 0px;
                    color: white;
                    font-size: 20px;
                    font-weight: bold;
                    position: relative;
                    margin-top: 4px;
                "
                id="dvs-sidebar-add-version" class="dvs-sidebar-page-version dark">+</button>
            </div>

        	<div>
        		<button id="dvs-sidebar-close" class="dvs-sidebar-close dark">&nbsp;</button>
        		<button id="dvs-sidebar-admin" class="dvs-sidebar-admin dark">&nbsp;</button>
        		<select id="dvs-sidebar-language-selector" name="other_languages">
        		    @foreach ($availableLanguages as $language)
                    <option value="{{ $language['url']  }}">Language: {{ $language['human_name'] }}</option>
                    @endforeach
                </select>
        	</div>

            @if(!$data->isCollection)
            	@if ($data->groups)
            		<div>
            			<select name="groups" id="dvs-sidebar-groups" class="large">
            			    @php $index = 0 @endphp
            				@foreach ($data->groups as $groupName => $group)
            					<option value="{{ $index++ }}">Group: {{ $groupName }}</option>
            				@endforeach
            			</select>
            		</div>
            	@endif
            @else
                @if ($data->groups)
                    <div>
                        <select name="groups" id="dvs-sidebar-groups" class="large">
                            @php $index = 0 @endphp
                            @foreach ($data->groups as $groupName => $group)
                                <option value="{{ $index++ }}">{{ $groupName }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @endif

        </div>

        <ul id="dvs-sidebar-elements-and-groups">

    	@if ($data->groups)

    		@php $index = 0 @endphp

    		@foreach ($data->groups as $name => $elements)

                @php $activeClass = ($index == 0) ? ' active' : ''; @endphp

    			<li id="dvs-sidebar-group-{{ $index++ }}" class="dvs-sidebar-group dvs-sidebar-elements{{ $activeClass }}">
    			    <div class="dvs-accordion">
                        @foreach ($elements as $element)
                            <h3>{{ $element->human_name }}</h3>
                            <div class="dvs-sidebar-element">
                                @include("devise::admin.sidebar._{$element->type}", compact('element'))
                            </div>
                        @endforeach
    				</div>

    				<button type="button" class="dvs-sidebar-save-group">Save</button>
    			</li>

    		@endforeach

    	@else

            @if(!$data->isCollection)
        		<li id="dvs-sidebar-elements" class="dvs-sidebar-elements">
        		    <div class="dvs-accordion">
                        @foreach($data->elements as $element)
                            <h3>{{ $element->human_name }}</h3>
                            <div>
                                @include("devise::admin.sidebar._{$element->type}", compact('element'))
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="dvs-sidebar-save-group">Save</button>

        		</li>
            @endif

        @endif
        </ul>

        @if($data->isCollection)
            <p class="notice">Please add new collection items using the form to the right.</p>
        @endif

    </div>
</div>

@if($data->isCollection)

    <div id="dvs-sidebar-collections" data-page-id="{{ $data->page_id }}" data-collection-id="{{ $data->collection->id }}" data-page-version-id="{{ $data->page_version_id }}">
        <h2>{{$data->categoryName}}</h2>

        <div class="dvs-new-collection">
            <p>Add a new instance by providing the name and clicking 'Add to Stack'</p>
            <input id="dvs-new-collection-instance-name" type="name" placeholder="Name">
            <button id="dvs-new-collection-instance">Add to Stack</button>
        </div>

        <hr>
        <p>Rearrange the order of the collection by dragging and dropping</p>
        <hr>

        {{-- Add a new line item to sortables array, update sortable, update dropdown --}}
        <ul id="dvs-collection-instances-sortable"></ul>

    </div>
@endif