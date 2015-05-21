<?php namespace Devise\Support\Console;

use Mockery as m;

class DeviseMigrateCommandTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
    	$Framework = new \Devise\Support\Framework;
    	new DeviseMigrateCommand($Framework->Container);
    }
}