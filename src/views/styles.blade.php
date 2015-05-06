@if (DeviseUser::checkConditions('canUseDeviseEditor'))

    <link rel="stylesheet" type="text/css" href="<?= URL::asset('/packages/devisephp/cms/css/main.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= URL::asset('/packages/devisephp/cms/css/spectrum.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= URL::asset('/packages/devisephp/cms/css/jquery.datetimepicker.css') ?>">

    <script>
		if (location.href.indexOf('start-editor=false') === -1
			&& location.href.indexOf('disable-editor') === -1) {
			document.writeln(
				'<style>' +
					'html, html body { height: 100%; margin: 0; padding: 0; overflow: hidden; }' +
					'body { display: none; }' +
				'</style>'
			);
		}
	</script>
@endif