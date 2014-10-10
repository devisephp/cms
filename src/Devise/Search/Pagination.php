<?php namespace Devise\Search;

use IteratorAggregate;
use Illuminate\Support\Contracts\JsonableInterface;

class Pagination implements IteratorAggregate, JsonableInterface
{
	protected $items;

	public function make($collection, $page, $perPage)
	{
		$this->perPage = $perPage;

		$this->page = $page;

		// get the total amount inside of this mixed collection
		$this->total = $collection->count();

		// we cut out the part of the collection we don't want (pseudo pagination)
		$this->items = $collection->slice(($page - 1) * $perPage, $perPage);

		// converts to real models
		$this->convertItemsToRealModel();

		// yep, it's fake... but it works
		return $this;
	}

	public function links()
	{
		return '';
	}

	public function appends()
	{
		return $this;
	}

	public function getIterator()
	{
		return $this->items->getIterator();
	}

	public function toJson($options = 0)
	{
		return json_encode(array(
			'total' => $this->total,
			'page' => $this->page,
			'per_page' => $this->perPage,
			'data' => json_decode($this->items->toJSON())
		));
	}

	protected function convertItemsToRealModel()
	{
		for ($i = 0; $i < count($this->items); $i++)
		{
			$this->items[$i]->searchType = $this->items[$i]->searchableType;
		}
	}
}