<?php namespace Devise\Sidebar;

use Devise\Pages\Fields\FieldManager;
use Devise\Pages\Collections\CollectionsRepository;

/**
 * The translator's job is to translate input into something we can use for our views and other places. This translator will also
 * validate our input to ensure that things are still sane - so for example if you leave certain fields out then we cannot
 * translate the babble. Here is an example of the data coming in from inputData.
 *
 * 	array(4) {
 * 		["coordinates"]=> array(2) {
 *			["top"]=> string(3) "647"
 *			["left"]=> string(5) "101.5"
 *		}
 *
 *		["categoryName"] => string(8) "Headings"
 *		["categoryCount"] => string(1) "3"
 *
 *		["groups"]=> array(3) {
 *			["Heading 1"]=> array(3) {
 *				[0]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *				[1]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *				[2]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *			}
 *	 	["Heading 2"]=> array(3) {
 *			[0]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 * 				[1]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *				[2]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *			}
 *			["Heading 3"]=> array(3) {
 *				[0]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *				[1]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *				[2]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *	 		}
 *		}
 *	}
 *
 * Here is an example of the data coming in from inputData when a collection is requested.
 *
 * 	array(4) {
 * 		["coordinates"]=> array(2) {
 *			["top"]=> string(3) "647"
 *			["left"]=> string(5) "101.5"
 *		}
 *
 *		["categoryName"] => string(8) "Headings"
 *		["categoryCount"] => string(1) "3"
 *
 *		["collection"]=> array(3) "towers"
 *		["towers"]=> array(3) {
 *			[0]=> array(3) { ["key"]=> string(5) "title" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *			[1]=> array(3) { ["key"]=> string(5) "color" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *			[2]=> array(3) { ["key"]=> string(5) "wysiwyg" ["type"]=> string(4) "text" ["humanName"]=> string(5) "Title" }
 *		}
 *	}
 *
 * It is our responsibility to translate this array data into a SidebarData format which is a little more structured and
 * behaves more like an object than array. Thus in our views we can access $data->coordinates->top instead of having to
 * check for existence like isset($data['coordinates']['top']) ? $data['coordinates']['top']
 */
class SidebarDataTranslator
{
	/**
	 * We use FieldManager to fetch/create fields in our
	 * resulting SidebarData object
	 *
	 * @var Devise\Fields\FieldManager
	 */
	protected $FieldManager;

	/**
	 * Create a new SidebarData Translator
	 *
	 * @param FieldManager       $FieldManager
	 * @param DvsCollectionSet	 $CollectionSet
	 */
	public function __construct(FieldManager $FieldManager, \DvsCollectionSet $CollectionSet, CollectionsRepository $CollectionsRepository)
	{
		$this->FieldManager = $FieldManager;
		$this->CollectionSet = $CollectionSet;
		$this->CollectionsRepository = $CollectionsRepository;
	}

	/**
	 * Structures the data for the editor from array input
	 *
	 * @param  array $inputData
	 * @return Models\SidebarData
	 */
	public function translateFromInputArray($inputData)
	{
		if (!isset($inputData['collection']) || $inputData['collection'] == '' || $inputData['collection'] == null)
		{
			return $this->translateNonCollectionData($inputData);
		}

		return $this->translateCollectionData($inputData);
	}

	/**
	 * This input array contains no colletions so we treat it differently
	 *
	 * @param  array $inputData
	 * @return SidebarData
	 */
	private function translateNonCollectionData($inputData)
	{
		$sidebarData = new SidebarData;

		$sidebarData->isCollection = false;
        $sidebarData->page_id = $inputData['page_id'];
        $sidebarData->page_version_id = $inputData['page_version_id'];
		$sidebarData->coordinates->top = $inputData['coordinates']['top'];
		$sidebarData->coordinates->left = $inputData['coordinates']['left'];
		$sidebarData->categoryCount = (isset($inputData['categoryCount'])) ? $inputData['categoryCount'] : null;

		$sidebarData->groups = $this->getGroups($inputData);
		$sidebarData->elements = $this->getElements($inputData);

		$sidebarData->sidebarTitle = $this->sidebarTitle($inputData);

		return $sidebarData;
	}

	/**
	 * Determines the sidebar title for this input data given
	 *
	 * @param  array $inputData
	 * @return string
	 */
	private function sidebarTitle($inputData)
	{
		if (isset($inputData['categoryName']))
		{
			return $inputData['categoryName'];
		}

		if (isset($inputData['groups']) && count($inputData['groups']))
		{
			$keys = array_keys($inputData['groups']);
			return reset($keys);
		}

		if (isset($inputData['elements']) && count($inputData['elements']))
		{
			return $inputData['elements'][0]['humanName'];
		}

		return '';
	}

