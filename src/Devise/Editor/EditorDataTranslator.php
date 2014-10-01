<?php namespace Devise\Editor;

use Devise\Editor\Models\EditorData;
use Devise\Fields\FieldManager;
use Devise\Collections\CollectionsManager;
/**
 * The translator's job is to translate input into something we can use for our
 * views and other places. This translator will also validate our input to
 * ensure that things are still sane - so for example if you leave certain fields
 * out then we cannot translate the babble.
 *
 * Here is an example of the data coming in from inputData.
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
 */

class EditorDataTranslator
{
	protected $FieldManager;
	protected $CollectionsManager;

	public function __construct(FieldManager $FieldManager, CollectionsManager $CollectionsManager)
	{
		$this->FieldManager = $FieldManager;
		$this->CollectionsManager = $CollectionsManager;
	}

	/**
	 * Structures the data for the editor from array input
	 *
	 * @param  array $inputData
	 * @return Models\EditorData
	 */
	public function translateFromInputArray($inputData)
	{
		// need to look stuff up to render out this page
		// @todo need to clean this up
		// $inputData['collection'] = 'twocolcatblocks';
	 // 		$inputData["twocolcatblocks"] = [
		// 	["key"=>"towerFace","type"=>"text","humanName"=>"Card Background face","group"=>"Tower Category 1","category"=>"Tower Categories","alternateTarget"=>null],
		// 	["key"=>"towerDude","type"=>"wysiwyg","humanName"=>"Room Categodddry","group"=>"Tower Category 1","category"=>"Tower Categories","alternateTarget"=>null]
		// ];

		if(!isset($inputData['collection']) || $inputData['collection'] == '' || $inputData['collection'] == null){
			return $this->translateNonCollectionData($inputData);
		} else {
			return $this->CollectionsManager->translateFromInputArray($inputData);
		}
	}

	private function translateNonCollectionData($inputData)
	{
		$editorData = new EditorData;

        $editorData->page_id = $inputData['page_id'];
		$editorData->coordinates->top = $inputData['coordinates']['top'];
		$editorData->coordinates->left = $inputData['coordinates']['left'];
		$editorData->isCollection = false;
		$editorData->categoryName = (isset($inputData['categoryName'])) ? $inputData['categoryName'] : null;
		$editorData->categoryCount = (isset($inputData['categoryCount'])) ? $inputData['categoryCount'] : null;

		$editorData->groups = $this->getGroups($inputData);
		$editorData->elements = $this->getElements($inputData);

		return $editorData;
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
        $input['type'] = $element['type'];
        $input['human_name'] = $element['humanName'];
        $input['key'] = $element['key'];
        $input['alternateTarget'] = $element['alternateTarget'];
        $input['value'] = '{}';
        $input['settings'] = '{}';

        return $this->FieldManager->findOrCreateField($input);
	}

	/**
	 * Run validation steps here for this inputData...
	 *
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