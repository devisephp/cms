<?php namespace Devise\Pages\Interpreter;

/**
 * Extract out information from variables
 *
 */
class DeviseModelExtractor
{
	/**
	 * Holds the chain of calls to this model
	 *
	 * @var array
	 */
	protected $chain, $model, $attribute;

	/**
	 * Create a new devise model extractor for this
	 * chain array of calls to a model
	 *
	 * @param array $chain
	 */
	public function __construct($chain)
	{
		$this->setVariables($chain);
	}

	/**
	 * Extracts a model from this chain
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function model()
	{
		return $this->model;
	}

	/**
	 * Attribute for this extractor
	 *
	 * @return mixed
	 */
	public function attribute()
	{
		return $this->attribute;
	}

	/**
	 * Setup the variables for this extractor
	 * specifically the model and attribute properties
	 *
	 * @return  void
	 */
	protected function setVariables($chain)
	{
		$this->chain = is_array($chain) ? $chain : array($chain);

		$iterator = new \ArrayIterator($this->chain);

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
			$this->model = $model;
			$this->attribute = null;

			return;
		}

		// didn't find the model so maybe it is an attribute
		// of a specific model, so advance the iterator

		$attribute = $iterator->key();
		$iterator->next();
		$model = $iterator->valid() ? $iterator->current() : null;

		// let's try this again
		if (is_a($model, '\Illuminate\Database\Eloquent\Model'))
		{
			$this->model = $model;
			$this->attribute = $attribute;

			return;
		}

		throw new Exceptions\InvalidDeviseTagException('Could not extract Eloquent model from devise tag');
	}
}