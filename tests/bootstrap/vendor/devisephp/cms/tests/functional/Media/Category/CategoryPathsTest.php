<?php namespace Devise\Media\Categories;

use Mockery as m;

class CategoryPathsTest extends \DeviseTestCase
{
    public function setUp()
    {
        $this->Config = m::mock('Illuminate\Config\Repository');
        $this->CategoryPaths = new CategoryPaths($this->Config);
    }

    public function test_it_converts_path_from_dot_notation()
    {
        assertEquals('some/path/here', $this->CategoryPaths->fromDot('some.path.here'));
    }

    public function test_it_converts_path_to_dot_notation()
    {
        assertEquals('some.path.here', $this->CategoryPaths->toDot('some/path/here'));
    }

    public function test_it_gets_server_path()
    {
        $this->Config->shouldReceive('get')->andReturn('some/root/path');
        assertEquals(public_path() . '/some/root/path/some/path/here/', $this->CategoryPaths->serverPath('some/path/here'));
    }

    public function test_it_gets_browser_path()
    {
        $this->Config->shouldReceive('get')->andReturn('some/root/path');
        assertEquals('/some/root/path/some/path/here/', $this->CategoryPaths->browserPath('some/path/here'));
    }
}