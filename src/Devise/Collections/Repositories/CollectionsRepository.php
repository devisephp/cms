<?php namespace Devise\Collections\Repositories;

use CollectionInstance, CollectionSet, Field, Page, CollectionFields;
use Devise\Collections\Models\CollectionFieldsFactory;

class CollectionsRepository
{
	private $CollectionInstance, $CollectionSet, $Field;

	public function __construct(CollectionInstance $CollectionInstance, CollectionSet $CollectionSet, Field $Field, CollectionFieldsFactory $CollectionFieldsFactory)
	{
		$this->CollectionInstance = $CollectionInstance;
        $this->Field = $Field;
        $this->CollectionSet = $CollectionSet;
        $this->CollectionFieldsFactory = $CollectionFieldsFactory;
	}

	public function getInstances($pageId, $collectionSetId)
	{
		return $this->CollectionInstance
                    ->where('page_id', '=', $pageId)
                    ->where('collection_set_id', '=', $collectionSetId)
                    ->orderBy('sort')
                    ->get();
	}

    /**
     * Get the list of collections for this page
     *
     * @param  Page $page
     * @return array($collectionName => array(CollectionFields))
     */
    public function findCollectionsForPage(Page $page)
    {
    	$collections = array();

    	// get a list of instances for this page
        // we order it by sort so that they are in order in our $collections array already
        $collectionInstances = $page->collectionInstances()->with('collectionSet')->orderBy('sort', 'ASC')->get();

        // loop over the instances and add it to the collections array
        foreach ($collectionInstances as $index => $collectionInstance)
        {
            // we want to add a dynamically created key name to the instance?
            $keyName = ($index + 1) . ') ' .$collectionInstance->name;

            // make this an array if it is not already set
            $collections[$collectionInstance->collectionSet->name] = isset($collections[$collectionInstance->collectionSet->name]) ? $collections[$collectionInstance->collectionSet->name] : [];

            // add these collection fields to this array
            $collections[$collectionInstance->collectionSet->name][] = $this->CollectionFieldsFactory->createFromCollectionInstance($collectionInstance);
        }

        return $collections;
    }
}