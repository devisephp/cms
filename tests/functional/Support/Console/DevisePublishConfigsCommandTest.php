<?php namespace Devise\Support\Console;

use Mockery as m;
use File;

class DevisePublishConfigsCommandTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
    	$Framework = new \Devise\Support\Framework;
    	new DevisePublishConfigsCommand($Framework->Container);
    }
}