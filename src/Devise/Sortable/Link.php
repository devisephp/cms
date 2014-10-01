<?php namespace Devise\Sortable;

use Input;
use Request;

class Link {

    function __construct($field = null, $label = null, $options = array(), $defaultOrderBy = array())
    {
        $this->field = $field;
        $this->label = $label;
        $this->options = $options;
        $this->defaultOrderBy = $defaultOrderBy;
    }

    public function getClearSortLink($text, $options) {
        $params['clearSort'] = 1;
        $url = Request::url() . '?' . http_build_query($params);

	    return link_to($url, $text, $options);
    }

    public function getLink($cookie) {

        list($relationship, $field) = $this->bustUpField($this->field);
        $currentlySorted = $this->findIfCurrentSorted($cookie, $relationship, $field);
        list($classes, $options) = $this->getBaseClasses($this->options);
        list($currentDirection, $classes) = $this->getDirection($field, $relationship, $classes, $currentlySorted);

        $text = (!is_null($this->label)) ? $this->label : ucfirst(str_replace('_','',$field));
	    $number = $this->getMultiSortOrder($currentlySorted, $cookie);
        $params = $this->getLinkParameters($field, $options, $currentDirection, $relationship);
        $url = Request::url() . '?' . http_build_query($params);

        $class = implode(' ', $classes);

        return '<a href="'.$url.'" class="'.$class.'">'.$text.'</a> '.$number;
    }

    /**
     * @param $options
     * @return array
     */
    protected function getBaseClasses($options)
    {
        $classes = ['page-sort'];
        if (isset($options['class'])) {
            $classes[] = $options['class'];
            return array($classes, $options);
        }

        return array($classes, $options);
    }

    /**
     * @param $field
     * @param $classes
     * @return array
     */
    protected function getDirection($field, $relationship, $classes, $currentlySorted) {
	    $currentDirection = 'desc';

	    if ( ( Input::has( 'dir' ) && Input::get( 'orderBy' ) == $field && Input::get( 'relationship' ) == $relationship ) ) {
		    $currentDirection = Input::get( 'dir' );
		    $classes[]        = $currentDirection;
	    } else if (count($currentlySorted) > 1) {
		    $currentDirection = $currentlySorted['dir'];
		    $classes[]        = $currentDirection;
        } else if ($this->defaultOrderBy != [] && $this->defaultOrderBy[0] == $field && !Input::has('orderBy')) {
            $currentDirection = (isset($this->defaultOrderBy[1])) ? $this->defaultOrderBy[1] : $currentDirection;
            $classes[] = $currentDirection;
        }

        return array($currentDirection, $classes);
    }

    /**
     * @param $field
     * @param $options
     * @param $currentDirection
     * @param $relationship
     * @return mixed
     */
    protected function getLinkParameters($field, $options, $currentDirection, $relationship = null)
    {
        $params = Input::except('dir', 'orderBy', 'multisort', 'relationship', 'clearSort');
        $params['dir'] = ($currentDirection == 'asc') ? 'desc' : 'asc';
        $params['orderBy'] = $field;

        if ($relationship !== null) {
            $params['relationship'] = $relationship;
        }

        if (isset($options['foreign_key'])) {
            $params['key'] = $options['foreign_key'];
        }

	    if (isset($options['multisort'])) {
		    $params['multisort'] = true;
	    }

        return $params;
    }

    /**
     * @param $field
     * @return array
     */
    protected function bustUpField($field)
    {
        $relationship = null;
        if (strpos($field, '.') > -1) {
            $optArr = explode('.', $field);
            $relationship = $optArr[0];
            $field = $optArr[1];
            return array($relationship, $field);
        }
        return array($relationship, $field);
    }

    private function findIfCurrentSorted($cookie, $relationship, $field)
    {
	    $i = 1;
        foreach($cookie as $c) {

            if ((!isset($c['relationship']) || $c['relationship'] == $relationship) && (isset($c['orderBy']) && $c['orderBy'] == $field)) {
	            $c['count'] = $i;
                return $c;
            }
	        $i++;
        }

        return false;
    }

	private function getMultiSortOrder( $currentlySorted, $cookie) {
		if (count($cookie) > 1) {
			return '<span class="dvs-sort-number">'.$currentlySorted['count'].'</span>';
		}

		return null;
	}
} 