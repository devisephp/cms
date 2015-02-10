<?php

class DeviseTestsOnlySeeder extends DeviseSeeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->fields();
		$this->collectionInstances();
		$this->collectionSets();
		$this->globalFields();
	}

	/**
	 * Fields
	 *
	 * @return void
	 */
	public function fields()
	{
        $data = array(
            array(
                'id'                        => 1,
                'page_version_id'           => 1,
                'collection_instance_id'    => null,
                'type' 				        => 'text',
                'human_name'                => 'Good-Bye',
                'key'                       => 'hello',
                'json_value'                => '{}',
            ),
            array(
                'id'                        => 2,
                'collection_instance_id'    => null,
                'page_version_id'           => 1,
                'type'                      => 'textarea',
                'human_name'                => 'Good-Bye',
                'key'                       => 'goodbye',
                'json_value'                => '{}',
            ),
            array(
                'id'                        => 3,
                'collection_instance_id'    => 1,
                'page_version_id'           => 1,
                'type'                      => 'image',
                'human_name'                => 'Key #1',
                'key'                       => 'key1',
                'json_value'                => '{"bar": "awesome"}'
            ),
        );

        DB::table('dvs_fields')->insert($data);
	}

	/**
	 * Collection instances
	 *
	 * @return void
	 */
	public function collectionInstances()
	{
		$data = array(
			array(
                'id'                  => 1,
                'collection_set_id'   => 1,
                'page_version_id' 	  => 1,
                'name'                => 'Instance #1',
                'sort' 				  => 1
			),
			array(
                'id'                  => 2,
                'collection_set_id'   => 1,
                'page_version_id' 	  => 1,
                'name'                => 'Instance #2',
                'sort' 				  => 2
			),
		);

		DB::table('dvs_collection_instances')->insert($data);
	}

	/**
	 * Collection sets
	 *
	 * @return void
	 */
	public function collectionSets()
	{
		DB::table( 'dvs_collection_sets' )->delete();

		$data = array(
			array(
                'id'	=> 1,
                'name' 	=> 'Collection Set #1',
			),
		);

		DB::table('dvs_collection_sets')->insert($data);
	}

	/**
	 * Global fields
	 *
	 * @return void
	 */
	public function globalFields()
	{
        $data = array(
            array(
                'id'          => 1,
                'language_id' => 45,
                'type'        => 'image',
                'human_name'  => 'Key #1',
                'key'         => 'key1',
                'json_value'  => '{"url": "/media/kitten.jpg"}',
            ),
        );

        DB::table('dvs_global_fields')->insert($data);
	}

}