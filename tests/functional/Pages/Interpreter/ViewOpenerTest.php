<?php namespace Devise\Pages\Interpreter;

use Mockery as m;

class ViewOpenerTest extends \DeviseTestCase
{
    public function test_it_can_open_views()
    {
        $includedViews = array();
        $finder = m::mock('Illuminate\View\FileViewFinder');
        $finder->shouldReceive('find')->times(1)->with('some.path');
        $obj = new ViewOpener($finder);
        $obj->open('@include("some.path")', $includedViews);
        assertEquals(['some.path'], $includedViews);
    }

    public function test_it_can_open_views_with_single_quotes()
    {
        $includedViews = array();
        $finder = m::mock('Illuminate\View\FileViewFinder');
        $finder->shouldReceive('find')->times(1)->with('some.path');
        $obj = new ViewOpener($finder);
        $obj->open("@include('some.path')", $includedViews);
        assertEquals(['some.path'], $includedViews);
    }

    public function test_it_does_not_error_when_view_is_not_found()
    {
        $includedViews = array();
        $finder = m::mock('Illuminate\View\FileViewFinder');
        $finder->shouldNotHaveReceived('find');
        $obj = new ViewOpener($finder);
        assertEquals('', $obj->open('... bad stuff here ...', $includedViews));
    }

    public function test_it_finds_all_included_views()
    {
        $finder = m::mock('Illuminate\View\FileViewFinder');
        $finder->shouldReceive('find')->times(4)->andReturn(
            __DIR__ . '/../../../fixtures/devise-views/view7.blade.php',
            __DIR__ . '/../../../fixtures/devise-views/view8.blade.php',
            __DIR__ . '/../../../fixtures/devise-views/view9.blade.php',
            __DIR__ . '/../../../fixtures/devise-views/view9.blade.php'
        );
        $obj = new ViewOpener($finder);
        $views = $obj->findAllIncludedViews('view7');
        assertEquals([
            "devise::admin.pages.page-versions._cards",
            "devise::view10",
            "view9",
            "view7"
        ], $views);
    }
}