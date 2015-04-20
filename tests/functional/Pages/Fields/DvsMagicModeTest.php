<?php namespace Devise\Pages\Fields;

use Mockery as m;

class DvsMagicModeTest extends \DeviseTestCase
{
	public function test_it_starts_disabled()
	{
		$DvsMagicMode = new DvsMagicMode;
		assertFalse($DvsMagicMode->enabled());
		assertTrue($DvsMagicMode->disabled());
	}

	public function test_it_enables()
	{
		$DvsMagicMode = new DvsMagicMode;
		$DvsMagicMode->enable(true);
		assertTrue($DvsMagicMode->enabled());
		assertFalse($DvsMagicMode->disabled());
	}

	public function test_it_disables()
	{
		$DvsMagicMode = new DvsMagicMode;
		$DvsMagicMode->disable(true);
		assertFalse($DvsMagicMode->enabled());
		assertTrue($DvsMagicMode->disabled());
	}
}