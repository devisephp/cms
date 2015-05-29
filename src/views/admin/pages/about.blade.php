<script data-template-name="about-page" type="text/x-handlebars-template">
	<h4>Useful Links</h4>
	<ul>
		<li>
			<a href="{{ URL::route('dvs-pages-edit', $page->id) }}">
				Page Settings
			</a>
		</li>
		<li>
			<a href="{{Request::url()}}?disable-editor">
				Disable Editor
			</a>
		</li>
	</ul>
	<h4>Current Route</h4>
	<ul><li><?= $page->route_name ?></li></ul>

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
				<div class="about-var-dump">
					<pre><code class="php">
						<?php
						ob_start();
						var_dump($data[$variable]);
						$a=ob_get_contents();
						ob_end_clean();
						?>
						{{ $a }}
					</code></pre>
				</div>
			</li>
		@endforeach
	</ul>
</script>