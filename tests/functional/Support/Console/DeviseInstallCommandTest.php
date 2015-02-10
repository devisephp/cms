<?php namespace Devise\Support\Console;

use Mockery as m;

class DeviseInstallCommandTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
    	$Framework = new \Devise\Support\Framework;
    	new DeviseInstallCommand($Framework->Container);
    }
}