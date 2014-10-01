<?php
use Devise\Pages\Repositories\BaseRepository;
use Mockery as m;

class BaseRepositoryTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * tests simpleStore()
     * tests that find validation failure will return false and have errors
     */
    public function testSimpleStoreFail()
    {
        $Page = m::mock('Page');
        Validator::shouldReceive('make')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('passes')
            ->andReturn(false)
            ->shouldReceive('errors')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('all')
            ->once()
            ->andReturn('there was an errors');

       $BaseRepository = new BaseRepository();
       $result = $BaseRepository->simpleStore($Page, array(
            'name' => 'test',
        ));

       $this->assertFalse($result);
       $this->assertEquals('there was an errors', $BaseRepository->errors);
    }

    /**
     * tests simpleStore()
     * tests that validation success will create a new model and return the result
     */
    public function testSimpleStoreSuccess()
    {
        $Page = m::mock('Page');
        $Page->shouldReceive('create')
            ->once()
            ->andReturn(m::self());

        Validator::shouldReceive('make')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('passes')
            ->andReturn(true);

       $BaseRepository = new BaseRepository();
       $result = $BaseRepository->simpleStore($Page, array(
            'name' => 'test',
        ));

       $this->assertEquals($result, $Page);
    }

    /**
     * tests simpleUpdate()
     * tests that find validation failure will return false and have errors
     */
    public function testSimpleUpdateFail()
    {
        $id = 1;
        $Page = m::mock('Page');
        Validator::shouldReceive('make')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('passes')
            ->andReturn(false)
            ->shouldReceive('errors')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('all')
            ->once()
            ->andReturn('there was an errors');

       $BaseRepository = new BaseRepository();
       $result = $BaseRepository->simpleUpdate($Page, $id, array(
            'name' => 'test',
        ));

       $this->assertFalse($result);
       $this->assertEquals('there was an errors', $BaseRepository->errors);
    }

    /**
     * tests simpleUpdate()
     * tests that validation success will create a new model and return the result
     */
    public function testSimpleUpdateSuccess()
    {
        $id = 1;
        $Page = m::mock('Page');
        $Page->shouldReceive('findOrFail')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('update')
            ->once()
            ->andReturn(m::self());

        Validator::shouldReceive('make')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('passes')
            ->andReturn(true);

       $BaseRepository = new BaseRepository();
       $result = $BaseRepository->simpleUpdate($Page, $id, array(
            'name' => 'test',
        ));

       $this->assertEquals($result, $Page);
    }
}