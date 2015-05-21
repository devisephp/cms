<?php namespace Devise\Menus;

class MenuCacheTest extends \DeviseTestCase
{
    public function test_it_saves_menus()
    {
        $menu = new \DvsMenu;
        $menu->name = "foo";
        MenuCache::$menus = [];
        MenuCache::saveMenu($menu, 'activeItemChildren', 'activeItemSiblings');
        assertEquals(['foo' => ['menu' => $menu, 'activeItemChildren' => 'activeItemChildren', 'activeItemSiblings' => 'activeItemSiblings']], MenuCache::$menus);
    }

    public function test_it_loads_menus()
    {
        MenuCache::$menus = ['somename' => 'menu#1'];
        assertEquals('menu#1', MenuCache::loadMenu('somename'));
    }
}