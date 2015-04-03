<?php namespace Devise\Support\Console;

use Mockery as m;

class DeviseSeedCommandTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
    	$Framework = new \Devise\Support\Framework;
    	new DeviseSeedCommand($Framework->Container);
    }
}