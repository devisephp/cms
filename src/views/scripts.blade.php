@if (DeviseUser::checkConditions('showDeviseEditor'))

	<script src="/packages/devisephp/cms/js/devise.js"></script>

	<script>
		devise.define('dvsPageData', [], function() {
			var dvsPageData = {};

			dvsPageData.csrf_token = "<?= csrf_token() ?>";
			dvsPageData.page_id = "<?=$page->id?>";
            dvsPageData.page_version_id = "<?= $page->version->id ?>";
			dvsPageData.models = <?= App::make("dvsPageData")->modelsJSON() ?>;
			dvsPageData.model_attributes = <?= App::make("dvsPageData")->modelAttributesJSON() ?>;
			dvsPageData.bindings = <?= App::make("dvsPageData")->bindingsJSON() ?>;
			dvsPageData.collections = <?= App::make("dvsPageData")->collectionsJSON() ?>;
			dvsPageData.model_creators = <?= App::make("dvsPageData")->modelCreatorsJSON() ?>;

			dvsPageData.urls = {};
			dvsPageData.urls.content_requested = "<?= URL::route('dvs-fields-content-requested', $page->version->id) ?>";
			dvsPageData.urls.sidebar_partials = '/admin/partials/';
			dvsPageData.urls.add_collection_instance = '/admin/pages/:pageVersionId/collections/:collectionId/instances/store';
            dvsPageData.urls.remove_collection_instance = '/admin/collections/:collectionId/instances/:id/delete';
			dvsPageData.urls.update_collection_instance = '/admin/pages/:pageVersionId/collections/:collectionId/instances/:id/update-name';
			dvsPageData.urls.sort_collection_instance = '/admin/pages/:pageVersionId/collections/:collectionId/instances/update-sort-orders';
			dvsPageData.urls.request_sort_collection = '/admin/pages/:pageVersionId/collections/:collectionId/instances';

			dvsPageData.url = function(name, params)
			{
				var url = dvsPageData.urls[name];
				params = params || [];

				for (var index in params)
				{
					var match = new RegExp(':' + index, 'g');
					url = url.replace(match, params[index]);
				}

				return url;
			};

			return devise.dvsPageData = dvsPageData;
   		});

		devise.require(['dvsEditor'], function(module)
		{
	    	module.init( <?= $page->id ?>, <?= (isset($page->version->id)) ? $page->version->id : 'null' ?> );
		});
	</script>

@endif