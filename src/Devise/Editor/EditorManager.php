<?php namespace Devise\Editor;

use Devise\Pages\Repositories\PagesRepository;
use View;

class EditorManager
{
    private $EditorDataTranslator;
    private $PagesRepository;

	public function __construct(EditorDataTranslator $EditorDataTranslator, PagesRepository $PagesRepository)
	{
		$this->EditorDataTranslator = $EditorDataTranslator;
		$this->PagesRepository = $PagesRepository;
	}

	public function fetchPartialView($inputData)
	{
        $data = $this->EditorDataTranslator->translateFromInputArray($inputData);
        $availableLanguages = $this->PagesRepository->availableLanguagesForPage($inputData['page_id']);
        $pageRoutes = $this->PagesRepository->getRouteList();

		return View::make('devise::admin.sidebar.main', compact('data', 'availableLanguages', 'pageRoutes'))->render();
	}
}