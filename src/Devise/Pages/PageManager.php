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
	private $Page;
	/**
	 * @var Validator
	 */
	private $Validator;

	/**
	 * @var
	 */
	public $errors;
	/**
	 * @var
	 */
	public $message;

	/**
	 * @param Page $Page
	 * @param Validator $Validator
	 */
	function __construct(Page $Page, Validator $Validator)
    {
        $this->Page = $Page;
        $this->Validator = $Validator;
    }

	/**
	 * Validates and creates a page with the given input
	 * @param $input
	 *
	 * @return bool
	 */
	public function createNewPage($input) {
        $input = array_except($input, array('_token', '_data_token', 'show_advanced'));

        $this->validator = $this->Validator->make($input, $this->Page->createRules, $this->Page->messages);
        $this->validator->sometimes('view', 'required|min:3', function($input)
        {
            return $input->http_verb == 'get';
        });

        if ($this->validator->passes()){
            $suggestedRouteName = (!isset($input['route_name'])) ? Str::slug($input['title']) : $input['route_name'];
            $input['route_name'] = $this->findAvailableRoute($suggestedRouteName);

            return $this->Page->create($input);
        } else {
            $this->errors = $this->validator->errors()->all();
            $this->message = "There were validation errors.";
            return false;
        }
    }

	/**
	 * Validates and updates a page with the given input
	 * @param $id
	 * @param $input
	 *
	 * @return bool
	 */
	public function updatePage($id, $input) {
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
	public function destroyPage($id) {
		$page = $this->Page->findOrFail($id);
		return $page->delete();
	}

	/**
	 * Takes the input provided and runs the create method after stripping necessary fields.
	 * @param $input
	 *
	 * @return bool
	 */
	public function copyPage($input) {
		$input = array_except($input, array('_token', '_data_token', '_method', 'show_advanced'));
        if($input['language_id'] == 45){
            $input['translated_from_page_id'] = 0;
        }
		return $this->createNewPage($input);
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


} 