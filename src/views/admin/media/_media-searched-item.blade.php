<div class="dvs-media-item-wrapper">
	<button type="button"
		title="Rename file"
		class="js-rename-item js-shown-on-item-hover dvs-media-rename-item"
		data-method="put"
		data-url="<?= route('dvs-media-rename') ?>"
		data-filepath="<?= $item['filepath'] ?>"
	>-</button>

	<button type="button"
		class="js-remove-item js-shown-on-item-hover dvs-media-remove-item"
		title="Remove file"
		data-method="delete"
		data-url="<?= route('dvs-media-remove') ?>"
		data-filepath="<?= $item['filepath'] ?>"
		data-confirm="Are you sure you wish to remove this file?"
	>x</button>

	<a class="dvs-media-item js-item-hover" href="<?= $item['url'] ?>" title="<?= $item['name'] ?>">
	    <div class="dvs-media-thumb-cont">
	        <img src="<?= $item['thumb'] ?>" />
	    </div>
	    <p><?= $item['filepath'] ?></p>
	</a>
</div>