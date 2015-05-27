@if (DeviseUser::checkConditions('canUseDeviseEditor'))

    <link rel="stylesheet" type="text/css" href="<?= asset('/packages/devisephp/cms/css/editor-nodes.css') ?>" data-devise-editor-asset>

    @if (Input::get('start-editor') !== 'false' or Input::get('disable-editor') !== null)

	    <link rel="stylesheet" type="text/css" href="<?= asset('/packages/devisephp/cms/css/main.css') ?>" data-devise-editor-asset >
	    <link rel="stylesheet" type="text/css" href="<?= asset('/packages/devisephp/cms/css/spectrum.css') ?>" data-devise-editor-asset >
	    <link rel="stylesheet" type="text/css" href="<?= asset('/packages/devisephp/cms/css/jquery.datetimepicker.css') ?>" data-devise-editor-asset>

		<style data-devise-editor-asset>
			html, html body { height: 100%; margin: 0; padding: 0; overflow: hidden; }
			body { display: none; }
		</style>

	@endif
@endif