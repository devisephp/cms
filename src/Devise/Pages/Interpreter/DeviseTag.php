<?php namespace Devise\Pages\Interpreter;

class DeviseTag
{
	/**
	 * Identifier of the devise tag
	 *
	 * @var string
	 */
	public $id;

	/**
	 * This could be a model, field or collection binding type
	 *
	 * @var string
	 */
	public $bindingType;

	/**
	 * Collection name
	 *
	 * @var string
	 */
	public $collection;

	/**
	 * Key name
	 *
	 * @var string
	 */
	public $key;

	/**
	 * Type of the devise tag (text, image, etc)
	 * @var string
	 */
	public $type;

	/**
	 * Human name of the devise tag
	 *
	 * @var string
	 */
	public $humanName;

	/**
	 * The human name of the collection
	 *
	 * @var string
	 */
	public $collectionName;

	/**
	 * Group name of the tag. We can
	 * group together different nodes.
	 *
	 * @var string
	 */
	public $group;

	/**
	 * Category name provides us with
	 * a dropdown in the sidebar for a
	 * group.
	 *
	 * @var string
	 */
	public $category;

	/**
	 * Alternate target for live updates
	 *
	 * @var string
	 */
	public $alternateTarget;

	/**
	 * Default values to set on this devise tag
	 *
	 * @var string
	 */
	public $defaults;

	/**
	 * String value of the entire matched string that was
	 * regex out. This parameters above are extracted from
	 * this value
	 *
	 * @var string
	 */
	public $value;

	/**
	 * The chain array of string value pairs for a model
	 * or attribute
	 *
	 * @var string
	 */
	public $chain;

	/**
	 * Create a new devise tag
	 *
	 * @param string $str
	 */
	public function __construct($str, $parsed = null)
	{
		$this->value = $str;

		$parsed = ($parsed === null) ? $this->isStringParsed($str) : $parsed;

		if ($parsed === 'parsed') $this->extractParametersFromParsedStr($str);
		else if ($parsed === 'creator') $this->extractParametersFromUnparsedCreatorStr($str);
		else $this->extractParametersFromUnparsedStr($str);
	}

	/**
	 * Convert this object to a string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->value;
	}

	/**
	 * Converts our devise tag into a giant ass array
	 *
	 * @return array
	 */
	public function toArray($escaped = '', $hasKeys = false)
	{
		$arrayFormat = array(
			'id' => $this->id,
			'bindingType' => $this->bindingType,
			'collection' => $this->collection,
			'key' => $this->key,
			'type' => $this->type,
			'humanName' => $this->humanName,
			'collectionName' => $this->collectionName,
			'group' => $this->group,
			'category' => $this->category,
			'alternateTarget' => $this->alternateTarget,
			'defaults' => $this->defaults,
			'chain' => $this->chain,
		);

		// walk over the array and churn out a list of string values
		// for each thing and make sure to enclose in \" quotes \"
		array_walk($arrayFormat, function(&$value, $index) use ($escaped)
		{
			if ($value === '' || is_null($value)) $value = 'null';

			if ($value !== 'null' && !empty($escaped) && !in_array($index, ['id', 'defaults', 'chain']))
			{
				$value = str_replace($escaped, "\\" . $escaped, $value);
				$value = "{$escaped}{$value}{$escaped}";
			}
		});

		return $hasKeys ? $arrayFormat : array_values($arrayFormat);
	}

