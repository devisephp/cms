<li id="itemOrder_{{ $item->id }}" class="js-menu-item">
	<div>
		<input type="text" name="item[{{$item->id}}][name]" value="{{ $item->name }}" placeholder="Title" style="width: 25%;">
		<input type="text" name="item[{{ $item->id}}][url]" value="{{ $item->url }}" placeholder="URL" style="width: 64%;">
		<button type="button" class="dvs-button js-remove-menu-item" style="padding: 0; float: right;">X</button>
	</div>

	@if ($item->items)
		<ol>
			@foreach ($item->items as $nested)
				@include('devise-views::view3', ['item' => $nested])
			@endforeach
		</ol>
	@endif

	@if (something)
		<div>...</div>
	@endif
</li>