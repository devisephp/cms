<?php namespace Devise\Search;

/**
 * Class UniversalSearch lets us register new searchable models
 * and then search through all of them
 *
 * @package Devise\Search
 */
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
     * @param $for
     * @param int $page
     * @param int $perPage
     * @throws \Devise\Support\DeviseException
     * @return array
     */
	public function search($for, $page = 1, $perPage = 10)
	{
    $collection = collect();
    if ($for != '') {
  		$limit = 100;

  		if ($perPage > $limit) throw new \Devise\Support\DeviseException("Cannot have more than $limit results per page");

  		// first pass, give everyone a fair chance to get into the collection
  		$collection = $this->searchRegistered($for, $limit);

  		// now that everyone had a chance to get into
  		// the search collection we can add more if needed
      $leftover = $collection ? $limit - $collection->count() : $limit;

  		// second pass to fill the gap of empty results (if we haven't filled it up)
  		if ($leftover)
  		{
  			$collection = $this->searchRegisteredSecondPass($for, $limit, $leftover, $collection);
  		}

  		// now we sort everything by relevance
  		$collection->sortByDesc('relevance');
    }

		// let's paginate!
		return $this->Pagination->make($collection, $page, $perPage);
	}

	/**
	 * Search all the registered searchables
     *
	 * @param  text $for
	 * @param  integer $limit
	 * @return Collection
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
	 * On the second pass it's all about trying to take up
     * as much of the leftovers as you want, like an all you
     * can eat salad bar
     *
	 * @param  string $for
	 * @param  integer $limit
	 * @param  integer $leftover
	 * @param  Collection $collection
	 * @return Collection
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
