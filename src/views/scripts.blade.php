@if (DeviseUser::checkConditions('canUseDeviseEditor'))

	<?php
		// handlebar templates are injected into our javascript
		// via the following code
		$templateDir = public_path() . '/packages/devisephp/cms/js/app/editor/templates';
		$templates = $files = File::allFiles($templateDir);

		// print out the html for this about page in a template
		// and we will inject this into the page at a later time
		$pagesRepository = App::make('Devise\Pages\PagesRepository');
		$pageTemplates = $pagesRepository->findPageTemplates($page);
		$pageVariables = $pagesRepository->findTemplateVariables($pageTemplates);

		$aboutPageData = [
			'variables' => $pageVariables,
			'templates' => $pageTemplates,
			'page' => $page,
			'data' => [],
		];

		foreach ($pageVariables as $variable)
		{
			$aboutPageData['data'][$variable] = isset($$variable) ? $$variable : 'undefined';
		}

		// print out the pages.about template... it will be a <script> tag
		// we will include it into the Templates JST below, it is treated
		// differently because of the php dynamic content it provides
		print view('devise::admin.pages.about', $aboutPageData)->render();
	?>

	<script src="/packages/devisephp/cms/js/devise.js"></script>

	<script>

		// create the dvsPageData singleton which contains all the page data we need for the dvsEditor
		devise.define('dvsPageData', [], function() {
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

			return devise.dvsPageData = dvsPageData;
   		});

		// bootstrap the dvsEditor
		devise.define('devise.editor', ['dvsTemplates', 'dvsEditor', 'dvsPageData', 'query', 'dvsCsrf'], function(Templates, Editor, PageData, query, csrf) {

			csrf(PageData.csrfToken);

			<?php foreach ($templates as $template): ?>
				<?php
					$templateName = explode('.', str_replace(['/', '\\'], '.', $template->getRelativePathname()));
					array_pop($templateName);
					$templateName = implode('.', $templateName);
				?>
				Templates.JST['<?php echo $templateName ?>'] = "<?php echo str_replace("\n", "", str_replace('"', '\"', file_get_contents($template))); ?>";
			<?php endforeach ?>

			Templates.JST['about-page'] = $('[data-template-name="about-page"]').html();

			devise.editor = new Editor(Templates, PageData);

			devise.editor.start();

			if (devise.editor.shouldStart())
			{
				var showNode = query.get('show-node', false);

				if (showNode !== false) devise.editor.showSidebar(showNode);
			}
		});

		devise.require(['devise.editor'], function(editor)
		{
			// this bootstraps the devise.editor for the first time
		});
	</script>

@endif