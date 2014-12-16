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
        $language = App::make('Devise\Languages\LanguageDetector')->current();
        $query->where('language_id', $language->id);
        return $this->createSearchQuery($query, $search);
    }

    protected function createSearchQuery($query, $search)
    {
        if (!$search) {
            return $query;
        }

        $relevance_count = 0;
        $words = explode(' ', $search);

        $selects = [];

        foreach ($this->getColumns() as $column => $relevance)
        {
            $relevance_count += $relevance;
            $queries = $this->getSearchQueriesForColumn($column, $relevance, $words);

            foreach ($queries as $select) {
                $selects[] = $select;
            }
        }

        $this->addSelectsToQuery($query, $selects);
        $this->filterQueryWithRelevance($query, ($relevance_count / 4));

        $this->makeJoins($query);

        return $query;
    }
}