<?php namespace Devise\Support\Sortable;

class EloquentModelTest extends \DeviseTestCase
{
    public function test_it_overrides_new_query()
    {
        $pages = new \DvsPage;
        $builder = $pages->newQuery();
        assertInstanceOf('Devise\Support\Sortable\EloquentBuilder', $builder);
    }
}