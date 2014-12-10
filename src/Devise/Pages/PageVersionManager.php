<?php namespace Devise\Pages;

use DateTime;
use Devise\Users\UserHelper;

/**
 * Class PageVersionManager manages all things page versions related.
 *
 * @package Devise\Pages
 */
class PageVersionManager
{
    /**
     * Construction
     * depends on PageVersin model and UserHelper to get current user id
     *
     * @param UserHelper $UserHelper
     * @param \DvsPageVersion $PageVersion
     * @param \DvsField $Field
     * @param \DvsCollectionInstance $CollectionInstance
     */
    public function __construct(UserHelper $UserHelper, \DvsPageVersion $PageVersion, \DvsField $Field, \DvsCollectionInstance $CollectionInstance, PagesRepository $PagesRepository)
    {
        $this->CollectionInstance = $CollectionInstance;
        $this->Field = $Field;
        $this->PagesRepository = $PagesRepository;
        $this->PageVersion = $PageVersion;
        $this->UserHelper = $UserHelper;
        $this->Hash = \Hash::getFacadeRoot();
    }

    /**
     * Create a new page version with given parameters
     *
     * @param  int $pageId
     * @param  string $name
     * @param  int $createdByUserId
     * @return PageVersion
     */
    public function createNewPageVersion($pageId, $name, $createdByUserId)
    {
        $version = $this->PageVersion->newInstance();
        $version->page_id = $pageId;
        $version->name = $name;
        $version->created_by_user_id = $createdByUserId;
        $version->preview_hash = null;
        $version->save();

        return $version;
    }

    /**
     * Create a new default page version for given page
     *
     * @param  Page $page
     * @return PageVersion
     */
    public function createDefaultPageVersion($page)
    {
        return $this->createNewPageVersion($page->id, 'Default', $this->UserHelper->currentUserId());
    }

    /**
     * Copies a page version to another page this is useful
     * when creating different languages of the same page
     *
     * @param $fromVersion
     * @param $toPage
     * @return PageVersion
     */
    public function copyPageVersionToAnotherPage($fromVersion, $toPage) {
        // create a new page version
        $newVersion = $this->createNewPageVersion($toPage->id, $fromVersion->name, $this->UserHelper->currentUserId());

        $this->copyFieldsFromVersionToVersion($fromVersion, $newVersion);

        $this->copyCollectionsFromVersionToVersion($fromVersion, $newVersion);

        return $newVersion;
    }

    /**
     * Copy page version for given page version id and name
     *
     * @param $pageVersionId
     * @param $name
     * @return PageVersion
     */
    public function copyPageVersion($pageVersionId, $name)
    {
        // get the old page version we are currently working with
        $oldVersion = $this->PageVersion->findOrFail($pageVersionId);

        // create a new page version
        $newVersion = $this->createNewPageVersion($oldVersion->page_id, $name, $this->UserHelper->currentUserId());

        // copy all existing fields from oldVersion to newVersion
        $this->copyFieldsFromVersionToVersion($oldVersion, $newVersion);

        // copy all existing collections from oldVersion to newVersion
        $this->copyCollectionsFromVersionToVersion($oldVersion, $newVersion);

        // return the new page version we just created
        return $newVersion;
    }

    /**
     * Update the page version dates
     *
     * @param  int   $pageVersionId
     * @param  array $input
     * @return void
     */
    public function updatePageVersionDates($pageVersionId, $input)
    {
        $version = $this->PageVersion->findOrFail($pageVersionId);

        // convert dates to proper timestamp
        $startsAt = $this->convertToDatabaseTimestamp(array_get($input, 'starts_at', null));
        $endsAt = $this->convertToDatabaseTimestamp(array_get($input, 'ends_at', null));

        $version->starts_at = $startsAt;
        $version->ends_at = $endsAt;
        $version->save();

        return $version;
    }

    /**
     * Changes the timestamp from human readable to database specific
     *
     * @param  string $timestamp
     * @param  string $from
     * @param  string $to
     * @return string
     */
    protected function convertToDatabaseTimestamp($timestamp, $from = 'm/d/y H:i:s', $to = 'Y-m-d H:i:s')
    {
        if (!$timestamp) return null;

        $date = DateTime::createFromFormat($from, $timestamp);

        return $date->format($to);
    }

    /**
     * Copies all the fields from one page version into another page version
     *
     * @param $oldVersion
     * @param $newVersion
     * @return void
     */
    protected function copyFieldsFromVersionToVersion($oldVersion, $newVersion)
    {
        foreach ($oldVersion->fields as $field)
        {
            $this->Field->create([
                "collection_instance_id" => $field->collection_instance_id,
                "page_version_id" => $newVersion->id,
                "type" => $field->type,
                "human_name" => $field->human_name,
                "key" => $field->key,
                "json_value" => $field->json_value,
            ]);
        }
    }

    /**
     * Copy all the collections from one page version into another
     *
     * @param $oldVersion
     * @param $newVersion
     * @return void
     */
    protected function copyCollectionsFromVersionToVersion($oldVersion, $newVersion)
    {
        foreach ($oldVersion->collectionInstances as $oldInstance)
        {
            $newInstance = $this->CollectionInstance->create([
                'collection_set_id' => $oldInstance->collection_set_id,
                'page_version_id' => $newVersion->id,
                'name' => $oldInstance->name,
                'sort' => $oldInstance->sort,
            ]);

            foreach ($oldInstance->fields as $field)
            {
                $this->Field->create([
                    "collection_instance_id" => $newInstance->id,
                    "page_version_id" => $newVersion->id,
                    "type" => $field->type,
                    "human_name" => $field->human_name,
                    "key" => $field->key,
                    "json_value" => $field->json_value,
                ]);
            }
        }
    }

    /**
     * Destroys a page version record
     *
     * @param $pageVersionId
     * @throws \Devise\Support\DeviseException
     * @return mixed
     */
    public function destroyPageVersion($pageVersionId)
    {
        $pageVersion = $this->PageVersion->findOrFail($pageVersionId);

        $page = $this->PagesRepository->find($pageVersion['page_id']);

        $liveVersionId = $this->PagesRepository->getLivePageVersion($page)->id;

        // throw exception if attempt to delete live page version
        if ($liveVersionId == $pageVersion['id'])
        {
            throw new \Devise\Support\DeviseException('Cannot delete live page version');
        }

        return $pageVersion->delete();
    }

    /**
     * Toggle "preview_hash" value between hashed string and null.
     * The value determines whether preview url is publicly available.
     *
     * @param  integer $pageVersionId
     * @return boolean
     */
    public function togglePageVersionPreviewShare($pageVersionId)
    {
        $pageVersion = $this->PageVersion->findOrFail($pageVersionId);

        $previewHashValue = is_null($pageVersion->preview_hash) ? urlencode($this->Hash->make($pageVersion->id)) : null;

        return $pageVersion->update(array('preview_hash' => $previewHashValue));
    }

}