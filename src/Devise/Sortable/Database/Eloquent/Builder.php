<?php namespace Devise\Sortable\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Sort;

class Builder extends BaseBuilder {

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
