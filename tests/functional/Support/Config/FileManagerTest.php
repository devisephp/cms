<?php namespace Devise\Support\Config;

use \Illuminate\Filesystem\Filesystem as Filesystem;
use Mockery as m;

class FileManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $Framework = new \Devise\Support\Framework;
        $this->Filesystem = m::mock(new Filesystem);

        $this->FileManager = new FileManager($this->Filesystem, $Framework);
    }

    public function test_it_can_save_to_file()
    {
        $content = 'blammo';
        $filename = 'randofile';

        $this->Filesystem->shouldReceive('put')->andReturn(true);
        $this->Filesystem->shouldReceive('isDirectory')->times(2)->andReturn(true);

        assertEquals($content, $this->FileManager->saveToFile($content, $filename));
    }
}