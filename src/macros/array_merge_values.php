<?php

if (!function_exists('array_merge_values'))
{
	function array_merge_values($items, $overrides)
	{
	    foreach ($overrides as $key => $value)
	    {
	        if (!is_array($value))
	        {
	            $items[$key] = $value;
	        }
	        else
	        {
	            $items[$key] = array_key_exists($key, $items) ? $items[$key] : array();
	            $items[$key] = array_merge_values($items[$key], $value);
	        }
	    }

	    return $items;
	}
}