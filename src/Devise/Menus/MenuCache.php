<?php namespace Devise\Menus;

class MenuCache
{
	public static $menus = array();

	public static function saveMenu($menu, $activeItemChildren, $activeItemSiblings)
	{
		self::$menus[ $menu->name ] = array(
			'menu' => $menu,
			'activeItemChildren' => $activeItemChildren,
			'activeItemSiblings' => $activeItemSiblings,
		);
	}

	public static function loadMenu($name)
	{
		return (isset(self::$menus[ $name ])) ? self::$menus[ $name ] : false;
	}

	public static function forgetMenu($name)
	{
		unset(self::$menus[$name]);
	}
}