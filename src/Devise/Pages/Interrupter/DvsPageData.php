<?php namespace Devise\Pages\Interrupter;

/**
 * A storage container class that stores collections and fields
 * for a given page. These fields and collections are addeded
 * to a singleton registered in Devise\Pages\PagesServiceProvider.php
 * called 'dvsPageData'. ALl blade views that contain fields and/or
 * collections will use methods like addCollection and addField respectively
 * to add in the data. Eventually all this data is spit out as JSON
 * for the javascript library in devise to take over from there.
 */
class DvsPageData
{
	/**
	 * Keep track of all the page collections
	 * @var array
	 */
	protected $collections = [];

	/**
	 * Keep track of all the page bindings
	 * @var array
	 */
	protected $bindings = [];

	/**
	 * Keep track of all the added keys
	 * @var array
	 */
	protected $addedKeys = [];

	/**
	 * Keep track of all the added models
	 * @var array
	 */
	protected $models = [];

	/**
	 * Keep track of all the added models with attributes
	 * @var array
	 */
	protected $modelAttributes = [];

	/**
	 * Keep track of all the added model creators
	 *
	 * @var array
	 */
	protected $modelCreators = [];

	/**
	 * Encodes the object passed in as a json
	 * string and also escapes all ' characters
	 *
	 * @param  mixed $object
	 * @return string
	 */
	public function json_encode($object)
	{
		$json = json_encode($object);

		$json = str_replace("'", "\'", $json);

		return $json;
	}

	/**
	 * Collections as json output
	 *
	 * @return string
	 */
	public function collectionsJSON()
	{
		return $this->json_encode($this->collections);
	}

	/**
	 * Bindings as json output
	 *
	 * @return string
	 */
	public function bindingsJSON()
	{
		return $this->json_encode($this->bindings);
	}

	/**
	 * Models as json output
	 *
	 * @return string
	 */
	public function modelsJSON()
	{
		return $this->json_encode($this->models);
	}

	/**
	 * Model attributes as json output
	 *
	 * @return string
	 */
	public function modelAttributesJSON()
	{
		return $this->json_encode($this->modelAttributes);
	}

	/**
	 * Model creators as json output
	 *
	 * @return string
	 */
	public function modelCreatorsJSON()
	{
		return $this->json_encode($this->modelCreators);
	}

	/**
	 * Add a collection to dvsPageData
	 *
	 * @param string $collection
	 * @param string $key
	 * @param string $type
	 * @param string $humanName
	 * @param string $group
	 * @param string $category
	 * @param string $alternateTarget
	 */
	public function addCollection($collection, $key, $type, $humanName, $group, $category, $alternateTarget)
	{
		$this->assertUniqueCollectionKey($collection, $key);

		$this->addedKeys[] = "{$collection}[{$key}]";

		$this->collections[$collection] = isset($this->collections[$collection]) ? $this->collections[$collection] : array();

		$this->collections[$collection][] = [
			'collection' => $collection,
			'key' => $key,
			'type' => $type,
			'humanName' => $humanName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget
		];
	}

	/**
	 * Add a binding to dvsPageData
	 *
	 * @param string $key
	 * @param string $type
	 * @param string $humanName
	 * @param string $group
	 * @param string $category
	 * @param string $alternateTarget
	 */
	public function addBinding($key, $type, $humanName, $group, $category, $alternateTarget)
	{
		$this->assertUniqueBindingKey($key);

		$this->addedKeys[] = "{$key}";

		$this->bindings[] = [
			'key' => $key,
			'type' => $type,
			'humanName' => $humanName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget
		];
	}

	/**
	 * Add a model to the page data so it can be used by
	 * the javascript later
	 *
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string                              $humanName
	 * @param string                              $collection
	 */
	public function addModel(\Illuminate\Database\Eloquent\Model $model, $humanName, $collection)
	{
		$model = [
			'cid' => 'model' . count($this->models),
			'key' => $model->getKey(),
			'table' => $model->getTable(),
			'class' => get_class($model),
			'humanName' => $humanName,
			'collection' => $collection,
		];

		$this->models[] = $model;

		return $model;
	}

	/**
	 * Add a model with a specific attribute to the page data
	 *
	 * @param \Illuminate\Database\Eloquent\Model  $model
	 * @param string $attribute
	 * @param string $humanName
	 * @param string $collection
	 */
	public function addModelAttribute(\Illuminate\Database\Eloquent\Model $model, $attribute, $humanName, $collection)
	{
		$model = [
			'cid' => 'attribute' . count($this->modelAttributes),
			'key' => $model->getKey(),
			'table' => $model->getTable(),
			'class' => get_class($model),
			'humanName' => $humanName,
			'collection' => $collection,
			'attribute' => $attribute,
		];

		$this->modelAttributes[] = $model;

		return $model;
	}

	/**
	 * Add model creators to the array on this
	 * dvsPageData object
	 *
	 * @param string $modelAlias
	 * @param string $humanName
	 */
	public function addModelCreator($cid, $modelAlias, $humanName)
	{
		$this->modelCreators[] = [
			'cid' => $cid,
			'model_name' => $modelAlias,
			'human_name' => $humanName,
		];
	}

    /**
     * Make sure the key is unique to the page
     * bindings
     *
     * @param  string $key
     * @throws Exceptions\DuplicateDeviseKeyException
     * @return void
     */
	protected function assertUniqueBindingKey($key)
	{
		if (in_array($key, $this->addedKeys))
		{
			throw new Exceptions\DuplicateDeviseKeyException('Found duplicate key ' . $key);
		}
	}

	/**
	 * Make sure this key is unique to the collection
	 *
	 * @param  string $collection
	 * @param  string $key
	 * @return void
	 */
	protected function assertUniqueCollectionKey($collection, $key)
	{
		$this->assertUniqueBindingKey("{$collection}[{$key}]");
	}
}