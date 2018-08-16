<?php namespace Devise\Users\Groups;

use Devise\Support\Framework;

/**
 * Class GroupManager manages the creating,
 * updating, and removing of groups.
 */
class GroupManager
{
    /**
     * @var DvsGroup
     */
	protected $Group;

    /**
     * Framework components being used from Laravel's framework
     *
     * @var Framework
     */
    protected $Framework;

    /**
     * Errors are kept in an array and can be
     * used later if validation fails and we want to
     * know why
     *
     * @var array
     */
    public $errors = [];

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
     * @param DvsGroup $Group
     */
	public function __construct(\DvsGroup $Group, Framework $Framework)
	{
		$this->Group = $Group;
        $this->Validator = $Framework->Validator;
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
	 * @return DvsGroup $Group
	 */
	public function createGroup($input)
	{
        $validator = $this->Validator->make($input, $this->createRules(), array("Could not create new group"));

        if ($validator->passes())
        {
    		$group = $this->Group;
    		$group->name = $input['name'];
    		$group->save();

    		return $group;
        }

        $this->errors = $validator->errors()->all();
        $this->message = "There were validation errors.";
        return false;
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
	 * @return DvsGroup $Group
	 */
	public function updateGroup($id, $input)
	{
        $validator = $this->Validator->make($input, $this->updateRules($id, $input), array("Could not update group"));

		if ($validator->passes())
        {
    		$group = $this->Group->findOrFail($id);
    		$group->name = $input['name'];
    		$group->save();

    		return $group;
        }

        $this->errors = $validator->errors()->all();
        $this->message = "There were validation errors.";
        return false;
	}

	/**
	 * Delete a Group
	 *
	 * @param  integer $id
	 * @return DvsGroup $Group
	 */
	public function destroyGroup($id)
	{
		$group = $this->Group->findOrFail($id);
		$group->delete();
		return $group;
	}

}