<?php namespace Devise\Pages\Response;

use Devise\Pages\Data\DataBuilder;
use Devise\Pages\Exceptions\PagesException;
use Input;
use Route;
use View;
use CollectionSet;
use FieldVersion;
use Field;
use stdClass;
class ResponseBuilder {
    private $DataBuilder;
    private $CollectionSet;
    private $page;

    public function __construct(DataBuilder $DataBuilder, CollectionSet $CollectionSet)
    {
        $this->DataBuilder = $DataBuilder;
        $this->CollectionSet = $CollectionSet;
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
        $collectionIds = $this->page->collectionFields()->lists('collection_set_id');

        if(count($collectionIds)){
            $pageCollections = $this->CollectionSet
                                    ->with(array(
                                        'instances' => function($query) use ($pageData) {
                                            $query->where('page_id', $pageData['page']->id);
                                        }
                                    ))
                                    ->whereIn('id', $collectionIds)
                                    ->get();
            foreach ($pageCollections as $collection) {
                if(count($collection->instances)){
                    foreach ($collection->instances as $instance) {
                        $data = new stdClass();
                        $fields = Field::with(array('latestPublishedVersion' => function($query) use ($instance){
                            $query->where('collection_instance_id','=',$instance->id);
                        }))
                        ->where('collection_set_id', '=', $collection->id)
                        ->where('page_id','=',$pageData['page']->id)
                        ->get();


                        foreach ($fields as $field) {
                            $fieldName = $field->key;
                            $data->$fieldName = $field;
                        }

                        $pageData[ $collection->name ][] = $data;
                    }
                }
            }
        }
    }
}