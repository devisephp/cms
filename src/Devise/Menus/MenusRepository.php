<?php namespace Devise\Menus;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Devise\Languages\LanguageDetector;
use Devise\Support\Framework;
use Devise\Users\UserHelper;
use Illuminate\Support\Collection;
use Devise\Support\DeviseException;

/**
 * Class MenusRepository retrieves things related to
 * DvsMenu and DvsMenuItems database table
 *
 * @package Devise\Menus\Repositories
 */
class MenusRepository
{
    /**
     * Needed to get the current language the site
     * is running under for this given user. We use this
     * to provide Spanish menus to spanish users, and English
     * menus to English users.
     *
     * @var \Devise\Languages\Language
     */
    private $currentLanguage;

    /**
     * @var array
     */
    private $activeItemSiblings = array();

    /**
     * @var array
     */
    private $activeItemChildren = array();

    /**
     * @param \DvsMenu $Menu
     * @param \DvsMenuItem $MenuItem
     * @param LanguageDetector $LanguageDetector
     * @param Framework $Framework
     */
    public function __construct(\DvsMenu $Menu, \DvsMenuItem $MenuItem, LanguageDetector $LanguageDetector, UserHelper $UserHelper, Framework $Framework)
    {
        $this->Menu = $Menu;
        $this->MenuItem = $MenuItem;
        $this->LanguageDetector = $LanguageDetector;
        $this->currentLanguage = $LanguageDetector->current();
        $this->Input = $Framework->Input;
        $this->UserHelper = $UserHelper;
    }

    /**
     * Returns a Collection of DvsMenus
     *
     * @return Collection
     */
    public function menus()
    {
        $languageId = $this->Input->get('language_id', $this->LanguageDetector->primaryLanguageId());
        return $this->Menu->where('language_id',$languageId)->paginate(25);
    }

    /**
     * Finds DvsMenu by an integer id
     *
     * @param $id
     * @return \DvsMenu
     */
    public function findById($id)
    {
        $menu = $this->Menu->find($id);

        if ($this->currentLanguage->id != $this->LanguageDetector->primaryLanguageId())
        {
            $menu = $this->getTranslation($menu);
        }

        return $menu;
    }

    /**
     * Find menu using name value
     *
     * @param  string  $name  Human readable name of link
     * @return array
     */
    public function findMenuByName($name)
    {
        $menu = $this->Menu->with('items.children')->whereName($name)->firstOrFail();

        if ($this->currentLanguage->id != $this->LanguageDetector->primaryLanguageId())
        {
            $menu = $this->getTranslation($menu);
        }

        return $menu;
    }

    /**
     * Build a menu from it's name
     *
     * @param $name
     * @param int $depth
     * @param null $page
     * @return mixed
     */
    public function buildMenu($name, $depth = 2, $page = null)
    {
        $menu = $this->findMenuByName($name);
        return $this->traverseMenu($menu, $depth, $page);
    }

    /**
     * Get the children menu items of a menu name
     *
     * @param $name
     * @return array
     */
    public function getChildrenMenuItems($name)
    {
        $this->buildMenu($name); // will retrieve from cache if exists;
        return $this->activeItemChildren;
    }

    /**
     * Get menu siblings
     *
     * @param $name
     * @return array
     */
    public function getSiblingMenuItems($name)
    {
        $this->buildMenu($name); // will retrieve from cache if exists;
        return $this->activeItemSiblings;
    }

    /**
     * Translate the menu if needed
     *
     * @param $menu
     * @return mixed
     */
    private function getTranslation($menu)
    {
        $translatedMenu = $this->Menu
            ->where('translated_from_menu_id', $menu->id)
            ->where('language_id', $this->currentLanguage->id)
            ->first();

        return ($translatedMenu) ? $translatedMenu : $menu;
    }

