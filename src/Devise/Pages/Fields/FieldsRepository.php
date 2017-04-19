<?php namespace Devise\Pages\Fields;

/**
 * Fields repository allows us to retrieve fields
 * that belong to page versions and keys and have been
 * deleted. We also can find global fields with this
 * repository.
 *
 */
class FieldsRepository
{
	/**
	 * DvsField model
	 *
	 * @var DvsField
	 */
	private $Field;

	/**
	 * DvsGlobalField
	 *
	 * @var DvsGlobalField
	 */
	private $GlobalField;

	/**
	 * Construct a new FieldsRepository
	 *
	 * @param DvsField       $Field
	 * @param DvsGlobalField $GlobalField
	 */
	public function __construct(\DvsField $Field, \DvsGlobalField $GlobalField)
	{
		$this->Field = $Field;
		$this->GlobalField = $GlobalField;
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
			->newInstance()
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
	 * @return DvsGlobalField
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
	 * Find the field by id
	 *
	 * @param  integer $id
	 * @return DvsField
	 */
	public function findFieldById($id)
	{
		return $this->Field->findOrFail($id);
	}

	/**
	 * Find a field by it's id and scope (page or global)
	 *
	 * @param  integer $fieldId
	 * @param  string  $fieldScope
	 * @return DvsField || DvsGlobalField
	 */
	public function findFieldByIdAndScope($fieldId, $fieldScope)
	{
		return $fieldScope == 'global' ? $this->GlobalField->find($fieldId) : $this->Field->find($fieldId);
	}

	/**
	 * Find a field by it's scope and included fields that have been deleted
	 *
	 * @param  integer $fieldId
	 * @param  string  $fieldScope
	 * @return DvsField || DvsGlobalField
	 */
	public function findTrashedFieldByIdAndScope($fieldId, $fieldScope)
	{
		return $fieldScope == 'global' ? $this->GlobalField->withTrashed()->find($fieldId) : $this->Field->withTrashed()->find($fieldId);
	}

	/**
	 * Find a field by it's global key and language id
	 *
	 * @param  string  $key
	 * @param  integer $languageId
	 * @return DvsGlobalField
	 */
	public function findFieldByGlobalKeyAndLanguage($key, $languageId)
	{
		return $this->GlobalField->where('key', $key)->where('language_id', $languageId)->first();
	}

	/**
	 * [findFieldByGlobalKeyAndLanguage description]
	 * @param  [type] $key
	 * @param  [type] $languageId
	 * @return [type]
	 */
	public function findTrashedFieldByGlobalKeyAndLanguage($key, $languageId)
	{
		return $this->GlobalField->withTrashed()->where('key', $key)->where('language_id', $languageId)->first();
	}

    /**
     * Find all fields where content requested is true for given
     * page version id and builds a list of field keys
     *
     * @param  integer $pageVersionId
     * @return Field
     */
    public function findContentRequestedFieldsList($pageVersionId)
    {
        return $this->Field
            ->where('page_version_id', '=', $pageVersionId)
            ->where('content_requested','=',true)
            ->select('id')
            ->pluck('id');
    }

    /**
     * Find all pristine page fields that match this
     * key
     *
     * @param  string $key
     * @return Collection
     */
	public function findPristinePageFields($key)
	{
        return $this->Field
        	->newInstance()
            ->where('key', '=', $key)
            ->where('created_at', '=', \DB::raw('updated_at'))
            ->get();
	}
}