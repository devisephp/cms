@if (DeviseUser::checkConditions('canUseDeviseEditor'))

	<script>
		// create the dvsPageData singleton which contains all the page data we need for the dvsEditor
		var dvsPageData = <?= App::make('dvsPageData')->toJSON() ?>;

		dvsPageData.urls = {};
		dvsPageData.urls.add_collection_instance = "<?= route('dvs-collection-instance-add', [':pageVersionId', ':collectionId']) ?>";
        dvsPageData.urls.remove_collection_instance = "<?= route('dvs-collection-instance-delete', [':collectionId', ':id']) ?>";
		dvsPageData.urls.update_collection_instance = "<?= route('dvs-collection-instance-update-name', [':pageVersionId', ':collectionId', ':id']) ?>";
		dvsPageData.urls.sort_collection_instance = "<?= route('dvs-collection-instance-update-sort-orders', [':pageVersionId', ':collectionId']) ?>";
		dvsPageData.urls.request_sort_collection = "<?= route('dvs-collection-instance-index', [':pageVersionId', ':collectionId']) ?>";
		dvsPageData.urls.media_manager = "<?= route('dvs-media-manager') ?>";
		dvsPageData.urls.update_field = "<?= route('dvs-fields-update', [':id']) ?>";
		dvsPageData.urls.update_collection_field = "<?= route('dvs-collection-instance-field-update', [':id']) ?>";
		dvsPageData.urls.update_model_fields = "<?= route('dvs-model-fields-update') ?>";
		dvsPageData.urls.update_model_attribute = "<?= route('dvs-model-field-update', [':id']) ?>";
		dvsPageData.urls.create_model = "<?= route('dvs-model-fields-create') ?>";
		dvsPageData.urls.reset_field = "<?= route('dvs-fields-reset', [':id', ':scope']) ?>";

		dvsPageData.url = function(name, params) { var url = dvsPageData.urls[name]; params = params || []; for (var index in params) {	var match = new RegExp(':' + index, 'g'); url = url.replace(match, params[index]); } return url; };

		dvsPageData.info = {
			language_id: dvsPageData.languageId,
			page_version_id: dvsPageData.pageVersionId,
			page_id: dvsPageData.pageId
		};
	</script>

@endif