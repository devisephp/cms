<?php namespace Devise\Sortable;

use View;
use Devise\Pages\Data\DataBuilder;
use Devise\Pages\Data\DataCrawler;

class Filter {

	private $filterName, $replacementSelector, $options, $attributes;

	function __construct($filterName, $replacementSelector, $options = array())
	{
		$this->filterName = $filterName;
		$this->replacementSelector = $replacementSelector;
		$this->options = $options;
		$this->attributes = $this->getAttributesFromOptions($options);
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

		return View::make('devise::elements.sort-filter', compact('filterName', 'replacementSelector', 'attributes'))->render();
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