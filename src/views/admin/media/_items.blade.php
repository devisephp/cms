
@php
	$data = Input::get('search') ? $pageData['searched-items'] : $pageData['media-items'];
	$view = Input::get('search') ? 'devise::admin.media._media-searched-item' : 'devise::admin.media._media-item';
@endphp

@if (count($data))

    @foreach ($data as $item)
        @include($view, array('item' => $item))
    @endforeach

@else
	<h5 class="empty">No Media Found</h5>
@endif