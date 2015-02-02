<?php namespace Devise\Pages\Interrupter;

/**
 *  convert this node data into useful key, type, humanName, group, collection, alternateTarget?
 *  assert key is valid for collection or binding both
 *  assert that there is a type
 *  no human name present, make one from key
 */
class DeviseTag
{
	/**
	 * node that created this tag
	 * @var Node
	 */
	protected $node;

	/**
	 * public fields for this devise tag
	 * @var string
	 */
	public $collection, $key, $type,
		   $humanName, $group,
		   $category, $alternateTarget;

	/**
	 * Create DeviseTag from this DeviseTag Node
	 *
	 * @param NodesDeviseTagNode $node [description]
	 */
	public function __construct(Nodes\DeviseTagNode $node)
	{
		$this->node = $node;
		$this->extractParameters($node);
	}

	/**
	 * DeviseTags can be either collections
	 * or simple bindings depending on the key
	 * being key or key[something]
	 *
	 * @return string
	 */
	public function tagBindingType()
	{
		return $this->collection ? 'Collection' : 'Binding';
	}

	/**
	 * String for this devise tag placeholder
	 *
	 * @return string
	 */
	public function hiddenPlaceHolderStr()
	{
		$tagType = $this->tagBindingType();

		return $tagType == 'Binding'
			? "<?php if (Devise\Users\DeviseUser::showDeviseSpan(\"{$this->key}\", null)): ?><span style=\"display:none;\" data-dvs-placeholder-{$this->key}-id=\"{$this->key}\"></span><?php endif ?>"
			: "<?php if (Devise\Users\DeviseUser::showDeviseSpan(\"{$this->key}\", \"{$this->collection}\")): ?><span style=\"display:none;\" data-dvs-placeholder-{$this->collection}-{$this->key}-id=\"{$this->key}\"></span><?php endif ?>";
	}

	/**
	 * The string which adds this to the
	 * devise container, depending on the
	 * tagBindingType
	 */
	public function addToDevisePageStr()
	{
		$tagType = $this->tagBindingType();

		$collection = "'{$this->collection}'";
		$key = "'{$this->key}'";
		$type = "'{$this->type}'";
		$humanName = "'{$this->humanName}'";
		$group = $this->group ? "'{$this->group}'" :'null';
		$category = $this->category ? "'{$this->category}'" : 'null';
		$alternateTarget = $this->alternateTarget ? "'{$this->alternateTarget}'" : 'null';

		return $tagType == 'Binding'
			? "App::make('dvsPageData')->add{$tagType}({$key}, {$type}, {$humanName}, {$group}, {$category}, {$alternateTarget});" . PHP_EOL
			: "App::make('dvsPageData')->add{$tagType}({$collection}, {$key}, {$type}, {$humanName}, {$group}, {$category}, {$alternateTarget});" . PHP_EOL;
	}

	/**
	 * Replaces this tag inside of this
	 * view. Changes data-devise="..." into
	 * data-dvs-key-id="key"
	 *
	 * @param  string $view
	 * @return string
	 */
	public function replaceTagInView($view)
	{
		$tagType = $this->tagBindingType();

		$searchFor = $this->node->matched;

		$replacement = $tagType == 'Binding'
			? " data-dvs-{$this->key}-id=\"{$this->key}\""
			: " data-dvs-{$this->collection}-{$this->key}-id=\"{$this->key}\"";

		return str_replace($searchFor, $replacement, $view);
	}


    /**
     * Assert this key is valid
     *
     * @param  string $key
     * @param  string $message
     * @throws Exceptions\InvalidDeviseKeyException
     * @return void
     */
	public function assertValidKey($key, $message = null)
	{
		$message = $message ?: "Invalid key provided " . $key;

		// is this key is valid php?
		if (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $key)) return;

		// see if this is a collection field type
		// which is something like collectionName[fieldName]
		list($collection, $keyname) = $this->collectionAndKey($key);

		if ($collection && $keyname)
		{
			$this->assertValidKey($collection, $message);
			$this->assertValidKey($keyname, $message);

			return;
		}

		// we made it here so we have an invalid key
		throw new Exceptions\InvalidDeviseKeyException($message);
	}

	/**
	 * Extract parameters from node
	 *
	 * @param  Node $node
	 * @return void
	 */
	protected function extractParameters($node)
	{
		$paramsStr = $this->convertToParametersString($node);

		$params = str_getcsv($paramsStr, ',', '\'');

		// trim away unwanted white space...
		foreach($params as $index => $param)
		{
			$params[$index] = trim($param);
		}

		$this->assertParametersValid($params);

		list($this->collection, $this->key) = $this->collectionAndKey($params[0]);

		$this->type = $params[1];
		$this->humanName = isset($params[2]) && $params[2] && $params[2] !== 'null' ? $params[2] : ucwords(str_replace('_', ' ', $this->key));
		$this->group = isset($params[3]) && $params[3] && $params[3] !== 'null' ? $params[3] : null;
		$this->category = isset($params[4]) && $params[4] && $params[4] !== 'null' ? $params[4] : null;
		$this->alternateTarget = isset($params[5]) && $params[5] && $params[5] !== 'null' ? $params[5] : null;
	}

	/**
	 * get the collection and key for this string
	 *
	 * @param  string $str
	 * @return array(collection, key)
	 */
	protected function collectionAndKey($str)
	{
		if (strpos($str, '[') === false)
		{
			return array(null, $str);
		}

		// this is a devise tag for a collection
		$collection = null;
		$key = null;
		$parts = explode('[', $str);

		if (count($parts) > 1)
		{
			$collection = array_shift($parts);
			$nextPart = count($parts) > 0 ? explode(']', $parts[0]) : array();
			$key = count($nextPart) > 0 ? array_shift($nextPart) : null;
		}

		return array($collection, $key);
	}

    /**
     * Assert that the parameters for this node
     * are valid
     *
     * @param  array $params
     * @throws Exceptions\InvalidDeviseKeyException
     * @throws Exceptions\InvalidDeviseTagException
     * @return void
     */
	protected function assertParametersValid($params)
	{
		if (count($params) < 2)
		{
			throw new Exceptions\InvalidDeviseTagException('No key and type parameters found for match:' . $this->node->matched);
		}

		$this->assertValidKey($params[0], "Invalid key '{$params[0]}' found at match:" . $this->node->matched);
	}

    /**
     * Convert this node into some csv string
     * that we can break apart and get the
     * parts from: key, type, humanName, etc...
     *
     * @param  Node $node
     * @throws Exceptions\InvalidDeviseTagException
     * @return string
     */
	protected function convertToParametersString($node)
	{
		$matched = $node->matched;
		$pattern = ' data-devise="';

		$offset = strpos($matched, $pattern);
		$size = strlen($pattern);
		$end = strlen($matched) - $offset - $size - 1;

		if ($offset === false)
		{
			throw new Exceptions\InvalidDeviseTagException('Could not find data-devise in this node:' . $matched);
		}

		return substr($matched, $offset + $size, $end);
	}
}