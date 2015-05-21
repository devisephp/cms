@foreach ($posts as $post)
	<div data-devise="$post, humanName">
		Stuff goes here... {{ $post->title }}
	</div>
@endforeach