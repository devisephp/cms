<?php namespace Devise\Collections;

use Devise\Collections\Repositories\CollectionsRepository;
use Devise\Editor\Models\EditorData;
use Devise\Fields\FieldManager;
use CollectionSet;
use CollectionInstance;
use Field;
use DB;

class CollectionsManager
{
    protected $FieldManager, $CollectionSet, $CollectionInstance, $CollectionsRepository;

    /**
     * [__construct description]
     * @param FieldManager          $FieldManager          [description]
     * @param CollectionSet         $CollectionSet         [description]
     * @param CollectionInstance    $CollectionInstance    [description]
     * @param CollectionsRepository $CollectionsRepository [description]
     */
	public function __construct(FieldManager $FieldManager, CollectionSet $CollectionSet, CollectionInstance $CollectionInstance, CollectionsRepository $CollectionsRepository)
	{
        $this->FieldManager = $FieldManager;
		$this->CollectionSet = $CollectionSet;
		$this->CollectionInstance = $CollectionInstance;
        $this->CollectionsRepository = $CollectionsRepository;
	}

    /**
     * [translateFromInputArray description]
     * @param  [type] $inputData [description]
     * @return [type]            [description]
     */
	public function translateFromInputArray($inputData)
	{
        $editorData = new EditorData;

        $editorData->isCollection = true;
        $editorData->page_id = $inputData['page_id'];
        $editorData->page_version_id = $inputData['page_version_id'];
        $editorData->coordinates->top = $inputData['coordinates']['top'];
        $editorData->coordinates->left = $inputData['coordinates']['left'];
        $editorData->categoryName = (isset($inputData['categoryName'])) ? $inputData['categoryName'] : null;
        $editorData->categoryCount = (isset($inputData['categoryCount'])) ? $inputData['categoryCount'] : null;

        $collection = $this->CollectionSet->whereName($inputData['collection'])->first();

        if($collection == null)
        {
            $collection = $this->createFirstInstance($inputData);
        }

        $editorData->collection = $collection;

        $editorData->groups = $this->buildGroups($collection, $inputData);

        return $editorData;
	}

    /**
     * Get the groups array for this input data
     * uses a combination of the collections instances and the requested fields from the post data
     * if a requested field is not found, it's added to the ui
     *
     * @param  array $inputData
     * @return array
     */
    protected function buildGroups($collection, $inputData)
    {
        $groups = array();

        $instances = $this->CollectionsRepository->findCollectionInstancesForCollectionSetIdAndPageVersionId($collection->id, $inputData['page_version_id']);

        // fields are added to instance here
        foreach ($instances as $instance)
        {
            $this->createAnyNewFieldsForCollectionInstance($instance, $inputData);
        }

        // re-fetch instances now that we've created any new fields
        $instances = $this->CollectionsRepository->findCollectionInstancesForCollectionSetIdAndPageVersionId($collection->id, $inputData['page_version_id']);

        //
        // loop through all instances for this collection set + page version
        // and make a big giant array of groups, each group has a set
        // of fields inside of it
        //
        foreach ($instances as $index => $instance)
        {
            $keyName = ($index + 1) . ') ' .$instance->name;

            $groups[$keyName] = array();

            foreach ($instance->fields as $field)
            {
                $groups[$keyName][] = $field;
            }
        }

        return $groups;
    }

    /**
     * We can add new fields to a collection at a later time
     * this keeps us fresh I guess
     *
     * @param  [type] $instance [description]
     * @return [type]           [description]
     */
    protected function createAnyNewFieldsForCollectionInstance($instance, $inputData)
    {
        $groupOfFields = reset($inputData['groups']);

        foreach ($groupOfFields as $fieldData)
        {
            $this->fetchField($inputData, $fieldData, $instance);
        }
    }

    /**
     * Get the page field for this given element and inputData
     *
     * @param  array $inputData
     * @param  array $fieldData
     * @return PageField
     */
    protected function fetchField($inputData, $fieldData, $instance)
    {
        $input = array();
        $input['index'] = '1';
        $input['page_id'] = $inputData['page_id'];
        $input['page_version_id'] = $inputData['page_version_id'];
        $input['type'] = $fieldData['type'];
        $input['human_name'] = $fieldData['humanName'];
        $input['key'] = $fieldData['key'];
        $input['alternateTarget'] = $fieldData['alternateTarget'];
        $input['value'] = '{}';
        $input['settings'] = '{}';
        $input['collection_instance_id'] = $instance->id;

        return $this->FieldManager->findOrCreateField($input);
    }

    /**
     * [createFirstInstance description]
     * @param  [type] $inputData [description]
     * @return [type]            [description]
     */
    protected function createFirstInstance($inputData)
    {
        $collection = $this->CollectionSet->create(array('name'=>$inputData['collection']));

        return $collection;
    }

    /**
     * [createNewInstance description]
     * @param  [type] $inputData [description]
     * @return [type]            [description]
     */
	public function createNewInstance($inputData)
	{
		$instance = $this->CollectionInstance->create($inputData);

		if ($instance) {
			return $instance;
		} else {
			return false;
		}
	}

    /**
     * [updateInstance description]
     * @param  [type] $inputData [description]
     * @return [type]            [description]
     */
	public function updateInstance($inputData)
	{
		$instance = $this->CollectionInstance->find($inputData['id']);

		if ($instance) {
			$instance->sort = $inputData['sort'];
			$instance->save();

			return $instance;
		} else {
			return false;
		}
	}

    /**
     * [updateInstanceName description]
     * @param  [type] $inputData [description]
     * @return [type]            [description]
     */
	public function updateInstanceName($inputData)
    {
		$instance = $this->CollectionInstance->find($inputData['id']);

		if ($instance) {
			$instance->name = $inputData['name'];
			$instance->save();

			return $instance;
		} else {
			return false;
		}
	}

    /**
     * [removeInstance description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
	public function removeInstance($id)
    {
		$instance = $this->CollectionInstance->find($id);

		if ($instance) {
			return $instance->delete();
		} else {
			return false;
		}
	}
}