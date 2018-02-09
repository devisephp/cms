<?php namespace Devise\Http\Controllers;

use Devise\Pages\PageData;
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
  public function __construct(PagesRepository $PagesRepository, Framework $Framework)
  {
    $this->PagesRepository = $PagesRepository;

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

    return $localized ? $this->retrieveLocalRedirect($localized) : $this->retrieveResponse($page);
  }

  /**
   * This retrieves a page with all the
   * view's vars set on the response
   *
   * @param \DvsPage $page
   * @return mixed
   */
  public function retrieveResponse($page)
  {
    $route = $this->Route->getCurrentRoute();

    $data['page'] = $page;
    $data['input'] = $this->Request->all();
    $data['params'] = $route ? $route->parameters() : [];

    return $this->getResponse($page);
  }

  /**
   * This retrieves the a redirect for the user's language
   *
   * @param DvsPage $localized
   * @throws PagesException
   */
  public function retrieveLocalRedirect($localized)
  {
    $route = $this->Route->getCurrentRoute();
    $params = $route ? $route->parameters() : [];

    return $this->Redirect->route($localized->route_name, $params);
  }

  /**
   * Gets the response for this page
   *
   * @param \DvsPage $page
   * @return mixed
   * @throws PagesException
   */
  protected function getResponse($page)
  {
    return $this->getView($page);
  }

  /**
   * Gets a view as the response type
   *
   * @param $page
   * @return mixed
   */
  protected function getView($page)
  {
    $page->version->load('slices.slice', 'slices.fields');

    $page->version->registerComponents();

    return $this->View->make($page->version->template->layout, ['page' => $page]);
  }
}
