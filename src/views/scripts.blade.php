@if (DeviseUser::checkConditions('canUseDeviseEditor'))

	<?php
		$templateDir = public_path() . '/packages/devisephp/cms/js/app/editor/templates';
		$templates = $files = File::allFiles($templateDir);
	?>

	<script src="/packages/devisephp/cms/js/devise.js"></script>

	<script>

		// create the dvsPageData singleton which contains all the page data we need for the dvsEditor
		devise.define('dvsPageData', [], function() {
			var dvsPageData = <?= App::make('dvsPageData')->toJSON() ?>;

			dvsPageData.urls = {};
			dvsPageData.urls.content_requested = "<?= URL::route('dvs-fields-content-requested', $page->version->id) ?>";
			dvsPageData.urls.sidebar_partials = '/admin/partials/';
			dvsPageData.urls.add_collection_instance = '/admin/pages/:pageVersionId/collections/:collectionId/instances/store';
            dvsPageData.urls.remove_collection_instance = '/admin/collections/:collectionId/instances/:id/delete';
			dvsPageData.urls.update_collection_instance = '/admin/pages/:pageVersionId/collections/:collectionId/instances/:id/update-name';
			dvsPageData.urls.sort_collection_instance = '/admin/pages/:pageVersionId/collections/:collectionId/instances/update-sort-orders';
			dvsPageData.urls.request_sort_collection = '/admin/pages/:pageVersionId/collections/:collectionId/instances';
			dvsPageData.urls.media_manager = "<?= URL::route('dvs-media-manager') ?>";

			dvsPageData.url = function(name, params) { var url = dvsPageData.urls[name]; params = params || []; for (var index in params) {	var match = new RegExp(':' + index, 'g'); url = url.replace(match, params[index]); } return url; };

			return devise.dvsPageData = dvsPageData;
   		});

		// bootstrap the dvsEditor
		devise.require(['dvsTemplates', 'dvsEditor', 'dvsPageData', 'query'], function(Templates, Editor, PageData, query) {

			<?php foreach ($templates as $template): ?>
				<?php
					$templateName = explode('.', str_replace(['/', '\\'], '.', $template->getRelativePathname()));
					array_pop($templateName);
					$templateName = implode('.', $templateName);
				?>
				Templates.JST['<?php echo $templateName ?>'] = "<?php echo str_replace("\n", "", str_replace('"', '\"', file_get_contents($template))); ?>";
			<?php endforeach ?>

			devise.editor = new Editor(Templates, PageData);

			devise.editor.start();

			if (devise.editor.shouldStart())
			{
				var showNode = query.get('show-node', false);

				if (showNode !== false) devise.editor.showSidebar(showNode);
			}
		});
	</script>

@endif