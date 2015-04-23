<?php namespace Devise\Media\Categories;

use Mockery as m;

class ManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        $this->Filesystem = m::mock('Devise\Media\Files\Filesystem');
        $this->CategoryPaths = m::mock('Devise\Media\Categories\CategoryPaths');
        $this->Manager = new Manager($this->Filesystem, $this->CategoryPaths);
    }

    public function test_it_stores_new_category()
    {
        $this->CategoryPaths->shouldReceive('fromDot')->andReturn('this/local/path');
        $this->CategoryPaths->shouldReceive('serverPath')->andReturn('/server/path');
        $this->Filesystem->shouldReceive('isDirectory')->andReturn(false);
        $this->Filesystem->shouldReceive('makeDirectory')->andReturn(true);
        $this->Manager->storeNewCategory(['name' => 'Some name', 'category' => 'Category 1']);
    }

    public function test_it_destroys_category()
    {
        $this->CategoryPaths->shouldReceive('fromDot')->andReturn('this/local/path');
        $this->CategoryPaths->shouldReceive('serverPath')->andReturn('/server/path');
        $this->Filesystem->shouldReceive('deleteDirectory')->andReturn(true);
        $this->Manager->destroyCategory(['category' => 'some/path']);
    }

    public function test_it_renames_category()
    {
        $this->Filesystem->shouldReceive('move')->times(1)->andReturn(true);
        $this->Manager->renameCategory('/some/path', '/some/new/path');
    }
}