<ul class="pagination search-results">
@for ($i = 1; $i <= $totalPageCount; $i++)
	@if ($i == $page)
		<li class="current paginated page item">{{ $i }}</li>
	@else
		<li class="paginated page item"><a href="{{ URL::current() }}?page={{$i}}{{ $appends }}">{{ $i }}</a></li>
	@endif
@endfor
</ul>