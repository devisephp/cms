<?php namespace Devise\Fields\Repositories;

use Field;

class FieldsRepository {

	private $Field;

	function __construct(Field $Field) {
		$this->Field = $Field;
	}

	public function queue() {
		return $this->Field
					->join('dvs_field_versions', 'dvs_field_versions.field_id', '=', 'dvs_fields.id')
					->with(array('page', 'latestVersion.user'))
					->where('dvs_field_versions.stage','<>','published')
					->orderBy('page_id')
					->select('dvs_fields.*')
					->paginate();
	}

	/**
	 * Find existing page field given key and pageId
	 *
	 * @param  string  $key
	 * @param  integer $pageId
	 * @return Field
	 */
	public function findFieldByKeyAndPage($key, $pageId)
	{
		return $this->Field
			->where('key', '=', $key)
			->where('page_id', '=', $pageId)
			->first();
	}

	/**
	 * Find existing page (even if it has been soft deleted)
	 *
	 * @param  string $key
	 * @param  integer $pageId
	 * @return Field
	 */
	public function findTrashedFieldByKeyAndPage($key, $pageId)
	{
		return $this->Field
			->onlyTrashed()
			->where('key', '=', $key)
			->where('page_id', '=', $pageId)
			->first();
	}

	/**
	 * Finds the global field by key
	 *
	 * @param  string $key
	 * @return Field
	 */
	public function findFieldByGlobalKey($key)
	{
		return $this->findFieldByKeyAndPage($key, 0);
	}

	/**
	 * Find the field by id
	 *
	 * @param  integer $id
	 * @return Field
	 */
	public function findFieldById($id)
	{
		return $this->Field->findOrFail($id);
	}

	/**
	 * Find the current stage
	 *
	 * @return string
	 */
	public function findCurrentStage()
	{
		return 'published';
	}
}