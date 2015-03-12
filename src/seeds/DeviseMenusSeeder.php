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
				'name' => 'Languages',
				'url' => '/admin/languages',
				'position' => 5,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Users',
				'url' => '/admin/users',
				'position' => 6,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 1,
				'name' => 'Logout',
				'url' => '/admin/logout',
				'position' => 7,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => null,
				'name' => 'Development',
				'url' => '#',
				'permission' => 'isDeveloper',
				'position' => 8,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'API',
				'url' => '/admin/api',
				'position' => 9,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Groups',
				'url' => '/admin/groups',
				'position' => 10,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Permissions',
				'url' => '/admin/permissions',
				'position' => 11,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Templates',
				'url' => '/admin/templates',
				'position' => 12,
			),
			array(
				'menu_id' => $menuId,
				'parent_item_id' => 8,
				'name' => 'Settings',
				'url' => '/admin/settings',
				'position' => 13,
			),
		);

		$this->findOrCreateRows('dvs_menu_items', ['menu_id', 'name'], $menuItems);
	}
}
