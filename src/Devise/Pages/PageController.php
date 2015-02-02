<?php namespace Devise\Pages;

/**
 * All pages registered in dvs_pages database table
 * come through this controller show method. The reason
 * for this is so that the database can be in charge of
 * the routes and a non developer can construct new
 * pages with predefined templates in a dropdown selectbox.
 * The templates have already been designed by the developer
 * but new pages can be added easily by the cms administrator.
 */
class PageController extends \Controller
{
    /**
     * Repository for retrieving pages
     *
     * @var PagesRepository
     */
    protected $PagesRepository;

    /**
     * The DataBuilder extracts view vars from the
     * views.php config file for a give page
     *
     * @var Devise\Pages\Viewvars\DataBuilder
     */
    protected $DataBuilder;

    /**
     * Creates a new DvsPagesController instance.
     *
     * @param  PagesRepository $PagesRepository
     * @param  Viewvars\DataBuilder $DataBuilder
     * @param null $Input
     * @param null $View
     * @param null $Route
     * @param null $Redirect
     */
    public function __construct(PagesRepository $PagesRepository, Viewvars\DataBuilder $DataBuilder, $Input = null, $View = null, $Route = null, $Redirect = null)
    {
        $this->PagesRepository = $PagesRepository;
        $this->DataBuilder = $DataBuilder;
        $this->Input = $Input ?: \Input::getFacadeRoot();
        $this->View = $View ?: \View::getFacadeRoot();
        $this->Route = $Route ?: \Route::getFacadeRoot();
        $this->Redirect = $Redirect ?: \Redirect::getFacadeRoot();
    }

	/**
	 * Displays details of a page
	 *
	 * @return Response
	 */
    public function show()
    {
        // what does it mean to be in editing mode? right now it is just when you are logged in
        $editing = !is_null(\Auth::user()); //&& Input::get('editing', false);

        $pageVersionHash = $this->Input->get('page_version_share', null);
        $pageVersionName = $this->Input->get('page_version', null);

        $page = $pageVersionHash
            ? $this->PagesRepository->findByRouteNameAndPreviewHash( $this->Route->currentRouteName(), $pageVersionHash)
            : $this->PagesRepository->findByRouteName( $this->Route->currentRouteName(), $pageVersionName, $editing);

        $localized = $this->PagesRepository->findLocalizedPage($page);

        return $localized ? $this->Redirect->route($localized->route_name) : $this->retrieveResponse($page);
    }

    /**
     * This retrieves a page with all the
     * view's vars set on the response
     *
     * @param \DvsPage $page
     * @throws PagesException
     */
    public function retrieveResponse($page)
    {
        $route = $this->Route->getCurrentRoute();

        $data['page'] = $page;
        $data['input'] = $this->Input->all();
        $data['params'] = $route ? $route->parameters() : [];

        $this->DataBuilder->setData($data);

        return $this->getResponse($page);
    }

    /**
     * Gets the response for this page
     *
     * @param \DvsPage $page
     * @throws PagesException
     */
    protected function getResponse($page)
    {
        if (strtolower($page->response_type) == 'view')
        {
            return $this->getView($page);
        }

        if (strtolower($page->response_type) == 'function')
        {
            return $this->getFunction($page);
        }

        throw new PagesException("Unknown response type [" . $page->response_type . "]");
    }

    /**
     * Get the results from a function as the response type
     *
     * @param \DvsPage $page
     * @return array
     * @throws Viewvars\DeviseRouteConfigurationException
     */
    protected function getFunction($page)
    {
        $config = ($page->response_params != null && $page->response_params != '')
            ? [ $page->response_path => explode(',', $page->response_params) ]
            : $page->response_path;

        if (isset($config[ $page->response_path ]))
        {
            // wrapping params in curly braces
            foreach ($config[ $page->response_path ] as &$param) {
                $param = '{' . $param .'}';
            }
        }

        return $this->DataBuilder->getValue($config);
    }

    /**
     * Gets a view as the response type
     *
     * @param $page
     * @return mixed
     */
    protected function getView($page)
    {
        $pageData = $this->DataBuilder->getData();
        return $this->View->make($page->view, $pageData);
    }
}