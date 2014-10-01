<?php

class DeviseGroupsSeeder extends Seeder {

	public function run() {
		DB::table( 'groups' )->delete();

		$groups = array(
			0  => array(
				'id'             => 1,
				'name'           => 'Devise Administrator',
				'created_at'     => null,
				'updated_at'     => null
			),
			1  => array(
				'id'             => 2,
				'name'           => 'Application Administrator',
				'created_at'     => null,
				'updated_at'     => null,
			),
			2  => array(
				'id'             => 3,
				'name'           => 'Editor',
				'created_at'     => null,
				'updated_at'     => null,
			)
		);

		foreach ( $groups as $group ) {
			DB::table( 'groups' )->insert( array( $group ) );
		}
	}

}

 