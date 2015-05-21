<?php namespace Devise\Support\Sortable;

use Devise\Support\Framework;

/**
 * Class Manager changes the cookie/session keys for multisorts
 *
 * @package Lbm\Sortable
 */
class Manager
{
    /**
     * @var string
     */
    private $key;

    /**
     * Construct a new Manager for sorting
     *
     * @param Framework $Framework
     */
    function __construct(Framework $Framework)
    {
        preg_match_all('/[a-zA-Z]/', $Framework->URL->current(), $matches);
        $this->key = implode($matches[0]);
        $this->Session = $Framework->Session;
    }

	/**
	 * @return mixed
	 */
	public function getIsMulti()
    {
		return $this->Session->get($this->key . '_multisort');
	}

	/**
	 * @param mixed $isMulti
	 */
	public function setIsMulti( $isMulti )
    {
		return $this->Session->put($this->key . '_multisort', $isMulti);
	}

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @param $all
     */
    public function addToStack($all)
    {
        $newSort = array_only($all, array('dir', 'orderBy', 'relationship'));
        $cookie = $this->getStack();
        $cookie = $this->setCookie($all, $cookie, $newSort);
        $this->writeCookie($cookie);
    }

    /**
     * @param $all
     */
    public function removeFromStack($all)
    {
        $newSort = array_only($all, array('dir', 'orderBy', 'relationship'));
        $cookie = $this->getStack();
        $cookie = $this->removeFromCookie($all, $cookie, $newSort);
        $this->writeCookie($cookie);
    }

    /**
     * @return mixed
     */
	public function getStack()
	{
		return $this->Session->get($this->key, array());
	}

    /**
     *
     */
    public function clearStack()
    {
        $this->Session->forget($this->key);
        $this->Session->forget($this->key.'_multisort');
    }

    /**
     * @param $cookie
     * @return mixed
     */
    private function writeCookie($cookie)
    {
        return $this->Session->put($this->key, $cookie);
    }

    /**
     * @param $all
     * @param $cookie
     * @param $newSort
     * @return mixed
     */
    private function setCookie($all, $cookie, $newSort)
    {
        $set = false;
        foreach ($cookie as $key => $c) {
	        if (isset($c['orderBy']) && isset($newSort['orderBy'])) {
		        if ( $c['orderBy'] == $newSort['orderBy'] && ( ! isset( $c['relationship'] ) || $c['relationship'] == $newSort['relationship'] ) ) {
			        $cookie[ $key ] = $all;
			        $set            = true;
		        }
	        }
        }

        if (!$set) {
            array_push($cookie, $newSort);
            return $cookie;
        }
        return $cookie;
    }

    /**
     * @param $all
     * @param $cookie
     * @param $newSort
     * @return mixed
     */
    private function removeFromCookie($all, $cookie, $newSort)
    {
        foreach ($cookie as $key => $c) {
            if ($c['orderBy'] == $newSort['orderBy'] && $c['relationship'] == $newSort['relationship']) {
                unset($cookie[$key]);

                return $cookie;
            }
        }
        return $cookie;
    }
}