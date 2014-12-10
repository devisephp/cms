<?php namespace Devise\Search;

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
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'meta_keywords' => 3,
            'meta_title' => 3,
            'meta_description' => 3,
            'dvs_fields.json_value' => 2,
        ],
        'joins' => [
            'dvs_page_versions' => ['dvs_page_versions.page_id', 'dvs_pages.id'],
            'dvs_fields' => ['dvs_page_versions.id', 'dvs_fields.page_version_id'],
        ]
    ];
}