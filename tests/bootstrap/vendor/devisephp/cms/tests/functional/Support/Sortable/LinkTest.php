<?php namespace Devise\Support\Sortable;

class LinkTest extends \DeviseTestCase
{
    public function test_get_clear_sort_link()
    {
        $Framework = new \Devise\Support\Framework;
        $Link = new Link($Framework);
        $output = $Link->getClearSortLink("some text", []);
        assertEquals('<a href="http://localhost?clearSort=1">some text</a>', $output);
    }

    public function test_it_gets_link()
    {
        $Framework = new \Devise\Support\Framework;
        $cookie = [];
        $Link = new Link($Framework);
        $output = $Link->getLink($cookie);
        assertEquals('<a href="http://localhost?dir=asc" class="page-sort"></a> ', $output);
    }
}