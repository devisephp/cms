<?php namespace Devise\Pages;

use Mockery as m;
use Devise\Support\Framework;

class RoutesGeneratorTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new Framework;
        $this->Framework->File = m::mock('FilesystemMock');
        $this->RoutesCacheCommand = m::mock('Devise\Pages\RoutesCacheCommand');
        $this->RoutesGenerator = new RoutesGenerator($this->Framework, $this->RoutesCacheCommand);
    }

    public function test_it_can_cache_routes()
    {
		$this->Framework->File->shouldReceive('put')->once();
		$this->RoutesCacheCommand->shouldReceive('fire')->once();
		$this->RoutesGenerator->cacheRoutes();
    }

    public function test_it_can_load_routes()
    {
		$this->Framework->File->shouldReceive('exists')->andReturn(false);
		$this->RoutesGenerator->Route = m::mock('Router');
		$this->RoutesGenerator->Route->shouldReceive('get');
		$this->RoutesGenerator->Route->shouldReceive('post');
		$this->RoutesGenerator->Route->shouldReceive('put');
		$this->RoutesGenerator->Route->shouldReceive('delete');
		$this->RoutesGenerator->Route->shouldReceive('patch');
		$this->RoutesGenerator->loadRoutes();
    }

    public function test_it_does_not_load_routes_when_cache_exists()
    {
		$this->Framework->File->shouldReceive('exists')->andReturn(true);
		$this->RoutesGenerator->Route = m::mock('Router');
		$this->RoutesGenerator->Route->shouldReceive('get')->times(0);
		$this->RoutesGenerator->Route->shouldReceive('post')->times(0);
		$this->RoutesGenerator->Route->shouldReceive('put')->times(0);
		$this->RoutesGenerator->Route->shouldReceive('delete')->times(0);
		$this->RoutesGenerator->Route->shouldReceive('patch')->times(0);
		$this->RoutesGenerator->loadRoutes();
    }

    public function test_it_can_load_filters()
    {
		$this->RoutesGenerator->Route = m::mock('Router');
		$this->RoutesGenerator->Route->shouldReceive('filter');
    	$this->RoutesGenerator->loadFilters();
    }
}