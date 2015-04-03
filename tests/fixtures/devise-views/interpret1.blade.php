<body>
	<div data-devise="key1, type, Human name 1"
		 data-something-else="hmm">

			Hello there #1
	</div>

	<?php if (isset($var) && ("hello" == "hello")) { ?>

		<?php if (isset($morevars)): ?>
			<div data-devise="key2,

				type, Human name 2">

				Hello there #2
			</div>
		<?php endif ?>

	<?php } ?>

	<?php $defaultValues = [] ?>

	<div data-devise="$key, human, group, category, alternate">Something here</div>

	<div data-devise="key3, text, null, , null, null, null">Something here</div>

	<div data-devise="col[key1], text, human, collection human, group, category, alternate, $defaultValues">Something here</div>

	<div data-devise="col[key2], text, human, collection human, group, category, alternate, ['value' => 'durka']">Something here</div>

	<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</p>
</body>