<?php

class DeviseFieldVersionsSeeder extends Seeder {

	public function run() {
		DB::table( 'dvs_field_versions' )->delete();

		$fields = array(
			array(
                'field_id'            => 1,
                'responsible_user_id' => 2,
                'stage'               => 'todo',
                'value'               => '{"text": "Hello There Mister"}',
				'created_at'          => date('Y-m-d H:i:s', strtotime('3 weeks ago')),
				'updated_at'          => date('Y-m-d H:i:s', strtotime('3 weeks ago'))
			),
            array(
                'field_id'            => 1,
                'responsible_user_id' => 2,
                'stage'               => 'todo',
                'value'               => '{"text": "Hello There Mister Again!"}',
                'created_at'          => date('Y-m-d H:i:s', strtotime('2 days ago')),
                'updated_at'          => date('Y-m-d H:i:s', strtotime('2 days ago'))
            ),
			array(
				'field_id'            => 2,
				'responsible_user_id' => 3,
                'stage'               => 'staging',
                'value'               => '{"text": "Good-Bye There Mister"}',
				'created_at'          => date('Y-m-d H:i:s', strtotime('3 weeks ago')),
				'updated_at'          => date('Y-m-d H:i:s', strtotime('3 weeks ago'))
			),
		);

		foreach ( $fields as $field ) {
			DB::table( 'dvs_field_versions' )->insert( array( $field ) );
		}
	}

}

