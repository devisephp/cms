@if (DeviseUser::checkConditions('showDeviseEditor'))

	<script src="/packages/devisephp/cms/js/devise.js"></script>

	<script>
		devise.define('dvsPageData', [], function() {
			return JSON.parse('{' +
				'"page_id": "{{$page->id}}",' +
				'"page_version_id": "{{ $page->version->id }}", ' +
				'"models": {{ App::make("dvsPageData")->modelsJSON() }},' +
				'"model_attributes": {{ App::make("dvsPageData")->modelAttributesJSON() }},' +
				'"bindings": {{ App::make("dvsPageData")->bindingsJSON() }}, ' +
				'"collections": {{ App::make("dvsPageData")->collectionsJSON() }},' +
				'"model_creators": {{ App::make("dvsPageData")->modelCreatorsJSON() }}' +
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