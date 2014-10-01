<?php namespace Devise\User\Response;

use Illuminate\Routing\Redirector;
use Devise\User\GroupManager as Manager;

class GroupsResponseHandler
{
    private $Redirect, $Manager;

    /**
     * Construct new response handler
     *
     * @param Redirector $Redirect
     * @param Manager    $Manager
     */
    public function __construct(Redirector $Redirect, Manager $Manager)
    {
        $this->Manager = $Manager;
        $this->Redirect = $Redirect;
    }

    /**
     * Create a new user request
     *
     * @param  array $input
     * @return Redirect
     */
    public function requestCreateGroup($input)
    {
        if ($this->Manager->createGroup($input)->errors)
        {
            return $this->Redirect->route('dvs-groups-create')
                ->withInput()
                ->withErrors($this->Manager->errors)
                ->with('message', $this->Manager->message);
        }

        return $this->Redirect->route('dvs-groups');
    }

    /**
     * Update a group
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirect
     */
    public function requestUpdateGroup($id, $input)
    {
        if ($this->Manager->updateGroup($id, $input)->errors)
        {
            return $this->Redirect->route('dvs-groups-edit', $id)
                ->withInput()
                ->withErrors($this->Manager->errors)
                ->with('message', $this->Manager->message);
        }

        return $this->Redirect->route('dvs-groups');
    }

    /**
     * Delete a group
     *
     * @param  integer $id
     * @return Redirect
     */
	public function requestDestroyGroup($id)
    {
        $this->Manager->destroyGroup($id);

        return $this->Redirect->route('dvs-groups')
                ->with('message', 'Group successfully removed');
	}
}