<?php namespace Devise\Pages\Collections;

/**
 * Manage collections in the database by creating, updating
 * and removing them.
 */
class CollectionsManager
{
    /**
     * DvsCollectionInstance model
     *
     * @var DvsCollectionInstance
     */
    protected $CollectionInstance;

    /**
     * DvsField model
     *
     * @var DvsField
     */
    protected $Field;
    /**
     * Create a new collections manager object
     *
     * @param DvsCollectionInstance $CollectionInstance
     */
	public function __construct(\DvsCollectionInstance $CollectionInstance, \DvsField $Field)
	{
		$this->CollectionInstance = $CollectionInstance;
        $this->Field = $Field;
	}

    /**
     * Create a new collection instance
     *
     * @todo  this has Mass Assignment vulnerability (don't use create() method here)
     * @param  array $inputData
     * @return CollectionInstance
     */
	public function createNewInstance(array $input)
	{
		$instance = $this->CollectionInstance->newInstance();
        $instance->page_version_id = $input['page_version_id'];
        $instance->collection_set_id = array_get($input, 'collection_set_id', null);
        $instance->name = $input['name'];
        $instance->sort = $input['sort'];
        $instance->save();

        $fields = array_get($input, 'fields', []);

        foreach ($fields as $field)
        {
            $this->createNewInstanceField($instance, $field);
        }

        return $this->CollectionInstance->newInstance()->with('fields')->findOrFail($instance->id);
	}

    /**
     * [createNewInstanceField description]
     * @param  [type] $instance [description]
     * @param  [type] $field    [description]
     * @return [type]           [description]
     */
    public function createNewInstanceField($instance, $fieldInput)
    {
        $field = $this->Field->newInstance();

        $field->collection_instance_id = $instance->id;
        $field->page_version_id = $instance->page_version_id;
        $field->type = $fieldInput['type'];
        $field->key = $fieldInput['key'];
        $field->human_name = $fieldInput['human_name'];
        $field->json_value = array_get($fieldInput, 'json_value', '{}');
        $field->content_requested = array_get($fieldInput, 'content_requested', 1);
        $field->save();

        return $field;
    }

    /**
     * Updates the instance with input data
     *
     * @param  array $inputData
     * @return CollectionInstance
     */
	public function updateInstanceSort($id, $sort)
	{
		$instance = $this->CollectionInstance->findOrFail($id);
		$instance->sort = $sort;
		$instance->save();

		return $instance;
	}

    /**
     * Update the collection instance name
     *
     * @param  array $inputData
     * @return CollectionInstance
     */
	public function updateInstanceName($id, $name)
    {
		$instance = $this->CollectionInstance->findOrFail($id);
		$instance->name = $name;
		$instance->save();

		return $instance;
	}

    /**
     * Remove instance from database
     *
     * @param  integer $id
     * @return bool
     */
	public function removeInstance($id)
    {
		$instance = $this->CollectionInstance->find($id);

        // should we remove all the fields of this instance here?

		return ($instance) ? $instance->delete() : false;
	}
}