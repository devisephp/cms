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
        $this->Framework->DB = m::mock('DBMock');
        $this->Framework->Artisan = m::mock('ArtisanMock');
        $this->Framework->Config = m::mock('ConfigMock');
        $this->Framework->Container = m::mock('AppMock');
        $this->RoutesGenerator = new RoutesGenerator($this->Framework);
    }

    public function test_it_can_cache_routes()
    {
    	$this->Framework->Config->shouldReceive('get')->with('devise.routes.enabled')->andReturn(true);
    	$this->Framework->Config->shouldReceive('get')->with('devise.routes.cache')->andReturn('some file path');
		$this->Framework->File->shouldReceive('put')->once();
		$this->Framework->DB->shouldReceive('table')->once()->andReturnSelf();
		$this->Framework->DB->shouldReceive('select')->once()->andReturnSelf();
		$this->Framework->DB->shouldReceive('get')->once()->andReturnSelf();
		$this->Framework->Artisan->shouldReceive('call')->once()->andReturnSelf();
		$this->RoutesGenerator->cacheRoutes();
    }

    public function test_it_can_load_routes()
    {
    	$this->Framework->Container->shouldReceive('routesAreCached')->andReturn(false);
		$this->Framework->File->shouldReceive('exists')->andReturn(false);
		$this->RoutesGenerator->Route = m::mock('Router');
		$this->RoutesGenerator->Route->shouldReceive('get');
		$this->RoutesGenerator->Route->shouldReceive('post');
		$this->RoutesGenerator->Route->shouldReceive('put');
		$this->RoutesGenerator->Route->shouldReceive('delete');
		$this->RoutesGenerator->Route->shouldReceive('patch');
		$this->Framework->DB->shouldReceive('table')->once()->andReturnSelf();
		$this->Framework->DB->shouldReceive('select')->once()->andReturnSelf();
		$this->Framework->DB->shouldReceive('get')->once()->andReturnSelf();
		$this->RoutesGenerator->loadRoutes();
    }

    public function test_it_does_not_load_routes_when_cache_exists()
    {
    	$this->Framework->Container->shouldReceive('routesAreCached')->andReturn(true);
        $this->Framework->Config->shouldReceive('get')->with('devise.routes.enabled')->andReturn(true);
		$this->RoutesGenerator->Route = m::mock('Router');
		$this->RoutesGenerator->Route->shouldReceive('get')->times(0);
		$this->RoutesGenerator->Route->shouldReceive('post')->times(0);
		$this->RoutesGenerator->Route->shouldReceive('put')->times(0);
		$this->RoutesGenerator->Route->shouldReceive('delete')->times(0);
		$this->RoutesGenerator->Route->shouldReceive('patch')->times(0);
		$this->RoutesGenerator->loadRoutes();
    }
}