<?php namespace Devise\Support\Sortable;

class FilterTest extends \DeviseTestCase
{
    public function test_it_gets_field()
    {
        $Framework = new \Devise\Support\Framework;
        $Filter = new Filter("some_filter", "some replacement selector", ['option1' => 'value1', 'option2' => 'value2'], $Framework);
        assertEquals('<input type="text" name="dvs-filters[some_filter]" data-dvs-replacement="some replacement selector" value=""  option1 = "value1" option2 = "value2">', $Filter->getField());
    }
}