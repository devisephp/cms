<?php namespace Devise\Pages\Repositories;

use PageVersion;

class PageVersionsRepository extends BaseRepository
{
    /**
     * Instance of the PageVersion Model
     *
     * @var PageVersion
     */
	private $PageVersion;

    /**
     * Create a new PageVersionsRepostiry instance.
     *
     * @param  PageVersion  $PageVersion
     */
	public function __construct(PageVersion $PageVersion)
	{
		$this->PageVersion = $PageVersion;
	}

    /**
     * finds a record by it's id
     *
     * @param  int $pageVersionId
     * @return PageVersion
     */
    public function findById($pageVersionId)
    {
        return $this->PageVersion->find($pageVersionId);
    }

}