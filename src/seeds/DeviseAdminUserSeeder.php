<?php

class DeviseAdminUserSeeder extends DeviseSeeder
{
	/**
	 * [run description]
	 * @return [type]
	 */
	public function run()
	{
		$groups = $this->createGroups();
		$this->createAdminUser($groups);
	}

	/**
	 * [createGroups description]
	 * @return [type]
	 */
	public function createGroups()
	{
		return $this->findOrCreateRows('groups', 'name',
		[
			[ 'name' => 'Devise Administrator' ],
			[ 'name' => 'Application Administrator' ],
			[ 'name' => 'Editor' ],
		]);
	}

	/**
	 * [createAdminUser description]
	 * @return [type]
	 */
	public function createAdminUser($groups)
	{
		$adminUser = $this->findOrCreateRow('users', 'email', [
			'name'           => 'Devise Administrator',
			'email'          => 'noreply@devisephp.com',
			'password'       => \Hash::make('secret'),
			'activated'      => true,
			'activate_code'  => null,
			'remember_token' => null,
			'deleted_at'     => null,
		]);

		DB::table('group_user')->insert([
			'group_id'       => $groups[0]->id,
			'user_id'        => $adminUser->id,
		]);
	}
}