<?php namespace Devise\Support\Sortable;

use Sort;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;

/**
 * Class EloquentBuilder is ran on paginate queries only and takes
 * the liberty of sorting and filtering results for us smartly and
 * magically...
 *
 * @package Devise\Support\Sortable
 */
class EloquentBuilder extends BaseBuilder
{
	/**
	 * Get a paginator for the "select" statement.
	 *
	 * @param  int    $perPage
	 * @param  array  $columns
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function paginate($perPage = null, $columns = array('*'))
	{
		Sort::handleSorting($this->query, $this->model);

		Sort::handleFiltering($this->query, $this->model);

		return parent::paginate($perPage, $columns);
	}
}
