<?php namespace Devise\Menus;

use Mockery as m;

class MenusManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->DvsMenu = new \DvsMenu;
        $this->DvsMenuItem = new \DvsMenuItem;
        $this->Framework = new \Devise\Support\Framework;
        $this->MenusManager = new MenusManager($this->DvsMenu, $this->DvsMenuItem, $this->Framework);
    }

    public function test_it_has_create_rules()
    {
        assertInternalType('array', $this->MenusManager->createRules());
    }

    public function test_it_creates_menus()
    {
        assertInstanceOf('DvsMenu', $this->MenusManager->createMenu([
           'name' => 'My menu name',
           'language_id' => 45,
        ]));
    }

    public function test_it_has_update_rules()
    {
        assertInternalType('array', $this->MenusManager->updateRules(1));
    }

    public function test_it_updates_menu()
    {
        $menu = $this->MenusManager->updateMenu(1, ['name' => 'Updated Menu Name', 'item' => [], 'item_order' => []]);
        assertInstanceOf('DvsMenu', $menu);
    }
}