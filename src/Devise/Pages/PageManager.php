<?php namespace Devise\Pages;

use Page;
use Illuminate\Support\Str;
use Illuminate\Validation\Factory as Validator;

/**
 * Class PageManager
 * @package Devise\Pages
 */
class PageManager {

	/**
	 * @var Page
	 */
	private $Page, $Validator, $PageVersionManager;

	/**
	 * @var
	 */
	public $errors, $message;

	/**
	 * @param Page $Page
	 * @param Validator $Validator
	 */
	function __construct(Page $Page, Validator $Validator, PageVersionManager $PageVersionManager)
    {
        $this->Page = $Page;
        $this->Validator = $Validator;
        $this->PageVersionManager = $PageVersionManager;
    }

	/**
	 * Validates and creates a page with the given input
	 * @param $input
	 *
	 * @return bool
	 */
	public function createNewPage($input)
	{
		$page = $this->createPageFromInput($input);

		$page->version = $this->PageVersionManager->createDefaultPageVersion($page);

		return $page;
    }

	/**
	 * Validates and updates a page with the given input
	 * @param $id
	 * @param $input
	 *
	 * @return bool
	 */
	public function updatePage($id, $input)
	{
        $input = array_except($input, array('_token', '_data_token', '_method', 'show_advanced'));
        $page = $this->Page->findOrFail($id);

        $this->validator = $this->Validator->make($input, $this->Page->updateRules, $this->Page->messages);
        $this->validator->sometimes('view', 'required|min:3', function($input)
        {
            return $input->http_verb == 'get';
        });

        if ($this->validator->passes()){
            return $page->update($input);
        } else {
            $this->errors = $this->validator->errors()->all();
            $this->message = "There were validation errors.";
            return false;
        }
    }

	/**
	 * Destroys a page
	 * @param $id
	 *
	 * @return mixed
	 */
	public function destroyPage($id)
	{
		$page = $this->Page->findOrFail($id);
		return $page->delete();
	}

	/**
	 * Takes the input provided and runs the create method after stripping necessary fields.
	 * @param $input
	 *
	 * @return bool
	 */
	public function copyPage($input)
	{
		dd($input);

		$fromPage = $this->Page->findOrFail($input['page_id']);
		$toPage = $this->createNewPageFromInput($input);

		if ($toPage)
		{
			$this->PageVersionManager->copyPageVersions($fromPage, $toPage);
		}

		return $toPage;
	}

	/**
	 * @param $suggestedRoute
	 * @param int $currentIteration
	 *
	 * @return string
	 */
	private function findAvailableRoute($suggestedRoute, $currentIteration = 0) {
        $modifiedRoute = ($currentIteration == 0) ? $suggestedRoute : $suggestedRoute . '-' . $currentIteration;

        $existingRouteSearch = $this->Page->where('route_name', '=', $modifiedRoute)->count();

        if ($existingRouteSearch < 1) {
            return $modifiedRoute;
        } else {
            $currentIteration++;
            return $this->findAvailableRoute($suggestedRoute, $currentIteration);
        }
    }


    /**
     * Create page from given input data
     *
     * @return Page
     */
    protected function createPageFromInput($input)
    {
        $input = array_except($input, array('_token', '_data_token', 'show_advanced'));

        if ($input['language_id'] == 45){
            $input['translated_from_page_id'] = 0;
        }

        // validate the input given before we create the page
        $this->validator = $this->Validator->make($input, $this->Page->createRules, $this->Page->messages);
        $this->validator->sometimes('view', 'required|min:3', function($input)
        {
            return $input->http_verb == 'get';
        });

        if ($this->validator->passes())
        {
            $suggestedRouteName = (!isset($input['route_name'])) ? Str::slug($input['title']) : $input['route_name'];
            $input['route_name'] = $this->findAvailableRoute($suggestedRouteName);

            return $this->Page->create($input);
        }

        $this->errors = $this->validator->errors()->all();
        $this->message = "There were validation errors.";

        return false;
    }

    /**
     * Copy the fields from this page version into
     * another page version
     * 
     * @param  [type] $pageVersion
     * @return [type]
     */
    public function copyFieldsFromPageVersion($pageVersion)
    {

    }
} 