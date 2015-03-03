<?php if($isTrue) ?>

    <div data-devise="keyname1, type, humanName">
		stuff goes here
	</div>

<?php } else { ?>

    <div data-devise="keyname2, type, humanName">
		<div data-devise="keyname3, type, humanName">
			more stuff here
		</div>
	</div>

<?php } ?>

<?php if($stuff) { ?>

	<?php foreach($stuff as $thing) { ?>

		<div data-devise="keyname4, type, humanName"></div>

	<?php } ?>

<?php } ?>

<div data-devise="col[keyname5], type, humanName, groupName, categoryName"></div>

<?php if($moreStuff) ?>

	<?php include 'devise-views::view2'; ?>

<?php } ?>