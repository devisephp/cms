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
     * Create a new collections manager object
     *
     * @param DvsCollectionInstance $CollectionInstance
     */
	public function __construct(\DvsCollectionInstance $CollectionInstance)
	{
		$this->CollectionInstance = $CollectionInstance;
	}

    /**
     * Create a new collection instance
     *
     * @todo  this has Mass Assignment vulnerability (don't use create() method here)
     * @param  array $inputData
     * @return CollectionInstance
     */
	public function createNewInstance(array $inputData)
	{
		$instance = $this->CollectionInstance->newInstance();

        $instance->page_version_id = $inputData['page_version_id'];
        $instance->collection_set_id = array_get($inputData, 'collection_set_id', null);
        $instance->name = $inputData['name'];
        $instance->sort = $inputData['sort'];

        $instance->save();

        return $instance;
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

		return ($instance) ? $instance->delete() : false;
	}
}