<?php namespace Devise\Pages\Interpreter;

/**
 *  convert this node data into useful information about the model
 *  creator. Model creators are the nodes we click on the front
 *  end and let us create new instances of particular models
 *  that have been mapped.
 */
class DeviseModelCreator
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
	public $modelName, $humanName;

	/**
	 * Create DeviseTag from this DeviseTag Node
	 *
	 * @param NodesDeviseTagNode $node
	 */
	public function __construct(Nodes\DeviseModelCreatorNode $node)
	{
		$this->node = $node;

		$this->extractParameters($node);
	}

	/**
	 * Unique cid that is used for this model creator
	 *
	 * @return string
	 */
	public function cid()
	{
		return sha1('model-creator' . $this->modelName . $this->humanName);
	}

	/**
	 * Replaces the data-devise-create-model in the view
	 *
	 * @param  string $view
	 * @return string
	 */
	public function replaceModelCreateTagInView($view)
	{
		$searchFor = $this->node->matched;

		$replacement = ' data-dvs-cid-' . $this->cid();

		return str_replace($searchFor, $replacement, $view);
	}

	/**
	 * The string that adds this model creator to the dvsPageData
	 * singleton registered in the Laravel IoC container
	 *
	 */
	public function addToDevisePageStr()
	{
		$cid = $this->cid();

		$modelName = $this->modelName;

		$humanName = $this->humanName;

		return "App::make('dvsPageData')->addModelCreator(\"$cid\", \"$modelName\", \"$humanName\");";
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

		$this->modelName = $params[0];
		$this->humanName = isset($params[1]) && $params[1] && $params[1] !== 'null' ? $params[1] : 'Create New ' . $params[0];
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
		$pattern = ' data-devise-create-model="';

		$offset = strpos($matched, $pattern);
		$size = strlen($pattern);
		$end = strlen($matched) - $offset - $size - 1;

		if ($offset === false)
		{
			throw new Exceptions\InvalidDeviseTagException('Could not find data-devise-create-model in this node:' . $matched);
		}

		return substr($matched, $offset + $size, $end);
	}
}