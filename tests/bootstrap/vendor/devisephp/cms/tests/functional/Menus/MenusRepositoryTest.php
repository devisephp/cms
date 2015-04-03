<?php namespace Devise\Menus;

use Mockery as m;

class MenusRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        // Menus are cached... so this static class
        // messes with our tests... so we do this little forget hack
        MenuCache::forgetMenu('Name');

        $this->DvsMenu = new \DvsMenu;
        $this->DvsMenuItem = new \DvsMenuItem;
        $this->DvsLanguage = new \DvsLanguage;
        $this->LanguageDetector = m::mock('Devise\Languages\LanguageDetector');
        $this->LanguageDetector->shouldReceive('current')->andReturn($this->DvsLanguage);
        $this->LanguageDetector->shouldReceive('primaryLanguageId')->andReturn(45);
        $this->UserHelper = m::mock('Devise\Users\UserHelper');
        $this->Input = m::mock('Illuminate\Http\Request');
        $Framework = m::mock('\Devise\Support\Framework');
        $Framework->Input = $this->Input;
        $this->MenusRepository = new MenusRepository($this->DvsMenu, $this->DvsMenuItem, $this->LanguageDetector, $this->UserHelper, $Framework);
    }

    public function test_it_retrieves_menus()
    {
        $this->Input->shouldReceive('get')->andReturn(45);
        assertCount(1, $this->MenusRepository->menus());
    }

    public function test_it_can_filter_out_menu_items_by_permission()
    {
        $this->createMenu([], [
            [
                'id' => 9999,
                'parent_item_id' => null,
                'name' => 'Parent #1',
                'url' => '#',
                'position' => 0,
            ],
            [
                'id' => 9998,
                'parent_item_id' => 9999,
                'name' => 'Child #1',
                'url' => '#',
                'position' => 1,
            ],
            [
                'id' => 9997,
                'parent_item_id' => 9999,
                'name' => 'Child #2',
                'url' => '#',
                'position' => 2,
                'permission' => 'durka',
            ],
            [
                'id' => 9996,
                'parent_item_id' => 9999,
                'name' => 'Child #3',
                'url' => '#',
                'position' => 3,
                'permission' => '',
            ],
        ]);

        $this->UserHelper->shouldReceive('checkConditions')->with('durka')->andReturn(false);
        $menu = $this->MenusRepository->buildMenu('Name');
        assertCount(1, $menu);
        assertCount(2, $menu[0]->children);

    }

    public function test_it_finds_menu_by_id()
    {
        $this->createMenu();
        $menu = $this->MenusRepository->findById(9999);
        assertInstanceOf('DvsMenu', $menu);
    }

    public function test_it_finds_menu_by_name()
    {
        $this->createMenu();
        assertInstanceOf('DvsMenu', $this->MenusRepository->findMenuByName("Name"));
    }

    public function test_it_builds_menus()
    {
        $this->createMenu();
        $menu = $this->MenusRepository->buildMenu('Name');
        assertCount(0, $menu);
    }

    public function test_it_gets_children_menu_items()
    {
        $this->createMenu();
        assertCount(0, $this->MenusRepository->getChildrenMenuItems('Name'));
    }

    public function test_it_gets_sibling_menu_items()
    {
        $this->createMenu();
        assertCount(0, $this->MenusRepository->getSiblingMenuItems('Name'));
    }

    protected function createMenu($menu = [], $menuItems = [])
    {
        $menu = array_merge([
            'id' => 9999,
            'name' => 'Name',
            'language_id' => 45,
        ], $menu);

        \DB::table('dvs_menus')->insert($menu);

        foreach ($menuItems as $menuItem)
        {
            $menuItem = array_merge(['menu_id' => $menu['id']], $menuItem);
            \DB::table('dvs_menu_items')->insert($menuItem);
        }
    }
}