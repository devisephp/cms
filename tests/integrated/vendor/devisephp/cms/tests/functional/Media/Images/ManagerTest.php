<?php namespace Devise\Media\Images;

use Mockery as m;

class ManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->Config = m::mock('Illuminate\Config\Repository');
        $this->CategoryPaths = m::mock('Devise\Media\Categories\CategoryPaths');
        $this->Filesystem = m::mock('Devise\Media\Files\Filesystem');
        $this->Images = m::mock('Devise\Media\Images\Images');
        $this->Manager = new Manager($this->Filesystem, $this->CategoryPaths, $this->Images, $this->Config);
    }

    public function test_it_extracts_images()
    {
        assertCount(0, $this->Manager->extractImagesForCallback([]));
    }

    public function test_it_gets_image_url()
    {
        $this->CategoryPaths->shouldReceive('browserPath')->times(1)->andReturn('browser/path');
        $this->Manager->getImageUrl(['image' => 'test']);
    }

    public function test_it_crops_and_save_file()
    {
        $image = m::mock('Imagick');
        $this->Config->shouldReceive('get')->times(1)->andReturn('root/path');
        $this->CategoryPaths->shouldReceive('serverPath')->times(1)->andReturn('server/path');
        $this->Images->shouldReceive('cropAndResizeImage')->times(1)->andReturn($image);
        $this->Images->shouldReceive('saveImage')->times(1);

        $output = $this->Manager->cropAndSaveFile(['image' => 'test', 'cropper' => [
            'width' => 100,
            'height' => 100,
            'w' => 50,
            'h' => 50,
            'x' => 0,
            'y' => 0,
        ]]);
        assertEquals('root/path.100x100.test', $output);
    }
}