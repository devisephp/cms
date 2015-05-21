<?php namespace Devise\Support;

class StrTest extends \DeviseTestCase
{
    public function test_it_replaces_between_haystack_with_closure()
    {
    	$Str = new Str;
        $outcome = $Str->replaceBetween('something @here(...) and @here(...)', '@here', function($between) { return "[ $between ]"; });
        assertEquals('something [ ... ] and [ ... ]', $outcome);
    }
}