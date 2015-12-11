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





		<?php
		/*
			here we truncate the page for performance reasons... to avoid
			double-tapping each page everytime when in Editor mode
		*/
		?>

		</head>
		<body>

		<div class="dvs-default" id="dvs-mode">
			<div id="dvs-container">
				<div id="dvs-pusher">
					<iframe id="dvs-iframe" name="dvsiframe" style="height: 100%; width: 100%;"></iframe>
				</div>
			</div>

			<button id="dvs-about-page-button">About Page</button>
			<button id="dvs-node-mode-button">Edit Page</button>
			<button id="dvs-admin-mode-button" onclick="location.href = '/admin/pages'">Admin</button>

			<div id="dvs-sidebar-container" style="display: none;">
				<div id="dvs-sidebar-scroller">
					<div id="dvs-sidebar">
						<!-- this is where sidebar view goes -->
					</div>
				</div>
			</div>

			<div id="dvs-about-page-container">
				<!-- this is where the about page view goes -->
			</div>
		</div>

		@include('devise::editor', ['bootstrap' => isset($bootstrap) ? $bootstrap : true])

		</body>
		</html>

		<?php die ?>

		<?
		/*
			none of your stuff got loaded here... but it will get loaded inside
			of the iframe in just another second
		*/
		?>

	@endif
@endif