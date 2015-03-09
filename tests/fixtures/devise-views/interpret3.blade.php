<body>

	<?php foreach ($tags as $tag): ?>

		<div data-devise="key1, type, Human name 1">Hello there #1</div>

		<?php for ($i = 0; $i < 10; $i++) { ?>

			<div data-devise="key2, type, Human name 2">Hello there #2</div>

			<?php if ($awesome): ?>

				<div data-devise="key3, type, Human name 3">Hello there #3</div>

			<?php endif ?>

		<?php } ?>
	<?php endforeach ?>

	<p data-devise="outside, type, Outside Key">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</p>
</body>