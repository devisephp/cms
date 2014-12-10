<?php

class DeviseCollectionSetsSeeder extends Seeder
{
	public function run()
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

}

