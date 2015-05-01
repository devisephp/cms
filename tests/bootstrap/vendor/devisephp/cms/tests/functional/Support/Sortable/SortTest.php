<?php namespace Devise\Support\Sortable;

use Mockery as m;

class SortTest extends \DeviseTestCase
{
    public function test_it_gets_a_link()
    {
        $Manager = m::mock('Devise\Support\Sortable\Manager');
        $Manager->shouldReceive('getStack')->times(1)->andReturn([]);
        $Framework = new \Devise\Support\Framework;
        $Sort = new Sort($Manager, $Framework);
        assertEquals('<a href="http://localhost?dir=asc&orderBy=someField" class="page-sort">SomeField</a> ', $Sort->link('someField'));
    }

    public function test_it_gets_a_clear_sort_link()
    {
        $Manager = m::mock('Devise\Support\Sortable\Manager');
        $Framework = new \Devise\Support\Framework;
        $Sort = new Sort($Manager, $Framework);
        assertEquals('<a href="http://localhost?clearSort=1">Some label</a>', $Sort->clearSortLink('Some label'));
    }

    public function test_it_gets_a_filter()
    {
        $Manager = m::mock('Devise\Support\Sortable\Manager');
        $Framework = new \Devise\Support\Framework;
        $Sort = new Sort($Manager, $Framework);
        assertEquals('<input type="text" name="dvs-filters[filtername]" data-dvs-replacement="[some-selector]" value="" >', $Sort->filter('filtername', '[some-selector]'));
    }

    public function test_it_sets_default_order_by()
    {
        $Manager = m::mock('Devise\Support\Sortable\Manager');
        $Framework = new \Devise\Support\Framework;
        $Sort = new Sort($Manager, $Framework);
        $Sort->setDefaultOrderBy('fieldname');
    }

    public function test_it_handles_sorting()
    {
        \Input::merge(['orderBy' => 'title', 'dir' => 'ASC']);
        $pages = \DvsPage::paginate();

        // page with id 1 is probably not the first since we ordered by title
        // assertNotEquals(1, $pages[0]->id);
    }

    public function test_it_handles_filtering()
    {
        \Input::merge(['dvs-filters' => ['slug' => '/admin/media-manager/category']]);
        $pages = \DvsPage::paginate();

        // are pages filtered?
        // assertCount(2, $pages);
    }
}