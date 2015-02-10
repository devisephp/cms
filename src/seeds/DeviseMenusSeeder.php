<?php

class DeviseMenusSeeder extends DeviseSeeder
{
	public function run()
    {
		$menus = array(
				'language_id' => 45,
				'name' => 'Admin Menu'
			);

		$menuId = DB::table('dvs_menus')->insertGetId($menus);

		$menuItems = array(
			array(
				'menu_id' => $menuId,
				'parent_item_id' => null,
				'name' => 'Website Management',
				'url' => '#',
				'position' => 1,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Dashboard',
				'url' => '/admin',
				'position' => 2,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Menus',
				'url' => '/admin/menus',
				'position' => 3,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Pages',
				'url' => '/admin/pages',
				'position' => 4,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Templates',
				'url' => '/admin/templates',
				'position' => 5,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Logout',
				'url' => '/admin/logout',
				'position' => 6,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => null,
				'name' => 'Application Management',
				'url' => '#',
				'position' => 7,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 7,
				'name' => 'Users',
				'url' => '/admin/users',
				'position' => 8,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 7,
				'name' => 'Groups',
				'url' => '/admin/groups',
				'position' => 9,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 7,
				'name' => 'Permissions',
				'url' => '/admin/permissions',
				'position' => 10,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 7,
				'name' => 'Languages',
				'url' => '/admin/languages',
				'position' => 11,
			),
		);

		DB::table('dvs_menu_items')->insert($menuItems);
	}
}