    /**
     * Tranlates the input data array that has collection data in it
     * into a SidebarData object
     *
     * @param  array $inputData
     * @return SidebarData
     */
	public function translateCollectionData($inputData)
	{
        $sidebarData = new SidebarData;

        $sidebarData->isCollection = true;
        $sidebarData->page_id = $inputData['page_id'];
        $sidebarData->page_version_id = $inputData['page_version_id'];
        $sidebarData->coordinates->top = $inputData['coordinates']['top'];
        $sidebarData->coordinates->left = $inputData['coordinates']['left'];
        $sidebarData->categoryCount = (isset($inputData['categoryCount'])) ? $inputData['categoryCount'] : null;

        $collection = $this->CollectionSet->whereName($inputData['collection'])->first();

        // create this collection because it doesn't exist in DB yet
        if ($collection == null)
        {
            $collection = $this->CollectionSet->create(array('name' => $inputData['collection']));
        }

        $sidebarData->collection = $collection;

        $sidebarData->groups = $this->getGroupsInCollection($collection, $inputData);

        $sidebarData->sidebarTitle = $this->sidebarTitle($inputData);

        return $sidebarData;
	}

	/**
	 * Get the groups array for this input data
	 *
	 * @param  array $inputData
	 * @return array
	 */
	protected function getGroups($inputData)
	{
		$groups = array();

		if (!isset($inputData['groups'])) return $groups;

		foreach ($inputData['groups'] as $name => $elements)
		{
			$groups[$name] = array();

			foreach ($elements as $element)
			{
				$groups[$name][] = $this->fetchField($element, $inputData);
			}
		}

		return $groups;
	}

	/**
	 * Gets the groups array for this input data and collection
	 * it is different than just getting groups of elements because
	 * we are now dealing with a collection
	 *
	 * @param  Collection 	$collection
	 * @param  array 		$inputData
	 * @return array
	 */
	protected function getGroupsInCollection($collection, $inputData)
	{
        $groups = array();

        $instances = $this->CollectionsRepository->findCollectionInstancesForCollectionSetIdAndPageVersionId($collection->id, $inputData['page_version_id']);

        if (isset($inputData['groups']))
        {
            // fields are added to instance here
            foreach ($instances as $instance)
            {
                $this->createNewFieldsForCollectionInstance($instance, $inputData);
            }

            // re-fetch instances now that we've created any new fields
            $instances = $this->CollectionsRepository->findCollectionInstancesForCollectionSetIdAndPageVersionId($collection->id, $inputData['page_version_id']);
        }

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
	 * Get the elements array for this input data
	 *
	 * @param  array $inputData
	 * @return array
	 */
	protected function getElements($inputData)
	{
		$elements = array();

		if (!isset($inputData['elements'])) return $elements;

		foreach ($inputData['elements'] as $name => $element)
		{
			$elements[$name] = $this->fetchField($element, $inputData);
		}

		return $elements;
	}

    /**
     * We can add new fields to a collection at a later time
     * this keeps us fresh I guess
     *
     * @param  DvsCollectionInstance $instance
     * @return void
     */
    protected function createNewFieldsForCollectionInstance($instance, $inputData)
    {
        $groupOfFields = reset($inputData['groups']);

        foreach ($groupOfFields as $fieldData)
        {
            $this->fetchFieldForInstance($fieldData, $inputData, $instance);
        }
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
        $input['index'] = $element['index'];
        $input['page_id'] = $inputData['page_id'];
        $input['page_version_id'] = $inputData['page_version_id'];
        $input['type'] = $element['type'];
        $input['human_name'] = $element['humanName'];
        $input['key'] = $element['key'];
        $input['alternateTarget'] = array_get($element, 'alternateTarget', '');
        $input['value'] = '{}';
        $input['settings'] = '{}';

        return $this->FieldManager->findOrCreateField($input);
	}

    /**
     * Get the page field for this given element and inputData
     *
     * @param  array $inputData
     * @param  array $fieldData
     * @param  array $instance
     * @return PageField
     */
    protected function fetchFieldForInstance($fieldData, $inputData, $instance)
    {
        $input = array();
        $input['index'] = $fieldData['index'];
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
	 * Run validation steps here for this inputData...
	 *
	 * @todo  need to implement this?
	 * @param  array $inputData
	 * @return void
	 */
	protected function validateInputData($inputData)
	{
		// assert uniqueness of element keys?
		// assert $inputData['page_id'] exists
		// assert $inputData['coordinates']['top'] exists
		// assert $inputData['coordinates']['left'] exists
		// assert $inputData['categoryName'] exists
		// assert $inputData['categoryCount'] exists
		// assert either $inputData['elements'] or $inputData['groups'] exists
	}
}