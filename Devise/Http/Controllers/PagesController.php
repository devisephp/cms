<?php namespace Devise\Http\Controllers;

use Devise\Pages\PageData;
use Devise\Pages\PagesManager;
use Devise\Pages\PagesRepository;
use Devise\Support\Framework;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * All pages registered in dvs_pages database table
 * come through this controller show method. The reason
 * for this is so that the database can be in charge of
 * the routes and a non developer can construct new
 * pages with predefined templates in a dropdown selectbox.
 * The templates have already been designed by the developer
 * but new pages can be added easily by the cms administrator.
 */
class PagesController extends Controller
{
  protected $PagesRepository;

  private $PagesManager;

  private $Redirect;

  private $View;

  private $Request;

  private $Route;

  /**
   * Creates a new DvsPagesController instance.
   *
   * @param  PagesRepository $PagesRepository
   * @param Framework $Framework
   */
  public function __construct(PagesRepository $PagesRepository, PagesManager $PagesManager, Framework $Framework)
  {
    $this->PagesRepository = $PagesRepository;
    $this->PagesManager = $PagesManager;

    $this->Redirect = $Framework->Redirect;
    $this->View = $Framework->View;
    $this->Request = $Framework->Request;
    $this->Route = $Framework->Route;
  }

  /**
   * Displays details of a page
   *
   * @return Response
   */
  public function show(Request $request)
  {
    // @todo rename var and check user permissions
    $editing = true;

    $pageVersionHash = $this->Request->get('page_version_share', null);
    $pageVersionName = $this->Request->get('page_version', null);

    $page = $pageVersionHash
      ? $this->PagesRepository->findByRouteNameAndPreviewHash($this->Route->currentRouteName(), $pageVersionHash)
      : $this->PagesRepository->findByRouteName($this->Route->currentRouteName(), $pageVersionName, $editing);

    $page = $this->PagesRepository->getTranslatedVersions($page);

    $localized = $this->PagesRepository->findLocalizedPage($page);
    $localized = $this->PagesRepository->getTranslatedVersions($localized);

    if ($localized)
    {
      $route = $this->Route->getCurrentRoute();
      $params = $route ? $route->parameters() : [];

      return $this->Redirect->route($localized->route_name, $params);
    } else
    {
      $page->version->load('slices.slice', 'slices.fields');

      $page->version->registerComponents();

      return $this->View->make($page->version->template->layout, ['page' => $page]);
    }
  }

  /**
   * Request the page listing
   *
   */
  public function requestPageList($input)
  {
    $term = array_get($input, 'term');
    $includeAdmin = array_get($input, 'includeAdmin') == '1' ? true : false;

    return $this->PagesRepository->getPagesList($includeAdmin, $term);
  }

  /**
   * Request a new page be created
   *
   * @param  array $input
   * @return Redirector
   */
  public function store(Request $request)
  {
    $page = $this->PagesManager->createNewPage($request->all());

    if ($page)
    {
      return $this->Redirect->route('dvs-pages')
        ->with('warnings', $this->PagesManager->warnings)
        ->with('message', $this->PagesManager->message);
    }

    return $this->Redirect->route('dvs-pages-create')
      ->withInput()
      ->withErrors($this->PagesManager->errors)
      ->with('message', $this->PagesManager->message);
  }

  /**
   * Request page be updated with given input
   *
   * @param  integer $id
   * @param  array   $input
   * @return Redirector
   */
  public function requestUpdatePage(Request $request, $id)
  {
    $page = $this->PagesManager->updatePage($id, $request->all());

    if ($page)
    {
      return $this->Redirect->route('dvs-pages')
        ->with('warnings', $this->PagesManager->warnings)
        ->with('message', $this->PagesManager->message);
    }

    return $this->Redirect->route('dvs-pages-edit', $id)
      ->withInput()
      ->withErrors($this->PagesManager->errors)
      ->with('message', $this->PagesManager->message);
  }

  /**
   * Request that ab testing be turned on or off
   *
   * @param  [type] $input
   * @return [type]
   */
  public function requestToggleAbTesting(Request $request)
  {
    $input = $request->all();
    $pageId = $input['pageId'];
    $enabled = $input['enabled'];
    $this->PagesManager->toggleABTesting($pageId, $enabled);

    return '';
  }

  /**
   * Request the page be copied to another page (duplicated)
   *
   * @param  integer $id
   * @param  array   $input
   * @return Redirector
   */
  public function requestCopyPage(Request $request, $id)
  {
    $page = $this->PagesManager->copyPage($id, $request->all());

    if ($page)
    {
      return $this->Redirect->route('dvs-pages')
        ->with('warnings', $this->PagesManager->warnings)
        ->with('message', $this->PagesManager->message);
    }

    return $this->Redirect->route('dvs-pages-copy', $id)
      ->withInput()
      ->withErrors($this->PagesManager->errors)
      ->with('message', $this->PagesManager->message);
  }

  /**
   * Request the page be deleted from database
   *
   * @param  integer $id
   * @return Redirector
   */
  public function requestDestroyPage(Request $request, $id)
  {
    $page = $this->PagesManager->destroyPage($id);

    if ($page)
    {
      return $this->Redirect->route('dvs-pages')
        ->with('warnings', $this->PagesManager->warnings)
        ->with('message', $this->PagesManager->message);
    }

    return $this->Redirect->route('dvs-pages')
      ->withInput()
      ->withErrors($this->PagesManager->errors)
      ->with('message', $this->PagesManager->message);
  }
}
