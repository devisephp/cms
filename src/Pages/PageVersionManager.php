<?php namespace Devise\Pages;

use Devise\Models\DvsPage;
use Devise\Models\DvsPageVersion;
use Devise\Pages\Slices\SlicesManager;

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
     * @param DvsPageVersion $DvsPageVersion
     * @param DvsPage $DvsPage
     * @param PagesRepository $PagesRepository
     * @internal param \DvsPageVersion $PageVersion
     * @internal param \DvsField $Field
     */
    public function __construct(DvsPageVersion $DvsPageVersion, DvsPage $DvsPage, PagesRepository $PagesRepository, SlicesManager $SlicesManager)
    {
        $this->PagesRepository = $PagesRepository;
        $this->DvsPage = $DvsPage;
        $this->DvsPageVersion = $DvsPageVersion;
        $this->SlicesManager = $SlicesManager;
        $this->Hash = \Hash::getFacadeRoot();
    }

    /**
     * Create a new default page version for given page
     *
     * @param DvsPage|DvsPa $page
     * @param null $startsAt
     * @return DvsPageVersion
     */
    public function createDefaultPageVersion(DvsPage $page, $layout, $startsAt = null)
    {
        return $this->createNewPageVersion($page->id, 'Default', $layout, $startsAt);
    }

    /**
     * Create a new page version with given parameters
     *
     * @param  int $pageId
     * @param  string $name
     * @param null $startsAt
     * @param null $endsAt
     * @return DvsPageVersion
     */
    public function createNewPageVersion($pageId, $name, $layout, $startsAt = null, $endsAt = null, $settings = null)
    {
        $version = $this->DvsPageVersion->newInstance();
        $version->layout = $layout;
        $version->page_id = $pageId;
        $version->name = $name;
        $version->starts_at = $startsAt;
        $version->ends_at = $endsAt;
        $version->settings = $settings;
        $version->save();

        return $version;
    }

    /**
     * Copies a page version to another page this is useful
     * when creating different languages of the same page
     *
     * @param $fromVersion
     * @param $toPage
     * @return DvsPageVersion
     */
    public function copyPageVersionToAnotherPage($fromVersion, $toPage, $startsAt = null, $settings = null)
    {
        // create a new page version
        $newVersion = $this->createNewPageVersion($toPage->id, $fromVersion->name, $fromVersion->layout, $startsAt, null, $settings);

        $this->SlicesManager
            ->copySlicesAndFieldsFromVersionToVersion($fromVersion, $newVersion);

        return $newVersion;
    }

    /**
     * Copy page version for given page version id and name
     *
     * @param $pageVersionId
     * @param $name
     * @return DvsPageVersion
     */
    public function copyPageVersion($pageVersionId, $name)
    {
        // get the old page version we are currently working with
        $oldVersion = $this->DvsPageVersion->findOrFail($pageVersionId);

        // create a new page version
        $newVersion = $this->createNewPageVersion($oldVersion->page_id, $name, $oldVersion->layout, null, null, $oldVersion->settings);

        // copy all existing fields from oldVersion to newVersion
        $this->SlicesManager
            ->copySlicesAndFieldsFromVersionToVersion($oldVersion, $newVersion);

        // return the new page version we just created
        return $newVersion;
    }

    /**
     * Update the page version dates
     *
     * @param  int $pageVersionId
     * @param $request
     * @return DvsPagVersion
     */
    public function update($pageVersionId, $request)
    {
        $version = $this->DvsPageVersion->findOrFail($pageVersionId);

        $version->updateFromRequest($request);

        return $version;
    }

    /**
     * Destroys a page version record
     *
     * @param $pageVersionId
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @return mixed
     */
    public function destroyPageVersion($pageVersionId)
    {
        $pageVersion = $this->DvsPageVersion->findOrFail($pageVersionId);

        $page = $this->DvsPage
            ->find($pageVersion['page_id']);

        // throw exception if attempt to delete live page version
        if ($page->liveVersion && $page->liveVersion->id == $pageVersion->id)
        {
            abort(422, 'Cannot delete live page version');
        }

        $pageVersion->delete();
    }

}