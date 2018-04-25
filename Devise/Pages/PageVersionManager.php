<?php namespace Devise\Pages;

use DateTime;
use Devise\Models\DvsField;
use Devise\Models\DvsPage;
use Devise\Models\DvsPageVersion;
use Devise\Models\DvsSliceInstance;
use Devise\Models\DvsTemplate;
use Devise\Pages\Slices\SlicesManager;

/**
 * Class PageVersionManager manages all things page versions related.
 *
 * @package Devise\Pages
 */
class PageVersionManager
{
  /**
   * @var DvsTemplate
   */
  private $DvsTemplate;

  /**
   * Construction
   * depends on PageVersin model and UserHelper to get current user id
   *
   * @param DvsPageVersion $DvsPageVersion
   * @param DvsSliceInstance $DvsSliceInstance
   * @param DvsField $DvsField
   * @param PagesRepository $PagesRepository
   * @internal param \DvsPageVersion $PageVersion
   * @internal param \DvsField $Field
   */
  public function __construct(DvsPageVersion $DvsPageVersion, PagesRepository $PagesRepository, SlicesManager $SlicesManager, DvsTemplate $DvsTemplate)
  {
    $this->PagesRepository = $PagesRepository;
    $this->DvsPageVersion = $DvsPageVersion;
    $this->SlicesManager = $SlicesManager;
    $this->DvsTemplate = $DvsTemplate;
    $this->Hash = \Hash::getFacadeRoot();
  }

  /**
   * Create a new default page version for given page
   *
   * @param DvsPage|DvsPa $page
   * @param $templateId
   * @param null $startsAt
   * @return DvsPageVersion
   */
  public function createDefaultPageVersion(DvsPage $page, $templateId, $startsAt = null)
  {
    return $this->createNewPageVersion($page->id, 'Default', $templateId, $startsAt);
  }

  /**
   * Create a new page version with given parameters
   *
   * @param  int $pageId
   * @param  string $name
   * @param $templateId
   * @param null $startsAt
   * @param null $endsAt
   * @return DvsPageVersion
   */
  public function createNewPageVersion($pageId, $name, $templateId, $startsAt = null, $endsAt = null)
  {
    $version = $this->DvsPageVersion->newInstance();
    $version->page_id = $pageId;
    $version->template_id = $templateId;
    $version->name = $name;
    $version->starts_at = $startsAt;
    $version->ends_at = $endsAt;
    $version->preview_hash = null;
    $version->save();

    $template = $this->DvsTemplate
      ->with('slices')
      ->findOrFail($templateId);

    $this->SlicesManager->copySlicesForNewPageVersion($template->slices, $version->id);

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
  public function copyPageVersionToAnotherPage($fromVersion, $toPage)
  {
    // create a new page version
    $newVersion = $this->createNewPageVersion($toPage->id, $fromVersion->name, $fromVersion->template_id);

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
    $newVersion = $this->createNewPageVersion($oldVersion->page_id, $name, $oldVersion->template_id);

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

    $page = $this->PagesRepository
      ->with('liveVersion')
      ->find($pageVersion['page_id']);

    // throw exception if attempt to delete live page version
    if ($page->liveVersion)
    {
      abort(422, 'Cannot delete live page version');
    }

    $pageVersion->delete();
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
    $pageVersion = $this->DvsPageVersion->findOrFail($pageVersionId);

    $previewHashValue = is_null($pageVersion->preview_hash) ? $this->Hash->make($pageVersion->id) : null;

    $pageVersion->update(array('preview_hash' => $previewHashValue));

    return $pageVersion;
  }

}