<?php namespace Devise\Search;

use App;

/**
 * Class PageSearch is an example of how you could search
 * for pages using the SearchableModelTrait
 *
 * @package Devise\Search
 */
class PageSearch extends \DvsPage
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    public $searchableType = "Page";

    /**
     * @var LanguageDetector
     */
    public $LanguageDetector;

    /**
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'meta_keywords' => 3,
            'title' => 4,
            'meta_description' => 3,
            'dvs_fields.json_value' => 2,
        ],
        'joins' => [
            'dvs_page_versions' => ['dvs_page_versions.page_id', 'dvs_pages.id'],
            'dvs_fields' => ['dvs_page_versions.id', 'dvs_fields.page_version_id'],
        ]
    ];

    public function scopeSearch($query, $search)
    {
        
        if (!$search) return $query;

        $query = $this->createSearchQuery($query, $search);

        // only show the languages that are active
        $language = App::make('Devise\Languages\LanguageDetector')->current();
        $query->where('language_id', $language->id);

        // exclude pages that don't have a live page version currently
        $now = new \DateTime;
        $query->where('dvs_page_versions.starts_at', '<', $now);
        $query->where(function($query) use ($now)
        {
            $query->where('dvs_page_versions.ends_at', '>', $now);
            $query->orWhereNull('dvs_page_versions.ends_at');
        });

        // make sure to only search on the latest version
        $query->join(\DB::raw('(SELECT MAX(starts_at) as max_starts, page_id FROM dvs_page_versions GROUP BY page_id) newest_version'), function($join){
                $join->on('newest_version.max_starts','=','dvs_page_versions.starts_at');
                $join->on('newest_version.page_id','=','dvs_page_versions.page_id');
        });

        return $query;

    }
}