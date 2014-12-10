<?php

class DeviseCollectionInstancesSeeder extends Seeder
{
	public function run()
	{
		DB::table('dvs_collection_instances')->delete();

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

}

