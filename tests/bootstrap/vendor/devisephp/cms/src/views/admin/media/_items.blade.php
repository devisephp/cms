
@php
	$data = Input::get('search') ? $pageData['searched-items'] : $pageData['media-items'];
	$view = Input::get('search') ? 'devise::admin.media._media-searched-item' : 'devise::admin.media._media-item';
@endphp

<!-- this is where new files go that are dragged and dropped into the dropzone -->

<div class="dropzone-previews js-media-items">

	<h5 class="empty">No Media Found</h5>

	@if (count($data))

	    @foreach ($data as $item)
	        @include($view, array('item' => $item))
	    @endforeach

	@endif

</div>
