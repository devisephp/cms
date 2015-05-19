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
    	$DevisePublishAssetsCommand->io = m::mock('InputOutput');
    	$DevisePublishAssetsCommand->io->shouldReceive('ask')->andReturn('Y');
    	$DevisePublishAssetsCommand->FileDiff = m::mock('Devise\Support\IO\FileDiff');
	   	$DevisePublishAssetsCommand->FileDiff->shouldReceive('different')->andReturn(['a_different_file.txt', 'bar.txt']);
	   	$DevisePublishAssetsCommand->FileDiff->shouldReceive('unmodified')->andReturn(['durka.txt']);
    	$DevisePublishAssetsCommand->File = m::mock('FileSystem');
    	$DevisePublishAssetsCommand->File->shouldReceive('isDirectory')->andReturn(true);
    	$DevisePublishAssetsCommand->File->shouldReceive('copy')->with("__DIR__/path/../../../../public/durka.txt", "/base/public/packages/devisephp/cms/durka.txt", true)->andReturn(1);
    	$DevisePublishAssetsCommand->File->shouldReceive('copy')->with("__DIR__/path/../../../../public/a_different_file.txt", "/base/public/packages/devisephp/cms/a_different_file.txt", true)->andReturn(1);
    	$DevisePublishAssetsCommand->File->shouldReceive('copy')->with("__DIR__/path/../../../../public/bar.txt", "/base/public/packages/devisephp/cms/bar.txt", true)->andReturn(1);
    	$DevisePublishAssetsCommand->File->shouldReceive('copy')->with("__DIR__/path/../../../views/errors/durka.txt", "/base/resources/views/errors//durka.txt", true)->andReturn(1);
    	$DevisePublishAssetsCommand->File->shouldReceive('copy')->with("__DIR__/path/../../../views/errors/a_different_file.txt", "/base/resources/views/errors//a_different_file.txt", true)->andReturn(1);
    	$DevisePublishAssetsCommand->File->shouldReceive('copy')->with("__DIR__/path/../../../views/errors/bar.txt", "/base/resources/views/errors//bar.txt", true)->andReturn(1);
    	$DevisePublishAssetsCommand->handle();
    }
}