<?php namespace Devise\Support\Sortable;

use Devise\Support\Framework;

/**
 * Class Sort handles creating links and filters for us which
 *
 * @package Devise\Support\Sortable
 */
class Sort
{
    /**
     * @var array
     */
	protected $defaultOrderBy;

    /**
     * @var Manager
     */
    protected $Manager;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $Input;

    /**
     * @var Framework
     */
    protected $Framework;

    /**
     * @param Manager $Manager
     * @param Framework $Framework
     */
    function __construct(Manager $Manager, Framework $Framework)
    {
        $this->Manager = $Manager;
        $this->Framework = $Framework;
        $this->Input = $Framework->Input;
        $this->defaultOrderBy = array();
    }

    /**
     * @param $field
     * @param null $label
     * @param array $options
     * @return string
     */
    public function link($field, $label = null, $options = array())
	{
        $Link = new Link($this->Framework, $field, $label, $options, $this->defaultOrderBy);
		return $Link->getLink($this->Manager->getStack());
	}

    /**
     * @param string $label
     * @param null $options
     * @return string
     */
    public function clearSortLink($label = 'Clear Sort', $options = null)
    {
        $Link = new Link($this->Framework);
        return $Link->getClearSortLink($label, $options);
    }

    /**
     * @param $filterName
     * @param $elementSelector
     * @param array $options
     * @return string
     */
	public function filter($filterName, $elementSelector, $options = array())
	{
		$Filter = new Filter($filterName, $elementSelector, $options, $this->Framework);
		return $Filter->getField();
	}

	/**
	 * Sets the default value of defaultOrderBy
	 *
	 * @param  string    $field
	 * @param  string  $dir
	 * @return void
	 */
	public function setDefaultOrderBy($field, $dir = 'asc')
	{
		$this->defaultOrderBy = [$field, $dir];
	}

	/**
	 * Ads orderBy to the current query in builder
	 *
	 * @param  QueryBuilder    $query
	 * @param  Model  $model
	 * @return void
	 */
	public function handleSorting(&$query, $model)
	{
        if($this->Input->has('clearSort')) {
            $this->Manager->clearStack();
        }

		if($this->Input->has('multisort')) {
			$this->Manager->setIsMulti(true);
		}

		$sortStack = $this->Manager->getStack();

		if($this->Input->has('orderBy') || count($sortStack) > 0){

	        if(!$this->Input->has('multisort') && !$this->Manager->getIsMulti() && $this->Input->has('orderBy')) {
		        $this->Manager->clearStack();
	        }

	        $this->Manager->addToStack($this->Input->all());
	        $sortStack = $this->Manager->getStack();

	        foreach($sortStack as $sort) {
		        $query = $this->appendSort( $query, $model, $sort );
	        }

		} else if(count($this->defaultOrderBy) > 0) {
	        $query = $this->sortByDefault($query, $model );
		}
	}

	/**
	 * We process filtering on this query if there
	 * is any $this->Input->get() found for dvs-filters
	 * this is used in Sortable\Database\Eloquent\Builder.paginate
	 *
	 * It's magic... really.
	 *
	 * @param  QueryBuilder $query
	 * @param  Eloquent     $model
	 * @return  void
	 */
	public function handleFiltering(&$query, $model)
	{
		$filters = $this->Input->get('dvs-filters', array());

        foreach ($filters as $filterName => $filterValue)
		{
			$query->where($filterName, 'LIKE', "%{$filterValue}%");
		}
	}

	/**
	 * @param $query
	 * @param $model
	 * @param $sort
	 *
	 * @return mixed
	 */
	protected function appendSort( &$query, $model, $sort ) {

		$relation = null;
		if(isset($sort['relationship'])) {
			$function = $sort['relationship'];
			$relation = $model->$function();

			switch ( get_class( $relation ) ) {
				case 'Illuminate\Database\Eloquent\Relations\MorphMany':
					$query = $this->morphMany( $relation, $query, $model, $sort['orderBy'], $sort['dir'] );
					break;

				case 'Illuminate\Database\Eloquent\Relations\BelongsTo':
					$query = $this->belongsTo( $relation, $query, $model, $sort['orderBy'], $sort['dir'] );
					break;

				case 'Illuminate\Database\Eloquent\Relations\HasOne':
					$query = $this->hasOne( $relation, $query, $model, $sort['orderBy'], $sort['dir'] );
					break;
			}
		} else {
			if ( isset( $sort['orderBy'] ) ) {
					$query = $query->orderBy( $sort['orderBy'], $sort['dir'] );
			}
		}

		return $query;
	}

