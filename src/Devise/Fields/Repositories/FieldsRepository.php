<?php namespace Devise\Fields\Repositories;

use Field, GlobalField;

class FieldsRepository
{
	private $Field, $GlobalField;

	public function __construct(Field $Field, GlobalField $GlobalField)
	{
		$this->Field = $Field;
		$this->GlobalField = $GlobalField;
	}

	public function queue()
	{
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
	public function findFieldByKeyAndPageVersion($key, $pageVersionId, $collectionInstanceId)
	{
		return $this->Field
			->where('key', '=', $key)
			->where('page_version_id', '=', $pageVersionId)
			->where('collection_instance_id', '=', $collectionInstanceId)
			->first();
	}

	/**
	 * Find existing page field (only if it has been trashed)
	 *
	 * @param  string $key
	 * @param  integer $pageId
	 * @return Field
	 */
	public function findTrashedFieldByKeyAndPageVersion($key, $pageVersionId)
	{
		return $this->Field
			->onlyTrashed()
			->where('key', '=', $key)
			->where('page_version_id', '=', $pageVersionId)
			->first();
	}

	/**
	 * Find existing global field (only if it has been trashed)
	 *
	 * @param  string  $key
	 * @param  integer $languageId
	 * @return GlobalField
	 */
	public function findTrashedGlobalFieldByKeyAndLanguage($key, $languageId)
	{
		return $this->GlobalField
			->onlyTrashed()
			->where('key', '=', $key)
			->where('language_id', '=', $languageId)
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
		return $this->findFieldByKeyAndPageVersion($key, 0);
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

	/**
	 * [findFieldByIdAndScope description]
	 * @param  [type] $fieldId    [description]
	 * @param  [type] $fieldScope [description]
	 * @return [type]             [description]
	 */
	public function findFieldByIdAndScope($fieldId, $fieldScope)
	{
		return $fieldScope == 'global' ? $this->GlobalField->find($fieldId) : $this->Field->find($fieldId);
	}

	/**
	 * [findFieldByGlobalKeyAndLanguage description]
	 * @param  [type] $key        [description]
	 * @param  [type] $languageId [description]
	 * @return [type]             [description]
	 */
	public function findFieldByGlobalKeyAndLanguage($key, $languageId)
	{
		return $this->GlobalField->where('key', $key)->where('language_id', $languageId)->first();
	}
}