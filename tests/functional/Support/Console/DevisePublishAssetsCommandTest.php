<?php namespace Devise\Support\Console;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use Mockery as m;

class DevisePublishAssetsCommandTest extends \DeviseTestCase
{
    public function test_it_can_handle_command()
    {
    	$Framework = new \Devise\Support\Framework;
    	$DevisePublishAssetsCommand = new DevisePublishAssetsCommand($Framework->Container);
    	$DevisePublishAssetsCommand->base_path = '/base';
    	$DevisePublishAssetsCommand->public_path = '/base/public';
    	$DevisePublishAssetsCommand->__DIR__ = '__DIR__/path';
    	$DevisePublishAssetsCommand->File = m::mock('FileSystem');
        $DevisePublishAssetsCommand->File->shouldReceive('copyDirectory')->with("__DIR__/path/../../../../public", "/base/public/packages/devisephp/cms");
        $DevisePublishAssetsCommand->File->shouldReceive('copyDirectory')->with("__DIR__/path/../../../views/errors", "/base/resources/views/errors/");
    	$DevisePublishAssetsCommand->handle();
    }
}