    /**
     * @param $relation
     * @param $query
     * @param $model
     * @param $orderBy
     * @param $direction
     * @return mixed
     */
	protected function hasOne($relation, $query, $model, $orderBy, $direction)
    {
		$relatedTable = $relation->getRelated()->getTable();
		$alias = $this->get_random_string(15);

		$query = $query
			->leftJoin($relatedTable . ' as ' . $alias, $model->getTable(). '.' . $model->getKeyName(), '=', $alias . '.' . $model->getForeignKey())
			->orderBy($alias.'.'.$orderBy, $direction);

		$query = $this->setSelectFromBindings($query, $model);

		return $query;
	}

    /**
     * @param $relation
     * @param $query
     * @param $model
     * @param $orderBy
     * @param $direction
     * @return mixed
     */
	protected function belongsTo($relation, $query, $model, $orderBy, $direction)
    {
        $relatedTable = $relation->getRelated()->getTable();
        $alias = $this->get_random_string(15);

        $query = $query
            ->leftJoin($relatedTable . ' as ' . $alias, $model->getTable(). '.' . $relation->getForeignKey(), '=', $alias . '.' . $model->getKeyName())
            ->orderBy($alias.'.'.$orderBy, $direction);

        $query = $this->setSelectFromBindings($query, $model);

        return $query;
    }

    /**
     * @param $relation
     * @param $query
     * @param $model
     * @param $orderBy
     * @param $direction
     * @return mixed
     */
	protected function morphMany($relation, $query, $model, $orderBy, $direction)
    {
		$relatedTable = $relation->getRelated()->getTable();
        $alias = $this->get_random_string(15);
        $aliasedForeignKey = $this->getAliasedForeignKey($relation, $alias);

		$query = $query
			->join($relatedTable . ' as ' . $alias, function($join) use ($model, $aliasedForeignKey){
				$join->on($aliasedForeignKey, '=', $model->getTable() . '.' . $model->getKeyName());
			})
	        ->orderBy($alias.'.'.$orderBy, $direction);

        $query = $this->setSelectFromBindings($query, $model);

        return $query;
	}

	/**
     * @param $query
     * @param $model
     */
    protected function setSelectFromBindings($query, $model)
    {
        $bindings = $query->getRawBindings();

        if (count($bindings['select']) < 1) {
            $query->select($model->getTable() . '.*');
        }

        return $query;
    }

	/**
     * @param $relation
     * @param $alias
     * @return string
     */
    protected function getAliasedForeignKey($relation, $alias)
    {
        $foreignKeyParts = explode('.', $relation->getForeignKey());
        $fk = (isset($foreignKeyParts[1])) ? $foreignKeyParts[1] : $relation->getForeignKey();

        return $alias . '.' . $fk;
    }

    /**
     * @param $length
     * @param string $valid_chars
     * @return string
     */
	protected function get_random_string($length, $valid_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $string = "";
        $num_valid_chars = strlen($valid_chars);

        for ($i = 0; $i < $length; $i++)
        {
            $random_pick = mt_rand(1, $num_valid_chars);
            $random_char = $valid_chars[$random_pick-1];
            $string .= $random_char;
        }

        return $string;
    }

	/**
     *
	 * @param $model
	 * @return mixed
	 */
	protected function sortByDefault( $query, $model )
    {
		$sort = array();
		$orderBy    = explode( '.', $this->defaultOrderBy[0] );

		$sort['dir']              = (isset($this->defaultOrderBy[1])) ? $this->defaultOrderBy[1] : 'asc';

		if(count($orderBy) !== 2) {
			$sort['orderBy']      = $orderBy[0];
		} else {
			$sort['relationship'] = $orderBy[0];
			$sort['orderBy']      = $orderBy[1];
		}

		$query = $this->appendSort( $query, $model, $sort );

		return $query;
	}

}
