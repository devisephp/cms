<?php namespace Devise\Pages;

use Devise\Languages\LanguageDetector;
use Devise\Pages\Collections\CollectionsRepository;
use Devise\Pages\Interpreter\ViewOpener;
use Devise\Models\DvsPage;
use Devise\Sites\SiteDetector;
use Devise\Support\Framework;
use Illuminate\Support\Facades\DB;

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
     * @var SiteDetector
     */
    private $SiteDetector;

    /**
     * @var LanguageDetector
     */
    private $LanguageDetector;

    /**
     * Create a new PageRepostiry instance.
     *
     * @param DvsPage $Page
     * @param LanguageDetector $LanguageDetector
     * @param Framework $Framework
     */
    public function __construct(DvsPage $Page, SiteDetector $SiteDetector, LanguageDetector $LanguageDetector, Framework $Framework)
    {
        $this->Page = $Page;
        $this->SiteDetector = $SiteDetector;
        $this->LanguageDetector = $LanguageDetector;

        $this->Config = $Framework->Config;
        $this->URL = $Framework->URL;
        $this->File = $Framework->File;
        $this->Request = $Framework->Request;
        $this->Cookie = $Framework->Cookie;
        $this->Cache = $Framework->Cache;
        $this->Route = $Framework->Route;

        $this->now = new \DateTime;
    }

    /**
     * finds a record by it's slug
     *
     * @param $name
     * @return Page
     * @internal param string $versionName
     */
    public function findByRouteName($name)
    {
        $site = $this->SiteDetector->current();

        $with = [
            'currentVersion.slices.slices.slices.slices',
            'currentVersion.slices.fields',
            'currentVersion.slices.slices.fields',
            'currentVersion.slices.slices.slices.fields',
            'currentVersion.slices.slices.slices.slices.fields',
            'versions.page.currentVersion',
            'versions.page.liveVersion',
            'translatedFromPage.language',
            'localizedPages.language',
            'metas',
            'language',
            'site.languages'
        ];

        if ($this->Config->get('devise.cache_enabled'))
        {
            $page = $this->Cache
                ->rememberForever('devise.page.' . $name . '.' . $site->id, function () use ($with, $name, $site) {
                    return $this->Page
                        ->with($with)
                        ->whereRouteName($name)
                        ->whereSiteId($site->id)
                        ->firstOrFail();
                });
        } else
        {
            $page = $this->Page
                ->with($with)
                ->whereRouteName($name)
                ->whereSiteId($site->id)
                ->firstOrFail();
        }

        return $page;
    }

    /**
     *
     * @param $id
     * @return Page
     * @internal param string $versionName
     */
    public function findById($id)
    {
        return $this->Page
            ->with([
                    'currentVersion.slices.slices.slices.slices',
                    'currentVersion.slices.fields',
                    'versions.page.currentVersion',
                    'translatedFromPage',
                    'localizedPages',
                    'metas'
                ]
            )
            ->findOrFail($id);
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

        return $this->Page
            ->whereTranslatedFromPageId($page->id)
            ->whereLanguageId($language->id)
            ->first();
    }

    /**
     * Finds all pages belong to the site and language (paginated)
     *
     * @return Collection
     */
    public function pages($siteId, $languageId)
    {
        return $this->Page
            ->with('versions', 'metas')
            ->where('site_id', $siteId)
            ->where('language_id', $languageId)
            ->paginate();
    }

    /**
     * Finds all pages belong to the site and language (paginated)
     *
     * @return Collection
     */
    public function all($siteId, $languageId)
    {
        return $this->Page
            ->with('versions', 'metas')
            ->where('site_id', $siteId)
            ->where('language_id', $languageId)
            ->get();
    }

    /**
     * Finds all pages belong to the site and language (paginated)
     *
     * @return Collection
     */
    public function routes($siteId, $languageId)
    {
        return $this->Page
            ->select('id', 'title', 'route_name')
            ->where('site_id', $siteId)
            ->where('language_id', $languageId)
            ->where('slug', 'not like', '%{%')
            ->orderBy('title')
            ->get();
    }

    /**
     * List of all the languages available for a page
     *
     * @param  integer $id
     * @return array
     */
    public function availableLanguagesForPage($id, $params = [])
    {
        $page = $this->Page->with('localizedPages', 'language', 'translatedFromPage.localizedPages')->find($id);

        $languages = [
            $page->language_id => [
                'human_name' => $page->language->human_name,
                'url'        => $this->URL->route($page->route_name, $params),
                'code'       => $page->language->code,
                'id'         => $page->language_id,
            ]
        ];

        foreach ($page->localizedPages as $p)
        {
            $languages[$p->language_id] = [
                'human_name' => $p->language->human_name,
                'url'        => $this->URL->route($p->route_name, $params),
                'code'       => $p->language->code,
                'id'         => $p->language_id,
            ];
        }

        if (isset($page->translatedFromPage))
        {
            $p = $page->translatedFromPage;
            $languages[$p->language_id] = [
                'human_name' => $p->language->human_name,
                'url'        => $this->URL->route($p->route_name, $params),
                'code'       => $p->language->code,
                'id'         => $p->language_id,
            ];

            foreach ($p->localizedPages as $lp)
            {
                $languages[$lp->language_id] = [
                    'human_name' => $lp->language->human_name,
                    'url'        => $this->URL->route($lp->route_name, $params),
                    'code'       => $lp->language->code,
                    'id'         => $lp->language_id,
                ];
            }
        }

        return $languages;
    }

    /**
     * Gets a list of pages in array format probably used for
     * drop down boxes.
     *
     * @param  string $searchTerm
     * @return array
     */
    public function searchPages($searchTerm = null, $siteId = null, $list = false, $limit = null)
    {
        $pages = $this->Page
            ->join('dvs_languages', 'dvs_languages.id', '=', 'dvs_pages.language_id')
            ->join('dvs_sites', 'dvs_sites.id', '=', 'dvs_pages.site_id');

        if (!$list) {
            $pages = $pages->with('versions');
            $pages = $pages->with('metas');
        }

        if ($siteId != null)
            $pages = $pages->where('site_id', $siteId);

        if ($searchTerm != null)
            $pages = $pages->where('title', 'LIKE', '%' . $searchTerm . '%');

        if ($list) {
            $pages = $pages->select('dvs_pages.id', 'dvs_pages.title', 'dvs_sites.name', 'dvs_languages.code')
                ->orderBy('dvs_pages.site_id');
        }

        if ($limit != null)
            $pages = $pages->take($limit);

        $pages = $pages->select('dvs_pages.*')->paginate();
        
        if (!$list)
        return $pages;
        
        $results = [];
        foreach ($pages as $page)
        {
            $name = (!$siteId) ? $page->name . ': ' : '';
            $name .= $page->title . ' (' . $page->code . ')';
            $results[$page->id] = $name;
        }
        
        return $results;
    }


    /**
     * Gets a list of languages that the page has not been translated to or originates from
     *
     * @param  integer $pageId
     * @param  array $languages
     * @return array
     */
    public function getUnUsedLanguageList($pageId, $languages)
    {
        $existingLangages = $this->Page
            ->where(function ($query) use ($pageId) {
                $query->where('id', $pageId)
                    ->orWhere('translated_from_page_id', $pageId);
            })
            ->pluck('title', 'language_id');

        return array_diff_key($languages, $existingLangages->toArray());
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

        foreach ($viewLocations['paths'] as $path)
        {
            if (!$this->File->exists($path))
            {
                continue;
            }

            $files = $this->File->allFiles($path);

            foreach ($files as $file)
            {
                if (substr_count($file->getRelativePathname(), '.blade.php'))
                {
                    $value = str_replace('/', '.', str_replace('.blade.php', '', $file->getRelativePathname()));
                    $nameArr = explode('.', $value);

                    // added in case you have a file directory within the views directory
                    // then you will see a big fat error because there is no index [1] below
                    if (count($nameArr) < 2) continue;

                    $folderName = $nameArr[0];
                    $viewName = $nameArr[1];

                    if (substr($viewName, 0, 1) != '_' && $folderName == 'templates')
                    {
                        $views[$value] = isset($humanNames[$value]) ? $humanNames[$value] : $value;
                    }
                }
            }
        }

        asort($views);

        return $views;
    }

    /**
     * Gets the primary language Url if the page is translated from another page
     *
     * @param  Page $page
     * @return Page
     */
    public function getLocalized($page)
    {
        if ($page !== null)
        {
            $page->translations = [];

            $route = $this->Route->getCurrentRoute();
            $params = ($route) ? $route->parameters() : [];

            $translations = $this->availableLanguagesForPage($page->id, $params);

            foreach ($translations as $key => $value)
            {
                if ($page->language_id === $value['id'])
                {
                    unset($translations[$key]);
                }
            }

            $page->translations = $translations;
        }

        return $page;
    }

    public function getPublishedPages()
    {
        $now = date('Y-m-d H:i:s');
        $site = $this->SiteDetector->current();

        return $this->Page
            ->join('dvs_page_versions', 'dvs_page_versions.page_id', '=', 'dvs_pages.id')
            ->join('dvs_pages as translated_from_page', 'translated_from_page.id', '=', 'dvs_pages.translated_from_page_id', 'left')
            ->where('dvs_pages.slug', 'not like', '%{%')
            ->whereNull('dvs_pages.deleted_at')
            ->whereNull('dvs_page_versions.deleted_at')
            ->where('starts_at', '<', $now)
            ->where(function ($query) use ($now) {
                $query->where('ends_at', '>', $now);
                $query->orWhereNull('ends_at');
            })
            ->where('dvs_pages.site_id', $site->id)
            ->where('dvs_pages.language_id', 1)
            ->select('dvs_pages.*')
            ->orderBy('dvs_pages.slug')
            ->groupBy('dvs_pages.id')
            ->get();
    }
}