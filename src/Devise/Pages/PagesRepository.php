<?php namespace Devise\Pages;

use Devise\Languages\LanguageDetector;
use Devise\Pages\Collections\CollectionsRepository;

/**
 * Class PagesRepository is used to search and retrieve DvsPage models
 * and things in context of a Devise Page.
 *
 * @package Devise\Pages
 */
class PagesRepository
{
    /**
     * Instance of the Page Model
     *
     * @var Page
     */
	private $Page;

    /**
     * @var LanguageDetector
     */
    private $LanguageDetector;

    /**
     * @var CollectionsRepository
     */
    private $CollectionsRepository;

    /**
     * Create a new PageRepostiry instance.
     *
     * @param \DvsPage $Page
     * @param \DvsField $Field
     * @param \DvsGlobalField $GlobalField
     * @param LanguageDetector $LanguageDetector
     * @param CollectionsRepository $CollectionsRepository
     * @param null $Input
     * @param null $Config
     * @param null $URL
     */
	public function __construct(\DvsPage $Page, \DvsField $Field, \DvsGlobalField $GlobalField, LanguageDetector $LanguageDetector, CollectionsRepository $CollectionsRepository, $Input = null, $Config = null, $URL = null, $File = null)
	{
		$this->Page = $Page;
        $this->Field = $Field;
        $this->GlobalField = $GlobalField;
        $this->LanguageDetector = $LanguageDetector;
        $this->CollectionsRepository = $CollectionsRepository;

        $this->Input = $Input ?: \Input::getFacadeRoot();
        $this->Config = $Config ?: \Config::getFacadeRoot();
        $this->URL = $URL ?: \URL::getFacadeRoot();
        $this->File = $File ?: \File::getFacadeRoot();

        $this->now = new \DateTime;
	}

    /**
     * finds a record by it's id
     *
     * @param  int $id
     * @param string $versionName
     * @param bool $editing
     * @return Page
     */
	public function find($id)
	{
        $page = $this->Page->with('versions')->findOrFail($id);

        $this->wrapPageVersionStatuses($page->versions, $page);

        return $page;
	}

    /**
     * finds a record by it's id and provide version and field data
     *
     * @param  int $id
     * @param string $versionName
     * @param bool $editing
     * @internal param string $slug
     * @return Page
     */
    public function findWithVersion($id, $versionName = null, $editing = false)
    {
        $page = $this->Page->findOrFail($id);

        // if the user is an admin user they can view any page
        // using the ?page_version query parameter otherwise
        // they just get the live version
        $page->version = $editing && $versionName !== null ? $this->getPageVersionByName($page, $versionName) : $this->getLivePageVersion($page);

        if (!$page->version)
        {
            throw new PageNotFoundException('Page not found!');
        }

        $page = $this->wrapFieldsAroundPage($page, $page->version);

        return $page;
    }

    /**
     * finds a record by it's slug
     *
     * @param $name
     * @param string $versionName
     * @param bool $editing
     * @internal param string $slug
     * @return Page
     */
	public function findByRouteName($name, $versionName = null, $editing = false)
	{
		$page = $this->Page->whereRouteName($name)->firstOrFail();

        // if the user is an admin user they can view any page
        // using the ?page_version query parameter otherwise
        // they just get the live version
        $page->version = $editing && $versionName !== null ? $this->getPageVersionByName($page, $versionName) : $this->getLivePageVersion($page);

        if (!$page->version)
        {
            throw new PageNotFoundException('Page not found!');
        }

        $page = $this->wrapFieldsAroundPage($page, $page->version);

        return $page;
	}

