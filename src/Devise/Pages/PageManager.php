<?php namespace Devise\Pages;

use Illuminate\Support\Str;
use Devise\Support\Framework;
use Devise\Pages\Fields\FieldsRepository;
use Devise\Pages\Fields\FieldManager;
use Devise\Languages\LocaleDetector;

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
        'route_name',
        'view',
        'title',
        'http_verb',
        'is_admin',
        'dvs_admin',
        'slug',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'head',
        'footer',
        'middleware',
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
     * [$warnings description]
     * @var [type]
     */
    public $warnings;

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
        Framework $Framework,
        RoutesGenerator $RoutesGenerator,
        \DvsLanguage $Language
    ){
        $this->Page = $Page;
        $this->Validator = $Framework->Validator;
        $this->PageVersionManager = $PageVersionManager;
        $this->PageVersionsRepository = $PageVersionsRepository;
        $this->FieldsRepository = $FieldsRepository;
        $this->FieldManager = $FieldManager;
        $this->Config = $Framework->config;
        $this->RoutesGenerator = $RoutesGenerator;
        $this->Language = $Language;
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
            $this->cacheDeviseRoutes();
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
            $this->cacheDeviseRoutes();
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

        $this->cacheDeviseRoutes();

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

        // get translated page id, if page copy is translation and langauges are different
        if(array_get($input, 'copy_reason') == 'translate' &&  array_get($input, 'language_id') !== $fromPage->language_id) {
            $this->setTranslatedFromPageId($fromPage, $input);
            $this->setTranslatedFromRouteName($fromPage, $input);
        }

        $toPage = $this->createPageFromInput($input);

        if (!$toPage) return false;

        $this->PageVersionManager->copyPageVersionToAnotherPage($fromPageVersion, $toPage);

        $this->cacheDeviseRoutes();

        return $toPage;
    }

    /**
     * This ensures that we are translating from the correct "parent" page.
     *
     * This happens when a user creates a page and then copies that "parent"
     * page to a "child" page. When the user tries to copy the "child"
     * page to a "grandchild" page. We want the "grandchild" to be a
     * "child" instead of a "grandchild".
     *
     * This keeps page nesting down to 1 level instead of nesting under
     * many levels.
     *
     * @param  integer $fromPageId
     * @param  array $input
     * @return array
     */
    protected function setTranslatedFromPageId($fromPage, &$input)
    {
        $input['translated_from_page_id'] = $fromPage->translated_from_page_id
            ? $fromPage->translated_from_page_id
            : $fromPage->id;
    }

    /**
     * Sets the route_name equal to the orignal page's route_name
     *
     * @param  integer $fromPageId
     * @param  array $input
     */
    protected function setTranslatedFromRouteName($fromPage, &$input)
    {
        if($fromPage->translated_from_page_id){

            $origPage = $this->Page
                            ->select('route_name')
                            ->findOrFail( $fromPage->translated_from_page_id );

            $input['route_name'] = $origPage->route_name;

        } else {
            $input['route_name'] = $fromPage->route_name;
        }
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
    protected function findAvailableRoute($suggestedRoute, $languageId)
    {
        $sanity = 0;

        $modifiedRoute = $suggestedRoute;

        if ($languageId != $this->Config->get('devise.languages.primary_language_id'))
        {
            $language = $this->Language->findOrFail($languageId);
            $modifiedRoute = $language->code . '-' . $suggestedRoute;
        }

        while ($this->Page->where('route_name', '=', $modifiedRoute)->count() > 0 && $sanity++ < 100)
        {
            $modifiedRoute .= '-' . $sanity;
        }

        return $modifiedRoute;
    }


    /**
     * Creates a page from the given input data
     *
     * @param  array $input
     * @return DvsPage
     */
    protected function createPageFromInput($input)
    {
        // fill in some default values
        $input = array_only($input, static::$PageFields);
        $input['is_admin'] = array_get($input, 'is_admin', false);
        $input['dvs_admin'] = array_get($input, 'dvs_admin', false);
        $input['language_id'] = array_get($input, 'language_id', $this->Config->get('devise.languages.primary_language_id'));

        // if route_name is there then we ave a suggestion
        if(!isset($input['route_name'])){
            $input['route_name'] = $this->findAvailableRoute(Str::slug(array_get($input, 'title', str_random(42))), $input['language_id']);
        } else {
            $input['route_name'] = $this->findAvailableRoute($input['route_name'], $input['language_id']);
        }

        if ($this->isValidInputForNewPage($input))
        {
            return $this->Page->create($input);
        }

        return false;
    }

    /**
     * [isValidInputForNewPage description]
     * @param  [type]  $input
     * @return boolean
     */
    protected function isValidInputForNewPage($input)
    {
        // validate the input given before we create the page
        $this->validator = $this->Validator->make($input, $this->Page->createRules, $this->Page->messages);

        $fails = $this->validator->fails();

        if ($fails)
        {
            $this->errors = $this->validator->errors()->all();
            $this->message = "There were validation errors.";
        }

        // check to make sure that there is no duplicate slug/method out there
        $duplicatePage = $this->Page->where('http_verb', $input['http_verb'])->where('slug', $input['slug'])->first();

        if ($duplicatePage)
        {
            $this->errors = $this->validator->errors()->all();
            $this->errors['slug'] = 'There is already a page with this slug/verb pair';
            $this->message = "There were validation errors.";
        }

        return count($this->errors) == 0;
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

    /**
     * Updates the page version view
     *
     * @param  [type] $pageVersionId
     * @param  [type] $view
     * @return [type]
     */
    public function updatePageVersionView($pageVersionId, $view)
    {
        return $this->PageVersionManager->updatePageVersionView($pageVersionId, $view);
    }

    /**
     * Marks all page's fields with a "true" content_requested value as complete
     *
     * @param  int   $pageVersionId
     * @param  array $input
     * @return string
     */
    public function markContentRequestedFieldsComplete($pageId)
    {
        $page = $this->Page->findOrFail($pageId);

        $pageVersions = $this->PageVersionsRepository->getVersionsListForPage($page);

        foreach($pageVersions as $pageVersion => $name) {
            $requestedFieldIds = $this->FieldsRepository->findContentRequestedFieldsList($pageVersion);

            if(!$this->FieldManager->markNoContentRequested($requestedFieldIds)) {
                return json_encode(false);
            }
        }

        return json_encode(true);
    }

    /**
     * [toggleABTesting description]
     * @param  [type] $pageId
     * @param  [type] $isEnabled
     * @return [type]
     */
    public function toggleABTesting($pageId, $isEnabled)
    {
        $page = $this->Page->findOrFail($pageId);

        $page->ab_testing_enabled = $isEnabled == 'true' ? true : false;

        $page->save();

        return $page;
    }

    /**
     * [updatePageVersionABTestingAmount description]
     * @param  [type] $pageVersionId
     * @param  [type] $amount
     * @return [type]
     */
    public function updatePageVersionABTestingAmount($pageVersionId, $amount)
    {
        return $this->PageVersionManager->updatePageVersionABTestingAmount($pageVersionId, $amount);
    }

    /**
     * Cache the devise routes, and make sure to catch an
     * exception. Exception thrown is likely due to serialization
     * error caused by caching routes with closures in them
     *
     * @return [type]
     */
    protected function cacheDeviseRoutes()
    {
        try {
            $this->RoutesGenerator->cacheRoutes();
        } catch (\Exception $e) {
            $this->message = $e->getMessage();
        }
    }
}