<?php namespace Devise\Users\Permissions;

use Devise\Support\Framework;

/**
 * Class PermissionsResponseHandler is used to retrieve permission data
 *
 * @package Devise\Permissions
 */
class PermissionsResponseHandler
{
    protected $PermissionsManager;

    public function __construct(PermissionsManager $PermissionsManager, Framework $Framework)
    {
        $this->PermissionsManager = $PermissionsManager;
        $this->Redirect = $Framework->Redirect;
    }

    /**
     * Executes store permission method in PermissionsManager
     * and properly handles the response.
     *
     * @param  array  $input
     * @return Redirect
     */
    public function executeStore($input)
    {
        $input = array_except($input, ['_method', '_token']);
        if($this->PermissionsManager->storePermission($input)) {
            return $this->Redirect->route('dvs-permissions')
                ->with('message', 'Permission registered succesfully');
        }

        return $this->Redirect->route('dvs-permissions-create')
            ->withInput()
            ->withErrors($this->PermissionsManager->errors)
            ->with('message', 'There were validation errors');
    }

    /**
     * Executes update permission method in PermissionsManager and
     * handles the response accordingly.
     *
     * @param  array  $input
     * @param  string  $condition  Permission condition name/key in config
     * @return Redirect
     */
    public function executeUpdate($input)
    {
        $input = array_except($input, ['_method', '_token']);

        if($this->PermissionsManager->updatePermission($input)) {
            return $this->Redirect->route('dvs-permissions')
                ->with('message', 'Permission updated succesfully');
        }

        return $this->Redirect->route('dvs-permissions-edit', array('condition' => $input['permission_name_edit']))
            ->withErrors($this->PermissionsManager->errors)
            ->with('message', 'There were validation errors');
    }

    /**
     * Executes destroy permission method in PermissionsManager
     * and properly handles the response.
     *
     * @param  string  $condition
     * @return Redirect
     */
    public function executeDestroy($condition)
    {
        if($this->PermissionsManager->destroyPermission($condition)) {
            return $this->Redirect->route('dvs-permissions')
                ->with('message', 'Permission deleted succesfully');
        }

        return $this->Redirect->route('dvs-permissions')
            ->withErrors($this->PermissionsManager->errors)
            ->with('message', 'There were validation errors');
    }

}