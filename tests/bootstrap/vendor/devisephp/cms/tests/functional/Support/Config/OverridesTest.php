<?php namespace Devise\Support\Config;

use Mockery as m;

class OverridesTest extends \DeviseTestCase
{
    public function test_it_overrides_config()
    {
    	$overrides = new Overrides(['a' => 1, 'b' => 2, 'c' => 3], ['b' => 4]);

    	assertEquals(1, $overrides->get('a'));
    	assertEquals(4, $overrides->get('b'));
    }
}