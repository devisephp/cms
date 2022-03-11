<?php namespace Devise\Pages;

use Devise\Models\DvsLanguage;
use Devise\Models\DvsPage;
use Devise\Pages\Meta\PageMetaManager;
use Devise\Sites\SiteDetector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Devise\Support\Framework;
use Devise\Pages\Fields\FieldsRepository;
use Devise\Pages\Fields\FieldManager;

/**
 * Class PageManager manages the creating of new pages,
 * updating pages and removing and copying pages.
 */
class PagesManager
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
     * @param DvsPage|\DvsPage $Page
     * @param PageVersionManager $PageVersionManager
     * @param PageVersionsRepository $PageVersionsRepository
     * @param FieldsRepository $FieldsRepository
     * @param FieldManager $FieldManager
     * @param Framework $Framework
     * @param RoutesGenerator $RoutesGenerator
     * @param DvsLanguage $Language
     * @param PageMetaManager $PageMetaManager
     * @param SiteDetector $SiteDetector
     */
    public function __construct(
        DvsPage $Page,
        PageVersionManager $PageVersionManager,
        PageVersionsRepository $PageVersionsRepository,
        FieldsRepository $FieldsRepository,
        FieldManager $FieldManager,
        Framework $Framework,
        RoutesGenerator $RoutesGenerator,
        DvsLanguage $Language,
        PageMetaManager $PageMetaManager,
        SiteDetector $SiteDetector
    )
    {
        $this->Page = $Page;
        $this->Validator = $Framework->Validator;
        $this->PageVersionManager = $PageVersionManager;
        $this->PageVersionsRepository = $PageVersionsRepository;
        $this->FieldsRepository = $FieldsRepository;
        $this->FieldManager = $FieldManager;
        $this->Config = $Framework->config;
        $this->RoutesGenerator = $RoutesGenerator;
        $this->Language = $Language;
        $this->PageMetaManager = $PageMetaManager;
        $this->SiteDetector = $SiteDetector;
        $this->now = new \DateTime;
    }

    /**
     * Validates and creates a page with the given input
     *
     * @param  array a$input
     * @return DvsPage
     */
    public function createNewPage($input)
    {
        $page = $this->createPageFromInput($input);

        $startsAt = Arr::get($input, 'published', false) ? date('Y-m-d H:i:s') : null;

        $layout = Arr::get($input, 'layout', '');

        $copyPageId = Arr::get($input, 'copy_page_id', false);

        if ($copyPageId)
        {
            $fromPage = $this->Page->findOrFail($copyPageId);
            $fromPageVersion = $fromPage->liveVersion;
            $this->PageVersionManager->copyPageVersionToAnotherPage($fromPageVersion, $page, $startsAt);
        } else
        {
            $this->PageVersionManager->createDefaultPageVersion($page, $layout, $startsAt);
        }

        $page->load('versions');

        $this->refreshRouteCache();

        return $page;
    }

    /**
     * Validates and updates a page with the given input
     *
     * @param  integer $id
     * @param  array $input
     * @return bool
     */
    public function updatePage($id, $input)
    {
        $page = $this->Page
            ->with('versions', 'currentVersion')
            ->findOrFail($id);

        $this->checkIfVersionHasBeenUpdated($input, $page->currentVersion);

        $page->updateFromArray($input);

        if (isset($input['slices']))
        {
            $this->FieldManager->saveSliceInstanceFields($page->currentVersion->id, $input['slices']);
        }

        if (isset($input['settings']))
        {
            $page->currentVersion->settings = $input['settings'];
            $page->currentVersion->save();
        }

        $this->PageMetaManager->savePageMeta($page, Arr::get($input, 'meta', []));

        $this->refreshRouteCache();

        $page->load('versions', 'currentVersion');

        return $page;
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

        $this->refreshRouteCache();

        return $page->delete();
    }

    /**
     * Takes the input provided and runs the create method after stripping necessary fields.
     *
     * @param  integer $fromPageId
     * @param  array $input
     * @return DvsPage
     */
    public function copyPage($fromPageId, $input)
    {
        $input['meta_title'] = $input['title'];
        $startsAt = date('Y-m-d H:i:s');
        $fromPage = $this->Page->findOrFail($fromPageId);


        // we'll use the current live version to copy
        $fromPageVersion = $fromPage->getLiveVersion();

        if (Arr::get($input, 'language_id', false))
        {
            // we are translating the page
            $this->setTranslatedFromPageId($fromPage, $input);
            $this->setTranslatedFromRouteName($fromPage, $input);

        } else
        {
            // inject default language id
            $input['language_id'] = $fromPage->language_id;
        }

        if (!Arr::get($input, 'site_id', false))
        {
            $site = $this->SiteDetector->current();
            $input['site_id'] = $site->id;
        }

        $toPage = $this->createPageFromInput($input);

        if (!$toPage) return false;

        $this->PageVersionManager->copyPageVersionToAnotherPage($fromPageVersion, $toPage, $startsAt);

        $this->refreshRouteCache();

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
        if ($fromPage->translated_from_page_id)
        {

            $origPage = $this->Page
                ->select('route_name')
                ->findOrFail($fromPage->translated_from_page_id);

            $input['route_name'] = $origPage->route_name;

        } else
        {
            $input['route_name'] = $fromPage->route_name;
        }
    }

    /**
     * This helper method keeps looking through suggested route names
     * and adding a number onto the suggested route until it finds an available
     * one that isn't taken in the database. We don't want route names to be
     * the same ever as they should be unique so this helps us accomplish that.
     *
     * @param  string $suggestedRoute
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

        while ($this->Page->withTrashed()->where('route_name', '=', $modifiedRoute)->count() > 0 && $sanity++ < 100)
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
        if (!isset($input['route_name']))
        {
            $input['route_name'] = $this->findAvailableRoute(Str::slug(Arr::get($input, 'title', Str::random(42))), $input['language_id']);
        } else
        {
            $input['route_name'] = $this->findAvailableRoute($input['route_name'], $input['language_id']);
        }

        return $this->Page->createFromArray($input);
    }

    /**
     * Marks all page's fields with a "true" content_requested value as complete
     *
     * @param  int $pageVersionId
     * @param  array $input
     * @return string
     */
    public function markContentRequestedFieldsComplete($pageId)
    {
        $page = $this->Page->findOrFail($pageId);

        $pageVersions = $this->PageVersionsRepository->getVersionsListForPage($page);

        foreach ($pageVersions as $pageVersion => $name)
        {
            $requestedFieldIds = $this->FieldsRepository->findContentRequestedFieldsList($pageVersion);

            if (!$this->FieldManager->markNoContentRequested($requestedFieldIds))
            {
                return json_encode(false);
            }
        }

        return json_encode(true);
    }

    private function refreshRouteCache()
    {
        if (App::routesAreCached())
        {
            Artisan::call('route:cache');
        }
    }

    private function checkIfVersionHasBeenUpdated($requestData, $currentVersion)
    {
        $ignore = (!isset($requestData['force']) || $requestData['force'] === false || $requestData['force'] === 0) ? false : true;

        if (!$ignore && $requestData['version_last_updated_at'] !== $currentVersion->updated_at->format('Y-m-d H:i:s'))
        {
            abort(480, 'The page being saved is outdated. Please refresh your page before making changes.');
        }
    }
}