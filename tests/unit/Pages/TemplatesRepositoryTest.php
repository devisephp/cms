<?php
use Devise\Pages\Repositories\TemplatesRepository;
use Devise\Support\Config\DeviseConfig;
use Mockery as m;

class TemplatesRepositoryTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * tests find()
     * tests that find calls config and passes template path
     */
    public function testFindReturnsData()
    {
        $config = $this->mockConfig();
        $config->shouldReceive('get')->once()
            ->with('devise::test')->andReturn(array('config'=> 'test'));

        Config::swap($config);

        $repo = new TemplatesRepository(new Field, new DeviseConfig);
        $result = $repo->find('test');

        $this->assertEquals('config', key($result));
        $this->assertEquals('test', reset($result));
    }

    /**
     * tests lists()
     * tests that lists() calls 'devise::views' and returns an array
     */
    public function testListReturnsData()
    {
        $config = $this->mockConfig();
        $config->shouldReceive('get')->once()
            ->with('devise::views')->andReturn(array(1,2,3));

        Config::swap($config);

        $repo = new TemplatesRepository(new Field, new DeviseConfig);
        $result = $repo->lists();

        $this->assertEquals(3, count($result));
    }

    /**
     * tests storeReview()
     * tests store review returns false and sets message when no data is passed
     */
    public function testStoreReviewWithNoData()
    {
        $repo = new TemplatesRepository(new Field, new DeviseConfig);
        $result = $repo->storeReview(array());

        $this->assertFalse($result);
        $this->assertEquals($repo->message, 'No templates found.');
    }

    /**
     * tests storeReview()
     * tests store review accepts an array of new templates
     * calls addkey and save on deviseconfig
     */
    public function testStoreReviewWithDataButNoFields()
    {
        $DeviseConfig = m::mock('Devise\Support\Config\DeviseConfig');
        $DeviseConfig->shouldReceive('addKey')
                     ->twice()
                     ->withArgs(array('devise::templates', 'test'))
                     ->shouldReceive('save')
                    ->once()
                    ->with('devise::templates');


        $repo = new TemplatesRepository(new Field, $DeviseConfig);
        $result = $repo->storeReview(array(
            array(
                'exists' => false,
                'path' => 'test'
            ),
            array(
                'exists' => false,
                'path' => 'test'
            )
        ));

        $this->assertTrue($result);
        $this->assertEquals($repo->message, 'Templates Saved.');
    }

    /**
     * tests storeReview()
     * tests store review accepts an array of new templates
     * calls addkey and save on deviseconfig
     * also calls save on Field
     */
    public function testStoreReviewWithDataAndFields()
    {
        $Field = m::mock('Field[create]');
        $Field->shouldReceive('create')
            ->once();

        $DeviseConfig = m::mock('Devise\Support\Config\DeviseConfig');
        $DeviseConfig->shouldReceive('addKey')
            ->once()
            ->withArgs(array('devise::templates', 'test'))
            ->shouldReceive('save')
            ->once()
            ->with('devise::templates');

        $repo = new TemplatesRepository($Field, $DeviseConfig);
        $result = $repo->storeReview(array(
            array(
                'exists' => false,
                'path' => 'test',
                'fields' => array(
                    array(
                      'human_name' => 'This Is the Editor',
                      'type' => 'editor',
                      'key' => 'this_is_the_editor',
                      'settings' => array(),
                      'value' => 'This is a header title',
                      //'id' => 27,
                      'level' => 0
                    )
                )
            ),
        ));

        $this->assertTrue($result);
        $this->assertEquals($repo->message, 'Templates Saved.');
    }

    /**
     * tests storeReview()
     * tests store review accepts an array of new templates
     * calls addkey and save on deviseconfig
     * also calls findOrFail and update on Field
     */
    public function testStoreReviewWithDataAndFieldsUpdates()
    {
        $Field = m::mock('Field[findOrFail,update]');
        $Field->shouldReceive('findOrFail')
            ->twice()
            ->andReturn(m::self())
            ->shouldReceive('update')
            ->twice();

        $DeviseConfig = m::mock('Devise\Support\Config\DeviseConfig');
        $DeviseConfig->shouldReceive('addKey')
            ->once()
            ->withArgs(array('devise::templates', 'test'))
            ->shouldReceive('save')
            ->once()
            ->with('devise::templates');

        $repo = new TemplatesRepository($Field, $DeviseConfig);
        $result = $repo->storeReview(array(
            array(
                'exists' => false,
                'path' => 'test',
                'fields' => array(
                    array(
                        'overwrite' => true,
                        'human_name' => 'This Is the Editor',
                        'type' => 'editor',
                        'key' => 'this_is_the_editor',
                        'settings' => array(),
                        'value' => 'This is a header title',
                        'id' => 27,
                        'level' => 0
                    ),
                    array(
                        'overwrite' => true,
                        'human_name' => 'This Is the Editor',
                        'type' => 'editor',
                        'key' => 'this_is_the_editor',
                        'settings' => array(),
                        'value' => 'This is a header title',
                        'id' => 27,
                        'level' => 1
                    )
                )
            ),
        ));

        $this->assertTrue($result);
        $this->assertEquals($repo->message, 'Templates Saved.');
    }

    /**
     * tests storeReview()
     * tests store review accepts an array of new templates
     * calls addkey and save on deviseconfig
     * but never calls update
     */
    public function testStoreReviewWithDataAndFieldsDoesNotUpdateWithoutOverwrite()
    {
        $Field = m::mock('Field[findOrFail,update]');
        $Field->shouldReceive('findOrFail')
            ->times(0)
            ->shouldReceive('update')
            ->times(0);

        $DeviseConfig = m::mock('Devise\Support\Config\DeviseConfig');
        $DeviseConfig->shouldReceive('addKey')
            ->once()
            ->withArgs(array('devise::templates', 'test'))
            ->shouldReceive('save')
            ->once()
            ->with('devise::templates');

        $repo = new TemplatesRepository($Field, $DeviseConfig);
        $result = $repo->storeReview(array(
            array(
                'exists' => false,
                'path' => 'test',
                'fields' => array(
                    array(
                        'human_name' => 'This Is the Editor',
                        'type' => 'editor',
                        'key' => 'this_is_the_editor',
                        'settings' => array(),
                        'value' => 'This is a header title',
                        'id' => 27,
                        'level' => 0
                    ),
                    array(
                        'human_name' => 'This Is the Editor',
                        'type' => 'editor',
                        'key' => 'this_is_the_editor',
                        'settings' => array(),
                        'value' => 'This is a header title',
                        'id' => 27,
                        'level' => 1
                    )
                )
            ),
        ));

        $this->assertTrue($result);
        $this->assertEquals($repo->message, 'Templates Saved.');
    }

    /**
     * helper function creates a mock of Config
     * @return m\MockInterface|Yay_MockObject
     */
    private function mockConfig()
    {
        $app = m::mock('AppMock');
        $app->shouldReceive('instance')->atLeast()->once()->andReturn($app);

        Illuminate\Support\Facades\Facade::setFacadeApplication($app);
        Illuminate\Support\Facades\Config::swap($config = m::mock('ConfigMock'));
        return $config;
    }
}