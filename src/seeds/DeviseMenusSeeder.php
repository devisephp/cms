<?php

class DeviseMenusSeeder extends Seeder
{
	public function run()
    {
		$menus = array(
			array(
				'id' => 1,
				'language_id' => 45,
				'name' => 'Admin Menu'
			),
		);

		$menuItems = array(
			array(
				'id' => 1,
				'menu_id' => 1,
				'parent_item_id' => null,
				'name' => 'Website Management',
				'url' => '#',
				'position' => 1,
			),
			array(
				'id' => 2,
				'menu_id' => 1,
				'parent_item_id' => 1,
				'name' => 'Dashboard',
				'url' => '/admin',
				'position' => 2,
			),
			array(
				'id' => 3,
				'menu_id' => 1,
				'parent_item_id' => 1,
				'name' => 'Menus',
				'url' => '/admin/menus',
				'position' => 3,
			),
			array(
				'id' => 4,
				'menu_id' => 1,
				'parent_item_id' => 1,
				'name' => 'Pages',
				'url' => '/admin/pages',
				'position' => 4,
			),
			array(
				'id' => 5,
				'menu_id' => 1,
				'parent_item_id' => 1,
				'name' => 'Templates',
				'url' => '/admin/templates',
				'position' => 5,
			),
			array(
				'id' => 6,
				'menu_id' => 1,
				'parent_item_id' => 1,
				'name' => 'Logout',
				'url' => '/admin/logout',
				'position' => 6,
			),
			array(
				'id' => 7,
				'menu_id' => 1,
				'parent_item_id' => null,
				'name' => 'Application Management',
				'url' => '#',
				'position' => 7,
			),
			array(
				'id' => 8,
				'menu_id' => 1,
				'parent_item_id' => 7,
				'name' => 'Users',
				'url' => '/admin/users',
				'position' => 8,
			),
			array(
				'id' => 9,
				'menu_id' => 1,
				'parent_item_id' => 7,
				'name' => 'Groups',
				'url' => '/admin/groups',
				'position' => 9,
			),
			array(
				'id' => 10,
				'menu_id' => 1,
				'parent_item_id' => 7,
				'name' => 'Permissions',
				'url' => '/admin/permissions',
				'position' => 10,
			),
			array(
				'id' => 11,
				'menu_id' => 1,
				'parent_item_id' => 7,
				'name' => 'Languages',
				'url' => '/admin/languages',
				'position' => 11,
			),
		);

		DB::table('dvs_menus')->insert($menus);
		DB::table('dvs_menu_items')->insert($menuItems);
	}
}
