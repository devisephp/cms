<?php namespace Devise\Users\Groups;

use Illuminate\Routing\Redirector;

class GroupsResponseHandler
{
    private $Redirect, $Manager;

    /**
     * Construct new response handler
     *
     * @param Redirector $Redirect
     * @param Manager    $Manager
     */
    public function __construct(Redirector $Redirect, GroupManager $Manager)
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
        if ($this->Manager->createGroup($input))
        {
            return $this->Redirect->route('dvs-groups')
                ->with('message', 'Group successfully created');
        }

        return $this->Redirect->route('dvs-groups-create')
                ->withInput()
                ->withErrors($this->Manager->errors)
                ->with('message', $this->Manager->message);
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
        if ($this->Manager->updateGroup($id, $input))
        {
            return $this->Redirect->route('dvs-groups')
                ->with('message', 'Group successfully updated');
        }

        return $this->Redirect->route('dvs-groups-edit', $id)
                ->withInput()
                ->withErrors($this->Manager->errors)
                ->with('message', $this->Manager->message);
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