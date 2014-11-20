<script>
	define('dvsPageData', [], function() {
		return JSON.parse('{ "page_id": "{{$page->id}}", "page_version_id": "{{ $page->version->id }}", ' +
			'"bindings": {{ App::make("dvsPageData")->bindingsJSON() }}, ' +
			'"collections": {{ App::make("dvsPageData")->collectionsJSON() }} }');
	});

    require(['dvsPublic'], function(module) {
        module( {{ $page->version }});
	});

</script>