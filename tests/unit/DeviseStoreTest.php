<?php

use Illuminate\Support\Facades\Config;
use Devise\Models\DeviseStore;
use Devise\Support\Helpers\DeviseArray;
use Mockery as m;


class DeviseStoreTest extends Orchestra\Testbench\TestCase
{
    private $configRelationships;
    private $DeviseStore;
    private $mockRoute;
    private $mockDvsRelationshipsRepository;
    private $mockDvsRelationship;

    public function setUp()
    {
        $this->configRelationships = array(
            'groups' => array(
                'model_1' => 'User',
                'model_2' => 'Group',
                'type' => 'belongsToMany',
                'foreign_key' => '',
                'pivot_table' => 'group_user',
                'pivot_key_model_1' => 'user_id',
                'pivot_key_model_2' => 'group_id',
            ),

            'users' => array(
                'model_1' => 'Group',
                'model_2' => 'User',
                'type' => 'belongsToMany',
                'foreign_key' => '',
                'pivot_table' => 'group_user',
                'pivot_key_model_1' => 'group_id',
                'pivot_key_model_2' => 'user_id',
            ),

            'car_factory' => array(
                'model_1' => 'Car',
                'model_2' => 'Factory',
                'type' => 'belongsTo',
                'foreign_key' => 'factory_id',
                'pivot_table' => '',
                'pivot_key_model_1' => '',
                'pivot_key_model_2' => '',
            ),

            'car_owner' => array(
                'model_1' => 'Car',
                'model_2' => 'Owner',
                'type' => 'belongsTo',
                'foreign_key' => 'owner_id',
                'pivot_table' => '',
                'pivot_key_model_1' => '',
                'pivot_key_model_2' => '',
            ),

            'factory_district' => array(
                'model_1' => 'Factory',
                'model_2' => 'District',
                'type' => 'belongsTo',
                'foreign_key' => 'district_id',
                'pivot_table' => '',
                'pivot_key_model_1' => '',
                'pivot_key_model_2' => '',
            )
        );

        $this->mockDvsRelationship = m::mock('DvsRelationship');
        $config = m::mock('Illuminate\Config\Repository');
        $config->shouldReceive('get')->once()->andReturn($this->configRelationships);

        $this->mockDvsRelationshipsRepository = m::mock('Devise\Models\Repositories\DvsRelationshipsRepository[aliasKeys]', array($this->mockDvsRelationship, $config));
        $this->mockRoute = m::mock('Illuminate\Routing\Router');
    }

    public function tearDown()
    {
        m::close();
    }


    public function validInputProvider()
    {
        return array(
            array(
                array(
                    'Car' => array (
                        'vin' => '34343439039494934039',
                        'name' => 'Mustang',
                        'owner' => array (
                            'name' => 'Gary Williams',
                        ),
                        'colors' => array (
                            0 => array (
                                'name' => 'Caramel',
                                'hex' => '000000', ),
                            1 => array ( 'name' => 'Vomit',
                                'hex' => '111111', ), ),
                        'factory' => array (
                            'name' => 'Georgia Plant',
                            'district' => array (
                                'name' => 'Southeast',
                            )
                        )
                    )
                )
            )
        );
    }

    /**
     * @dataProvider validInputProvider
     */
    public function testCreateValidInput($input)
    {
        $this->mockDvsRelationshipsRepository
            ->shouldReceive('aliasKeys')
            ->andReturn($this->configRelationships);

        $this->DeviseStore = new DeviseStore(new DeviseArray(), $this->mockDvsRelationshipsRepository, $this->mockRoute);

        $mockCar = m::mock('Car');
        $mockCar->shouldReceive('create')
            ->once()
            ->andReturn(m::self());

        dd($this->DeviseStore->create($input));
    }

}

class Car {
    function create() { return $this; }
}