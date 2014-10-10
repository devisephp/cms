<?php namespace Devise\Pages\Response;

use Devise\Collections\Repositories\CollectionsRepository;
use Devise\Pages\Data\DataBuilder;
use Devise\Pages\Exceptions\PagesException;
use Input;
use Route;
use View;
use CollectionSet;
use Field;
use stdClass;

class ResponseBuilder
{
    private $DataBuilder;
    private $CollectionSet;
    private $page;

    public function __construct(DataBuilder $DataBuilder, CollectionSet $CollectionSet, CollectionsRepository $CollectionsRepository)
    {
        $this->DataBuilder = $DataBuilder;
        $this->CollectionSet = $CollectionSet;
        $this->CollectionsRepository = $CollectionsRepository;
    }

    public function retrieve($page)
    {
        $this->page = $page;

        $data['page'] = $this->page;
        $data['input'] = Input::all();
        $data['params'] = Route::getCurrentRoute()->parameters();
        $this->DataBuilder->setData($data);

        return $this->getResponse();
    }

    private function getResponse()
    {
        $functionName = 'get' . $this->page->response_type;
        if(method_exists($this, $functionName)){
            return $this->$functionName();
        } else {
            throw new PagesException("Unknown response type [" . $this->page->response_type . "]");
        }
    }

    private function getFunction()
    {
        if($this->page->response_params != null && $this->page->response_params != ''){
            $config = array(
                $this->page->response_path => explode(',', $this->page->response_params)
            );
        } else {
            $config = $this->page->response_path;
        }

        return $this->DataBuilder->getValue($config);
    }

    private function getView()
    {
        $pageData = $this->DataBuilder->getData();
        $this->injectCollections($pageData);

        return View::make($this->page->view, $pageData);
    }

    /*
    * the following need a better home. writing in full panic mode lol!
    * injecting the related collections into the page data
    */
    private function injectCollections(&$pageData)
    {
        $collections = $this->CollectionsRepository->findCollectionsForPageVersion($this->page->version);

        foreach ($collections as $collectionName => $collectionData)
        {
            $pageData[$collectionName] = $collectionData;
        }
    }
}