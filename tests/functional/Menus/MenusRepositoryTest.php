<?php namespace Devise\Menus;

use Mockery as m;

class MenusRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->DvsMenu = new \DvsMenu;
        $this->DvsMenuItem = new \DvsMenuItem;
        $this->DvsLanguage = new \DvsLanguage;
        $this->LanguageDetector = m::mock('Devise\Languages\LanguageDetector');
        $this->LanguageDetector->shouldReceive('current')->andReturn($this->DvsLanguage);
        $this->LanguageDetector->shouldReceive('primaryLanguageId')->andReturn(45);
        $this->Input = m::mock('Illuminate\Http\Request');
        $Framework = m::mock('\Devise\Support\Framework');
        $Framework->Input = $this->Input;
        $this->MenusRepository = new MenusRepository($this->DvsMenu, $this->DvsMenuItem, $this->LanguageDetector, $Framework);
    }

    public function test_it_retrieves_menus()
    {
        $this->Input->shouldReceive('get')->andReturn(45);
        assertCount(1, $this->MenusRepository->menus());
    }

    public function test_it_finds_menu_by_id()
    {
        $this->createMenu([], []);
        $menu = $this->MenusRepository->findById(9999);
        assertInstanceOf('DvsMenu', $menu);
    }

    public function test_it_finds_menu_by_name()
    {
        $this->createMenu([], []);
        $menu = $this->MenusRepository->findMenuByName("Name");
        assertInstanceOf('DvsMenu', $menu);
    }

    public function test_it_builds_menus()
    {
        $this->createMenu([], []);
        assertCount(0, $this->MenusRepository->buildMenu('Name'));
    }

    public function test_it_gets_children_menu_items()
    {
        $this->createMenu([], []);
        assertCount(0, $this->MenusRepository->getChildrenMenuItems('Name'));
    }

    public function test_it_gets_sibling_menu_items()
    {
        $this->createMenu([], []);
        assertCount(0, $this->MenusRepository->getSiblingMenuItems('Name'));
    }

    protected function createMenu($menu, $menuitems)
    {
        $menu = array_merge([
            'id' => 9999,
            'name' => 'Name',
            'language_id' => 45,
        ], $menu);

        \DB::table('dvs_menus')->insert($menu);
    }
}