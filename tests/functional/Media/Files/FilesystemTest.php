<?php namespace Devise\Media\Files;

use Mockery as m;
use org\bovigo\vfs\vfsStream;

class FilesystemTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        vfsStream::setup('baseFilePath', null, [
            'some_file.txt' => file_get_contents($this->fixture('images.awesome'))
        ]);
    }

    public function test_it_searches()
    {
        $this->Filesystem = new Filesystem;
        assertCount(1, $this->Filesystem->search('vfs://baseFilePath/', '.txt'));
    }

    public function test_it_renames()
    {
        $this->Filesystem = new Filesystem;
        $this->Filesystem->rename('vfs://baseFilePath/some_file.txt', 'vfs://baseFilePath/some_renamed_file.txt');
        assertFileExists('vfs://baseFilePath/some_renamed_file.txt');
    }
}