    /**
     * Finds the DvsPage by a route name and preview hash
     *
     * @param  string $name
     * @param  string $previewHash
     * @return DvsPage
     */
    public function findByRouteNameAndPreviewHash($name, $previewHash)
    {
        $page = $this->Page->whereRouteName($name)->firstOrFail();

        $page->version = $this->getPageVersionByPreviewHash($page, $previewHash);

        if (!$page->version)
        {
            $page->version = $this->getLivePageVersion($page);
            $page->version->preview_message = array(
                'warning' => 'The page version you are trying to access is no longer available'
            );
        }

        if ($page->version)
        {
            $page = $this->wrapFieldsAroundPage($page, $page->version);
            $page->version->preview_message = array(
                'message' => 'You are viewing a preview of a specific page version, which may or may not be live'
            );
        }

        return $page;
    }

    /**
     * See if a localized version of this page exists
     * if there is no difference we return null
     *
     * @param  Page $page
     * @return Page
     */
    public function findLocalizedPage($page)
    {
        $language = $this->LanguageDetector->current();

        if ($language->id == $page->language_id) return null;

        return $this->Page->whereTranslatedFromPageId($page->id)->whereLanguageId($language->id)->first();
    }

    /**
     * Finds lots of pages in the system that
     * are not admin pages and belong to the current language
     *
     * @return Page
     */
    public function pages()
    {
        $languageId = $this->Input->get('language_id', $this->Config->get('devise.languages.primary_language_id'));

        $showAdmin = $this->Input->get('show_admin', false);

        $pages = $this->Page->where('language_id', '=', $languageId);

        if ($showAdmin !== 'true')
        {
            $pages = $pages->where('dvs_admin', '<>', 1);
        }

        $pages = $pages->paginate();

        foreach ($pages as $page)
        {
            $this->wrapPageVersionStatuses($page->versions, $page);
        }

        return $this->wrapLanguagesAroundPages($pages);
    }

    /**
     * List of all the languages available for a page
     *
     * @param  integer $id
     * @return array
     */
    public function availableLanguagesForPage($id)
    {
        $page = $this->Page->with('localizedPages', 'language', 'translatedFromPage')->find($id);

        $languages = [
            $page->language_id => [
                'human_name' => $page->language->human_name,
                'url' => $this->URL->route($page->route_name),
                'code' => $page->language->code,
            ]
        ];

        foreach ($page->localizedPages as $p)
        {
            $languages[$p->language_id] = [
                'human_name' => $p->language->human_name,
                'url' => $this->URL->route($p->route_name),
                'code' => $p->language->code,
            ];
        }

        if (isset($page->translatedFromPage))
        {
            $p = $page->translatedFromPage;
            $languages[$p->language_id] = [
                'human_name' => $p->language->human_name,
                'url' => $this->URL->route($p->route_name),
                'code' => $p->language->code,
            ];
        }

        return $languages;
    }

    /**
     * Get the versions of a page
     *
     * @param  integer $pageId
     * @param null $selectedPageVersionId
     * @return EloquentCollection[PageVersions]
     */
    public function getPageVersions($pageId, $selectedPageVersionId = null)
    {
        $page = $this->Page->findOrFail($pageId);
        $versions = $page->versions;

        foreach ($versions as $version)
        {
            if ($selectedPageVersionId && $version->id == $selectedPageVersionId)
            {
                $version->selected = 'selected';
            }
        }

        $versions = $this->wrapPageVersionStatuses($versions, $page);

        return $versions;
    }

    /**
     * Get the route list for all the non admin pages
     *
     * @return Collection
     */
    public function getRouteList()
    {
        $routes = $this->Page->where('dvs_admin', '<>', 1)->where('language_id',45)->orderBy('slug')->get();
        $list = array();
        $slugName = null;

        foreach ($routes as $route)
        {
            $arr = explode('/', $route->slug);
            array_pop($arr);
            $routeName = implode(' ', $arr);

            if ($routeName != $slugName)
            {
                $slugName = ucwords($routeName);
                $list[ $slugName ][ $route->route_name ] = $route->title;
            } else {
                $list[$route->route_name] = $route->title;
            }
        }

        return $list;
    }

