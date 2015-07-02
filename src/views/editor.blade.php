@if (DeviseUser::checkConditions('canUseDeviseEditor'))

	<script src="/packages/devisephp/cms/js/devise.js"></script>

	<?php
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

	<?php
		// handlebar templates are injected into our javascript
		// via the following code
		$templateDir = public_path() . '/packages/devisephp/cms/js/app/editor/templates';
		$templates = $files = File::allFiles($templateDir);
	?>

	<?php foreach ($templates as $template): ?>
		<script type="text/x-handlebars-template" id="<?php echo relativeFileNameFromTemplate($template) ?>">
			<?php echo file_get_contents($template) ?>
		</script>
	<?php endforeach ?>

	<script>
		devise.define('devise.editor', ['jquery', 'dvsTemplates', 'dvsEditor', 'query', 'dvsCsrf'], function($, Templates, Editor, query, csrf) {

			devise.editor = new Editor(Templates, {}, csrf);

			var showNode = query.get('show-node', false);

			devise.editor.start();

			if (showNode !== false) devise.editor.showSidebar(showNode);
		});

		@if(!isset($bootstrap) || $bootstrap)
			devise.require(['devise.editor'], function(editor)
			{
				// this bootstraps the devise.editor for the first time
			});
		@endif
	</script>
@endif