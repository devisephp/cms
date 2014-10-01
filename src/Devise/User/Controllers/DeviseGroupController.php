<?php

use Devise\User\Repositories\GroupsRepository;

class DeviseGroupController extends Controller {
    protected $Group;
    protected $GroupsRepository;
    protected $data;

	public function __construct(Group $Group, GroupsRepository $GroupsRepository)
	{
        $this->Group = $Group;
        $this->GroupsRepository = $GroupsRepository;

        $this->data['title'] = 'Group';
	}

    /**
     * Render groups index
     *
     * @return Void
     */
    public function index()
    {
        $groups = $this->Group->get();
        $this->data = array_merge($this->data, compact('groups'));
        $this->data['title'] = "Groups Index";

        return View::make('devise::groups.index', $this->data);
    }

    /**
     * Render group create
     *
     * @return Void
     */
    public function create()
    {
        $this->data['title'] = "Create Group";
        return View::make('devise::groups.create', $this->data);
    }

    /**
     * Process group create form
     *
     * @return Response
     */
    public function store()
    {
        if($this->GroupsRepository->store(Input::except('_token'))) {
            return Redirect::action('DeviseGroupController@index')->with('message', $this->GroupsRepository->message);
        } else {
            return Redirect::back()
                ->withInput()
                ->withErrors($this->GroupsRepository->errors)
                ->with('message', $this->GroupsRepository->message);
        }
    }

    /**
     * Render group edit
     *
     * @param  integer  $groupId
     * @return Void
     */
    public function edit($groupId)
    {
        $group = $this->GroupsRepository->findById($groupId);

        $this->data = array_merge($this->data, compact('group', 'groupId'));
        $this->data['title'] = "Edit Group";

        return View::make('devise::groups.edit', $this->data);
    }

    /**
     * Process group edit form
     *
     * @param  integer  $groupId
     * @return Response
     */
    public function update($groupId)
    {
        if($this->GroupsRepository->update($groupId, Input::except('_token'))) {
            return Redirect::action('DeviseGroupController@index')->with('message', $this->GroupsRepository->message);
        } else {
            return Redirect::back()
                ->withInput()
                ->withErrors($this->GroupsRepository->errors)
                ->with('message', $this->GroupsRepository->message);
        }
    }

    /**
     * Render group show
     *
     * @param  integer  $groupId
     * @return Void
     */
    public function show($groupId)
    {
        $group = $this->GroupsRepository->findById($groupId);
        $groupUsers = $group->users()->get();

        $this->data = array_merge($this->data, compact('group', 'groupUsers', 'groupId'));
        $this->data['title'] = "Group: ".$group->name;

        return View::make('devise::groups.show', $this->data);
    }

    /**
     * Render group destroy confirmation
     *
     * @param  integer  $groupId
     * @return Void
     */
    public function confirmDestroy($groupId)
    {
        $group = $this->GroupsRepository->findById($groupId);
        $this->data = array_merge($this->data, compact('group', 'groupId'));
        $this->data['title'] = 'Confirm User Destroy';

        return View::make('devise::groups.destroy', $this->data);
    }

    /**
     * Destroy group record
     *
     * @param  integer  $groupId
     * @return Void
     */
    public function postDestroy($groupId)
    {
        $this->GroupsRepository->destroy($groupId);
        return Redirect::action('DeviseGroupController@index')->with('message', $this->GroupsRepository->message);
    }

}