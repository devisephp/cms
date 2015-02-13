<?php namespace Devise\Support\Config;

use \Illuminate\Filesystem\Filesystem as Filesystem;
use Mockery as m;

class FileManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Filesystem = m::mock(new Filesystem);
        $this->Filesystem->shouldReceive('put')->andReturn(true);

        $this->FileManager = new FileManager($this->Filesystem);
    }

    public function test_it_can_save_to_file()
    {
    	$content = 'blammo';
    	$filename = 'randofile';
    	$package = 'devisephp';

        assertEquals($content, $this->FileManager->saveToFile($content, $filename, $package));
    }
}