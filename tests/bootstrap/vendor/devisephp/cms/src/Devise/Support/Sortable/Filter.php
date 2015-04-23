<?php namespace Devise\Support\Sortable;

use Devise\Support\Framework;

/**
 * Class Filter
 * @package Devise\Support\Sortable
 */
class Filter
{
    /**
     * @var
     */
	private $filterName;

    /**
     * @var
     */
    private $replacementSelector;

    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $attributes;

    /**
     * @param $filterName
     * @param $replacementSelector
     * @param array $options
     * @param Framework $Framework
     */
	public function __construct($filterName, $replacementSelector, $options = array(), Framework $Framework)
	{
		$this->filterName = $filterName;
		$this->replacementSelector = $replacementSelector;
		$this->options = $options;
		$this->attributes = $this->getAttributesFromOptions($options);
        $this->View = $Framework->View;
	}

	/**
	 * Get the field for this Filter, basically
	 * the <input type="text" ...> html
	 *
	 * @return string
	 */
	public function getField()
	{
		$filterName = $this->filterName;
		$replacementSelector = $this->replacementSelector;
		$attributes = $this->attributes;

		return $this->View->make('devise::elements.sort-filter', compact('filterName', 'replacementSelector', 'attributes'))->render();
	}

	/**
	 * Get the attributes as a string from the
	 * options array
	 *
	 * @param  array $options
	 * @return string
	 */
	private function getAttributesFromOptions($options)
	{
		$attributes = '';

		foreach ($options as $optionName => $optionValue) {
			$attributes .= " {$optionName} = \"{$optionValue}\"";
		}

		return $attributes;
	}
}