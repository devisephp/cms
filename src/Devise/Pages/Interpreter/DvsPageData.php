<?php namespace Devise\Pages\Interpreter;

use Devise\Pages\Collections\CollectionsRepository;
use Devise\Pages\PagesRepository;
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
	 * Csrf token
	 * @var string
	 */
	protected $csrfToken;

	/**
	 * Keep track of all the page tags
	 * @var array
	 */
	protected $tags = [];

	/**
	 * Keeps track of some cids for variable tags
	 * @var array
	 */
	protected $cids = [];

	/**
	 * Tag manager that creates and finds
	 * fields for our tags
	 *
	 * @var TagManager
	 */
	protected $TagManager;

	/**
	 * The collections repository gets a list
	 * of collections for us
	 *
	 * @var CollectionRepository
	 */
	protected $CollectionsRepository;

	/**
	 * The pages repository fetches additional
	 * information we need for our page
	 *
	 * @var PagesRepository
	 */
	protected $PagesRepository;

	/**
	 * Create a new page data object
	 *
	 * @param TagManager     $TagManager
	 */
	public function __construct(TagManager $TagManager, CollectionsRepository $CollectionsRepository, PagesRepository $PagesRepository)
	{
		$this->TagManager = $TagManager;
		$this->CollectionsRepository = $CollectionsRepository;
		$this->cids = ['hidden' => 0, 'model' => 0, 'attribute' => 0, 'creator' => 0, 'field' => 0, 'variable' => 0, 'collection' => 0];
		$this->PagesRepository = $PagesRepository;
	}

	/**
	 * Creates a json object that we use for editing a
	 * devise page
	 *
	 * @return string
	 */
	public function toJSON()
	{
		$pageVersionId = $this->pageVersionId;
		$pageId = $this->pageId;
		$languageId = $this->languageId;
		$csrfToken = $this->csrfToken;
		$availableLanguages = $this->PagesRepository->availableLanguagesForPage($pageId);
	    $pageRoutes = $this->PagesRepository->getRouteList();
		$pageVersions = $this->PagesRepository->getPageVersions($pageId, $pageVersionId);
		$collections = $this->filterTags('collection');
		$fields = $this->filterTags('field');
		$models = $this->filterTags('model');
		$attributes = $this->filterTags('attribute');
		$creators = $this->filterTags('creator');
		$nodes = $this->buildNodes($collections, $fields, $models, $attributes, $creators);

		return $this->jsonEncode(compact('nodes', 'pageId', 'pageVersionId', 'languageId', 'csrfToken', 'availableLanguages', 'pageRoutes', 'pageVersions'));
	}

	/**
	 * The dvs page data cannot create fields and collection objects
	 * without knowing what page we are on. This is injected in on every
	 * view that uses dvsPageData...
	 *
	 * @param  integer $pageId
	 * @param  integer $pageVersionId
	 * @param  integer $languageId
	 * @return void
	 */
	public function initialize($pageId, $pageVersionId, $languageId, $csrfToken)
	{
		$this->pageId = $pageId;
		$this->pageVersionId = $pageVersionId;
		$this->languageId = $languageId;
		$this->csrfToken = $csrfToken;
		$this->TagManager->initialize($pageId, $pageVersionId, $languageId);
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
	public function register($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget)
	{
		if ($bindingType !== 'variable')
		{
			$this->assertNoDuplicateTags($id);
		}

		$this->tags[$id] = [
			'id' => $id,
			'cid' => 'hidden' . $this->cids['hidden']++,
			'bindingType' => $bindingType,
			'collection' => $collection,
			'key' => $key,
			'type' => $type,
			'humanName' => $humanName,
			'collectionName' => $collectionName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget,
			'defaults' => null,
			'data' => [],
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
	public function cid($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults)
	{
		$this->assertTagExists($id);

		$tag = $this->resolveTag($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults);

		return $tag['cid'];
	}

	/**
	 * Resolve the tag
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
	protected function resolveTag($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults)
	{
		if ($bindingType === 'variable')
		{
			return $this->resolveVariableTag($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults);
		}

		$tag = $this->tags[$id];

		$tag['id'] = $id;
		$tag['bindingType'] = $bindingType;
		$tag['collection'] = $collection;
		$tag['key'] = $key;
		$tag['type'] = $type;
		$tag['humanName'] = $humanName;
		$tag['collectionName'] = $collectionName;
		$tag['group'] = $group;
		$tag['category'] = $category;
		$tag['alternateTarget'] = $alternateTarget;
		$tag['defaults'] = $defaults;
		$tag['data'] = $this->resolveInstance($tag);
		$tag['cid'] = $tag['bindingType'] . $tag['data']->id;

		$this->tags[$id] = $tag;

		return $tag;
	}

	/**
	 * Resolve the variable tag
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
	protected function resolveVariableTag($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults)
	{
		list($model, $attribute) = $this->extractModelFromKey($key);

		$tag = $this->tags[$id];

		$tag['id'] = $id;
		$tag['bindingType'] = $attribute ? 'attribute' : 'model';
		$tag['collection'] = $collection;
		$tag['key'] = $model->getKey();
		$tag['type'] = get_class($model);
		$tag['humanName'] = $humanName;
		$tag['collectionName'] = $collectionName;
		$tag['group'] = $group;
		$tag['category'] = $category;
		$tag['alternateTarget'] = $alternateTarget;
		$tag['defaults'] = $defaults;
		$tag['model'] = $model;

		if ($attribute)
		{
			$tag['attribute'] = $attribute;
		}

		$tag['data'] = $this->resolveInstance($tag);

		if ($attribute)
		{
			$tag['cid'] = $tag['bindingType'] . $tag['data']->id;
		}
		else
		{
			$tag['cid'] = $tag['bindingType'] . $this->cids[$tag['bindingType']]++;
		}

		$this->tags[] = $tag;

		return $tag;
	}

	/**
	 * Get the instance for this tag
	 *
	 * @param  array $tag
	 * @return DvsField|DvsModel|DvsCollectionSet|DvsGlobalField
	 */
	protected function resolveInstance($tag)
	{
		return $this->TagManager->getInstanceForTag($tag);
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
	 * Build the node structure for this json. This takes
	 * into account groups too. Nodes that are grouped together
	 * we will take that into account too...
	 *
	 * Loop through all collections, fields, models,
	 * attributes and creators and create the node
	 * structure for them.
	 *
	 * @return array
	 */
	protected function buildNodes($collections, $fields, $models, $attributes, $creators)
	{
		$nodes = [];

		$groups = [];

		list($groups, $nodes) = $this->addNodesIntoGroupsOrNodes($fields, $groups, $nodes);

		list($groups, $nodes) = $this->addCollectionNodesIntoGroupsOrNodes($collections, $groups, $nodes);

		list($groups, $nodes) = $this->addNodesIntoGroupsOrNodes($models, $groups, $nodes);

		list($groups, $nodes) = $this->addNodesIntoGroupsOrNodes($attributes, $groups, $nodes);

		list($groups, $nodes) = $this->addNodesIntoGroupsOrNodes($creators, $groups, $nodes);

		list($groups, $nodes) = $this->addGroupNodes($groups, $nodes);

		return $nodes;
	}

	/**
	 * Adds collections into the existing nodes or groups array
	 *
	 * @param array $collections
	 * @param array $groups
	 * @param array $nodes
	 */
	protected function addCollectionNodesIntoGroupsOrNodes($collections, $groups, $nodes)
	{
		$normalCollections = [];

		$groupCollections = [];

		foreach ($collections as $collection)
		{
			$group = $collection['group'];
			$name = $collection['collectionName'];

			if ($group) $groupCollections = $this->appendToArray($groupCollections, $group, $collection);
			else $normalCollections = $this->appendToArray($normalCollections, $name, $collection);
		}

		foreach ($normalCollections as $collectionName => $collectionFields)
		{
			$nodes[] = $this->buildCollectionNode($collectionName, $collectionFields);
		}

		foreach ($groupCollections as $groupName => $collectionFields)
		{
			$builtCollections = [];
			$insideCollectionFields = [];

			foreach ($collectionFields as $collectionField)
			{
				$name = $collectionField['collectionName'];
				$insideCollectionFields = $this->appendToArray($insideCollectionFields, $name, $collection);
			}

			foreach ($insideCollectionFields as $collectionName => $insideFields)
			{
				$builtCollections = $this->buildCollectionNode($collectionName, $insideFields);
			}

			$groups = $this->appendToArray($builtCollections, $groupName, $groups);
		}

		return array($groups, $nodes);
	}

	/**
	 * Adds the groups into the nodes
	 *
	 * @param array $groups
	 * @param array $nodes
	 */
	protected function addGroupNodes($groups, $nodes)
	{
		$index = 0;

		foreach ($groups as $name => $items)
		{
			$nodes[] = $this->buildGroupNode('group' . $index++, $name, $items);
		}

		return array($groups, $nodes);
	}

	/**
	 * Adds nodes into the existing nodes or groups array
	 *
	 * @param array $nodes
	 * @param array $groups
	 * @param array $existingNodes
	 * @return  array
	 */
	protected function addNodesIntoGroupsOrNodes($nodes, $groups, $allNodes)
	{
		foreach ($nodes as $node)
		{
			$key = $node['group'];

			$built = $this->buildNode($node);

			if ($key) $groups = $this->appendToArray($groups, $key, $built);

			else $allNodes = $this->appendToArray($allNodes, false, $built);
		}

		return array($groups, $allNodes);
	}

	/**
	 * Group nodes are just a bunch of node items
	 *
	 * @param  string $cid
	 * @param  array $items
	 * @return array
	 */
	protected function buildGroupNode($cid, $name, $items)
	{
		$node = $items[0];

		return [
			'cid' => $cid,
			'key' => $node['key'],
			'binding' => 'group',
			'human_name' => $name,
			'template' => $this->buildTemplateForNode(['bindingType' => 'group']),
			'position' => [ 'top' => 0, 'left' => 0, 'side' => 'left' ],
			'data' => $items,
		];
	}

	/**
	 * Collection nodes are grouped together
	 *
	 * @param  string $collectionName
	 * @param  array  $collectionFields
	 * @return array
	 */
	protected function buildCollectionNode($collectionName, $collectionFields)
	{
		$node = $collectionFields[0];

		return [
			'cid' => $node['cid'],
			'key' => $node['collection'],
			'binding' => 'collection',
			'human_name' => $collectionName,
			'template' => $this->buildTemplateForNode($node),
			'position' => [ 'top' => 0, 'left' => 0, 'side' => 'left' ],
			'schema' => $collectionFields,
			'data' => $this->CollectionsRepository->findCollectionInstancesForCollectionSetIdAndPageVersionId($node['data']->id, $this->pageVersionId),
		];
	}

	/**
	 * Build a node
	 *
	 * @param  array $node
	 * @return array
	 */
	protected function buildNode($node)
	{
		$binding = $node['bindingType'];

		$built = [
			'cid' => $node['cid'],
			'key' => $node['id'],
			'binding' => $binding,
			'human_name' => $node['humanName'],
			'template' => $this->buildTemplateForNode($node),
			'position' => [ 'top' => 0, 'left' => 0, 'side' => 'left' ],
			'data' => $node['data'],
		];

		if ($binding === 'model' || $binding === 'attribute')
		{
			$built['model'] = $node['model'];
		}

		return $built;
	}

	/**
	 * Gets us the template path for this node. The
	 * path depends on the type of node this is...
	 *
	 * @param  array $node
	 * @return string
	 */
	protected function buildTemplateForNode($node)
	{
		switch ($node['bindingType'])
		{
			case 'field': return 'sidebar.layouts.field';
			case 'collection': return 'sidebar.layouts.collection';
			case 'model': return 'sidebar.layouts.model';
			case 'attribute': return 'sidebar.layouts.attribute';
			case 'creator': return 'sidebar.layouts.creator';
			case 'group': return 'sidebar.layouts.group';
		}

		return null;
	}

	/**
	 * Helper method so that I don't have to put this logic
	 * inside of another foreach loop
	 *
	 * @param  array $container
	 * @param  string $key
	 * @param  mixed $item
	 * @return array
	 */
	protected function appendToArray(array $container, $key, $item)
	{
		if ($key === false)
		{
			$container[] = $item;
			return $container;
		}

		if (!isset($container[$key]))
		{
			$container[$key] = [];
		}

		$container[$key][] = $item;

		return $container;
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