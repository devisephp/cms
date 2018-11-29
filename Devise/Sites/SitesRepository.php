<?php namespace Devise\Sites;

use Devise\Models\DvsSite;
use Devise\Support\Framework;
use Illuminate\Support\Facades\DB;

/**
 * Class SitesRepository is used to search and retrieve DvsSite models
 * and things in context of a Devise Site.
 *
 * @package Devise\Sites
 */
class SitesRepository
{
    /**
     * Instance of the Site Model
     *
     * @var Site
     */
    private $Site;

    /**
     * Create a new SiteRepostiry instance.
     *
     * @param DvsSite $Site
     * @param Framework $Framework
     */
    public function __construct(DvsSite $Site, Framework $Framework)
    {
        $this->Site = $Site;
    }

    /**
     *
     * @param $id
     * @return Site
     * @internal param string $versionName
     */
    public function findById($id)
    {
        return $this->Site->findOrFail($id);
    }
}
