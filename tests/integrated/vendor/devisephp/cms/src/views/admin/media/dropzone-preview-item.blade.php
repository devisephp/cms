<!--
	Here are the attributes we can use...

	data-dz-name
	data-dz-size
	data-dz-thumbnail (This has to be an <img /> element and the alt and src attributes will be changed by Dropzone)
	data-dz-uploadprogress (Dropzone will change the style.width property from 0% to 100% whenever there’s a uploadprogress event)
	data-dz-errormessage
-->

<template name="dropzone-preview-item">

	<div class="dvs-media-item-wrapper">

		<div class="dvs-media-item-actions">
			<button type="button"
				title="Rename file"
				class="js-rename-item js-shown-on-item-hover dvs-media-rename-item"
				data-method="put"
				data-url="<?= route('dvs-media-rename') ?>"
				data-filepath=" ... "
			><span class="ion-folder"></span></button>

			<button type="button"
				class="js-remove-item js-shown-on-item-hover dvs-media-remove-item"
				title="Remove file"
				data-method="delete"
				data-url="<?= route('dvs-media-remove') ?>"
				data-filepath="  ... "
				data-confirm="Are you sure you wish to remove this file?"
			><span class="ion-android-close"></span></button>
		</div>

		<a class="dvs-media-item js-item-hover" href="#" title="">
		    <div class="dvs-media-thumb-cont">
		        <img src="/packages/devisephp/cms/img/meda-manager-default-thumb.png" data-dz-thumbnail>
		    </div>
		    <p data-dz-name></p>
		</a>
	</div>

</template>