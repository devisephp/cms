@php $index = 0; @endphp

@foreach ($data->groups as $name => $elements)
    @php $activeGroupClass = ($index === 0) ? 'dvs-active' : ''; @endphp

    <li id="dvs-sidebar-group-{{ $index++ }}" class="dvs-sidebar-group dvs-sidebar-elements {{ $activeGroupClass }}">
	    @foreach ($elements as $element)
            @php
                $contentRequested = ($element->content_requested === '1') ? 'dvs-content-requested' : '';
            @endphp

            <button class="{{$contentRequested}}" data-field-id="{{ $element->id }}" data-field-scope="{{ $element->scope }}" >{{ $element->human_name }}</button>
	    @endforeach
    </li>
@endforeach