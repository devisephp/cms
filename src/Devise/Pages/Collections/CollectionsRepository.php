<?php namespace Devise\Pages\Collections;

use Illuminate\Support\Collection;

/**
 * Retreives collection instances and sets and fields for us.
 * This class is used in many places to retreieve collection
 * data from the database.
 *
 */
class CollectionsRepository
{
    /**
     * DvsCollectionInstance model
     *
     * @var DvsCollectionInstance
     */
	private $CollectionInstance;

    /**
     * DvsCollectionSet model
     *
     * @var DvsCollectionSet
     */
    private $CollectionSet;

    /**
     * DvsField model
     *
     * @var DvsField
     */
    private $Field;

    /**
     * DvsPageVersion model
     *
     * @var DvsPageVersion
     */
    private $PageVersion;

    /**
     * Collection fields factory creates
     * new collection field objects for us
     *
     * @var CollectionFieldsFactory
     */
    private $CollectionFieldsFactory;

    /**
     * Construct a new repository with all the dependencies
     *
     * @param DvsCollectionInstance   $CollectionInstance
     * @param DvsCollectionSet        $CollectionSet
     * @param DvsField                $Field
     * @param CollectionFieldsFactory $CollectionFieldsFactory
     * @param DvsPageVersion          $PageVersion
     */
	public function __construct(\DvsCollectionInstance $CollectionInstance, \DvsCollectionSet $CollectionSet, \DvsField $Field, \DvsPageVersion $PageVersion, CollectionFieldsFactory $CollectionFieldsFactory)
	{
		$this->CollectionInstance = $CollectionInstance;
        $this->Field = $Field;
        $this->CollectionSet = $CollectionSet;
        $this->CollectionFieldsFactory = $CollectionFieldsFactory;
        $this->PageVersion = $PageVersion;
	}

    /**
     * This is used by the /admin/pages/{pageVersionId}/collections/{collectionSetId}/instances slug
     *
     * @param  int $pageVersionId
     * @param  int $collectionSetId
     * @return EloquentCollection[CollectionInstance]
     */
	public function getInstances($pageVersionId, $collectionSetId)
	{
		return $this->CollectionInstance
            ->with('fields')
            ->where('page_version_id', '=', $pageVersionId)
            ->where('collection_set_id', '=', $collectionSetId)
            ->orderBy('sort')
            ->get();
	}

    /**
     * When we only have the pageVersionId we can use this function
     * as a proxy to findCollectionsForPageVersion
     *
     * @param  int $pageVersionId
     * @return array
     */
    public function findCollectionsForPageVersionId($pageVersionId)
    {
        return $this->findCollectionsForPageVersion($this->PageVersion->findOrFail($pageVersionId));
    }

    /**
     * Get the list of collections for this page
     *
     * @param  DvsPageVersion $page
     * @return array($collectionName => array(CollectionFields))
     */
    public function findCollectionsForPageVersion(\DvsPageVersion $pageVersion)
    {
    	$collections = array();

    	// get a list of instances for this page
        // we order it by sort so that they are in order in our $collections array already
        $collectionInstances = $pageVersion->collectionInstances()->with('collectionSet')->orderBy('sort', 'ASC')->get();

        // loop over the instances and add it to the collections array
        foreach ($collectionInstances as $index => $collectionInstance)
        {
            // we want to add a dynamically created key name to the instance?
            // not being used in this context as far as I know of... but I'm
            // leaving this here just in case we need to bring it back at some point
            // $keyName = ($index + 1) . ') ' .$collectionInstance->name;
            $keyName = $collectionInstance->collectionSet->name;

            // make this an array if it is not already set
            $collections[] = isset($collections[$keyName]) ? $collections[$keyName] : [];

            // add these collection fields to this array
            $collections[$keyName][] = $this->CollectionFieldsFactory->createFromCollectionInstance($collectionInstance);
        }

        // put these instances into a Laravel collection
        foreach ($collections as $keyName => $collectionInstances)
        {
            $collections[$keyName] = new Collection($collectionInstances);
        }

        return $collections;
    }

    /**
     * Get the instances + fields for this collection set / page_version combo
     *
     * @param  int $collectionSetId
     * @param  int $pageVersionId
     * @return EloquentCollection[CollectionInstance]
     */
    public function findCollectionInstancesForCollectionSetIdAndPageVersionId($collectionSetId, $pageVersionId)
    {
        return $this->CollectionInstance
            ->with('fields')
            ->where('collection_set_id', $collectionSetId)
            ->where('page_version_id', $pageVersionId)
            ->orderBy('sort', 'ASC')
            ->get();
    }
}