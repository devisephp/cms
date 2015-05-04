<script data-template-name="about-page" type="text/x-handlebars-template">
	<h4>Current Route</h4>
	<p><?= $page->route_name ?></p>

	<h4>Templates Loaded</h4>
	<ul>
		@foreach ($templates as $template)
			<li><?= $template ?></li>
		@endforeach
	</ul>

	<h4>List of the variables available</h4>
	<ul>
		@foreach ($variables as $variable)
			<li>
				<h5 class="about-var-name"><?= $variable ?></h5>
				<div class="about-var-dump"><?= var_dump($data[$variable]) ?></div>
			</li>
		@endforeach
	</ul>
</script>