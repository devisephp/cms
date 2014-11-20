<?php namespace Devise\Editor;

use Devise\Pages\Repositories\PagesRepository;
use Devise\Fields\Repositories\FieldsRepository;
use View;

class EditorManager
{
    private $EditorDataTranslator;
    private $PagesRepository;
    private $FieldsRepository;

	public function __construct(EditorDataTranslator $EditorDataTranslator, PagesRepository $PagesRepository, FieldsRepository $FieldsRepository)
	{
		$this->EditorDataTranslator = $EditorDataTranslator;
		$this->PagesRepository = $PagesRepository;
		$this->FieldsRepository = $FieldsRepository;
	}

	public function fetchPartialView($inputData)
	{
        $data = $this->EditorDataTranslator->translateFromInputArray($inputData);
        $availableLanguages = $this->PagesRepository->availableLanguagesForPage($inputData['page_id']);
        $pageRoutes = $this->PagesRepository->getRouteList();
        $pageVersions = $this->PagesRepository->getPageVersions($inputData['page_id'], $inputData['page_version_id']);

		return View::make('devise::admin.sidebar.main', compact('data', 'pageVersions', 'availableLanguages', 'pageRoutes'))->render();
	}

    public function fetchElementView($inputData)
    {
        $element = $this->FieldsRepository->findFieldById($inputData['field_id']);
        $pageRoutes = $this->PagesRepository->getRouteList();
        return View::make('devise::admin.sidebar._'.$element->type, compact('element','pageRoutes'))->render();
    }

	public function fetchElementGridView($inputData)
	{
        $data = $this->EditorDataTranslator->translateFromInputArray($inputData);
		return View::make('devise::admin.sidebar._sidebar-elements-grid', compact('data'))->render();
	}
}