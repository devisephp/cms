<?php namespace Devise\Support;

use DB, Datetime, Exception;

class DeviseSeeder extends \Illuminate\Database\Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// template method, this will be overriden
		throw new Exception("You must override the run method when using DeviseSeeder");
	}

	/**
	 * This gives us the ability to call the seeds only once. We
	 * will keep up with what classes have ran in the database and
	 * that way we know which ones to call and which ones not to call.
	 *
	 * @param  [type] $seederClass
	 * @return [type]
	 */
	protected function callOnlyOnce($seederClass)
	{
		$found = DB::table('dvs_seeds')->where('name', '=', $seederClass)->first();

		if ($found) return;

		$this->call($seederClass);

		DB::table('dvs_seeds')->insert([
			'name' => $seederClass,
			'created_at' => new Datetime,
			'updated_at' => new Datetime,
		]);
	}

	/**
	 * Iterate over all the rows and insert them one by one checking
	 * for existing before
	 *
	 * @param  string  		 $tableName
	 * @param  array|string  $uniqueKeys
	 * @param  array 		 $data
	 * @param  boolean 		 $timestamps
	 * @return array
	 */
	protected function findOrCreateRows($tableName, $uniqueKeys, $rows, $timestamps = true)
	{
		$records = [];

		foreach ($rows as $row)
		{
			$records[] = $this->findOrCreateRow($tableName, $uniqueKeys, $row, $timestamps);
		}

		return $records;
	}

	/**
	 * We are creating a new page when it does not exist already.
	 * We use the route name as it should be unique. If an row
	 * already exists with the same route name we just ignore
	 * the insert. We use similiar logic for new page versions.
	 * If a page does not have a page version then it will not
	 * be available at it's url because we don't show pages
	 * unless there is an active page version
	 *
	 * @param  string $tableName
	 * @param  array  $uniqueKeys
	 * @param  array  $data
	 * @return StdObject
	 */
	protected function findOrCreateRow($tableName, $uniqueKeys , $data, $timestamps = true)
	{
		// merge in created_at and updated_at timestamps
		$data = $timestamps ? array_merge(['created_at' => new DateTime, 'updated_at' => new DateTime], $data) : $data;

		$object = $this->findRow($tableName, $uniqueKeys, $data);

		if (!$object)
		{
			DB::table($tableName)->insert($data);
			$object = $this->findRow($tableName, $uniqueKeys, $data);
		}

		return $object;
	}

	/**
	 * Search for the row with these unique keys
	 *
	 * @param  string $tableName
	 * @param  array  $uniqueKeys
	 * @param  array  $data
	 * @return StdObject
	 */
	protected function findRow($tableName, $uniqueKeys, $data)
	{
		$uniqueKeys = is_array($uniqueKeys) ? $uniqueKeys : array($uniqueKeys);

		$table = DB::table($tableName);

		foreach ($uniqueKeys as $uniqueKey)
		{
			$table = $table->where($uniqueKey, '=', $data[$uniqueKey]);
		}

		return $table->first();
	}
}