    /**
     * Gets the live version of this page
     *
     * @param  Page $page
     * @param null $now
     * @return PageVersion
     */
    public function getLivePageVersion($page)
    {
        $now = $this->now;

        $version = $page->versions()->with('fields')
            ->where('starts_at', '<', $now)
            ->where(function($query) use ($now)
            {
                $query->where('ends_at', '>', $now);
                $query->orWhereNull('ends_at');
            })
            ->orderBy('starts_at', 'DESC')
            ->first();

        return $version;
    }

    /**
     * Gets the page version by name
     *
     * @param  Page   $page
     * @param  string $versionName
     * @return PageVersion
     */
    public function getPageVersionByName($page, $versionName)
    {
        return $page->versions()->with('fields')->whereName($versionName)->first();
    }

    /**
     * Gets a list of pages in array format probably used for
     * drop down boxes.
     *
     * @param  boolean $includeAdmin
     * @param  string  $search
     * @return array
     */
    public function getPagesList($includeAdmin = false, $search = null)
    {
        $pages = $this->Page->with('language');

        if ($search != null) {
            $pages = $pages->where('title', 'LIKE', '%'.$search.'%');
        }

        if (!$includeAdmin) {
            $pages = $pages->where('is_admin', '=', 0)->where('dvs_admin', '=', 0);
        }

        $pageCollection = $pages->get();

        $pageList = array();
        foreach($pageCollection as $page) {
            $pageList[$page->id] = $page->title . ' (' . $page->language->code . ')';
        }

        return $pageList;
    }


    /**
     * Gets a list of languages that the page has not been translated to or originates from
     *
     * @param  integer $pageId
     * @param  array  $languages
     * @return array
     */
    public function getUnUsedLanguageList($pageId, $languages)
    {
        $existingLangages = $this->Page
                                ->where(function($query) use ($pageId) {
                                    $query->where('id',$pageId)
                                        ->orWhere('translated_from_page_id', $pageId);
                                })
                                ->lists('title', 'language_id');

        return array_diff_key($languages, $existingLangages);
    }

    /**
     * Get the list of available views
     *
     * @return array
     */
    public function availableViewsList()
    {
        $views = array();
        $viewLocations = $this->Config->get('view');
        $humanNames = $this->Config->get('view.template_human_names');

        foreach ($viewLocations['paths'] as $path) {
            if (!$this->File->exists($path)) {
                continue;
            }

            $files = $this->File->allFiles($path);

            foreach ($files as $file) {
                if (substr_count($file->getRelativePathname(), '.blade.php')) {
                    $value = str_replace('/', '.', str_replace('.blade.php', '', $file->getRelativePathname()));
                    $nameArr = explode('.', $value);

                    // added in case you have a file directory within the views directory
                    // then you will see a big fat error because there is no index [1] below
                    if (count($nameArr) < 2) continue;

                    $folderName = $nameArr[0];
                    $viewName = $nameArr[1];

                    if (substr($viewName, 0, 1) != '_' && $folderName == 'templates') {
                        $views[$value] = isset($humanNames[$value]) ? $humanNames[$value] : $value;
                    }
                }
            }
        }

        asort($views);
        return $views;
    }

    /*
     * Gets the page version by a hash
     *
     * @param  Page   $page
     * @param  string $previewHash
     * @return PageVersion
     */
    protected function getPageVersionByPreviewHash($page, $previewHash)
    {
        return $page->versions()->with('fields')->wherePreviewHash($previewHash)->first();
    }

    /**
     * Wrap all fields around the page
     *
     * @param  Page $page
     * @param $pageVersion
     * @return Page
     */
    protected function wrapFieldsAroundPage($page, $pageVersion)
    {
        $language = $this->LanguageDetector->current();

        $globalFields = $this->GlobalField->where('language_id', $language->id)->get();

        $page = $this->wrapTheseFieldsAroundThisPage($globalFields, $page);

        $page = $this->wrapTheseFieldsAroundThisPage($pageVersion->fields, $page);

        $page = $this->wrapTheseCollectionsAroundThisPage($this->CollectionsRepository->findCollectionsForPageVersion($pageVersion), $page);

        return $page;
    }

