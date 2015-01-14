@if (DeviseUser::checkConditions('showDeviseEditor'))

	<script src="/packages/devisephp/cms/js/devise.min.js"></script>

	<script>
		devise.define('dvsPageData', [], function() {
			return JSON.parse('{' +
				'"page_id": "{{$page->id}}",' +
				'"page_version_id": "{{ $page->version->id }}", ' +
				'"bindings": {{ App::make("dvsPageData")->bindingsJSON() }}, ' +
				'"collections": {{ App::make("dvsPageData")->collectionsJSON() }}' +
			'}');
		});

		devise.require(['dvsEditor'], function(module)
		{
	    	module.init( {{ $page->id }}, {{ $page->version->id or 'null' }} );
		});
	</script>

@elseif (DeviseUser::checkConditions('showAnnotationEditor'))

	<script src="/packages/devisephp/cms/js/devise.min.js"></script>

	<script>
		devise.require(['dvsPublic'], function(module)
		{
			module( {{ $page->version }});
		});
	</script>

@endif