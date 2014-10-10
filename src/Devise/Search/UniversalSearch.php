<?php namespace Devise\Search;

class UniversalSearch
{
	/**
	 * These are all the registered search
	 * providers that we will use in our
	 * universal search
	 *
	 * @var array[SearchableInterface]
	 */
	protected $registered = [];

	/**
	 * Create a new universal search
	 */
	public function __construct(Pagination $Pagination)
	{
		$this->Pagination = $Pagination;
	}

	/**
	 * Provides a way to register new searchable items
	 * in our collection of Searchable items
	 *
	 * @param  Searchable $item
	 * @return void
	 */
	public function register($item)
	{
		$this->registered[] = $item;
	}

	/**
	 * Search through all registered searchers
	 * and put them together in results
	 *
	 * @param  string $text
	 * @return array
	 */
	public function search($for, $page = 1, $perPage = 10)
	{
		$limit = 100;

		if ($perPage > $limit) throw new \Exception("Cannot have more than $limit results per page");

		// first pass, give everyone a fair chance to get into the collection
		$collection = $this->searchRegistered($for, $limit);

		// now that everyone had a chance to get into
		// the search collection we can add more if needed
		$leftover = $limit - $collection->count();

		// second pass to fill the gap of empty results (if we haven't filled it up)
		if ($leftover)
		{
			$collection = $this->searchRegisteredSecondPass($for, $limit, $leftover, $collection);
		}

		// now we sort everything by relevance
		$collection->sortByDesc('relevance');

		// let's paginate!
		return $this->Pagination->make($collection, $page, $perPage);
	}

	/**
	 * [searchRegistered description]
	 * @param  [type] $for   [description]
	 * @param  [type] $limit [description]
	 * @return [type]        [description]
	 */
	protected function searchRegistered($for, $limit)
	{
		$collection = null;
		$numberOfSearchers = count($this->registered);

		foreach ($this->registered as $registered)
		{
			$results = $registered->search($for)->take($limit / $numberOfSearchers)->get();
			$collection = $collection ? $collection->merge($results) : $results;
		}

		return $collection;
	}

	/**
	 * [searchRegisteredSecondPass description]
	 * @param  [type] $for        [description]
	 * @param  [type] $limit      [description]
	 * @param  [type] $leftover   [description]
	 * @param  [type] $collection [description]
	 * @return [type]             [description]
	 */
	protected function searchRegisteredSecondPass($for, $limit, $leftover, $collection)
	{
		$max = $limit / count($this->registered);

		foreach ($this->registered as $registered)
		{
			if ($leftover < 1) continue;

			$results = $registered->search($for)->take($leftover)->skip($max)->get();
			$collection = $results->count() > 0 ? $collection->merge($results) : $collection;
			$leftover = $leftover - $results->count();
		}

		return $collection;
	}
}