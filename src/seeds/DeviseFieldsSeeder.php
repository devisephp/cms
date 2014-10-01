<?php

class DeviseFieldsSeeder extends Seeder {

	public function run() {
		DB::table( 'dvs_fields' )->delete();

		$fields = array(
			0  => array(
                'id'                  => 1,
                'page_id'             => 100,
                'type' 				  => 'text',
                'human_name'          => 'Good-Bye',
                'key' 				  => 'hello',
				'created_at'          => '-0001-11-30 00:00:00',
				'updated_at'          => '-0001-11-30 00:00:00'
			),
			1  => array(
                'id'                  => 2,
                'page_id'             => 100,
                'type'                => 'textarea',
                'human_name'          => 'Good-Bye',
                'key' 				  => 'goodbye',
				'created_at'          => '-0001-11-30 00:00:00',
				'updated_at'          => '-0001-11-30 00:00:00'
			),
		);

		foreach ( $fields as $field ) {
			DB::table( 'dvs_fields' )->insert( array( $field ) );
		}
	}

}

