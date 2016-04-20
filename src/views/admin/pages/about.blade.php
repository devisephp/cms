<script id="about-page" type="text/x-handlebars-template">
	<h4>Useful Links</h4>
	<ul>
		<li>
			<a href="{{ URL::route('dvs-pages-edit', $page->id) }}">
				Page Settings
			</a>
		</li>
	</ul>
	<h4>Current Route</h4>
	<ul><li><?=$page->route_name?></li></ul>

	<h4>Templates Loaded</h4>
	<ul>
		@foreach ($templates as $template)
			<li><?=$template?></li>
		@endforeach
	</ul>

	<h4>List of the variables available</h4>
	<ul>
		@foreach ($variables as $variable)
			<li>
				<h5 class="about-var-name"><?=$variable?></h5>
			</li>
		@endforeach
	</ul>
</script>