	/**
	 * Extracts out the parameters from a parsed devise string
	 *
	 * @return void
	 */
	protected function extractParametersFromParsedStr($params)
	{
		$params = ltrim($params);

		$params = str_replace('data-devise-<?php echo devise_tag_cid(', '', $params);

		$params = substr($params, 1);

		$params = substr($params, 0, -4);

		$params = str_getcsv($params);

		array_walk($params, function(&$value) { $value = ltrim(rtrim($value)); });

		$this->id = $this->stripquotes($params[0]);

		$this->bindingType = $this->stripquotes($params[1]);

		$this->collection = $this->stripquotes($params[2]);

		$this->key = $this->stripquotes($params[3]);

		$this->type = $this->stripquotes($params[4]);

		$this->humanName = $this->stripquotes($params[5]);

		$this->collectionName = $this->stripquotes($params[6]);

		$this->group = $this->stripquotes($params[7]);

		$this->category = $this->stripquotes($params[8]);

		$this->alternateTarget = $this->stripquotes($params[9]);

		$this->defaults = $this->stripquotes($params[10]);
	}

	/**
	 * Extracts out the parameters from an unparsed devise create model
	 *
	 * @param  string $params
	 * @return void
	 */
	protected function extractParametersFromUnparsedCreatorStr($params)
	{
		$params = ltrim($params);

		$params = str_replace('data-devise-create-model=', '', $params);

		$params = substr($params, 1);

		$params = substr($params, 0, -1);

		$params = str_getcsv($params);

		// trim away extra white space off each value
		array_walk($params, function(&$value) { $value = ltrim(rtrim($value)); });

		$this->id = 'creator-' . md5($params[0]);

		$this->collection = null;

		$this->bindingType = 'creator';

		$this->key = $params[0];

		$this->type = 'creator';

		$this->humanName = isset($params[1]) && $params[1] !== 'null' && $params[1] ? $params[1] : $this->humanize($key);

		$this->collectionName = null;

		$this->group = null;

		$this->category = null;

		$this->alternateTarget = null;

		$this->defaults = null;
	}

	/**
	 * Extracts out the parameters from an unparsed devise string
	 *
	 * @return void
	 */
	protected function extractParametersFromUnparsedStr($params)
	{
		$params = ltrim($params);

		$params = str_replace('data-devise=', '', $params);

		$params = substr($params, 1);

		$params = substr($params, 0, -1);

		$params = str_getcsv($params);

		// trim away extra white space off each value
		array_walk($params, function(&$value) { $value = ltrim(rtrim($value)); });

		if (!isset($params[0])) {
			throw new InvalidDeviseKeyException('Cannot have an empty key');
		}

		// below we list out all the params and defaults too
		list($collection, $key) = $this->extractKeyAndCollection($params[0]);

		$this->id = $params[0];

		$this->collection = $collection ?: null;

		$this->bindingType = $this->extractBindingType($collection, $key);

		$this->key = $key;

		$this->type = isset($params[1]) ? $params[1] : null;

		$this->humanName = isset($params[2]) && $params[2] !== 'null' && $params[2] ? $params[2] : $this->humanize($key);

		$this->collectionName = null;

		$this->group = isset($params[3]) && $params[3] !== 'null' && $params[3] ? $params[3] : null;

		$this->category = isset($params[4]) && $params[4] !== 'null' && $params[4] ? $params[4] : null;

		$this->alternateTarget = isset($params[5]) && $params[5] !== 'null' && $params[5] ? $params[5] : null;

		$this->defaults = isset($params[6]) && $params[6] !== 'null' && $params[6] ? $params[6] : null;

		if ($this->bindingType === 'variable')
		{
			$this->extractParametersForVariable($key, $params);
		}

		if ($this->bindingType === 'collection')
		{
			$this->extractParametersForCollection($key, $params);
		}
	}

	/**
	 * Extracts out parameters for collection. They are different
	 * because collections have a collection name in the place
	 * where a group name should be. So this throws everything off
	 * by one
	 *
	 * @param  string $key
	 * @param  array $params
	 * @return void
	 */
	protected function extractParametersForCollection($key, $params)
	{
		$this->collectionName = isset($params[3]) && $params[3] !== 'null' && $params[3] ? $params[3] : $this->humanize($this->collection);

		$this->group = isset($params[4]) && $params[4] !== 'null' && $params[4] ? $params[4] : null;

		$this->category = isset($params[5]) && $params[5] !== 'null' && $params[5] ? $params[5] : null;

		$this->alternateTarget = isset($params[6]) && $params[6] !== 'null' && $params[6] ? $params[6] : null;

		$this->defaults = isset($params[7]) && $params[7] !== 'null' && $params[7] ? $params[7] : null;
	}

