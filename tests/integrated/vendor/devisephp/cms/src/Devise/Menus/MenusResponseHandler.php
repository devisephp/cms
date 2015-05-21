<?php namespace Devise\Menus;

use Illuminate\Routing\Redirector;
use Devise\Menus\MenusManager as Manager;

/**
 * Class MenusResponseHandler is used to store and update menus
 * and menu items in the database. There is likely a dvs_pages
 * database row pointing to these two methods.
 *
 * @package Devise\Menus\Response
 */
class MenusResponseHandler
{
    /**
     * @var Redirector
     */
    private $Redirect;

    /**
     * @var Manager
     */
    private $Manager;

    /**
     * Construct new response handler
     * @param Redirector $Redirect
     * @param Manager $Manager
     * @internal param Response $Response
     */
    public function __construct(Redirector $Redirect, Manager $Manager)
    {
        $this->Manager = $Manager;
        $this->Redirect = $Redirect;
    }

    /**
     * Create a new menu then redirect to edit page
     *
     * @param  array $input
     * @return Redirect
     */
    public function requestStore($input)
    {
        if ($menu = $this->Manager->createMenu($input))
        {
            return $this->Redirect->route('dvs-menus-edit', $menu->id);
        }

        return $this->Redirect->route('dvs-menus')
            ->withInput()
            ->withErrors($this->Manager->errors)
            ->with('message', $this->Manager->message);
    }

    /**
     * Update a Menu
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirect
     */
    public function requestUpdate($id, $input)
    {
        if ($this->Manager->updateMenu($id, $input))
        {
            return $this->Redirect->route('dvs-menus');
        }

        return $this->Redirect->route('dvs-menus-edit', $id)
            ->withInput()
            ->withErrors($this->Manager->errors)
            ->with('message', $this->Manager->message);
    }
}