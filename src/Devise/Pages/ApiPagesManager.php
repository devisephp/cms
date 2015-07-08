<?php namespace Devise\Pages;

use Illuminate\Support\Str;
use Devise\Support\Framework;

/**
 * Class ApiPagesManager manages the creating of new pages,
 * updating pages
 */
class ApiPagesManager extends PageManager
{

    /**
     * List of database fields/columns for a dvs_page
     * we don't want to be vulnerable to mass assignment
     * attack so we need to specify these...
     *
     * @var array
     */
    static protected $PageFields = [
        'language_id',
        'http_verb',
        'title',
        'slug',
        'before',
        'response_type',
        'response_path',
        'response_params',
    ];

	/**
	 * Validates and creates a page with the given input
     *
	 * @param  array a$input
	 * @return bool
	 */
	public function createNewPage($input)
	{
        $input['response_type'] = 'Function';
		$page = $this->createPageFromInput($input);

        if ($page)
        {
            $startsAt = new \DateTime; // is published immediately
    		$page->version = $this->PageVersionManager->createDefaultPageVersion($page, $startsAt);
            $this->RoutesGenerator->cacheRoutes();
        }

		return $page;
    }
}