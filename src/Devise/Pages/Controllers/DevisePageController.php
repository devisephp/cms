<?php

use Devise\Pages\Repositories\PagesRepository;
use Devise\Pages\Response\ResponseBuilder;

class DevisePageController extends Controller {
    protected $PagesRepository;
    protected $ResponseBuilder;

    /**
     * Creates a new DvsPagesController instance.
     *
     * @param  PagesRepository $PagesRepository
     * @param  ResponseBuilder $ResponseBuilder
     * @return \DevisePageController
     */
    public function __construct(PagesRepository $PagesRepository, ResponseBuilder $ResponseBuilder)
    {
        $this->PagesRepository = $PagesRepository;
        $this->ResponseBuilder = $ResponseBuilder;
    }

	/**
	 * Displays details of a page
	 *
	 * @internal param array $slug
	 * @return Response
	 */
    public function show()
    {
        $page = $this->PagesRepository->findByRouteName( Route::currentRouteName() );

        $localized = $this->PagesRepository->findLocalizedPage($page);

        return $localized ? $this->redirectTo($localized) : $this->ResponseBuilder->retrieve($page);
    }
}