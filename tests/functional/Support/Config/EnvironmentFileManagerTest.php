<?php namespace Devise\Support\Config;

use Mockery as m;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class EnvironmentFileManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $structure = array(
            '.env' => $this->fixture('env-example'),
        );

        vfsStream::setup('root', null, $structure);

        $this->Framework = new \Devise\Support\Framework;
        $this->EnvironmentFileManager = new EnvironmentFileManager($this->Framework, vfsStream::url('root/.env'));
    }

    public function test_it_can_get()
    {
        $settings = $this->EnvironmentFileManager->get();
        assertCount(14, $settings);
        assertEquals('local', $settings['APP_ENV']);
    }

    public function test_it_can_get_with_comments_and_empty_lines()
    {
        $settings = $this->EnvironmentFileManager->get($file = null, $settingsOnly = false);
        assertCount(17, $settings);
        assertEquals('local', $settings['APP_ENV']);
    }

    public function test_it_can_save()
    {
        $settings = $this->EnvironmentFileManager->save(['something' => 'new', '### some comments here']);
        $contents = file_get_contents(vfsStream::url('root/.env'));
        assertEquals('something=new' . PHP_EOL . '### some comments here', $contents);
    }

    public function test_it_can_merge()
    {
        $settings = $this->EnvironmentFileManager->merge(['something' => 'new']);
        $contents = file_get_contents(vfsStream::url('root/.env'));
        assertEquals($this->fixture('env-example') . PHP_EOL . 'something=new', $contents);
    }

}