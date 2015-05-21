<body>
	<?php if (isset($var) && ("hello" == "hello")) { ?>

		<?php if (isset($morevars)): ?>

			<div data-devise="key1, type, Human name 1">Hello there #1</div>

			<?php if ($durka): ?>
				<div data-devise="durka, type, Durka">Durka</div>
			<?php endif ?>

		<?php elseif (isset($evenmorevars)): ?>

			<div data-devise="key2, type, Human name 2">Hello there #2</div>

			<?php if ($durka2): ?>
				<div data-devise="durka2, type, Durka 2">Durka 2</div>
			<?php endif ?>

		<?php elseif (isset($evenmorevarsagain)): ?>

			<div data-devise="key3, type, Human name 3">Hello there #3</div>
			<div data-devise="key4, type, Human name 4">Hello there #4</div>

		<?php else: ?>

			<div data-devise="key5, type, Human name 5">Hello there #5</div>

		<?php endif ?>

	<?php } ?>

	<p data-devise="outside, type, Outside Key">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</p>
</body>