<?php namespace Devise\Pages\Collections;

use Devise\Pages\Fields\FieldManager;

/**
 * Handle responses for collection instances
 */
class ResponseHandler
{
	/**
	 * Collections manager allows us to manage a collection instance
	 *
	 * @var CollectionsManager
	 */
    private $CollectionsManager;

    /**
     * Fields manager lets us update fields
     *
     * @var FieldManager
     */
    private $FieldManager;

    /**
     * Construct a new Response Handler used by dvs_pages
     *
     * @param CollectionsManager $CollectionsManager
     */
    public function __construct(CollectionsManager $CollectionsManager, FieldManager $FieldManager)
    {
        $this->CollectionsManager = $CollectionsManager;
        $this->FieldManager = $FieldManager;
    }

    /**
     * Stores the instance with given pageversion and collection set ids
     *
     * @param  integer $pageVersionId
     * @param  integer $collectionSetId
     * @param  array $input
     * @return instance
     */
    public function requestStoreInstance($pageVersionId, $collectionSetId, $input)
    {
		return $this->CollectionsManager->createNewInstance($input);
    }

    /**
     * Updates the sort order for a given instance
     *
     * @param  integer $pageVersionId
     * @param  integer $collectionSetId
     * @param  array $input
     * @return array
     */
	public function updateSortOrder($pageVersionId, $collectionSetId, $input)
	{
		foreach ($input['instances'] as $i => $id)
		{
			$this->CollectionsManager->updateInstanceSort($id, $i + 1);
		}

		return $input;
	}

	/**
	 * Renames the instance with a better, faster, more improved name.
	 *
	 * @param  integer $pageVersionId
	 * @param  integer $collectionInstanceId
	 * @param  array $input
	 * @return void
	 */
	public function renameInstance($pageVersionId, $collectionInstanceId, $input)
	{
		$this->CollectionsManager->updateInstanceName($collectionInstanceId, $input['name']);
	}

	/**
	 * Remove the collection instance from the database
	 *
	 * @param  integer $collectionInstanceId
	 * @return void
	 */
	public function requestDeleteInstance($collectionInstanceId)
	{
		$this->CollectionsManager->removeInstance($collectionInstanceId);
	}

	/**
	 * Update the collection instance field
	 *
	 * @param  [type] $fieldId [description]
	 * @param  [type] $input   [description]
	 * @return [type]          [description]
	 */
	public function updateCollectionInstanceField($fieldId, $input)
	{
		return $this->FieldManager->updateField($fieldId, $input);
	}
}