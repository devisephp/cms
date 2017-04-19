<?php namespace Devise\Pages;

use Devise\Languages\LanguageDetector;
use Devise\Pages\Collections\CollectionsRepository;

/**
 * Class PageVersionsRepository is used to search and retrieve
 * DvsPageVersion models and things in context of a Devise Page Versions.
 *
 * @package Devise\Pages
 */
class PageVersionsRepository
{
    /**
     * Instance of the Page Version Model
     *
     * @var DvsPageVersion
     */
    private $PageVersion;

    /**
     * Create a new PageRepostiry instance.
     *
     * @param \DvsPageVersion $PageVersion
     */
    public function __construct(\DvsPageVersion $PageVersion)
    {
        $this->PageVersion = $PageVersion;
    }

    /**
     * Returns a list of all the unscheduled page versions
     * in this system
     *
     * @return Collection
     */
    public function getUnscheduledPageVersions()
    {
        $versions = $this->PageVersion->with('page')->where('starts_at', '=', null)->get();

        return $this->wrapPageDataAroundVersions($versions);
    }

    /**
     * Returns a list of all the versions for a particular page
     *
     * @param DvsPage
     * @return array
     */
    public function getVersionsListForPage($page)
    {
        return $page->versions()->orderBy('created_at','desc')->pluck('name','id');
    }

    /**
     * Wraps these extra fields around page versions that are passed in
     *
     * @param  Collection $versions
     * @return Collection
     */
    protected function wrapPageDataAroundVersions($versions)
    {
        foreach ($versions as $version)
        {
            $version->update_url = route('dvs-calendar-page-version-source-update', $version->id);
            $version->page_slug = $version->page->slug;
        }

        return $versions;
    }
}