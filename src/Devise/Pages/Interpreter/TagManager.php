<?php namespace Devise\Pages\Interpreter;

use Devise\Pages\Models\ModelMapper;
use Devise\Pages\Collections\CollectionsRepository;
use Devise\Pages\Interpreter\Exceptions\PageDataNotInitializedException;

/**
 * Create and find tags in the database. A tag could be a model, field,
 * attribute, model creator or collection
 *
 */
class TagManager
{
	/**
	 * Dvs Field model
	 * @var DvsField
	 */
	protected $DvsField;

	/**
	 * Dvs Global Field model
	 * @var DvsGlobalField
	 */
	protected $DvsGlobalField;

	/**
	 * Dvs Collection Set model
	 * @var DvsCollectionSet
	 */
	protected $DvsCollectionSet;

	/**
	 * Dvs Model Field model
	 * @var DvsModelField
	 */
	protected $DvsModelField;

	/**
	 * Collections Repository to fiddle with
	 * collections
	 *
	 * @var CollectionsRepository
	 */
	protected $CollectionsRepository;

	/**
	 * Model mapper handles creating DvsModelField
	 * @var ModelMapper
	 */
	protected $ModelMapper;

	/**
	 * Page id
	 * @var integer
	 */
	protected $pageId;

	/**
	 * Page version id
	 * @var integer
	 */
	protected $pageVersionId;

	/**
	 * Language id
	 * @var integer
	 */
	protected $languageId;

	/**
	 * Create a new tag manager
	 *
	 * @param \DvsField             $DvsField
	 * @param \DvsGlobalField       $DvsGlobalField
	 * @param \DvsCollectionSet     $DvsCollectionSet
	 * @param \DvsModelField        $DvsModelField
	 * @param CollectionsRepository $CollectionsRepository
	 * @param ModelMapper           $ModelMapper
	 */
	public function __construct(\DvsField $DvsField, \DvsGlobalField $DvsGlobalField, \DvsCollectionSet $DvsCollectionSet, \DvsModelField $DvsModelField, CollectionsRepository $CollectionsRepository, ModelMapper $ModelMapper)
	{
		$this->DvsField = $DvsField;
		$this->DvsGlobalField = $DvsGlobalField;
		$this->DvsCollectionSet = $DvsCollectionSet;
		$this->DvsModelField = $DvsModelField;
		$this->CollectionsRepository = $CollectionsRepository;
		$this->ModelMapper = $ModelMapper;
	}

	/**
	 * Initializes values for our tag manager
	 *
	 * @param  integer $pageId
	 * @param  integer $pageVersionId
	 * @param  integer $languageId
	 * @return void
	 */
	public function initialize($pageId, $pageVersionId, $languageId)
	{
		$this->pageId = $pageId;
		$this->pageVersionId = $pageVersionId;
		$this->languageId = $languageId;
	}

	/**
	 * Find this tag in the database
	 *
	 * @param  array $tag
	 * @return DvsField | DvsCollection | DvsModelField | DvsGlobalField
	 */
	public function getInstanceForTag($tag)
	{
		$this->assertInitialized();

		$binding = 'getInstanceFor' . ucfirst($tag['bindingType']);

		return $this->{$binding}($tag);
	}

	/**
	 * Find this field in database
	 *
	 * @param   $tag
	 * @return DvsField | DvsGlobalField
	 */
	protected function getInstanceForField($tag)
	{
		$field = $this->findField($tag);

		$field = $field ?: $this->findGlobalField($tag);

		$field = $field ?: $this->restoreFieldInstance($tag);

		$field = $field ?: $this->createFieldInstance($tag);

		$field = $this->updateInstance($field, ['type' => $tag['type'], 'human_name' => $tag['humanName']]);

		$field->scope = $field->scope;

		return $field;
	}

	/**
	 * Get the instance of a collection. This is
	 * the CollectionSet with  all instances attached
	 *
	 * @param  array $tag
	 * @return DvsCollectionSet
	 */
	protected function getInstanceForCollection($tag)
	{
		$collectionSet = $this->DvsCollectionSet->newInstance()->where('name', $tag['collection'])->first();

		$collectionSet = $collectionSet ?: $this->createCollectionSet($tag);

		//$colelctionSet->collectionInstances = $this->CollectionsRepository->findCollectionInstancesForCollectionSetIdAndPageVersionId($collectionSet->id, $this->pageVersionId);

		return $collectionSet;
	}