    /**
     * Takes a list of fields and a page and puts those
     * field values onto a page object to return
     *
     * @param  array $fields
     * @param  Page $page
     * @return Page
     */
    protected function wrapTheseFieldsAroundThisPage($fields, $page)
    {
        foreach ($fields as $field)
        {
            // turn routes into urls GO MAGIC GO! ^_^
            if (isset($field->value->route) && $field->value->route !== '')
            {
                $field->value->url = $this->URL->route($field->value->route);
            }

            $page->{$field->key} = $field->value;
        }

        return $page;
    }

    /**
     * Takes a list of collections and wraps the page with those
     * collections so we can access them dynamically.
     *
     * @param $collections
     * @param  Page $page
     * @return Page
     */
    protected function wrapTheseCollectionsAroundThisPage($collections, $page)
    {
        foreach ($collections as $key => $collection)
        {
            $page->{$key} = $collection;
        }

        return $page;
    }

    /**
     * Wraps the available languages for a page
     *
     * @param  Collection $pages
     * @return Collection
     */
    protected function wrapLanguagesAroundPages($pages)
    {
        foreach ($pages as $page)
        {
            $page->availableLanguages = $this->availableLanguagesForPage($page->id);
        }

        return $pages;
    }

    /**
     * Wraps the statues around page versions
     *
     * @param  $versions
     * @param $page
     * @return Collection
     */
    protected function wrapPageVersionStatuses($versions, $page)
    {
        $page->status = 'unpublished';
        $currentVersion = $this->getLivePageVersion($page);

        foreach ($versions as $version)
        {
            $version = $this->wrapPageVersionStatus($version, $page, $currentVersion);
        }

        return $versions;
    }

    /**
     * Wraps the status around a single page version
     *
     * @param  DvsPageVersion $version
     * @param  DvsPage        $page
     * @param  DvsPageVersion $currentVersion
     * @return DvsPageVersion
     */
    protected function wrapPageVersionStatus($version, $page, $currentVersion)
    {
        // sometimes we don't have a current version
        // like when a page is completely unpublished!
        if (is_null($currentVersion))
        {
            $currentVersion = new \StdClass;
            $currentVersion->id = -1;
        }

        $now = new \DateTime;
        $startsAt = $version->starts_at;
        $endsAt = $version->ends_at;

        $version->starts_at_human = $version->starts_at ? $this->toHumanDateFormat($version->starts_at) : 'never starts';
        $version->ends_at_human = $version->ends_at ? $this->toHumanDateFormat($version->ends_at) : 'never ends';

        // the current version is live
        if ($version->id == $currentVersion->id)
        {
            $page->status = 'live';
            $version->status = "live";
            return $version;
        }

        // if the version is overriden b/c it has started and has not finished but is not live version
        if ($version->id != $currentVersion->id && $startsAt && $startsAt < $now && ($endsAt > $now || is_null($endsAt)))
        {
            $version->status = "overridden";
            return $version;
        }

        // if version has a starts_at date scheduled
        if ($startsAt && $startsAt > $now)
        {
            $version->status = 'scheduled';
            return $version;
        }

        // finally fallback to the page is just unpublished status
        $version->status = "unpublished";
        return $version;
    }

    /**
     * To human date format converts this to a readable human format
     *
     * @param  Datetime $timestamp
     * @param  string $to
     * @return string
     */
    protected function toHumanDateFormat($timestamp, $to = 'm/d/y H:i:s')
    {
        if (!$timestamp) return null;

        $date = new \DateTime($timestamp);

        return $date->format($to);
    }
}