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
        $this->items = $this->overrideKeyValuePairs($items, $overrides);
    }

    /**
     * Override only the key value pairs
     *
     * @param  array $items
     * @param  array $overrides
     * @return array
     */
    private function overrideKeyValuePairs($items, $overrides)
    {
        foreach ($overrides as $key => $value)
        {
            if (!is_array($value))
            {
                $items[$key] = $value;
            }
            else
            {
                $items[$key] = $this->overrideKeyValuePairs($items[$key], $value);
            }
        }

        return $items;
    }
}