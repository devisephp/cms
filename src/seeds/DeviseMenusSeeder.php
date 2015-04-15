<?php

class DeviseMenusSeeder extends DeviseSeeder
{
	public function run()
    {
		$menu = $this->findOrCreateRow('dvs_menus', 'name', [
				'language_id' => 45,
				'name' => 'Admin Menu'
		]);

		$menuId = $menu->id;

		$menuItems = array(
			array(
				'menu_id' => $menuId,
				'parent_item_id' => null,
				'name' => 'Management',
				'url' => '#',
				'position' => 100,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Dashboard',
				'url' => '/admin',
				'position' => 101,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Menus',
				'url' => '/admin/menus',
				'position' => 102,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Pages',
				'url' => '/admin/pages',
				'position' => 103,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Languages',
				'url' => '/admin/languages',
				'position' => 104,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Users',
				'url' => '/admin/users',
				'position' => 105,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Logout',
				'url' => '/admin/logout',
				'position' => 106,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => null,
				'name' => 'Development',
				'url' => '#',
				'permission' => 'isDeveloper',
				'position' => 200,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'API',
				'url' => '/admin/api',
				'position' => 201,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Groups',
				'url' => '/admin/groups',
				'position' => 202,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Permissions',
				'url' => '/admin/permissions',
				'position' => 203,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Templates',
				'url' => '/admin/templates',
				'position' => 204,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Create Models',
				'url' => '/admin/models/create',
				'position' => 205,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Settings',
				'url' => '/admin/settings',
				'position' => 206,
			),
		);

		$this->findOrCreateRows('dvs_menu_items', ['menu_id', 'name'], $menuItems);
	}
}
