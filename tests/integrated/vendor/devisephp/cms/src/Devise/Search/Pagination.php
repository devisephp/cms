<?php namespace Devise\Search;

use IteratorAggregate, View;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class Pagination is used so we can paginate search results
 * from many different searched models
 *
 * @package Devise\Search
 */
class Pagination implements IteratorAggregate, Jsonable
{
    /**
     * @var
     */
	protected $items;

    /**
     * @var
     */
    protected $appendsToLinkData;

    /**
     * @var
     */
    protected $appendsToLink;

    /**
     * Makes a new paginated result from a collection
     *
     * @param $collection
     * @param $page
     * @param $perPage
     * @return $this
     */
	public function make($collection, $page, $perPage)
	{
		$this->perPage = $perPage;

		$this->appendsToLinkData = array();

		$this->appendsToLink = '';

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

    /**
     * Lets us do links on this paginated object
     *
     * @return mixed
     */
	public function links()
	{
		return $this->View()->make('devise::search.pagination', $this->toArray())->render();
	}

    /**
     * Turns this paginated object into an array
     *
     * @return array
     */
	public function toArray()
	{
		return [
			'items' => $this->items,
			'total' => $this->total,
			'page' => $this->page,
			'perPage' => $this->perPage,
			'totalPageCount' => ceil($this->total / $this->perPage),
			'appends' => $this->appendsToLink,
		];
	}

    /**
     * Append input queries
     *
     * @param $data
     * @return $this
     */
	public function appends($data)
	{
		$this->appendsToLinkData = array_merge($this->appendsToLinkData, $data);

		$this->appendsToLink = '&' . http_build_query($this->appendsToLinkData);

		return $this;
	}

    /**
     * Iterator lets us traverse this paginated object
     *
     * @return \Traversable
     */
	public function getIterator()
	{
		return $this->items->getIterator();
	}

    /**
     * Turns this object into a json serialized object
     *
     * @param int $options
     * @return string
     */
	public function toJson($options = 0)
	{
		return json_encode(array(
			'total' => $this->total,
			'page' => $this->page,
			'per_page' => $this->perPage,
			'data' => json_decode($this->items->toJSON())
		));
	}

    /**
     * Turns the items into the real model. PageSearch turns into
     * Page model. We usually want that model instead...
     *
     */
	protected function convertItemsToRealModel()
	{
		for ($i = 0; $i < count($this->items); $i++)
		{
			$this->items[$i]->searchType = $this->items[$i]->searchableType;
		}
	}

    /**
     * Creates the view for us
     *
     * @return mixed
     */
    protected function View()
    {
        if (!isset($this->View))
        {
            $this->View = \View::getFacadeRoot();
        }

        return $this->View;
    }
}