<?php namespace Devise\Pages\Interpreter;

use Devise\Pages\Interpreter\Exceptions\InvalidDeviseKeyException;
use Devise\Pages\Interpreter\Exceptions\DuplicateDeviseKeyException;

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
	 * Keeps track of cids for given types
	 *
	 * @var array
	 */
	protected $cids = [];

	/**
	 * Keep track of all the page tags
	 * @var array
	 */
	protected $tags = [];

	/**
	 * Collections as json output
	 *
	 * @return string
	 */
	public function collectionsJSON()
	{
		return $this->jsonEncode($this->buildCollections());
	}

	/**
	 * Bindings as json output
	 *
	 * @return string
	 */
	public function fieldsJSON()
	{
		return $this->jsonEncode($this->buildFields());
	}

	/**
	 * Models as json output
	 *
	 * @return string
	 */
	public function modelsJSON()
	{
		return $this->jsonEncode($this->buildModels());
	}

	/**
	 * Model attributes as json output
	 *
	 * @return string
	 */
	public function modelAttributesJSON()
	{
		return $this->jsonEncode($this->buildModelAttributes());
	}

	/**
	 * Model creators as json output
	 *
	 * @return string
	 */
	public function modelCreatorsJSON()
	{
		return $this->jsonEncode($this->buildModelCreators());
	}

	/**
	 * Get the list of all the tags. This is used for introspection
	 * for testing
	 *
	 * @return array
	 */
	public function tags()
	{
		return $this->tags;
	}

	/**
	 * Register a binding, collection or model data-devise tag using
	 * this method.
	 *
	 * @param  string $id
	 * @param  string $bindingType
	 * @param  string $collection
	 * @param  string $key
	 * @param  string $type
	 * @param  string $humanName
	 * @param  string $group
	 * @param  string $category
	 * @param  string $alternateTarget
	 * @return void
	 */
	public function register($id, $bindingType, $collection, $key, $type, $humanName, $group, $category, $alternateTarget)
	{
		if ($bindingType !== 'variable')
		{
			$this->assertNoDuplicateTags($id);
		}

		$this->tags[$id] = [
			'id' => $id,
			'cid' => $this->getCidForType($bindingType),
			'bindingType' => $bindingType,
			'collection' => $collection,
			'key' => $key,
			'type' => $type,
			'humanName' => $humanName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget,
			'defaults' => null,
		];
	}

	/**
	 * Try to set defaults for an id
	 *
	 * @param string $id
	 * @param mixed  $defaults
	 */
	public function setDefaults($id, $defaults)
	{
		$this->assertTagExists($id);
		$this->tags[$id]['defaults'] = $defaults;
	}

	/**
	 * Returns the cid for this $id and also sets default values
	 * for this cid. At this point, the $default values should be
	 * set correctly, if not then we need to just throw the exception
	 * because something is not right. We also allow for variables
	 * in this place, so we need to update all the values for this
	 * $id. So if we have a human name with like $someVar in it, then
	 * this is the place where we actually update it...
	 *
	 * if this field's binding type is a
	 * creator, field, or colelction then we
	 * only use 1 cid
	 *
	 * if this type is a model or attribute
	 * then we need to register a new cid for this
	 * thing... because we are dealing with
	 * new instances everytime we get called
	 *
	 * (think about iterating over a collection of
	 * models inside of a foreach loop), each one has
	 * their own key (model's id)
	 *
	 * @param  string $id
	 * @param  string $bindingType
	 * @param  string $collection
	 * @param  string $key
	 * @param  string $type
	 * @param  string $humanName
	 * @param  string $group
	 * @param  string $category
	 * @param  string $alternateTarget
	 * @param  mixed $defaults
	 * @return string
	 */
	public function cid($id, $bindingType, $collection, $key, $type, $humanName, $group, $category, $alternateTarget, $defaults)
	{
		$this->assertTagExists($id);

		$tag = $bindingType === 'variable'
			? $this->findVariableTag($id, $bindingType, $collection, $key, $type, $humanName, $group, $category, $alternateTarget, $defaults)
			: $this->findRegularTag($id, $bindingType, $collection, $key, $type, $humanName, $group, $category, $alternateTarget, $defaults);

		return $tag['cid'];
	}

	/**
	 * Find the variable tags and add them to our array
	 *
	 * @param  string $id
	 * @param  string $bindingType
	 * @param  string $collection
	 * @param  string $key
	 * @param  string $type
	 * @param  string $humanName
	 * @param  string $group
	 * @param  string $category
	 * @param  string $alternateTarget
	 * @param  string $defaults
	 * @return array
	 */
	protected function findVariableTag($id, $bindingType, $collection, $key, $type, $humanName, $group, $category, $alternateTarget, $defaults)
	{
		list($model, $attribute) = $this->extractModelFromKey($key);

		if ($attribute)
		{
			return $this->findModelAttributeTag($id, 'attribute', $collection, $model, $attribute, 'attribute', $humanName, $group, $category, $alternateTarget, $defaults);
		}

		return $this->findModelTag($id, 'model', $collection, $model, 'model', $humanName, $group, $category, $alternateTarget, $defaults);
	}

	/**
	 * Find the regular tag and add it to our array
	 *
	 * @param  string $id
	 * @param  string $bindingType
	 * @param  string $collection
	 * @param  string $key
	 * @param  string $type
	 * @param  string $humanName
	 * @param  string $group
	 * @param  string $category
	 * @param  string $alternateTarget
	 * @param  mixed  $defaults
	 * @return array
	 */
	protected function findRegularTag($id, $bindingType, $collection, $key, $type, $humanName, $group, $category, $alternateTarget, $defaults)
	{
		$cid = strpos($this->tags[$id]['cid'], 'tag') !== 0 ? $this->tags[$id]['cid'] : $this->getCidForType($bindingType);

		$this->tags[$id] = [
			'id' => $id,
			'cid' => $cid,
			'bindingType' => $bindingType,
			'collection' => $collection,
			'key' => $key,
			'type' => $type,
			'humanName' => $humanName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget,
			'defaults' => $defaults,
		];

		return $this->tags[$id];
	}

	/**
	 * Adds the model tag for us
	 *
	 * @param  string $id
	 * @param  string $bindingType
	 * @param  string $collection
	 * @param  Model  $model
	 * @param  string $type
	 * @param  string $humanName
	 * @param  string $group
	 * @param  string $category
	 * @param  string $alternateTarget
	 * @param  mixed  $defaults
	 * @return array
	 */
	protected function findModelTag($id, $bindingType, $collection, $model, $type, $humanName, $group, $category, $alternateTarget, $defaults)
	{
		$tag = [
			'id' => $id,
			'cid' => $this->getCidForType('model'),
			'bindingType' => 'model',
			'collection' => $collection,
			'table' => $model->getTable(),
			'class' => get_class($model),
			'key' => $model->getKey(),
			'model' => $model,
			'type' => $type,
			'humanName' => $humanName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget,
			'defaults' => $defaults,
		];

		$this->tags[] = $tag;

		return $tag;
	}

	/**
	 * Adds the model attribute tag for us
	 *
	 * @param  string $id
	 * @param  string $bindingType
	 * @param  string $collection
	 * @param  Model  $model
	 * @param  string $attribute
	 * @param  string $type
	 * @param  string $humanName
	 * @param  string $group
	 * @param  string $category
	 * @param  string $alternateTarget
	 * @param  mixed  $defaults
	 * @return array
	 */
	protected function findModelAttributeTag($id, $bindingType, $collection, $model, $attribute, $type, $humanName, $group, $category, $alternateTarget, $defaults)
	{
		$tag = [
			'id' => $id,
			'cid' => $this->getCidForType('attribute'),
			'bindingType' => $type,
			'collection' => $collection,
			'key' => $model->getKey(),
			'table' => $model->getTable(),
			'class' => get_class($model),
			'attribute' => $attribute,
			'type' => $type,
			'humanName' => $humanName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget,
			'defaults' => $defaults,
		];

		$this->tags[] = $tag;

		return $tag;
	}

	/**
	 * Analyze this key variable and determine if it is
	 * a attribute or model type
	 *
	 * @param  mixed $var
	 * @return string
	 */
	protected function extractModelFromKey($chain)
	{
		$chain = is_array($chain) ? $chain : array($chain);

		$iterator = new \ArrayIterator($chain);

		$model = $iterator->current();

		// we cant do anything with null models so throw an error
		if (is_null($model))
		{
			$variableName = $iterator->key();
			throw new Exceptions\InvalidDeviseTagException("Cannot use '{$variableName}'' as a devise model because it is null");
		}

		// make sure this model is a model
		if (is_a($model, '\Illuminate\Database\Eloquent\Model'))
		{
			return array($model, null);
		}

		// didn't find the model so maybe it is an attribute
		// of a specific model, so advance the iterator

		$attribute = $iterator->key();
		$iterator->next();
		$model = $iterator->valid() ? $iterator->current() : null;

		// let's try this again
		if (is_a($model, '\Illuminate\Database\Eloquent\Model'))
		{
			return array($model, $attribute);
		}

		throw new Exceptions\InvalidDeviseTagException('Could not extract Eloquent model from devise tag');
	}

	/**
	 * Encodes the object passed in as a json
	 * string and also escapes all ' characters
	 *
	 * @param  mixed $object
	 * @return string
	 */
	protected function jsonEncode($object)
	{
		$json = json_encode($object);

		$json = str_replace("'", "\'", $json);

		return $json;
	}

	/**
	 * Filter the tags by the binding type
	 *
	 * @param  string $bindingType
	 * @return array
	 */
	protected function filterTags($bindingType)
	{
		return array_filter($this->tags, function($tag) use ($bindingType)
		{
			return $tag['bindingType'] === $bindingType;
		});
	}

	/**
	 * Builds out list of collections from our
	 * registered tags
	 *
	 * @return array
	 */
	protected function buildCollections()
	{
		$collections = [];

		$tags = $this->filterTags('collection');

		foreach ($tags as $tag)
		{
			$collection = $tag['collection'];

			$collections[$collection] = isset($collections[$collection]) ? $collections[$collection] : array();

			$collections[$collection][] = [
				'tid' => $tag['id'],
				'cid' => $tag['cid'],
				'collection' => $collection,
				'key' => $tag['key'],
				'type' => $tag['type'],
				'humanName' => $tag['humanName'],
				'group' => $tag['group'],
				'category' => $tag['category'],
				'alternateTarget' => $tag['alternateTarget'],
				'defaults' => $tag['defaults'],
			];
		}

		return $collections;
	}

	/**
	 * Builds out a list of fields from our
	 * registered tags
	 *
	 * @return array
	 */
	protected function buildFields()
	{
		$fields = [];

		$tags = $this->filterTags('field');

		foreach ($tags as $tag)
		{
			$fields[] = [
				'tid' => $tag['id'],
				'cid' => $tag['cid'],
				'key' => $tag['key'],
				'type' => $tag['type'],
				'humanName' => $tag['humanName'],
				'group' => $tag['group'],
				'category' => $tag['category'],
				'alternateTarget' => $tag['alternateTarget'],
				'defaults' => $tag['defaults'],
			];
		}

		return $fields;
	}

	/**
	 * Builds out the models
	 *
	 * @return array
	 */
	protected function buildModels()
	{
		$models = [];

		$tags = $this->filterTags('model');

		foreach ($tags as $tag)
		{
			$models[] = [
				'tid' => $tag['id'],
				'cid' => $tag['cid'],
				'key' => $tag['key'],
				'table' => $tag['table'],
				'class' => $tag['class'],
				'humanName' => $tag['humanName'],
				'collection' => $tag['group'],
			];
		}

		return $models;
	}

	/**
	 * Builds out the model attributes
	 *
	 * @return array
	 */
	protected function buildModelAttributes()
	{
		$attributes = [];

		$tags = $this->filterTags('attribute');

		foreach ($tags as $tag)
		{
			$attributes[] = [
				'tid' => $tag['id'],
				'cid' => $tag['cid'],
				'key' => $tag['key'],
				'table' => $tag['table'],
				'class' => $tag['class'],
				'humanName' => $tag['humanName'],
				'collection' => $tag['group'],
				'attribute' => $tag['attribute'],
			];
		}
		return $attributes;
	}

	/**
	 * Builds out the model creators
	 *
	 * @return array
	 */
	protected function buildModelCreators()
	{
		$creators = [];

		$tags = $this->filterTags('creator');

		foreach ($tags as $tag)
		{
			$creators[] = [
				'tid' => $tag['id'],
				'cid' => $tag['cid'],
				'model_name' => $tag['key'],
				'human_name' => $tag['humanName'],
			];
		}

		return $creators;
	}

	/**
	 * Gets the cids broken down by types
	 *
	 * @param  string $type
	 * @return string
	 */
	protected function getCidForType($type)
	{
		if (!isset($this->cids[$type]))
		{
			$this->cids[$type] = 0;
		}

		return $type . $this->cids[$type]++;
	}

	/**
	 * Makes sure we don't get duplicate tags registered
	 *
	 * @param  string $id
	 * @return void
	 */
	protected function assertNoDuplicateTags($id)
	{
		if (array_key_exists($id, $this->tags))
		{
			throw new DuplicateDeviseKeyException('Found duplicate key ' . $id);
		}
	}

	/**
	 * Assert that the id exists... this means we should have registered
	 * the id already
	 *
	 * @param  string $id
	 * @return void
	 */
	protected function assertTagExists($id)
	{
		if (!array_key_exists($id, $this->tags))
		{
			throw new InvalidDeviseKeyException("Could not find a registered tag with id: {$id}");
		}
	}
}