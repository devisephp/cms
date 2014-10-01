<?php
use Devise\Pages\Repositories\PagesRepository;
use Mockery as m;

class PagesRepositoryTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * tests find()
     * tests that find calls with and findOrFail on Page
     */
    public function testFindReturnsData()
    {
        $Page = m::mock('Page');
        $Page->shouldReceive('with')
            ->once()
            ->with('fields')
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->once()
            ->with(2)
            ->andReturn('test');

       $PagesRepository = new PagesRepository($Page);
       $this->assertEquals('test', $PagesRepository->find(2));
    }

    /**
     * tests findBySlug()
     * tests that findBySlug calls with, whereSlug, and firstOrFail on Page
     */
    public function testFindBySlugWith()
    {
        $slug = 'awesome-slug';
        $Page = m::mock('Page');
        $Page->shouldReceive('with')
            ->once()
            ->with('fields')
            ->andReturn(m::self())
            ->shouldReceive('whereSlug')
            ->once()
            ->with( $slug )
            ->andReturn(m::self())
            ->shouldReceive('firstOrFail')
            ->once()
            ->andReturn('test');

        $PagesRepository = new PagesRepository($Page);
        $this->assertEquals('test', $PagesRepository->findBySlug( $slug ));
    }

    /**
     * tests pages()
     * tests that findBySlug calls paginate on Page
     */
    public function testPages()
    {
        $slug = 'awesome-slug';
        $Page = m::mock('Page');
        $Page->shouldReceive('paginate')
            ->once()
            ->andReturn('test');

        $PagesRepository = new PagesRepository($Page);
        $this->assertEquals('test', $PagesRepository->pages());
    }

    /**
     * tests update()
     * tests that simpleUpdate on self
     */
    public function testUpdate()
    {
        $input = 'test-input';
        $id = 13;
        $Page = m::mock('Page');

        $PagesRepository = m::mock('Devise\Pages\Repositories\PagesRepository', array($Page))->makePartial();
        $PagesRepository->shouldReceive('simpleUpdate')
            ->once()
            ->withArgs(array( $Page, $id, $input))
            ->andReturn('test');

        $this->assertEquals('test', $PagesRepository->update($id, $input));
    }

    /**
     * tests store()
     * tests that simpleStore on self
     */
    public function testStore()
    {
        $input = 'test-input';
        $Page = m::mock('Page');

        $PagesRepository = m::mock('Devise\Pages\Repositories\PagesRepository', array($Page))->makePartial();
        $PagesRepository->shouldReceive('simpleStore')
            ->once()
            ->withArgs(array( $Page,  $input))
            ->andReturn('test');

        $this->assertEquals('test', $PagesRepository->store($input));
    }
}