<?php namespace Devise\Support\Installer;

use Mockery as m;

class DatabaseCreatorTest extends \DeviseTestCase
{
    public function test_it_creates_a_database()
    {
    	$connection = m::mock('PDO');
    	$connection->shouldReceive('setAttribute')->with(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION)->once();
    	$connection->shouldReceive('exec')->with('CREATE DATABASE `database`;');
    	$DatabaseCreator = new DatabaseCreator($connection);
    	$DatabaseCreator->createDatabase('driver', 'host', 'database', 'username', 'password');
    }
}