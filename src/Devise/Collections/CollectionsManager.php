<?php namespace Devise\Collections;

use Devise\Editor\Models\EditorData;
use Devise\Fields\FieldManager;
use CollectionSet;
use CollectionInstance;
use Field;
use FieldVersion;
use DB;

class CollectionsManager
{
    protected $FieldManager;
    private $CollectionSet;
	private $CollectionInstance;

	public function __construct(FieldManager $FieldManager, CollectionSet $CollectionSet, CollectionInstance $CollectionInstance)
	{
        $this->FieldManager = $FieldManager;
		$this->CollectionSet = $CollectionSet;
		$this->CollectionInstance = $CollectionInstance;
	}

	public function translateFromInputArray($inputData)
	{
        $editorData = new EditorData;

        $editorData->isCollection = true;
        $editorData->page_id = $inputData['page_id'];
        $editorData->coordinates->top = $inputData['coordinates']['top'];
        $editorData->coordinates->left = $inputData['coordinates']['left'];
        $editorData->categoryName = (isset($inputData['categoryName'])) ? $inputData['categoryName'] : null;
        $editorData->categoryCount = (isset($inputData['categoryCount'])) ? $inputData['categoryCount'] : null;

        $collection = $this->findOrFetch($inputData);

        $editorData->collection = $collection;
        
        $editorData->groups = $this->buildGroups($collection, $inputData);

        return $editorData;
	}

    private function findOrFetch($inputData)
    {
        $collection = $this->CollectionSet->whereName($inputData['collection'])->first();
        if($collection == null){

            $collection = $this->createFirstInstance($inputData);
        }

        return $collection;
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
        if(count($collection->instances)){
            $inputData['collection_set_id'] = $collection->id;
            $instances = $collection->instances()->where('page_id', $inputData['page_id'])->get();
            foreach ($instances as $index => $instance) {
                $keyName = ($index + 1) . ') ' .$instance->name;
                $allRequestedFields = $inputData[ $inputData['collection'] ];
                $foundKeys = array();

                $fields = Field::with(array('latestPublishedVersion' => function($query) use ($instance){
                    $query->where('collection_instance_id','=',$instance->id);
                }))
                ->where('collection_set_id', '=', $collection->id)
                ->where('page_id','=',$inputData['page_id'])
                ->get();


                foreach ($fields as $field) {
                    $field->collection_instance_id = $instance->id;
                    
                    $foundKeys[] = $field->key;

                    $fieldName = $field->key;
                    $groups[ $keyName ][] = $field;
                }

                $newKeys = array();
                foreach ($allRequestedFields as $requestedField) {
                    if(!in_array($requestedField['key'], $foundKeys))
                    {
                        $newKeys[] = $requestedField['key'];
                        $field = $this->fetchField($inputData, $requestedField);
                    }
                }

                if(count($newKeys)){
                    $fields = Field::with(array('latestPublishedVersion' => function($query) use ($instance){
                        $query->where('collection_instance_id','=',$instance->id);
                    }))
                    ->where('collection_set_id', '=', $collection->id)
                    ->where('page_id','=',$inputData['page_id'])
                    ->whereIn('key',$newKeys)
                    ->get();


                    foreach ($fields as $field) {
                        $field->collection_instance_id = $instance->id;
                        $fieldName = $field->key;
                        $groups[ $keyName ][] = $field;
                    }
                }

                usort($groups[ $keyName ], array($this, 'sortById'));
            }
        }

        return $groups;
    }

    protected function sortById($a, $b)
    {
        return $a->id - $b->id;
    }

    /**
     * Get the page field for this given element and inputData
     *
     * @param  array $element
     * @param  array $inputData
     * @return PageField
     */
    protected function fetchField($element, $inputData)
    {
        $input = array();
        $input['index'] = '1';
        $input['page_id'] = $element['page_id'];
        $input['type'] = $inputData['type'];
        $input['human_name'] = $inputData['humanName'];
        $input['key'] = $inputData['key'];
        $input['alternateTarget'] = $inputData['alternateTarget'];
        $input['value'] = '{}';
        $input['settings'] = '{}';
        if(isset($element['collection_set_id'])){
            $input['collection_set_id'] = $element['collection_set_id'];
        }

        return $this->FieldManager->findOrCreateField($input);
    }

    protected function createFirstInstance($inputData)
    {
        $collection = $this->CollectionSet->create(array('name'=>$inputData['collection']));

        return $collection;
    }

	public function createNewInstance($inputData)
	{
		$instance = $this->CollectionInstance->create($inputData);

		if ($instance) {
			return $instance;
		} else {
			return false;
		}
	}

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