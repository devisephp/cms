<?php namespace Devise\Pages;

use Devise\Languages\LanguageDetector;
use Devise\Pages\Collections\CollectionsRepository;
use Devise\Pages\Interpreter\ViewOpener;
use Devise\Models\DvsPage;
use Devise\Support\Framework;

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
   * @param DvsPage $Page
   * @param LanguageDetector $LanguageDetector
   * @param Framework $Framework
   */
  public function __construct(DvsPage $Page, LanguageDetector $LanguageDetector, Framework $Framework)
  {
    $this->Page = $Page;
    $this->LanguageDetector = $LanguageDetector;

    $this->Config = $Framework->Config;
    $this->URL = $Framework->URL;
    $this->File = $Framework->File;
    $this->Request = $Framework->Request;
    $this->Cookie = $Framework->Cookie;
    $this->Route = $Framework->Route;

    $this->now = new \DateTime;
  }

  /**
   * finds a record by it's id
   *
   * @param  int $id
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

//        $page = $this->wrapFieldsAroundPage($page, $page->version);

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
//            $page = $this->wrapFieldsAroundPage($page, $page->version);
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
   * Find the page variables for this given page
   *
   * @param  [type] $page
   * @return [type]
   */
  public function findTemplateVariables($templates)
  {
    $variables = [];
    $templates = is_array($templates) ? $templates : array($templates);
    $config = $this->Config->get('devise.templates');

    foreach ($templates as $template)
    {
      $templateConfig = isset($config[$template]) ? $config[$template] : [];
      $templateVars = isset($templateConfig['vars']) ? array_keys($templateConfig['vars']) : [];
      $variables = array_merge($variables, $templateVars);
    }

    return $variables;
  }

  /**
   * Find the page templates for this given page
   *
   * @param  [type] $page
   * @return [type]
   */
  public function findPageTemplates($page)
  {
    $templates = [];

    $view = $page->view;
    $config = $this->Config->get('devise.templates');
    $config = isset($config[$view]) ? $config[$view] : [];
    $extends = isset($config['extends']) ? $config['extends'] : null;

    if ($view) $templates[] = $view;
    if ($extends) $templates[] = $extends;

    $templates = array_merge($templates, $this->ViewOpener->findAllIncludedViews($view));

    return $templates;
  }

  /**
   * Finds lots of pages in the system that
   * are not admin pages and belong to the current language
   *
   * @return DvsPage
   */
  public function pages()
  {
    $languageId = $this->Request->get('language_id', $this->Config->get('devise.languages.primary_language_id'));

    $showAdmin = $this->Request->get('show_admin', false);

    $pages = $this->Page->where('response_type', 'View')->where('language_id', $languageId);

    if ($showAdmin !== 'true')
    {
      $pages = $pages->where('dvs_admin', '<>', 1)->where('is_admin', '<>', 1);
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
    $primaryLanguageId = $this->Config->get('devise.languages.primary_language_id');
    $routes = $this->Page->where('dvs_admin', '<>', 1)->where('language_id', $primaryLanguageId)->orderBy('slug')->get();
    $list = array();
    $slugName = null;

    foreach ($routes as $route)
    {
      $arr = explode('/', $route->slug);
      array_pop($arr);
      $routeName = implode(' ', $arr);

      if ($routeName != $slugName && $routeName != '')
      {
        $slugName = ucwords($routeName);
        $list[$slugName][$route->route_name] = $route->title;
      } else
      {
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
    if ($page->ab_testing_enabled) return $this->getLivePageVersionByAB($page);

    return $this->getLivePageVersionByDate($page);
  }

  /**
   * Gets the live version of this page by date
   *
   * @param  [type] $page
   * @return [type]
   */
  public function getLivePageVersionByDate($page)
  {
    $now = $this->now;

    $version = $page->versions()
      ->where('starts_at', '<', $now)
      ->where(function ($query) use ($now) {
        $query->where('ends_at', '>', $now);
        $query->orWhereNull('ends_at');
      })
      ->orderBy('starts_at', 'DESC')
      ->first();

    return $version;
  }

  /**
   * Get the live version of this page by id
   *
   * @param  [type] $page
   * @param  [type] $pageVersionId
   * @return [type]
   */
  public function getLivePageVersionById($page, $pageVersionId)
  {
    $now = $this->now;

    $version = $page->versions()
      ->where('starts_at', '<', $now)
      ->where(function ($query) use ($now) {
        $query->where('ends_at', '>', $now);
        $query->orWhereNull('ends_at');
      })
      ->where('id', '=', $pageVersionId)
      ->orderBy('starts_at', 'DESC');

    if ($page->ab_testing_enabled)
    {
      $version = $version->where('ab_testing_amount', '>', 0);
    }

    return $version->first();
  }

  /**
   * Checks to see if the page already has a cookie
   * set so this user doesn't see different page
   * versions all the time...
   *
   * @param  [type] $page
   * @return [type]
   */
  public function getLivePageVersionByCookie($page)
  {
    $pageVersionId = $this->Request->cookie('dvs-ab-testing-' . $page->id);

    if (!$pageVersionId) return null;

    $liveVersion = $this->getLivePageVersionById($page, $pageVersionId);

    if ($liveVersion) return $liveVersion;

    return null;
  }

  /**
   * Get the live page using ab testing logic. This
   * will first search for a cookie and if no version is
   * found it will use the dice roll. If no page version
   * is found with this dice roll then it will resort
   * back to using the old "dates" system.
   *
   * @param  [type] $page
   * @return [type]
   */
  public function getLivePageVersionByAB($page)
  {
    $liveVersion = $this->getLivePageVersionByCookie($page);

    if ($liveVersion) return $liveVersion;

    $liveVersion = $this->getLivePageVersionByDiceRoll($page);

    if ($liveVersion) return $liveVersion;

    return $this->getLivePageVersionByDate($page);
  }

  /**
   * Gets the live page version by a dice roll
   *
   * @param  [type] $page
   * @return [type]
   */
  public function getLivePageVersionByDiceRoll($page)
  {
    $liveVersion = null;

    $versions = $this->getPageVersionsByAB($page);

    $diceroll = array();

    foreach ($versions as $index => $version)
    {
      $diceroll = array_merge(array_fill(0, $version->ab_testing_amount, $index), $diceroll);
    }

    if (count($diceroll) == 0) return null;

    $diceroll = $diceroll[array_rand($diceroll)];

    if (isset($versions[$diceroll]))
    {
      $liveVersion = $versions[$diceroll];
      $this->Cookie->queue('dvs-ab-testing-' . $page->id, $liveVersion->id);
    }

    return $liveVersion;
  }

  /**
   * Gets all live page versions when we are
   * in a A|B testing mode for a page
   *
   * @param  [type] $page
   * @return [type]
   */
  public function getPageVersionsByAB($page)
  {
    $now = $this->now;

    $versions = $page->versions()
      ->where('ab_testing_amount', '>', 0)
      ->where('starts_at', '<', $now)
      ->where(function ($query) use ($now) {
        $query->where('ends_at', '>', $now);
        $query->orWhereNull('ends_at');
      })
      ->orderBy('starts_at', 'DESC')
      ->get();

    return $versions;
  }

  /**
   * Gets the page version by name
   *
   * @param  Page $page
   * @param  string $versionName
   * @return PageVersion
   */
  public function getPageVersionByName($page, $versionName)
  {
    return $page->versions()->whereName($versionName)->first();
  }

  /**
   * Gets a list of pages in array format probably used for
   * drop down boxes.
   *
   * @param  boolean $includeAdmin
   * @param  string $search
   * @return array
   */
  public function getPagesList($includeAdmin = false, $search = null)
  {
    $pages = $this->Page->with('language');

    if ($search != null)
    {
      $pages = $pages->where('title', 'LIKE', '%' . $search . '%');
    }

    if (!$includeAdmin)
    {
      $pages = $pages->where('is_admin', '=', 0)->where('dvs_admin', '=', 0);
    }

    $pageCollection = $pages->get();

    $pageList = array();
    foreach ($pageCollection as $page)
    {
      $pageList[$page->id] = $page->title . ' (' . $page->language->code . ')';
    }

    return $pageList;
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

  /*
   * Gets the page version by a hash
   *
   * @param  Page   $page
   * @param  string $previewHash
   * @return PageVersion
   */
  protected function getPageVersionByPreviewHash($page, $previewHash)
  {
    return $page->versions()->wherePreviewHash($previewHash)->first();
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

    // loading primary language if language cannot be detected
    $languageId = ($language) ? $language->id : $this->Config->get('devise.primary_language_id.primary_language_id');

    $globalFields = $this->GlobalField->where('language_id', $languageId)->get();

    $page = $this->wrapTheseFieldsAroundThisPage($globalFields, $page);

    $page = $this->wrapTheseFieldsAroundThisPage($pageVersion->fields, $page);

    $page = $this->wrapTheseCollectionsAroundThisPage($this->CollectionsRepository->findCollectionsForPageVersion($pageVersion), $page);

    return $page;
  }

  /**
   * Gets the primary language Url if the page is translated from another page
   *
   * @param  Page $page
   * @return Page
   */
  public function getTranslatedVersions($page)
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
      $this->updateUrlsInField($field);
      $page->{$field->key} = $field->value;
    }

    return $page;
  }

  /**
   * [updateUrlsInField description]
   * @param  [type] $field
   * @return [type]
   */
  protected function updateUrlsInField($field)
  {
    if (isset($field->value->route) && $field->value->route !== '')
    {
      if (!isset($field->value->url) || $field->value->url == '')
      {
        $field->value->merge(['url' => dvspage($field->value->route)]);
      }
    }
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
      foreach ($collection as $fields)
      {
        foreach ($fields as $field)
        {
          $this->updateUrlsInField($field);
        }
      }

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
      if (!$page->slugHasParameters)
      {
        $page->availableLanguages = $this->availableLanguagesForPage($page->id);
      }
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
    if ($page->ab_testing_enabled && count($this->getPageVersionsByAB($page)) > 0) return $this->wrapPageVersionStatusesByAB($versions, $page);

    return $this->wrapPageVersionStatusesByDate($versions, $page);
  }

  /**
   * [wrapPageVersionStatusesByDate description]
   * @param  [type] $versions
   * @param  [type] $page
   * @return [type]
   */
  protected function wrapPageVersionStatusesByDate($versions, $page)
  {
    $page->status = 'unpublished';

    $liveVersion = $this->getLivePageVersionByDate($page);

    foreach ($versions as $version)
    {
      $version = $this->wrapPageVersionStatusByDate($version, $page, $liveVersion);
    }

    return $versions;
  }

  /**
   * Wraps AB Page Version Statuses on all versions for the page
   *
   * @param  [type] $versions
   * @param  [type] $page
   * @return [type]
   */
  protected function wrapPageVersionStatusesByAB($versions, $page)
  {
    $page->status = 'unpublished';

    $liveVersions = $this->getPageVersionsByAB($page);

    foreach ($versions as $version)
    {
      $version = $this->wrapPageVersionStatusByAB($version, $page, $liveVersions);
    }

    $avg = array_sum($versions->pluck('ab_testing_amount')->toArray());

    foreach ($versions as $version)
    {
      $version->ab_percentage_shown = $avg > 0 ? round($version->ab_testing_amount / $avg, 2) * 100 : 0;
    }

    return $versions;
  }

  /**
   * Wrap the status around a single page version
   *
   * @param  [type] $version
   * @param  [type] $page
   * @param  [type] $liveVersions
   * @return [type]
   */
  protected function wrapPageVersionStatusByAB($version, $page, $liveVersions)
  {
    $startsAt = $version->starts_at;
    $endsAt = $version->ends_at;

    $version->starts_at_human = $version->starts_at ? $this->toHumanDateFormat($version->starts_at) : 'never starts';
    $version->ends_at_human = $version->ends_at ? $this->toHumanDateFormat($version->ends_at) : 'never ends';

    $liveVersionIds = $liveVersions->pluck('id')->toArray();

    // the current version is live
    if (in_array($version->id, $liveVersionIds))
    {
      $page->status = 'live';
      $version->status = "live";

      return $version;
    }

    // if version has a starts_at date scheduled
    if ($startsAt && $startsAt > $this->now)
    {
      $version->status = 'scheduled';

      return $version;
    }

    $version->status = "unpublished";

    return $version;
  }

  /**
   * Wraps the status around a single page version
   *
   * @param  DvsPageVersion $version
   * @param  DvsPage $page
   * @param  DvsPageVersion $liveVersion
   * @return DvsPageVersion
   */
  protected function wrapPageVersionStatusByDate($version, $page, $liveVersion)
  {
    // sometimes we don't have a current version
    // like when a page is completely unpublished!
    if (is_null($liveVersion))
    {
      $liveVersion = new \StdClass;
      $liveVersion->id = -1;
    }

    $now = new \DateTime;
    $startsAt = $version->starts_at;
    $endsAt = $version->ends_at;

    $version->starts_at_human = $version->starts_at ? $this->toHumanDateFormat($version->starts_at) : 'never starts';
    $version->ends_at_human = $version->ends_at ? $this->toHumanDateFormat($version->ends_at) : 'never ends';

    // the current version is live
    if ($version->id == $liveVersion->id)
    {
      $page->status = 'live';
      $version->status = "live";

      return $version;
    }

    // if the version is overriden b/c it has started and has not finished but is not live version
    if ($version->id != $liveVersion->id && $startsAt && $startsAt < $now && ($endsAt > $now || is_null($endsAt)))
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
