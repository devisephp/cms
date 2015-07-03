<?php namespace Devise\Pages;

use Mockery as m;

class ApiPagesRespostoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->counter = 0;
        $this->DvsPage = new \DvsPage;
        $this->ApiPagesRepository = new ApiPagesRepository($this->DvsPage);
    }

    public function test_it_finds_page()
    {
        $page = $this->ApiPagesRepository->find(1);
        assertEquals(1, $page->id);
    }

    public function test_it_finds_pages()
    {
        $pageCount = \DB::table('dvs_pages')->where('response_type', 'Function')->count();
        $this->createTestPage([]);
        $this->createTestPage(['id'=>99998], 'Function');
        $pages = $this->ApiPagesRepository->pages();
        assertEquals($pageCount + 1, $pages->total());
    }

    /**
     * Helper function to create test pages in database
     *
     * @param $input
     */
    protected function createTestPage($input, $type = 'View')
    {
        $this->counter++;

        $input = array_merge([
            'id'                      => '99999',
            'language_id'             => '45',
            'view'                    => 'some.view',
            'title'                   => 'Some test title',
            'http_verb'               => 'get',
            'route_name'              => 'page' . $this->counter,
            'is_admin'                => '0',
            'dvs_admin'               => '0',
            'slug'                    => '/page' . $this->counter,
            'response_type'           => $type,
            'short_description'       => 'A short description',
        ], $input);

        // create a non-dvsadmin page
        \DB::table('dvs_pages')->insert($input);
    }
}
