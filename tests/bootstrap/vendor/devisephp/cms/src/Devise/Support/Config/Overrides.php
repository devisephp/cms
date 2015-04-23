<?php namespace Devise\Support\Config;

class Overrides extends \Illuminate\Config\Repository
{
    /**
     * The items
     *
     * @var array
     */
    protected $items = [];

    /**
     * create a new config overrides
     *
     * @param array $items
     * @param array $overrides
     */
    public function __construct(array $items = array(), array $overrides = array())
    {
        $this->items = array_merge($items, $overrides);
    }
}