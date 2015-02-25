<?php namespace Devise\Media\Images;

use Mockery as m;
use org\bovigo\vfs\vfsStream;

class ImagesTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        vfsStream::setup('baseImagePath', null, [
            'test.png' => file_get_contents($this->fixture('images.awesome'))
        ]);

        $this->Images = new Images;
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

    public function test_it_can_tell_me_if_a_file_has_thumbnail()
    {
        $this->markTestIncomplete();
    }

    public function test_it_saves_image()
    {
        $this->markTestIncomplete();
        // $image = new \Imagick('vfs://baseImagePath/test.png');
        // $this->Images->saveImage($image, );
        // assertFileExists('vfs://baseImagePath/test2.png');
    }

    public function test_it_makes_thumbnail_images()
    {
        $this->markTestIncomplete();
        // $image = $this->Images->makeThumbnailImage('vfs://baseImagePath/test.png', 'vfs://baseImagePath.new-test.png');
        // assertEquals(200, $image->getImageWidth());
        // assertFileExists('vfs://baseImagePath.new-test.png');
    }
}