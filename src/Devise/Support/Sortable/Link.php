<?php namespace Devise\Support\Sortable;

use Devise\Support\Framework;

/**
 * Class Link returns html <a> anchor tags when given parameters
 * this field helps create the up and down sorting links when
 * filtering html table columns
 *
 * @package Devise\Support\Sortable
 */
class Link
{
    /**
     * Construct a new link
     *
     * @param Framework $Framework
     * @param null $field
     * @param null $label
     * @param array $options
     * @param array $defaultOrderBy
     */
    public function __construct(Framework $Framework, $field = null, $label = null, $options = array(), $defaultOrderBy = array())
    {
        $this->field = $field;
        $this->label = $label;
        $this->options = $options;
        $this->defaultOrderBy = $defaultOrderBy;
        $this->Request = $Framework->Request;
        $this->Input = $Framework->Input;
    }

    /**
     * @param $text
     * @param $options
     * @return string
     */
    public function getClearSortLink($text, $options)
    {
        $params['clearSort'] = 1;
        $url = $this->Request->url() . '?' . http_build_query($params);

	    return link_to($url, $text, $options);
    }

    /**
     * @param $cookie
     * @return string
     */
    public function getLink($cookie)
    {
        list($relationship, $field) = $this->bustUpField($this->field);
        $currentlySorted = $this->findIfCurrentSorted($cookie, $relationship, $field);
        list($classes, $options) = $this->getBaseClasses($this->options);
        list($currentDirection, $classes) = $this->getDirection($field, $relationship, $classes, $currentlySorted);

        $text = (!is_null($this->label)) ? $this->label : ucfirst(str_replace('_','',$field));
	    $number = $this->getMultiSortOrder($currentlySorted, $cookie);
        $params = $this->getLinkParameters($field, $options, $currentDirection, $relationship);
        $url = $this->Request->url() . '?' . http_build_query($params);

        $class = implode(' ', $classes);

        return '<a href="'.$url.'" class="'.$class.'">'.$text.'</a> '.$number;
    }

    /**
     *
     * @param $options
     * @return array
     */
    protected function getBaseClasses($options)
    {
        $classes = ['page-sort'];
        if (isset($options['class']))
        {
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
    protected function getDirection($field, $relationship, $classes, $currentlySorted)
    {
	    $currentDirection = 'desc';

	    if ( ( $this->Input->has( 'dir' ) && $this->Input->get( 'orderBy' ) == $field && $this->Input->get( 'relationship' ) == $relationship ) ) {
		    $currentDirection = $this->Input->get( 'dir' );
		    $classes[]        = $currentDirection;
	    } else if ($currentlySorted && count($currentlySorted) > 1) {
		    $currentDirection = $currentlySorted['dir'];
		    $classes[]        = $currentDirection;
        } else if ($this->defaultOrderBy != [] && $this->defaultOrderBy[0] == $field && !$this->Input->has('orderBy')) {
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
        $params = $this->Input->except('dir', 'orderBy', 'multisort', 'relationship', 'clearSort');
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
        if (strpos($field, '.') > -1)
        {
            $optArr = explode('.', $field);
            $relationship = $optArr[0];
            $field = $optArr[1];
            return array($relationship, $field);
        }

        return array($relationship, $field);
    }

    /**
     * @param $cookie
     * @param $relationship
     * @param $field
     * @return bool
     */
    private function findIfCurrentSorted($cookie, $relationship, $field)
    {
	    $i = 1;
        foreach ($cookie as $c)
        {
            if ((!isset($c['relationship']) || $c['relationship'] == $relationship) && (isset($c['orderBy']) && $c['orderBy'] == $field))
            {
	            $c['count'] = $i;
                return $c;
            }
	        $i++;
        }

        return false;
    }

    /**
     * @param $currentlySorted
     * @param $cookie
     * @return null|string
     */
	private function getMultiSortOrder( $currentlySorted, $cookie)
    {
		if (count($cookie) > 1)
        {
			return '<span class="dvs-sort-number">'.$currentlySorted['count'].'</span>';
		}

		return null;
	}
}
