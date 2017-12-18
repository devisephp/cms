<?php namespace Devise\Meta;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Devise\Languages\LanguageDetector;
use Devise\Support\Framework;
use Devise\Users\UserHelper;
use Illuminate\Support\Collection;
use Devise\Support\DeviseException;

/**
 * Class MetaRepository retrieves things related to
 * DvsMeta and DvsMetaItems database table
 *
 * @package Devise\Meta\Repositories
 */
class MetaRepository
{
    /**
     * @param \DvsMeta $Meta
     * @param Framework $Framework
     */
    public function __construct(\DvsMeta $Meta, Framework $Framework)
    {
        $this->Meta = $Meta;
        $this->Input = $Framework->Input;
    }

    /**
     * Returns a Collection of DvsMeta based on the Page and global settings
     *
     * @return Collection
     */
    public function metaForPage($pageId)
    {
        $globalMeta = $this->Meta
                          ->where('value', '<>', '')
                          ->whereNull('page_id')
                          ->get();
        $pageMeta = $this->Meta
                          ->where('page_id', $pageId)
                          ->get();

        $meta = $pageMeta->merge($globalMeta);

        return $meta->unique('key');
    }

    /**
     * Returns a Collection of DvsMeta for the global admin
     *
     * @return Collection
     */
    public function globalMeta()
    {
        return $this->Meta->whereNull('page_id')->get();
    }

    /**
     * Returns a Collection of DvsMeta for the a single page
     *
     * @return Collection
     */
    public function pageMeta($pageId)
    {
        return $this->Meta->where('page_id', $pageId)->get();
    }
}
