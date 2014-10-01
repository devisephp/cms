<?php namespace Devise\User;

use Group;
use Devise\Common\Manager;

class GroupManager extends Manager
{
	protected $Group;

    /**
     * Validation messages
     */
    public $messages = array(
        'name.required' => 'Group name required.',
        'name.min' => 'Group name must contain more than :min characters.'
    );

	/**
	 * Construct a new Group manager
	 *
	 * @param Group $Group
	 * @param Hash $Hash
	 */
	public function __construct(Group $Group)
	{
		$this->Group = $Group;
	}

    /**
     * Create validation rules
     *
     * @return array
     */
	public function createRules()
	{
 		return array(
        	'name' => 'required|min:2'
    	);
	}

	/**
	 * Create a new Group
	 *
	 * @param  array $input
	 * @return $this
	 */
	public function createGroup($input)
	{
		if ($this->fails($input, $this->createRules(), "Could not create a new group")) return $this;

		$group = $this->Group;
		$group->name = $input['name'];
		$group->save();

		return $this;
	}

    /**
     * Update validation rules
     *
     * @param  integer $id
     * @param  array   $input
     * @return array
     */
    public function updateRules($id, $input)
    {
        return array(
        	'name' => 'required|min:2'
        );
    }

	/**
	 * Update a new Group
	 *
	 * @param  integer $id
	 * @param  array $input
	 * @return $this
	 */
	public function updateGroup($id, $input)
	{
		if ($this->fails($input, $this->updateRules($id, $input), "Could not update group")) return $this;

		$group = $this->Group->findOrFail($id);
		$group->name = $input['name'];
		$group->save();

		return $this;
	}

	/**
	 * Delete a Group
	 *
	 * @param  integer $id
	 * @return $this
	 */
	public function destroyGroup($id)
	{
		$group = $this->Group->findOrFail($id);

		$group->delete();

		return $this;
	}

}