<?php

class DeviseGroupUserSeeder extends Seeder {

	public function run() {
		DB::table( 'group_user' )->delete();

		$groupUser = array(
			0  => array(
				'group_id'       => 1,
				'user_id'        => 1,
			),
			1  => array(
				'group_id'       => 2,
				'user_id'        => 2,
			),
			2  => array(
				'group_id'       => 3,
				'user_id'        => 3,
			),
			3  => array(
				'group_id'       => 4,
				'user_id'        => 4,
			),
			4  => array(
				'group_id'       => 5,
				'user_id'        => 4,
			)
		);

		foreach ( $groupUser as $user ) {
			DB::table( 'group_user' )->insert( array( $user ) );
		}
	}

}

