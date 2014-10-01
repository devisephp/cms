<?php namespace Devise\Menus\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Menu;
use MenuItem;
use Input;
use Config;
use Devise\Languages\LanguageDetector;
use Devise\Menus\MenuCache;

class MenusRepository
{
    private $currentLanguage;
    private $menuCache = array();
    private $activeItemSiblings = array();
    private $activeItemChildren = array();

    public function __construct(Menu $Menu, MenuItem $MenuItem, LanguageDetector $LanguageDetector)
    {
        $this->Menu = $Menu;
        $this->MenuItem = $MenuItem;
        $this->currentLanguage = $LanguageDetector->current();
    }

    public function menus()
    {
        $languageId = (!Input::has('language_id')) ? Config::get('devise::languages.primary_language_id') : Input::get('language_id');
        return $this->Menu
                    ->where('language_id',$languageId)
                    ->paginate(25);
    }

    public function findById($id)
    {
        $menu = $this->Menu->find($id);
        
        if($this->currentLanguage->id != Config::get('devise::languages.primary_language_id')){
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
    public function findMenuByName($name) {
        $menu = $this->Menu->whereName($name)->first();
        if($this->currentLanguage->id != Config::get('devise::languages.primary_language_id')){
            $menu = $this->getTranslation($menu);
        }

        if(!$menu) {
            throw new ModelNotFoundException('Could not find menu by name "'.$name.'"');
        }

        return $menu;
    }

    public function buildMenu($name, $depth = 2, $page = null) {
        $this->menuCache[] = $name;
        $menu = $this->findMenuByName($name);

        return $this->traverseMenu($menu, $depth, $page);
    }

    public function getChildrenMenuItems($name)
    {
        $this->buildMenu($name); // will retrieve from cache if exists;
        return $this->activeItemChildren;
    }

    public function getSiblingMenuItems($name)
    {
        $this->buildMenu($name); // will retrieve from cache if exists;
        return $this->activeItemSiblings;
    }

    private function getTranslation($menu){
        $translatedMenu = $this->Menu
            ->where('translated_from_menu_id', $menu->id)
            ->where('language_id', $this->currentLanguage->id)
            ->first();
        return ($translatedMenu) ? $translatedMenu : $menu;
    }

    /**
     * @param $depth
     * @param $page
     * @param $menu
     * @return mixed
     */
    private function traverseMenu($menu, $depth, $page)
    {
        $cache = MenuCache::loadMenu($menu->name);

        if(!$cache){
            $lazyLoadString = $this->getLazyLoadByDepth('items', $depth);
            $menu->load($lazyLoadString);

            if ($page !== null) {
                $this->activeItemSiblings = array();
                $this->activeItemChildren = array();
                $this->locateCurrentMenuItem($page->id, $menu->items);
            }
            MenuCache::saveMenu($menu, $this->activeItemChildren, $this->activeItemSiblings);
        } else {
            $menu = $cache['menu'];
        }

        return $menu->items;
    }

    private function getLazyLoadByDepth($startingRelation, $depth)
    {
        $relations = $startingRelation;
        for ($i=0; $i < $depth; $i++) {
            $relations .= '.children';
        }
        return $relations;
    }

    private function locateCurrentMenuItem($pageId, $menuItems)
    {
        foreach ($menuItems as $key => $menuItem) {
            if($this->locateCurrentMenuItem($pageId, $menuItem->children)){
                // the active item was found in the children
                $menuItem->activeAncestor = true;
                return true;
            }

            if($menuItem->page_id == $pageId) {
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