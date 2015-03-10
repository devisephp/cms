<?php

class DeviseTestModelSeeder extends DeviseSeeder
{
	/**
	 * [run description]
	 * @return [type]
	 */
	public function run()
	{
		$adminUser = $this->findOrCreateRows('dvs_test_models', 'id',
		[
			[
				'id' => 1,
				'page_version_id' => 1,
				'name' => 'Some name here',
			],
		]);

	}
}