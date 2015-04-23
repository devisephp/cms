<?php namespace Devise\Pages;

use Illuminate\Support\Str;
use Devise\Support\Framework;
use Devise\Pages\Fields\FieldsRepository;
use Devise\Pages\Fields\FieldManager;

/**
 * Class PageManager manages the creating of new pages,
 * updating pages and removing and copying pages.
 */
class PageManager
{
	/**
     * DvsPage model to fetch database dvs_pages
     *
	 * @var Page
	 */
	protected $Page;

    /**
     * Validator is used to validate page rules
     *
     * @var Illuminate\Validation\Factory
     */
    protected $Validator;

    /**
     * PageVersionManager lets us manage versions of a page
     *
     * @var PageVersionManager
     */
    protected $PageVersionManager;

    /**
     * FieldsRepository returns information about fields
     *
     * @var FieldsRepository
     */
    protected $FieldsRepository;

    /**
     * FieldManager lets us manage the fields
     *
     * @var FieldManager
     */
    protected $FieldManager;

    /**
     * List of database fields/columns for a dvs_page
     * we don't want to be vulnerable to mass assignment
     * attack so we need to specify these...
     *
     * @var array
     */
    static protected $PageFields = [
        'language_id',
        'translated_from_page_id',
        'view',
        'title',
        'http_verb',
        'route_name',
        'is_admin',
        'dvs_admin',
        'slug',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'head',
        'footer',
        'before',
        'after',
        'response_type',
        'response_path',
        'response_params',
    ];

	/**
     * Errors are kept in an array and can be
     * used later if validation fails and we want to
     * know why
     *
	 * @var array
	 */
	public $errors;

    /**
     * This is a message that we can store why the
     * validation failed
     *
     * @var string
     */
    public $message;

    /**
     * Construct a new page manager
     *
     * @param \DvsPage $Page
     * @param Validator $Validator
     * @param PageVersionManager $PageVersionManager
     * @param FieldsRepository $FieldsRepository
     * @param FieldManager $FieldManager
     * @param Framework $Framework
     */
	public function __construct(
        \DvsPage $Page,
        PageVersionManager $PageVersionManager,
        PageVersionsRepository $PageVersionsRepository,
        FieldsRepository $FieldsRepository,
        FieldManager $FieldManager,
        Framework $Framework
    ){
        $this->Page = $Page;
        $this->Validator = $Framework->Validator;
        $this->PageVersionManager = $PageVersionManager;
        $this->PageVersionsRepository = $PageVersionsRepository;
        $this->FieldsRepository = $FieldsRepository;
        $this->FieldManager = $FieldManager;
        $this->Config = $Framework->config;
        $this->now = new \DateTime;
    }

	/**
	 * Validates and creates a page with the given input
     *
	 * @param  array a$input
	 * @return bool
	 */
	public function createNewPage($input)
	{
        $input['response_type'] = 'View';
		$page = $this->createPageFromInput($input);

        if ($page)
        {
            $startsAt = array_get($input, 'published', false) ? new \DateTime : null;
    		$page->version = $this->PageVersionManager->createDefaultPageVersion($page, $startsAt);
        }

		return $page;
    }

	/**
	 * Validates and updates a page with the given input
     *
	 * @param  integer $id
	 * @param  array   $input
	 * @return bool
	 */
	public function updatePage($id, $input)
	{
        $input = array_only($input, static::$PageFields);
        $page = $this->Page->findOrFail($id);

        $this->validator = $this->Validator->make($input, $this->Page->updateRules, $this->Page->messages);

        if ($this->validator->passes())
        {
            $page->update($input);
            return $page;
        }

        $this->errors = $this->validator->errors()->all();
        $this->message = "There were validation errors.";
        return false;
    }

	/**
     * Destroys a page
     *
     * @param  integer $id
     * @return boolean
     */
	public function destroyPage($id)
	{
		$page = $this->Page->findOrFail($id);

        $page->versions()->delete();

		return $page->delete();
	}

	/**
     * Takes the input provided and runs the create method after stripping necessary fields.
     *
     * @param  integer $fromPageId
     * @param  array   $input
     * @return DvsPage
     */
	public function copyPage($fromPageId, $input)
	{
		$fromPage = $this->Page->findOrFail($fromPageId);

        if (isset($input['page_version_id']))
        {
            // a specific version has been requested to copy
            $fromPageVersion = $fromPage->versions()->findOrFail($input['page_version_id']);
            $fromPageVersion->name = 'Default';
        }
        else
        {
            // we'll use the current live version to copy
            $fromPageVersion = $fromPage->getLiveVersion();
        }

		$toPage = $this->createPageFromInput($input);

        $this->PageVersionManager->copyPageVersionToAnotherPage($fromPageVersion, $toPage);

		return $toPage;
	}



	/**
     * This helper method keeps looking through suggested route names
     * and adding a number onto the suggested route until it finds an available
     * one that isn't taken in the database. We don't want route names to be
     * the same ever as they should be unique so this helps us accomplish that.
     *
     * @param  string  $suggestedRoute
     * @param  integer $currentIteration
     * @return string
     */
	protected function findAvailableRoute($suggestedRoute, $currentIteration = 0)
    {
        $modifiedRoute = ($currentIteration == 0) ? $suggestedRoute : $suggestedRoute . '-' . $currentIteration;

        $existingRouteSearch = $this->Page->where('route_name', '=', $modifiedRoute)->count();

        if ($existingRouteSearch < 1)
        {
            return $modifiedRoute;
        }

        return $this->findAvailableRoute($suggestedRoute, $currentIteration + 1);
    }


    /**
     * Creates a page from the given input data
     *
     * @param  array $input
     * @return DvsPage
     */
    protected function createPageFromInput($input)
    {
        $primaryLanguageId = $this->Config->get('devise.languages.primary_language_id');
        // fill in some default values
        $input = array_only($input, static::$PageFields);
        $input['is_admin'] = array_get($input, 'is_admin', false);
        $input['dvs_admin'] = array_get($input, 'dvs_admin', false);
        $input['language_id'] = array_get($input, 'language_id', $primaryLanguageId);

        // validate the input given before we create the page
        $this->validator = $this->Validator->make($input, $this->Page->createRules, $this->Page->messages);

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
     * Updates the page version dates
     *
     * @param  int   $pageVersionId
     * @param  array $input
     * @return void
     */
    public function updatePageVersionDates($pageVersionId, $input)
    {
        return $this->PageVersionManager->updatePageVersionDates($pageVersionId, $input);
    }

    public function markContentRequestedFieldsComplete($pageId)
    {
        $page = $this->Page->findOrFail($pageId);

        $pageVersions = $this->PageVersionsRepository->getVersionsListForPage($page);

        foreach($pageVersions as $pageVersion => $name) {

            $contentRequestedFieldList = $this->FieldsRepository->findContentRequestedFieldsList($pageVersion);

            $contentRequestedFields = [];
            foreach($contentRequestedFieldList as $id => $field) {
                $contentRequestedFields[] = $id;
            }

            if(!$this->FieldManager->markNoContentRequested($contentRequestedFields)) {
                return json_encode(false);
            }
        }

        return json_encode(true);
    }
}