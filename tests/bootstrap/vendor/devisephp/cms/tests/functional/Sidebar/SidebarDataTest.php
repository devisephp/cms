<?php namespace Devise\Sidebar;

use Mockery as m;

class SidebarDataTest extends \DeviseTestCase
{
    public function test_it_constructs_and_has_certain_public_properties()
    {
        $SidebarData = new SidebarData;

        assertEquals(0, $SidebarData->coordinates->top);
        assertEquals(0, $SidebarData->coordinates->left);
        assertEquals("", $SidebarData->categoryName);
        assertEquals(0, $SidebarData->categoryCount);
        assertEquals([], $SidebarData->groups);
        assertEquals([], $SidebarData->elements);
    }
}