<?php namespace Devise\Media\Images;

use Mockery as m;
use org\bovigo\vfs\vfsStream;

class ImagesTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        vfsStream::setup('baseImagePath', null, [
            'test.png' => file_get_contents($this->fixture('images.awesome')),
        ]);

        $this->testImageFile =  __DIR__ . '/../../test.png';
        if (file_exists($this->testImageFile)) unlink($this->testImageFile);

        $this->Images = new Images;
    }

    public function tearDown()
    {
        if (file_exists($this->testImageFile)) unlink($this->testImageFile);
        parent::tearDown();
    }

    public function test_it_copies_image()
    {
        $this->Images->copyImage('vfs://baseImagePath/test.png', 'vfs://baseImagePath/test1.png');
        assertFileExists('vfs://baseImagePath/test1.png');
    }

    public function test_it_crops_image()
    {
        $image = $this->Images->cropImage('vfs://baseImagePath/test.png', 100, 100, 0, 0);
        assertInstanceOf('Imagick', $image);
        assertEquals(110, $image->getImageWidth());
    }

    public function test_it_resizes_image()
    {
        $image = $this->Images->resizeImage('vfs://baseImagePath/test.png', 100, 100);
        assertInstanceOf('Imagick', $image);
        assertEquals(100, $image->getImageWidth());
    }

    public function test_it_crops_and_resizes_image()
    {
        $image = $this->Images->cropAndResizeImage('vfs://baseImagePath/test.png', 100, 100, 50, 50, 0, 0);
        assertInstanceOf('Imagick', $image);
        assertEquals(100, $image->getImageWidth());
    }

    public function test_it_saves_image()
    {
        $image = new \Imagick( vfsStream::url('baseImagePath/test.png') );
        $this->Images->saveImage($image, $this->testImageFile);
        assertFileExists($this->testImageFile);
    }

    public function test_it_makes_thumbnail_images()
    {
        $image = $this->Images->makeThumbnailImage('vfs://baseImagePath/test.png', $this->testImageFile);
        assertEquals(200, $image->getImageWidth());
        assertFileExists($this->testImageFile);
    }

    public function test_it_can_tell_me_if_this_file_can_have_thumbnails()
    {
        assertTrue($this->Images->canMakeThumbnailFromFile('vfs://baseImagePath/test.png'));
    }
}