<?php namespace Devise\Menus;

use Mockery as m;

class MenusManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->DvsMenu = new \DvsMenu;
        $this->DvsMenuItem = new \DvsMenuItem;
        $this->Framework = m::mock('\Devise\Support\Framework');
        $this->Framework->Validator = m::mock('Illuminate\Validation\Factory');
        $this->MenusManager = new MenusManager($this->DvsMenu, $this->DvsMenuItem, $this->Framework);
    }

    public function test_it_has_create_rules()
    {
        assertInternalType('array', $this->MenusManager->createRules());
    }

    public function test_it_creates_menus()
    {
        $this->Framework->Validator->shouldReceive('make')->times(1)->andReturnSelf();
        $this->Framework->Validator->shouldReceive('fails')->times(1)->andReturn(false);
        assertInstanceOf('DvsMenu', $this->MenusManager->createMenu([
           'name' => 'My menu name'
        ]));
    }

    public function test_it_has_update_rules()
    {
        assertInternalType('array', $this->MenusManager->updateRules(1));
    }

    public function test_it_updates_menu()
    {
        $this->Framework->Validator->shouldReceive('make')->times(1)->andReturnSelf();
        $this->Framework->Validator->shouldReceive('fails')->times(1)->andReturn(false);
        $menu = $this->MenusManager->updateMenu(1, ['name' => 'Updated Menu Name', 'item' => [], 'item_order' => []]);
        assertInstanceOf('DvsMenu', $menu);
    }
}