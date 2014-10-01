<script>

	define('dvsPageData', [], function() {
		return JSON.parse('{ "page_id": "{{$page->id}}", "bindings": {{ App::make("deviseDataJavascriptBindings")->toJSON() }}, "collections": {{ App::make("deviseDataJavascriptCollections")->toJSON() }} }');
	});

	require(['dvsEditor'], function(module) {
	    module.init( {{ $page->id }} );
	});

</script>