<?php

class DeviseGroupsSeeder extends Seeder
{
	public function run() {
		DB::table( 'groups' )->delete();

		$groups = array(
			0  => array(
				'id'             => 1,
				'name'           => 'Devise Administrator',
			),
			1  => array(
				'id'             => 2,
				'name'           => 'Application Administrator',
			),
			2  => array(
				'id'             => 3,
				'name'           => 'Editor',
			)
		);

		foreach ( $groups as $group ) {
			DB::table( 'groups' )->insert( array( $group ) );
		}
	}

}