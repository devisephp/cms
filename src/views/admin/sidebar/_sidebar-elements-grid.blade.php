@php $index = 0; @endphp

@foreach ($data->groups as $name => $elements)
    @php $activeGroupClass = ''; @endphp
    @if($index === 0)
        @php $activeGroupClass = 'dvs-active'; @endphp
    @endif

    <li id="dvs-sidebar-group-{{ $index++ }}" class="dvs-sidebar-group dvs-sidebar-elements {{ $activeGroupClass }}">
    @foreach ($elements as $element)
        <button data-field-id="{{ $element->id }}" data-field-scope="{{ $element->scope }}" >{{ $element->human_name }}</button>
    @endforeach
    </li>

@endforeach