    /**
     * Traverses the menu recursively finding sub menus
     *
     * @param $depth
     * @param $page
     * @param $menu
     * @return mixed
     */
    private function traverseMenu($menu, $depth, $page)
    {
        $cache = MenuCache::loadMenu($menu->name);

        if (!$cache)
        {
            $lazyLoadString = $this->getLazyLoadByDepth('items', $depth);
            $menu->load($lazyLoadString);
            $menu->allowedMenuItems = $this->getAllowedMenuItemsFromMenu($menu);

            if ($page !== null)
            {
                $this->activeItemSiblings = array();
                $this->activeItemChildren = array();
                $this->locateCurrentMenuItem($page->id, $menu->allowedMenuItems);
            }

            MenuCache::saveMenu($menu, $this->activeItemChildren, $this->activeItemSiblings);
        } else {
            $menu = $cache['menu'];
        }

        return $menu->allowedMenuItems;
    }

    /**
     * This gets us all the allowed menu items from a
     * particular menu.
     *
     * @param  DvsMenu $menu
     * @return Collection
     */
    private function getAllowedMenuItemsFromMenu($menu)
    {
        $menuItems = new Collection;

        foreach ($menu->items as $menuItem)
        {
            $items = $this->getAllowedMenuItems($menuItem);
            if ($items) $menuItems[] = $items;
        }

        return $menuItems;
    }

    /**
     * A simple way to view the menu structure
     * not in use by anything right now but here for
     * troubleshooting menus if we need to
     *
     * @param  DvsMenu|DvsMenuItem  $menu
     * @param  boolean $isRootMenu
     * @return array
     */
    public function menuStructure($menu, $isRootMenu = true)
    {
        $structure = [];

        $items = $isRootMenu ? $menu->items : $menu->children;

        foreach ($items as $item)
        {
            $children = $this->menuStructure($item, false);
            $structure[$item->name] = $children ?: $item->url;
        }

        return $structure;
    }

    /**
     * This will let us know if the menu item is allowed and
     * it also traverses all it's children (and future generations)
     * filtering out menu items that are not allowed
     *
     * @param  DvsMenuItem $menuItem
     * @return DvsMenuItem | false
     */
    private function getAllowedMenuItems($menuItem)
    {
        $shown = $this->checkMenuItemPermission($menuItem->permission);

        // filter out children of this menu item for permissions too
        if ($shown)
        {
            foreach ($menuItem->children as $key => $child)
            {
                $childShown = $this->getAllowedMenuItems($child);
                if (! $childShown) $menuItem->children->forget($key);
            }
        }

        return $shown ? $menuItem : false;
    }

    /**
     * Tells us whether or not the menu item is supposed
     * to be shown to this user
     *
     * @param  DvsMenuItem $menuItem
     * @return boolean
     */
    private function checkMenuItemPermission($permission)
    {
        $passesCondition = false;

        try
        {
            $passesCondition = empty($permission) || $this->UserHelper->checkConditions($permission);
        }
        catch (DeviseException $e) {
            // do nothing, condition was likely not found
            // this might be a place to notify the administrator
            // that we have busted permissions...
        }

        return $passesCondition;
    }

    /**
     * Loads children for this menu
     *
     * @param $startingRelation
     * @param $depth
     * @return string
     */
    private function getLazyLoadByDepth($startingRelation, $depth)
    {
        $relations = $startingRelation;

        for ($i=0; $i < $depth; $i++)
        {
            $relations .= '.children';
        }

        return $relations;
    }

    /**
     * Not sure what this does...
     * @todo determine what this thing does
     *
     * @param $pageId
     * @param $menuItems
     * @return bool
     */
    private function locateCurrentMenuItem($pageId, $menuItems)
    {
        foreach ($menuItems as $key => $menuItem)
        {
            if ($this->locateCurrentMenuItem($pageId, $menuItem->children))
            {
                // the active item was found in the children
                $menuItem->activeAncestor = true;
                return true;
            }

            if ($menuItem->page_id == $pageId)
            {
                // this item is the active item
                $menuItem->activeItem = true;

                $this->activeItemChildren = $menuItem->children;
                $this->activeItemSiblings = $menuItems;

                return true;
            }
        }

        return false;
    }
}