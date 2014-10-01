<?php namespace Devise\Collections\Response;

use Devise\Collections\CollectionsManager;
use Illuminate\Support\Facades\Input;

class ResponseHandler {

    private $CollectionsManager;

    function __construct(CollectionsManager $CollectionsManager)
    {
        $this->CollectionsManager = $CollectionsManager;
    }

    public function requestStoreInstance($pageId, $collectionSetId, $input) {

	    $data = array(
            'collection_set_id' => $collectionSetId,
		    'page_id' => $pageId,
            'sort' => $input['sort'],
		    'name' => $input['name']
	    );

	    $instance = $this->CollectionsManager->createNewInstance($data);

        if ($instance) {
            return $instance;
        } else {
            return false;
        }
    }

	public function updateSortOrder($pageId, $collectionSetId, $input) {
		foreach ($input['instance'] as $i => $id) {

			$data = array(
				'id' => $id,
				'sort' => $i+1,
			);

			$this->CollectionsManager->updateInstance($data);
		}

		return $input;
	}

	public function renameInstance($pageId, $collectionInstanceId, $input) {
		$data = array(
			'id' => $collectionInstanceId,
			'name' => $input['name']
		);

		$this->CollectionsManager->updateInstanceName($data);
	}

	public function requestDeleteInstance($collectionInstanceId) {

		$this->CollectionsManager->removeInstance($collectionInstanceId);

	}

} 