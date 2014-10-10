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
        $pageVersions = $this->PagesRepository->getPageVersions($inputData['page_id'], $inputData['page_version_id']);

		return View::make('devise::admin.sidebar.main', compact('data', 'pageVersions', 'availableLanguages', 'pageRoutes'))->render();
	}
}