<?php

class DeviseUsersSeeder extends Seeder {

	public function run() {
		DB::table( 'users' )->delete();

		$users = array(
			0  => array(
				'id'             => 1,
				'name'           => 'Devise Administrator',
				'email'          => 'deviseadmin@lbm.co',
				'password'       => \Hash::make('secret'),
				'activated'      => true,
				'activate_code'  => null,
				'remember_token' => null,
				'created_at'     => null,
				'updated_at'     => null,
				'deleted_at'     => null,
			),
			1  => array(
				'id'             => 2,
				'name'           => 'Application Administrator',
				'email'          => 'appadmin@lbm.co',
				'password'       => \Hash::make('secret'),
				'activated'      => true,
				'activate_code'  => null,
				'remember_token' => null,
				'created_at'     => null,
				'updated_at'     => null,
				'deleted_at'     => null,
			),
			2  => array(
				'id'             => 3,
				'name'           => 'Editor 1',
				'email'          => 'editor1@lbm.co',
				'password'       => \Hash::make('secret'),
				'activated'      => true,
				'activate_code'  => null,
				'remember_token' => null,
				'created_at'     => null,
				'updated_at'     => null,
				'deleted_at'     => null,
			),
			3  => array(
				'id'             => 4,
				'name'           => 'Editor 2',
				'email'          => 'editor2@lbm.co',
				'password'       => \Hash::make('secret'),
				'activated'      => true,
				'activate_code'  => null,
				'remember_token' => null,
				'created_at'     => null,
				'updated_at'     => null,
				'deleted_at'     => null,
			),
			4  => array(
				'id'             => 5,
				'name'           => 'Public Application User',
				'email'          => 'public@lbm.co',
				'password'       => \Hash::make('secret'),
				'activated'      => true,
				'activate_code'  => null,
				'remember_token' => null,
				'created_at'     => null,
				'updated_at'     => null,
				'deleted_at'     => null,
			)
		);

		foreach ( $users as $user ) {
			DB::table( 'users' )->insert( array( $user ) );
		}
	}

}