	/**
	 * Get the instance for a model in this tag
	 *
	 * @param  array $tag
	 * @return DvsModelField
	 */
	protected function getInstanceForModel($tag)
	{
		$fields = $this->DvsModelField
			->newInstance()
			->where('model_id', $tag['key'])
			->where('model_type', $tag['type'])
			->get();

		$model = count($fields) > 0 ? $fields[0]->model : null;

		foreach ($fields as $field)
		{
			$field->syncValuesWithModelValues($model);
		}

		return $fields;
	}

	/**
	 * Get the instance for a model attribute in this tag
	 *
	 * @param  array $tag
	 * @return DvsModelField
	 */
	protected function getInstanceForAttribute($tag)
	{
		$fields = $this->DvsModelField
			->newInstance()
			->where('model_id', $tag['key'])
			->where('model_type', $tag['type'])
			->get();

		$field = $this->filterModelFieldByAttribute($fields, $tag['attribute']);

		$field->syncValuesWithModelValues();

		return $field;
	}

	/**
	 * There is no database instance for creators...
	 * this doesn't really make sense, but it is here
	 * for the sake of consistency, since all the other
	 * tag types have database stuff
	 *
	 * @param  array $tag
	 * @return StdClass
	 */
	protected function getInstanceForCreator($tag)
	{
		$creator = new \StdClass;

		$creator->id = $tag['id'];

		return $creator;
	}

	/**
	 * Find the field in the database
	 *
	 * @param  array $tag
	 * @return DvsField
	 */
	protected function findField($tag)
	{
		return $this->DvsField
			->newInstance()
			->where('key', $tag['key'])
			->where('collection_instance_id', null)
			->where('page_version_id', $this->pageVersionId)
			->first();
	}

	/**
	 * Finds a global field for this tag
	 *
	 * @param  array $tag
	 * @return DvsGlobalField
	 */
	protected function findGlobalField($tag)
	{
		return $this->DvsGlobalField
			->newInstance()
			->where('key', $tag['key'])
			->where('language_id', $this->languageId)
			->first();
	}

	/**
	 * If there is a field instance that has been
	 * deleted, then we restore it cuz we need it
	 * again
	 *
	 * @param  array $tag
	 * @return DvsField
	 */
	protected function restoreFieldInstance($tag)
	{
		$field = $this->DvsField
			->newInstance()
			->onlyTrashed()
			->where('key', $tag['key'])
			->where('collection_instance_id', null)
			->where('page_version_id', $this->pageVersionId)
			->first();

		if ($field) $field->restore();

		return $field;
	}

	/**
	 * Create a new field instance
	 *
	 * @param  array $tag
	 * @return DvsField
	 */
	protected function createFieldInstance($tag)
	{
		$field = $this->DvsField->newInstance();

		$field->collection_instance_id = null;
		$field->page_version_id = $this->pageVersionId;
		$field->type = $tag['type'];
		$field->human_name = $tag['humanName'];
		$field->key = $tag['key'];
		$field->json_value = $tag['defaults'] ?: '{}';
		$field->content_requested = false;
		$field->save();

		return $field;
	}

	/**
	 * Create a collection set from this tag
	 *
	 * @param  array $tag
	 * @return DvsCollectionSet
	 */
	protected function createCollectionSet($tag)
	{
		$collectionSet = $this->DvsCollectionSet->newInstance();

		$collectionSet->name = $tag['collection'];

		$collectionSet->save();

		return $collectionSet;
	}

	/**
	 * Updates an instance with the fields given
	 * but only if the field values are different
	 * than what is already in the database
	 *
	 * @param  Eloquent $instance
	 * @param  array	$fields
	 * @return void
	 */
	protected function updateInstance($instance, $fields)
	{
		$changed = false;

		foreach ($fields as $field => $value)
		{
			if ($instance->{$field} != $value)
			{
				$changed = true;
				$instance->{$field} = $value;
			}
		}

		if ($changed) $instance->save();

		return $instance;
	}

	/**
	 * Filters out the attribute from this model field
	 *
	 * @param  Collection 	  $modelField
	 * @param  string 		  $attribute
	 * @return DvsModelField
	 */
	protected function filterModelFieldByAttribute($modelFields, $attribute)
	{
		foreach ($modelFields as $modelField)
		{
			if (array_key_exists($attribute, $modelField->picks))
			{
				return $modelField;
			}
		}

		return null;
	}

	/**
	 * Assert that pageId, pageVersionId and
	 * languageId are all set
	 *
	 * @return void
	 */
	protected function assertInitialized()
	{
		if (is_null($this->pageVersionId) || is_null($this->pageId) || is_null($this->languageId))
		{
			throw new PageDataNotInitializedException('You must initialize the dvsPageData singleton with a page id, page version id and language id.');
		}
	}
}