<?php namespace Devise\Support\Console;

use Mockery as m;

class DevisePublishAssetsCommandTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
    	$Framework = new \Devise\Support\Framework;
    	new DevisePublishAssetsCommand($Framework->Container);
    }
}