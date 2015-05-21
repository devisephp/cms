<?php namespace Devise\Pages\Viewvars;

class DataCrawlerTest extends \DeviseTestCase
{
    public function test_it_extracts_data()
    {
        $obj = new DataCrawler;
        assertEquals('here', $obj->extract(['some' => ['data' => 'here']], 'some.data'));
    }
}