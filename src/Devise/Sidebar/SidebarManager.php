<?php namespace Devise\Sidebar;

use View;
use Devise\Pages\PagesRepository;
use Devise\Pages\Fields\FieldsRepository;

/**
 * Class SidebarManager fetches the partial sidebar view
 * for the given input data
 *
 * @package Devise\Sidebar
 */
class SidebarManager
{
    /**
     * @var SidebarDataTranslator
     */
    private $SidebarDataTranslator;

    /**
     * @var PagesRepository
     */
    private $PagesRepository;

    /**
     * @var FieldsRepository
     */
    private $FieldsRepository;

    /**
     * Create a new sidebar manager
     *
     * @param SidebarDataTranslator $SidebarDataTranslator
     * @param PagesRepository $PagesRepository
     * @param FieldsRepository  [varname] [description]
     */
	public function __construct(SidebarDataTranslator $SidebarDataTranslator, PagesRepository $PagesRepository, FieldsRepository $FieldsRepository, $View = null)
	{
		$this->SidebarDataTranslator = $SidebarDataTranslator;
		$this->PagesRepository = $PagesRepository;
        $this->FieldsRepository = $FieldsRepository;
        $this->View = $View ?: \View::getFacadeRoot();
	}

    /**
     * Fetches the corresponding html views for this sidebar from the input data
     *
     * @param $inputData
     * @return mixed
     */
	public function fetchPartialView($inputData)
	{
        $data = $this->SidebarDataTranslator->translateFromInputArray($inputData);
        $availableLanguages = $this->PagesRepository->availableLanguagesForPage($inputData['page_id']);
        $pageRoutes = $this->PagesRepository->getRouteList();
        $pageVersions = $this->PagesRepository->getPageVersions($inputData['page_id'], $inputData['page_version_id']);

		return $this->View->make('devise::admin.sidebar.main', compact('data', 'pageVersions', 'availableLanguages', 'pageRoutes'))->render();
	}

    /**
     * Fetches the sidebar form for this specific type of element
     *
     * @param  array $inputData
     * @return view
     */
    public function fetchElementView($inputData)
    {
        $fieldId = array_get($inputData, 'field_id');
        $fieldScope = array_get($inputData, 'field_scope', 'page');
        $element = $this->FieldsRepository->findFieldByIdAndScope($fieldId, $fieldScope);
        $pageRoutes = $this->PagesRepository->getRouteList();
        return $this->View->make('devise::admin.sidebar._'.$element->type, compact('element','pageRoutes'))->render();
    }

    /**
     * Fetches the grid of items that lists all the elements we can
     * click on and bring up the edit form for
     *
     * @param  array $inputData
     * @return view
     */
    public function fetchElementGridView($inputData)
    {
        $data = $this->SidebarDataTranslator->translateFromInputArray($inputData);
        return $this->View->make('devise::admin.sidebar._sidebar-elements-grid', compact('data'))->render();
    }
}