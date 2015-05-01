<?php namespace Devise\Media;

use Mockery as m;
use org\bovigo\vfs\vfsStream;

class MediaPathsTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        vfsStream::setup('basePath', null, [
            'test.png' => 'some content'
        ]);
        $this->basepath = 'vfs://basePath/';
        $this->Config = m::mock("Illuminate\Config\Repository");
        $this->MediaPaths = new MediaPaths($this->basepath, 'baseurl', $this->Config);
    }

    public function test_it_returns_basepath()
    {
        assertEquals($this->basepath, $this->MediaPaths->basePath());
    }

    public function test_it_checks_for_file_existence()
    {
        assertTrue($this->MediaPaths->fileExists('test.png'));
    }

    public function test_it_can_touch_a_path()
    {
        $this->MediaPaths->touch('some/file.txt');
        assertFileExists('vfs://basePath/some/file.txt');
    }

    public function test_it_gets_file_version_info_from_a_url()
    {
        $obj = $this->MediaPaths->fileVersionInfoFromUrl('http://someurl.com/file.jpg');
        assertEquals('vfs://basePath/', $obj->basepath);
        assertEquals("vfs://basePath//media", $obj->mediapath);
        assertEquals("vfs://basePath//media-versions", $obj->mediaversionpath);
        assertEquals("bfe05a788f9c98b29c9746d4a80c0341", $obj->md5);
        assertEquals("jpg", $obj->ext);
        assertEquals("bfe/05a/bfe05a788f9c98b29c9746d4a80c0341", $obj->partition);
        assertEquals(false, $obj->tempfile);
        assertEquals("vfs://basePath//bfe05a788f9c98b29c9746d4a80c0341", $obj->filepath);
        assertEquals("bfe05a788f9c98b29c9746d4a80c0341", $obj->filename);
        assertEquals("vfs://basePath/", $obj->filedir);
        assertEquals("vfs://basePath//media-versions/bfe/05a/bfe05a788f9c98b29c9746d4a80c0341/bfe05a788f9c98b29c9746d4a80c0341.jpg ", $obj->versionpath);
        assertEquals("bfe05a788f9c98b29c9746d4a80c0341", $obj->versionname);
        assertEquals("vfs://basePath//media-versions/bfe/05a/bfe05a788f9c98b29c9746d4a80c0341", $obj->versiondir);
    }

    public function test_it_gets_file_version_info()
    {
        $obj = $this->MediaPaths->fileVersionInfo('test.png');
        assertEquals("vfs://basePath/", $obj->basepath );
        assertEquals("vfs://basePath//media", $obj->mediapath );
        assertEquals("vfs://basePath//media-versions", $obj->mediaversionpath);
        assertEquals("9893532233caff98cd083a116b013c0b", $obj->md5);
        assertEquals("png", $obj->ext);
        assertEquals("989/353/9893532233caff98cd083a116b013c0b", $obj->partition);
        assertEquals(false, $obj->tempfile);
        assertEquals("vfs://basePath/test.png", $obj->filepath);
        assertEquals("test", $obj->filename);
        assertEquals("vfs://basePath", $obj->filedir);
        assertEquals("vfs://basePath//media-versions/989/353/9893532233caff98cd083a116b013c0b/test.png", $obj->versionpath);
        assertEquals("test", $obj->versionname);
        assertEquals("vfs://basePath//media-versions/989/353/9893532233caff98cd083a116b013c0b", $obj->versiondir);
    }

    public function test_it_makes_relative_path()
    {
        assertEquals('some/path', $this->MediaPaths->makeRelativePath('vfs://basePath/some/path'));
    }

    public function test_it_gets_zencoder_url()
    {
        $this->Config->shouldReceive('get')->times(1)->andReturn('zencoder/');
        assertEquals('zencoder/some/path', $this->MediaPaths->zencoderUrl('some/path'));
    }

    public function test_it_downloads_from_url()
    {
        $this->MediaPaths->downloadFromUrl("vfs://basePath/test.png", 'vfs://basePath/new-test.png');
    }

    public function test_it_checks_if_url_is_a_path()
    {
        assertTrue($this->MediaPaths->isUrlPath('http://google.com'));
        assertFalse($this->MediaPaths->isUrlPath('not a url'));
        assertTrue($this->MediaPaths->isUrlPath('https://google.com'));
    }
}