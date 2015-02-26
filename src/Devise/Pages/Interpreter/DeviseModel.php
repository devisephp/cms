<?php namespace Devise\Pages\Interpreter;

/**
 *  convert this node data into useful information about the model
 *  at this point we don't know anything about the model, just
 *  that we need to rewrite some of the html to accommidate for it
 */
class DeviseModel
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
	public $collection, $model, $humanName;

	/**
	 * Create DeviseTag from this DeviseTag Node
	 *
	 * @param NodesDeviseTagNode $node [description]
	 */
	public function __construct(Nodes\DeviseModelNode $node)
	{
		$this->node = $node;

		$this->extractParameters($node);
	}

	/**
	 * Replaces this tag inside of this
	 * view. Changes data-devise="$post ..." into
	 * data-dvs-model-id="key"
	 *
	 * @param  string $view
	 * @return string
	 */
	public function replaceModelInView($view)
	{
		$searchFor = $this->node->matched;

		$collection = $this->collection ? '"' . $this->collection . '"' : 'null';

		$replacement = ' data-dvs-cid-<?php echo devise_model(' . $this->modelChain() . ', "' . $this->humanName . '", ' . $collection . ') ?>';

		return str_replace($searchFor, $replacement, $view);
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

		$this->model = $params[0];
		$this->humanName = isset($params[1]) && $params[1] && $params[1] !== 'null' ? $params[1] : null;
		$this->collection = isset($params[2]) && $params[2] && $params[2] !== 'null' ? $params[2] : null;
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
	 * @return string
	 */
	protected function modelChain()
	{
		$chain = [];

		$index = '';

		$model = $this->model;

		$split = explode('->', $model);

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