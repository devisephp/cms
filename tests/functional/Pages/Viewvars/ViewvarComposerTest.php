<?php namespace Devise\Pages\Viewvars;

use Mockery as m;

class ViewvarComposerTest extends \DeviseTestCase
{
    public function test_it_composes()
    {
        $vars = [ 'var1' => 1, 'var2' => 2 ];
        $view = m::mock('Illuminate\View\View');
        $view->shouldReceive('getData')->times(1)->andReturn([]);
        $view->shouldReceive('getName')->times(1)->andReturn('cool-view');
        $view->shouldReceive('with')->times(2);
        $Config = m::mock('Illuminate\Config\Repository');
        $Config->shouldReceive('get')->with('devise::view-vars')->andReturn(['cool-view' => $vars]);
        $Config->shouldReceive('get')->with('devise::view-extensions.cool-view')->andReturn([]);
        $DataBuilder = m::mock('Devise\Pages\Viewvars\DataBuilder');
        $DataBuilder->shouldReceive('setData')->with([]);
        $DataBuilder->shouldReceive('compile')->with($vars)->andReturn($vars);
        $composer = new ViewvarComposer($DataBuilder, $Config);
        $composer->compose($view);
    }
}