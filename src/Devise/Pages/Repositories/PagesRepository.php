<?php namespace Devise\Pages\Repositories;

use Config, Input, Page, Field, GlobalField;
use URL;
use Devise\Search\Searchable;
use Devise\Languages\LanguageDetector;
use Devise\Collections\Repositories\CollectionsRepository;

class PagesRepository extends BaseRepository
{
    /**
     * Instance of the Page Model
     *
     * @var Page
     */
	private $Page, $LanguageDetector, $CollectionsRepository;

    /**
     * Create a new PageRepostiry instance.
     *
     * @param  Page  $Page
     */
	public function __construct(Page $Page, LanguageDetector $LanguageDetector, Field $Field, GlobalField $GlobalField, CollectionsRepository $CollectionsRepository)
	{
		$this->Page = $Page;
        $this->LanguageDetector = $LanguageDetector;
        $this->Field = $Field;
        $this->GlobalField = $GlobalField;
        $this->CollectionsRepository = $CollectionsRepository;
	}

    /**
     * finds a record by it's id
     *
     * @param  int $id
     * @return Page
     */
	public function find($id)
	{
		return $this->Page->findOrFail($id);
	}

    /**
     * finds a record by it's slug
     *
     * @param $name
     * @internal param string $slug
     * @return Page
     */
	public function findByRouteName($name, $versionName = 'Default')
	{
		$page = $this->Page->whereRouteName($name)->firstOrFail();

        $page->version = $page->versions()->with('fields')->where('name', $versionName)->first();

        if ($page->version)
        {
            $page = $this->wrapFieldsAroundPage($page, $page->version);
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
     * calls paginate on Page
     *
     * @return Page
     */
	public function pages()
	{
        $languageId = (!Input::has('language_id')) ? Config::get('devise::languages.primary_language_id') : Input::get('language_id');
        $pages = $this->Page->where('dvs_admin', '<>', 1)
                            ->where('language_id', '=', $languageId)
                            ->paginate();

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

        $languages = array($page->language_id => array('human_name' => $page->language->human_name, 'url' => URL::route($page->route_name)));

        foreach ($page->localizedPages as $p)
        {
            $languages[$p->language_id] = array('human_name' => $p->language->human_name, 'url' => URL::route($p->route_name));
        }

        if (isset($page->translatedFromPage))
        {
            $p = $page->translatedFromPage;
            $languages[$p->language_id] = array('human_name' => $p->language->human_name, 'url' => URL::route($p->route_name));
        }

        return $languages;
    }

    /**
     * Get the versions of a page
     *
     * @param  integer $pageId
     * @return EloquentCollection[PageVersions]
     */
    public function getPageVersions($pageId, $selectedPageVersionId = null)
    {
        $versions = $this->Page->findOrFail($pageId)->versions;

        if ($selectedPageVersionId)
        {
            foreach ($versions as $version)
            {
                if ($version->id == $selectedPageVersionId)
                {
                    $version->selected = 'selected';
                }
            }
        }

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
            if ($routeName != $slugName){
                $slugName = ucwords($routeName);
            }
            $list[ $slugName ][ $route->route_name ] = $route->title;
        }
        return $list;
    }

    /**
     * Wrap all fields around the page
     *
     * @param  Page $page
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
                $field->value->url = URL::route($field->value->route);
            }

            $page->{$field->key} = $field->value;
        }

        return $page;
    }

    /**
     * Takes a list of collections and wraps the page with those
     * collections so we can access them dynamically.
     *
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
     * [getPagesList description]
     * @param  boolean $includeAdmin [description]
     * @param  [type]  $search       [description]
     * @return [type]                [description]
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
}