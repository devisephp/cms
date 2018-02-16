<?php namespace Devise\Pages;

use Devise\Models\DvsPageMeta;

/**
 * Class PageManager manages the creating of new pages,
 * updating pages and removing and copying pages.
 */
class PageMetaManager
{

  /**
   * PageMetaManager constructor.
   */
  public function __construct(DvsPageMeta $DvsPageMeta)
  {
    $this->DvsPageMeta = $DvsPageMeta;
  }

  public function savePageMeta($pageId, $metas)
  {
    $allIds = $this->DvsPageMeta
      ->where('page_id', $pageId)
      ->pluck('id', 'id')
      ->toArray();

    foreach ($metas as $meta)
    {
      if (isset($meta['id']))
      {
        $record = $this->DvsPageMeta
          ->find($meta['id']);

        unset($allIds[$meta['id']]);
      } else
      {
        $record = new DvsPageMeta();
      }

      $record->page_id = $pageId;
      $record->attribute_name = $meta['attribute_name'];
      $record->attribute_value = $meta['attribute_value'];
      $record->content = $meta['content'];
      $record->save();
    }

    if ($allIds)
    {
      $this->DvsPageMeta
        ->whereIn('id', array_keys($allIds))
        ->delete();
    }
  }
}