	/**
	 * Extracts out parameters for a variable binding type
	 * which is essentially a model or model attribute type
	 *
	 * @param  string $key
	 * @param  array $params
	 * @return void
	 */
	protected function extractParametersForVariable($key, $params)
	{
		$this->chain = $this->createChainArray($key);

		$this->type = 'variable';

		$this->humanName = isset($params[1]) && $params[1] !== 'null' && $params[1] ? $params[1] : $this->humanize($key);

		$this->group = isset($params[2]) && $params[2] !== 'null' && $params[2] ? $params[2] : null;

		$this->category = isset($params[3]) && $params[3] !== 'null' && $params[3] ? $params[3] : null;

		$this->alternateTarget = isset($params[4]) && $params[4] !== 'null' && $params[4] ? $params[4] : null;

		$this->defaults = isset($params[5]) && $params[5] !== 'null' && $params[5] ? $params[5] : null;
	}

	/**
	 * Strips off the quotes from the beginning and end of string
	 *
	 * @param  string $str
	 * @return string
	 */
	protected function stripquotes($str)
	{
		$newstr = rtrim(ltrim(rtrim(ltrim($str, '"'), '"'), "'"), "'");

		if ($newstr === "null") return null;

		return $newstr;
	}

	/**
	 * Create a human version name of this string
	 *
	 * @param  string $str
	 * @return string
	 */
	protected function humanize($str)
	{
		$str = str_replace('$', '', $str);

		$str = str_replace('_', ' ', $str);

		return ucwords($str);
	}

	/**
	 * Extracts out the key and collection from a string
	 *
	 * @param  string $str
	 * @return array
	 */
	protected function extractKeyAndCollection($str)
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
	 * [extractBindingType description]
	 * @param  [type] $collection
	 * @param  [type] $key
	 * @return [type]
	 */
	protected function extractBindingType($collection, $key)
	{
		if ($collection !== null) return 'collection';

		if (strpos($key, '$') === 0) return 'variable';

		return 'field';
	}

	/**
	 * Checks the string to see if it is parsed or not
	 *
	 * @param  string  $str
	 * @return boolean
	 */
	protected function isStringParsed($str)
	{
		if (strpos($str, 'data-devise-<?php echo devise_tag_cid(') !== false)
		{
			return 'parsed';
		}

		return 'unparsed';
	}

	/**
	 * We can't assume that the model will just be a single variable
	 * it might be nested inside of another variable such as
	 * $page->someModel
	 *
	 * Furthermore we cannot assume that this is a model, we will
	 * have to check to ensure it is a Eloquent model later when
	 * the code is actually running. At this point we are just
	 * passing variables, the check actually happens in the
	 * devise_model method which is an alias for
	 * dvsPageData->addModel.
	 *
	 * @param  string $key
	 * @return string
	 */
	protected function createChainArray($key)
	{
		$chain = [];

		$index = '';

		$split = explode('->', $key);

		foreach ($split as $name)
		{
			$index .= $index ? '->' . $name : $name;
			$chain["$name"] = "$index";
		}

		return $this->arrayAsString(array_reverse($chain));
	}

	/**
	 * Converts this array to a string version that
	 * we can read in a blade php view later
	 *
	 * @param  array $array
	 * @return string
	 */
	protected function arrayAsString($array)
	{
		$arrayAsString = '[';

		foreach ($array as $key => $value)
		{
			$arrayAsString .= "'$key' => $value,";
		}

		return $arrayAsString . ']';
	}
}