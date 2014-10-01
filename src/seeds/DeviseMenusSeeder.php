<?php

class DeviseMenusSeeder extends Seeder
{
	public function run()
    {
		$menus = array(
			array(
				'id' => 1,
				'name' => 'Main Navigation'
			),
		);

		$menuItems = array(
			array(
				'id' => 1,
				'menu_id' => 1,
				'parent_item_id' => null,
				'name' => 'Menu Item 1',
				'url' => 'http://www.google.com',
			),
			array(
				'id' => 2,
				'menu_id' => 1,
				'parent_item_id' => 1,
				'name' => 'Menu Item 2',
				'url' => 'http://www.google.com',
			),
			array(
				'id' => 3,
				'menu_id' => 1,
				'parent_item_id' => 1,
				'name' => 'Menu Item 3',
				'url' => 'http://www.google.com',
			),
			array(
				'id' => 4,
				'menu_id' => 1,
				'parent_item_id' => null,
				'name' => 'Menu Item 4',
				'url' => 'http://www.google.com',
			),
		);

		DB::table('dvs_menus')->delete();
		DB::table('dvs_menu_items')->delete();

		foreach ($menus as $menu) {
			DB::table('dvs_menus')->insert($menu);
		}

		foreach ($menuItems as $menuItem) {
			DB::table('dvs_menu_items')->insert($menuItem);
		}
	}

}
