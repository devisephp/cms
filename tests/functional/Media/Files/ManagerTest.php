<?php namespace Devise\Media\Files;

use Mockery as m;

class ManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Filesystem = m::mock('Devise\Media\Files\Filesystem');
        $this->CategoryPaths = m::mock('Devise\Media\Categories\CategoryPaths');
        $this->Image = m::mock('Devise\Media\Images\Image');
        $this->Config = m::mock('Illuminate\Config\Repository');
        $this->Manager = new Manager($this->Filesystem, $this->CategoryPaths, $this->Image, $this->Config);
    }

    public function test_it_saves_uploaded_files()
    {
        $file = m::mock('SplFileInfo');
        $file->shouldReceive('getClientOriginalName')->times(1)->andReturn('originalfilename.png');
        $file->shouldReceive('move')->times(1)->with('server/path', 'originalfilename.png');
        $file->shouldReceive('getClientMimeType')->times(1)->andReturn('image');
        $this->CategoryPaths->shouldReceive('serverPath')->andReturn('server/path');
        $this->Config->shouldReceive('get')->andReturn('yep');
        $this->Image->shouldReceive('makeThumbnailImage');
        $this->Manager->saveUploadedFile(['file' => $file]);
    }

    public function test_it_renames_uploaded_files()
    {
        $this->Filesystem->shouldReceive('rename')->times(1)->with('/media/some/path', '/media/new/path');
        $this->Manager->renameUploadedFile('some/path', 'new/path');
    }

    public function test_removes_uploaded_file()
    {
        $this->Config->shouldReceive('get')->times(1)->andReturn('something');
        $this->Filesystem->shouldReceive('delete')->times(1)->andReturn(true);
        $this->Manager->removeUploadedFile('some/file');
    }
}